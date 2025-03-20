<div>
    <x-mary-header title="Edit Project" subtitle="Manage your Project Detials" separator progress-indicator>
        <x-slot name="actions">
            <x-filament::button tag="button" wire:click="update" class="bg-blue-400">{{ __('Save') }}
                <i wire:target="update" wire:loading wire:loading.delay.long wire:loading.class="fas fa-spinner fa-spin"></i>
            </x-filament::button>
            <x-filament::modal>
                <x-slot name="heading">
                    {{ __('Cancel Project') }}
                </x-slot>
                <x-slot name="trigger">
                    <x-filament::button class="bg-red-600 hover:bg-red-500">
                        {{ __('Cancel') }}
                    </x-filament::button>
                </x-slot>
                <div class="text-red-500">
                    {{ __('Do you want to cancel the update project?') }}
                </div>

                <x-slot name="footerActions">
                    <x-filament::button x-on:click="close()" class="bg-red-500 hover:bg-red-400" tag="button">
                        {{ __('No') }}
                        <i class="fas fa-xmark"></i>
                    </x-filament::button>
                    <x-filament::button wire:click="cancel" class="bg-green-500 hover:bg-green-400" tag="button">
                        {{ __('Yes') }}
                        <i class="fas fa-check"></i>
                    </x-filament::button>
                </x-slot>
                {{-- Modal content --}}
            </x-filament::modal>
        </x-slot>
    </x-mary-header>
    <form wire:submit="update">
        {{ $this->form }}
        <div class="my-4">
            <x-filament::button tag="button" type="submit" class="bg-blue-400">{{ __('Save') }}
                <i wire:target="update" wire:loading wire:loading.delay.long wire:loading.class="fas fa-spinner fa-spin"></i>
            </x-filament::button>
        </div>
        {{-- </x-filament::section> --}}
    </form>
</div>
