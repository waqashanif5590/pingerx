<div
    class="mobile-header"
    x-data="{ open: false }"
    @keydown.escape.window="open = false">

    <div class="mobile-header-bar">
        <button
            type="button"
            class="mobile-menu-toggle"
            @click="open = true"
            aria-label="Open menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
            </svg>
        </button>

        <x-application-logo class="mobile-brand" />
    </div>

    {{-- Backdrop --}}
    <div
        class="mobile-nav-backdrop"
        x-show="open"
        x-transition.opacity.duration.200ms
        @click="open = false"
        style="display: none;"></div>

    {{-- Slide-out navigation --}}
    <aside
        class="mobile-nav-drawer"
        x-show="open"
        x-transition:enter="mobile-nav-enter"
        x-transition:enter-start="mobile-nav-enter-start"
        x-transition:enter-end="mobile-nav-enter-end"
        x-transition:leave="mobile-nav-leave"
        x-transition:leave-start="mobile-nav-leave-start"
        x-transition:leave-end="mobile-nav-leave-end"
        style="display: none;"
        @click.outside="open = false">

        <div class="mobile-nav-drawer-header">
            <span class="mobile-brand">{{ config('app.name', 'PingerX') }}</span>
            <button
                type="button"
                class="mobile-menu-toggle"
                @click="open = false"
                aria-label="Close menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                </svg>
            </button>
        </div>

        <ul class="mobile-nav-links">
            <li>
                <a
                    href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    wire:navigate
                    @click="open = false">
                    Home
                </a>
            </li>
            <li>
                <a
                    href="{{ route('chat') }}"
                    class="{{ request()->routeIs('chat*') ? 'active' : '' }}"
                    wire:navigate
                    @click="open = false">
                    Chats
                </a>
            </li>
            <li>
                <a
                    href="{{ route('users') }}"
                    class="{{ request()->routeIs('users') ? 'active' : '' }}"
                    wire:navigate
                    @click="open = false">
                    Find Friends
                </a>
            </li>
            <li>
                <a
                    href="{{ route('profile') }}"
                    class="{{ request()->routeIs('profile') ? 'active' : '' }}"
                    wire:navigate
                    @click="open = false">
                    Profile
                </a>
            </li>
        </ul>

        <button type="button" class="mobile-nav-logout" wire:click="logout">
            Logout
        </button>
    </aside>
</div>
