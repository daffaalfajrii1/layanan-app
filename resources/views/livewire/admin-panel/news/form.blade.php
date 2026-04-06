<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="{{ $editing ? 'edit' : 'save' }}" class="tablelist-form" autocomplete="off">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <x-input-label for="judul" value="Judul Informasi" required/>
                                <x-text-input wire:model="form.judul" type="text" id="judul" placeholder="Judul Informasi" :error="$errors->get('form.judul')" />
                                <x-input-error :messages="$errors->get('form.judul')"/>
                            </div>

                            <div class="col-lg-12">
                                <x-input-label for="category_id" value="Kategori" required/>
                                <x-select-list class="w-full" id="category_id" name="category_id" :options="$this->listsForFields['categories']" wire:model="form.category_id" data-placeholder="-- Pilih --"/>
                                <x-input-error :messages="$errors->get('form.category_id')"/>
                            </div>

                            <div class="col-lg-12">
                                <x-input-label for="isi" value="Isi" required/>
                                <x-textarea wire:model="form.isi" id="isi" placeholder="Isi" :error="$errors->get('form.isi')" rows="3" />
                                <x-input-error :messages="$errors->get('form.isi')"/>
                            </div>

                            <div class="col-lg-12">
                                <x-input-label for="thumbnail" value="Thumbnail" required/>
                                <input type="file" wire:model="form.thumbnail" class="form-control" placeholder="Thumbnail">
                                <x-input-error :messages="$errors->get('form.thumbnail')"/>
                            </div>

                            <div class="col-lg-12">
                                <div class="text-end">
                                    <x-primary-button type="submit">
                                        Simpan
                                    </x-primary-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
