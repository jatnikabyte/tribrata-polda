<aside class="sidenav" id="sidenavDrawer">
    <!-- Logo Section -->
    <div class="kt-drawer-header border-b border-border h-topbar">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            @php
                $logo = getSetting('app_logo');
                $title = getSetting('app_title') ?? config('app.name');
            @endphp
            @if ($logo && file_exists(public_path('storage/settings/' . $logo)))
                <img src="{{ asset('storage/settings/' . $logo) }}" alt="{{ $title }}" class="w-10 h-10 object-contain rounded-xl shadow-lg">
            @else
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-xl font-bold text-primary-content">
                        {{ strtoupper(substr($title, 0, 1)) }}
                    </span>
                </div>
            @endif
            <div>
                <span class="text-xl font-bold text-default-800">{{ $title }}</span>
                <p class="text-xs text-default-500">{{ getSetting('site_name') }}</p>
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <div class="kt-drawer-content kt-scrollable h-[calc(100%-theme('spacing.topbar'))]" data-simplebar>
        <ul data-kt-accordion="true" class="kt-accordion-menu">
            <li class="px-3 py-2 text-xs uppercase font-medium text-default-500">Menu</li>

            <!-- Dashboard -->
            <li class="kt-accordion-menu-item" data-kt-accordion-item="true">
                <a href="{{ route('dashboard') }}" wire:navigate class="kt-accordion-menu-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                    <i class="iconify lucide--monitor-dot kt-accordion-menu-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>



            <!-- Pages -->
            <li class="kt-accordion-menu-item" data-kt-accordion-item="true">
                <a href="{{ route('pages') }}" wire:navigate class="kt-accordion-menu-link {{ request()->is('pages*') ? 'active' : '' }}">
                    <i class="iconify lucide--file-text kt-accordion-menu-icon"></i>
                    <span>Halaman</span>
                </a>
            </li>

            <!-- Tabloids -->
            <li class="kt-accordion-menu-item" data-kt-accordion-item="true">
                <a href="{{ route('tabloids') }}" wire:navigate class="kt-accordion-menu-link {{ request()->is('tabloids*') ? 'active' : '' }}">
                    <i class="iconify lucide--newspaper kt-accordion-menu-icon"></i>
                    <span>Tabloid</span>
                </a>
            </li>

            <!-- Videos -->
            <li class="kt-accordion-menu-item" data-kt-accordion-item="true">
                <a href="{{ route('videos') }}" wire:navigate class="kt-accordion-menu-link {{ request()->is('videos*') ? 'active' : '' }}">
                    <i class="iconify lucide--video kt-accordion-menu-icon"></i>
                    <span>Videos</span>
                </a>
            </li>

            <!-- Headlines -->
            <li class="kt-accordion-menu-item" data-kt-accordion-item="true">
                <a href="{{ route('headlines') }}" wire:navigate class="kt-accordion-menu-link {{ request()->is('headlines*') ? 'active' : '' }}">
                    <i class="iconify lucide--type kt-accordion-menu-icon"></i>
                    <span>Headlines</span>
                </a>
            </li>

            <li class="kt-accordion-menu-item" data-kt-accordion-item="true">
                <a href="{{ route('speeches') }}" wire:navigate class="kt-accordion-menu-link {{ request()->is('speeches*') ? 'active' : '' }}">
                    <i class="iconify lucide--message-square kt-accordion-menu-icon"></i>
                    <span>Ucapan</span>
                </a>
            </li>

            <!-- Subscribers -->
            <li class="kt-accordion-menu-item" data-kt-accordion-item="true">
                <a href="{{ route('subscribers') }}" wire:navigate class="kt-accordion-menu-link {{ request()->is('subscribers*') ? 'active' : '' }}">
                    <i class="iconify lucide--users-round kt-accordion-menu-icon"></i>
                    <span>Subscribers</span>
                </a>
            </li>

            <li class="px-3 py-2 text-xs uppercase font-medium text-default-500">Settings</li>

            <!-- Settings -->
            <li class="kt-accordion-menu-item" data-kt-accordion-item="true">
                <a href="{{ route('settings') }}" wire:navigate class="kt-accordion-menu-link {{ request()->is('settings*') ? 'active' : '' }}">
                    <i class="iconify lucide--settings kt-accordion-menu-icon"></i>
                    <span>Pengaturan</span>
                </a>
            </li>

            <!-- Users -->
            <li class="kt-accordion-menu-item" data-kt-accordion-item="true">
                <a href="{{ route('users') }}" wire:navigate class="kt-accordion-menu-link {{ request()->is('users*') ? 'active' : '' }}">
                    <i class="iconify lucide--user kt-accordion-menu-icon"></i>
                    <span>Users</span>
                </a>
            </li>

            <!-- File Manager -->
            <li class="kt-accordion-menu-item" data-kt-accordion-item="true">
                <a href="{{ route('file-manager') }}" wire:navigate class="kt-accordion-menu-link {{ request()->is('file-manager*') ? 'active' : '' }}">
                    <i class="iconify lucide--folder-open kt-accordion-menu-icon"></i>
                    <span>File Manager</span>
                </a>
            </li>


            <!-- System Health -->
            <li class="kt-accordion-menu-item" data-kt-accordion-item="true">
                <a href="{{ route('system-health') }}" wire:navigate class="kt-accordion-menu-link {{ request()->is('system-health*') ? 'active' : '' }}">
                    <i class="iconify lucide--activity kt-accordion-menu-icon"></i>
                    <span>System Health</span>
                </a>
            </li>

            <!-- Activity Logs -->
            <li class="kt-accordion-menu-item" data-kt-accordion-item="true">
                <a href="{{ route('activity-logs') }}" wire:navigate class="kt-accordion-menu-link {{ request()->is('activity-logs*') ? 'active' : '' }}">
                    <i class="iconify lucide--history kt-accordion-menu-icon"></i>
                    <span>Activity Logs</span>
                </a>
            </li>

            <!-- Activity Logs -->
            <li class="kt-accordion-menu-item" data-kt-accordion-item="true">
                <a href="{{ url('/') }}?edit-template=1" target="_blank" class="kt-accordion-menu-link text-primary {{ request()->is('activity-logs*') ? 'active' : '' }}">
                    <i class="iconify lucide--file-pen kt-accordion-menu-icon"></i>
                    <span>Edit Template</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<!-- Mobile Sidebar Overlay -->
<div id="sidenavOverlay" class="sidenav-overlay lg:hidden"></div>
