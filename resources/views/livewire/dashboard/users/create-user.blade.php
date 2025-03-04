<div>
    <form wire:submit="create">
        {{ $this->form }}
        <div class="my-4">
            <x-filament::button tag="button" type="submit" class="bg-blue-400">{{ __('Save') }}
                <i wire:target="create" wire:loading wire:loading.delay.long wire:loading.class="fas fa-spinner fa-spin"></i>
            </x-filament::button>
        </div>
    </form>
</div>
