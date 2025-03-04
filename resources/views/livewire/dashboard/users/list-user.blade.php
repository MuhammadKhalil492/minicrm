<div>
    <x-mary-header title="Users" subtitle="Manage your Users" separator progress-indicator>
        <x-slot name="actions">
            <x-filament::button href="{{ route('dashboard_v2_user_create') }}" tag="a" class="bg-blue-400">{{ __('Create User') }}</x-filament::button>
        </x-slot>
    </x-mary-header>
    {{ $this->table }}
</div>
