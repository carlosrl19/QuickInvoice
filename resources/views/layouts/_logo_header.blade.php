<div class="logo-header" data-background-color="dark">
    <a href="#" class="logo text-white">
        @php
        $settings = App\Models\Settings::first();
        @endphp

        <img src="{{ Storage::url('sys_config/img/' . ($settings->system_icon ?? 'default_image.png')) }}" alt="" class="rounded-circle bg-white p-1 me-2 navbar-brand" height="45" />

        <span class="text-white fw-bold">
            {{ $settings && $settings->show_system_name == 1 ? config('app.name'):config('app.name') }}
        </span>
    </a>
    <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
            <x-heroicon-o-bars-3 style="width: 25px; height: 25px; color: white;" />
        </button>
        <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
        </button>
    </div>
    <button class="btn topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
    </button>
</div>