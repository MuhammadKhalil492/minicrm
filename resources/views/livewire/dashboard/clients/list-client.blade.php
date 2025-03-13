<div>
    <x-mary-header title="Clients" subtitle="Manage your Clients" separator progress-indicator>
        <x-slot name="actions">
            <x-filament::button href="{{ route('dashboard_v2_client_create') }}" tag="a" class="bg-blue-400">{{ __('Create User') }}</x-filament::button>
        </x-slot>
    </x-mary-header>
    {{ $this->table }}
</div>
