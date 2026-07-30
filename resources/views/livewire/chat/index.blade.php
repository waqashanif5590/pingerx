<!-- Index css -->

<div
    class="chat-app is-chat-index"
    x-data>

    <livewire:layout.mobile-header />

    <!-- Sidebar / Chat List -->
    <livewire:chat.chat-list />

    <!-- Chat Area (hidden on mobile via CSS) -->
    <section class="chat-area">
        <h4 style="margin: auto;">Select a conversation to get started with chat</h4>
    </section>

</div>
