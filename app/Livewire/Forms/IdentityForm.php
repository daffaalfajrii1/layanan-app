<?php

namespace App\Livewire\Forms;

use App\Models\Master\Identity;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Str;

class IdentityForm extends Form
{
    public ?Identity $identity = null;

    #[Rule(['required', 'string', 'max:100'])]
    public ?string $name = null;

    #[Rule(['required', 'string'])]
    public ?string $description = null;

    #[Rule(['required', 'string'])]
    public ?string $favicon = null;

    #[Rule(['nullable'])]
    public $logo = null;

    #[Rule(['required', 'string'])]
    public ?string $email = null;

    #[Rule(['required', 'string'])]
    public ?string $address = null;

    #[Rule(['required', 'string'])]
    public ?string $google_maps = null;

    #[Rule(['required', 'string'])]
    public ?string $phone = null;

    #[Rule(['required', 'string'])]
    public ?string $facebook = null;

    #[Rule(['required', 'string'])]
    public ?string $instagram = null;

    #[Rule(['required', 'string'])]
    public ?string $youtube = null;

    #[Rule(['required', 'string'])]
    public ?string $twitter = null;

    #[Rule(['required', 'string'])]
    public ?string $vision_mission = null;

    #[Rule(['required', 'string'])]
    public ?string $task_function = null;

    public function setIdentity(Identity $identity): void
    {
        $this->identity = $identity;
        $this->name = $identity->name;
        $this->description = $identity->description;
        $this->favicon = $identity->favicon;
        $this->logo = $identity->logo;
        $this->email = $identity->email;
        $this->address = $identity->address;
        $this->google_maps = $identity->google_maps;
        $this->phone = $identity->phone;
        $this->facebook = $identity->facebook;
        $this->instagram = $identity->instagram;
        $this->youtube = $identity->youtube;
        $this->twitter = $identity->twitter;
        $this->vision_mission = $identity->vision_mission;
        $this->task_function = $identity->task_function;
    }

    public function update(): void
    {
        $this->validate();

        $this->logo = $this->logo !== $this->identity->logo ? $this->handleUploadedImage($this->logo, $this->name) : $this->identity->logo;

        if ($this->logo !== $this->identity->logo && $this->logo != 'logo.png') {
            $destinationPath = public_path('/storage/images/identity/');
            if (file_exists($destinationPath . $this->identity->logo)) {
                unlink($destinationPath . $this->identity->logo);
            }
        }

        $this->identity->update($this->except('identity'));
    }

    public function handleUploadedImage($image, $name): string
    {
        if ($image) {
            $image = $image;
            $imageName = time() . '-' . Str::slug($name) . '.' . $image->getClientOriginalExtension();

            $image->storeAs('images/identity', $imageName, 'public');
            return $imageName;
        }
    }
}
