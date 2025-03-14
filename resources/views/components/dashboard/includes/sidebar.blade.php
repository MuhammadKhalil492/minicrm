<x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

    {{-- BRAND --}}
    <div class="ml-5 pt-5">{{ __('App') }}</div>

    {{-- MENU --}}
    <x-mary-menu activate-by-route>

        {{-- User --}}
        {{-- @if ($user = auth()->user())
        <x-mary-menu-separator />

        <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
            <x-slot:actions>
                <x-mary-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate link="/logout" />
            </x-slot:actions>
        </x-mary-list-item>

        <x-mary-menu-separator />
    @endif --}}

        <x-mary-menu-item title="Users" icon="o-sparkles" link="{{route('dashboard_v2_users')}}" />
        <x-mary-menu-item title="Client" icon="o-sparkles" link="{{route('dashboard_v2_clients')}}" />
        <x-mary-menu-item title="Hello" icon="o-sparkles" link="/" />
        <x-mary-menu-sub title="Settings" icon="o-cog-6-tooth">
            <x-mary-menu-item title="Wifi" icon="o-wifi" link="####" />
            <x-mary-menu-item title="Archives" icon="o-archive-box" link="####" />
            </x-menu-sub>
            </x-menu>
</x-slot:sidebar>
