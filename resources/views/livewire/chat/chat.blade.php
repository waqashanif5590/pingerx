<div
    class="chat-app has-conversation"
    x-data="{ mobileView: 'conversation' }"
    :class="{
        'mobile-showing-list': mobileView === 'list',
        'mobile-showing-chat': mobileView === 'conversation'
    }"
    @mobile-back.window="mobileView = 'list'"
    @mobile-open-chat.window="mobileView = 'conversation'">

    <livewire:layout.mobile-header />

    <!-- Sidebar / Chat List -->
    <livewire:chat.chat-list :selectedConversation="$selectedConversation" />

    <!-- Chat Area -->
    <livewire:chat.chat-box :selectedConversation="$selectedConversation" />

</div>
