@props(['title'])

<!-- Topbar Start -->
<div id="topbar" class="app-header min-h-topbar flex items-center sticky top-0 z-30 bg-card shadow">
    <div class="px-6 w-full flex items-center">
        <div class="w-full flex items-center justify-between gap-4">
            <div class="flex items-center gap-5">
                <!-- Sidenav Menu Toggle Button -->
                <button class="kt-btn lg:hidden" data-kt-drawer-toggle="#sidenavDrawer">
                    <i class="iconify lucide--align-left text-2xl"></i>
                </button>

                <!-- Topbar Brand Logo -->
                <a href="{{ route('dashboard') }}" class="md:hidden flex">
                    <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                        <span class="text-sm font-bold text-white">{{ strtoupper(substr(config('app.name'), 0, 1)) }}</span>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-5">
                <!-- User Profile Dropdown -->
                <div class="relative inline-flex" data-kt-dropdown="true" data-kt-dropdown-trigger="click" data-kt-dropdown-placement="bottom-end">
                    <button class="inline-flex items-center gap-2 p-1.5 rounded-lg bg-white border border-default-200 hover:bg-default-50 transition-all" data-kt-dropdown-toggle="true">
                        @if (auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                        @else
                            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center">
                                <span class="text-xl font-bold">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                            </div>
                        @endif
                        <div class="hidden md:flex flex-col items-start">
                            <span class="text-sm font-semibold text-default-800">{{ auth()->user()->name ?? 'User' }}</span>
                            <span class="text-xs text-default-500">Administrator</span>
                        </div>
                        <i class="iconify lucide--chevron-down text-default-400 hidden md:block"></i>
                    </button>

                    <div class="kt-dropdown absolute right-0 top-full mt-2 w-56 text-sm" data-kt-dropdown-menu="true">
                        <div class="px-4 py-3 border-b border-default-100">
                            <p class="font-semibold text-default-800 truncate">{{ auth()->user()->display_name ?? (auth()->user()->name ?? 'User') }}</p>
                        </div>

                        <div class="py-1">
                            <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-default-100">
                                <i class="iconify lucide--user text-default-500"></i>
                                <span>Profile</span>
                            </a>
                        </div>

                        <div class="border-t border-default-100 py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-red-50 text-red-600">
                                    <i class="iconify lucide--log-out"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->
