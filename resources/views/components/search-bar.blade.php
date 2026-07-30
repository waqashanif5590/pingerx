<style>
    /* ==========================================
   Search Bar
========================================== */

    .search-container {
        display: flex;
        align-items: center;

        max-width: 450px;
        width: 100%;

        background: #ffffff;

        border: 1px solid #d1d5db;
        border-radius: 12px;

        padding: 0 16px;

        margin-bottom: 30px;

        transition: all .25s ease;
    }

    .search-container:focus-within {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
    }

    .search-icon {
        width: 20px;
        height: 20px;
        color: #9ca3af;
        flex-shrink: 0;
    }

    .search-input {
        flex: 1;

        border: none;
        outline: none;

        padding: 14px 12px;

        font-size: 15px;

        color: #111827;

        background: transparent;
    }

    .search-input::placeholder {
        color: #9ca3af;
    }
</style>
<div class="search-container">

    <svg xmlns="http://www.w3.org/2000/svg"
        class="search-icon"
        viewBox="0 0 16 16"
        fill="currentColor">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.867-3.834zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
    </svg>

    <input
        type="search"
        placeholder="Search users..."
        class="search-input">

</div>