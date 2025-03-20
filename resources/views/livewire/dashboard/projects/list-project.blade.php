<div>
    <x-mary-header title="Projects" subtitle="Manage your Projects" separator progress-indicator>
        <x-slot name="actions">
            <x-filament::button href="{{ route('dashboard_v2_project_create') }}" tag="a" class="bg-blue-400">{{ __('New Project') }}</x-filament::button>
        </x-slot>
    </x-mary-header>
    {{ $this->table }}
</div>
