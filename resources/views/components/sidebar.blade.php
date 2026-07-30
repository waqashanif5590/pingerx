<style>
    /* ===========================
   app-sidebar
=========================== */

    .app-sidebar {
        width: 260px;
        height: 88vh;
        background: #ffffff;
        border-right: 1px solid #e5e7eb;

        display: flex;
        flex-direction: column;

        padding: 24px 18px;
        position: sticky;
        top: 0;
    }

    /* ===========================
   Navigation
=========================== */

    .app-sidebar ul {
        list-style: none;
        margin: 0;
        padding: 0;

        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    /* ===========================
   Navigation Links
=========================== */

    .app-sidebar ul li a {
        display: flex;
        align-items: center;

        padding: 12px 16px;

        text-decoration: none;
        color: #374151;

        font-size: 15px;
        font-weight: 500;

        border-radius: 10px;

        transition: all .2s ease;
    }

    /* Hover */

    .app-sidebar ul li a:hover {
        background: #eff6ff;
        color: #2563eb;
    }

    /* Active Page */

    .app-sidebar ul li a.active,
    .app-sidebar ul li a[aria-current="page"] {
        background: #2563eb;
        color: #ffffff;
    }

    /* ===========================
   Logout Button
=========================== */

    .app-sidebar x-primary-button,
    .app-sidebar button {
        margin-top: auto;
        width: 100%;
    }
</style>
<div class="app-sidebar">
    <ul>
        <li><a href="{{route('dashboard')}}">Home</a></li>
        <li><a href="{{route('chat')}}">Messages</a></li>
        <li><a href="{{route('users')}}">Find Friends</a></li>
    </ul>


    <x-primary-button wire:click="logout">
        Logout
    </x-primary-button>
</div>