<x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

    {{-- BRAND --}}
    <div class="ml-5 pt-5">{{ __('App') }}</div>

    {{-- MENU --}}
    <x-mary-menu activate-by-route>


        <x-mary-menu-item title="Users" icon="o-sparkles" link="{{route('dashboard_v2_users')}}" />
        <x-mary-menu-item title="Client" icon="o-sparkles" link="{{route('dashboard_v2_clients')}}" />
        <x-mary-menu-item title="Project" icon="o-sparkles" link="{{route('dashboard_v2_projects')}}" />
        <x-mary-menu-item title="Hello" icon="o-sparkles" link="/" />
        <x-mary-menu-sub title="Settings" icon="o-cog-6-tooth">
            <x-mary-menu-item title="Wifi" icon="o-wifi" link="####" />
            <x-mary-menu-item title="Archives" icon="o-archive-box" link="####" />
            </x-menu-sub>
            </x-menu>
</x-slot:sidebar>
