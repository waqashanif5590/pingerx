<div class="sidebar"
    x-data
    x-init="
        setTimeout(() => {
            const selectedChat = document.getElementById('conversation-{{ optional($selectedConversation)->id }}');

            if (selectedChat) {
                selectedChat.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }, 100);
    ">

    <div class="sidebar-header">
        <div class="header-top">
            <h2>Chats</h2>
            <a href="{{route('users')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Find Friends</a>
        </div>
        <input
            type="text"
            placeholder="Search contacts..."
            class="search-box">

    </div>
    <div class="contacts">
        @if($conversations->isEmpty())
        <p>No conversations found.</p>
        <span> <a href="{{route('users')}}">Find People</a> to get start chat. </span>
        @else
        @foreach($conversations as $conversation)
        <div class="contact {{ optional($selectedConversation)->id == $conversation->id ? 'active' : '' }}" id="conversation-{{ $conversation->id }}" wire:key="{{ $conversation->id }}">
            <a
                href="{{ route('chat.show', $conversation->id) }}"
                class="contact-link"
                wire:navigate
                @click="
                    if (window.matchMedia('(max-width: 768px)').matches) {
                        const selectedId = {{ optional($selectedConversation)->id ?? 'null' }};
                        if (selectedId === {{ $conversation->id }}) {
                            $event.preventDefault();
                            $dispatch('mobile-open-chat');
                        }
                    }
                ">
                @php
                        $selectedUser = $conversation->sender_id == auth()->id()?$conversation->receiver:$conversation->sender
                        @endphp
                <x-avatar :avatar="$selectedUser->profile_picture" />
                <div class="contact-info">

                    <div class="top">

                       
                        <h3>{{$selectedUser->name}}</h3>

                        <span>{{$conversation->latestMessage?->created_at?->shortAbsoluteDiffForHumans()}}</span>

                    </div>

                    <div class="message-new">
                        <p>{{$conversation->messages?->last()->content??''}}</p>

                        @if($conversation->unreadMessagesCount()>0)
                        <span class="unread-count">{{$conversation->unreadMessagesCount()}}</span>
                        @endif

                        <!-- If sender is auth user then show ticks on sent messages -->
                        @if($conversation->messages?->last()?->sender_id==auth()->id())
                        @if($conversation->isLastMessageRead())
                        <!-- Double check -->
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0" />
                                <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708" />
                            </svg></span>
                        @else
                        <!-- Single check -->
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                            </svg></span>
                        @endif
                        @endif

                    </div>

                </div>

            </a>
            <div class="contact-menu">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <button wire:click="clicked">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                </svg>
                            </span>
                            View Profile
                        </button>
                        <button wire:click="deleteChat('{{ encrypt($conversation->id) }}')"
                        wire:confirm="Are you sure you want to permanently delete this conversation?">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                </svg>
                            </span>
                            Delete Chat
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

        </div>
        @endforeach
        @endif
    </div>
</div>