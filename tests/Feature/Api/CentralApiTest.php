<?php

namespace Tests\Feature\Api;

use App\Http\Controllers\Api\AuthController;
use App\Models\Master\Role;
use App\Models\Registration\Registration;
use App\Models\Service\Service;
use App\Models\Service\ServiceDocument;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CentralApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_login_and_receive_sanctum_token_with_allowed_abilities(): void
    {
        $user = $this->createClientUser();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
            'client_name' => 'Portal Client',
            'abilities' => ['services:read', 'registrations:create'],
        ]);

        $response->assertOk()
            ->assertJsonPath('token_type', 'Bearer')
            ->assertJsonPath('abilities', ['services:read', 'registrations:create'])
            ->assertJsonPath('client.email', $user->email);

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'Portal Client',
        ]);
    }

    public function test_service_schema_requires_services_read_ability(): void
    {
        $user = $this->createClientUser();
        $service = Service::create(['name' => 'Layanan Test', 'slug' => 'layanan-test']);
        $field = ServiceDocument::create([
            'service_id' => $service->id,
            'name' => 'Nama Pemohon',
            'type' => 'text',
            'is_required' => true,
        ]);

        Sanctum::actingAs($user, ['registrations:create']);
        $this->getJson('/api/services')->assertForbidden();

        Sanctum::actingAs($user, ['services:read']);
        $this->getJson('/api/services')
            ->assertOk()
            ->assertJsonPath('data.0.slug', 'layanan-test')
            ->assertJsonPath('data.0.schema.fields.0.key', 'field_' . $field->id)
            ->assertJsonPath('data.0.schema.fields.0.input_name', 'documents[field_' . $field->id . ']');
    }

    public function test_client_can_submit_registration_with_multipart_file(): void
    {
        Storage::fake('public');

        $user = $this->createClientUser();
        $service = Service::create(['name' => 'Pendaftaran Test', 'slug' => 'pendaftaran-test']);
        $nameField = ServiceDocument::create([
            'service_id' => $service->id,
            'name' => 'Nama Pemohon',
            'type' => 'text',
            'is_required' => true,
        ]);
        $fileField = ServiceDocument::create([
            'service_id' => $service->id,
            'name' => 'Upload Surat',
            'type' => 'file',
            'is_required' => true,
        ]);

        Sanctum::actingAs($user, ['registrations:create']);

        $response = $this->post('/api/services/pendaftaran-test/registrations', [
            'documents' => [
                'field_' . $nameField->id => 'Pemohon API',
                'field_' . $fileField->id => UploadedFile::fake()->create('surat.pdf', 128, 'application/pdf'),
            ],
        ], ['Accept' => 'application/json']);

        $response->assertCreated()
            ->assertJsonPath('data.status', 'pending')
            ->assertJsonPath('data.service.slug', 'pendaftaran-test')
            ->assertJsonPath('data.documents.0.value', 'Pemohon API')
            ->assertJsonPath('data.documents.1.type', 'file');

        $registration = Registration::with('documents')->firstOrFail();

        $this->assertSame('pending', $registration->status);
        $this->assertCount(2, $registration->documents);
        Storage::disk('public')->assertExists($registration->documents->last()->file_path);
    }

    public function test_registration_read_requires_registration_read_ability(): void
    {
        $user = $this->createClientUser();
        $service = Service::create(['name' => 'Layanan Test', 'slug' => 'layanan-test']);
        $registration = Registration::create([
            'service_id' => $service->id,
            'registration_number' => '20260829-ABC123',
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        Sanctum::actingAs($user, ['services:read']);
        $this->getJson('/api/registrations/' . $registration->registration_number)->assertForbidden();

        Sanctum::actingAs($user, ['registrations:read']);
        $this->getJson('/api/registrations/' . $registration->registration_number)
            ->assertOk()
            ->assertJsonPath('data.registration_number', '20260829-ABC123');
    }

    private function createClientUser(): User
    {
        $role = Role::create(['name' => 'Client', 'slug' => 'client']);

        return User::create([
            'role_id' => $role->id,
            'username' => 'client_' . uniqid(),
            'name' => 'Client API',
            'email' => uniqid('client_') . '@example.test',
            'password' => 'password',
        ]);
    }
}
