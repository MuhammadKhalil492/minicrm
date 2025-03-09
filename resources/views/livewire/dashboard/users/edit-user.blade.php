<div>
    <x-mary-header title="Edit User" subtitle="Manages your Users" separator />
    <form wire:submit="update">
        {{ $this->form }}
        <div class="my-2">
            <x-filament::button type="submit" size="sm" class="bg-blue-300">
                {{ __('Update') }}
                <i wire:target="update" wire:loading wire:loading.delay.long wire:loading.class="fa fa-spinner fa-spin"></i>
            </x-filament::button>
        </div>
    </form>
</div>
