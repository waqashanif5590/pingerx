    <section
        x-data="{height:0,conversationElement:document.getElementById('conversation')}"
        x-init="
                height=conversationElement.scrollHeight;
                $nextTick(()=>conversationElement.scrollTop=height);

                Echo.private('users.{{auth()->user()->id}}')
                .notification((notification)=>{
                if(notification['type']=='App\\Notifications\\MessageRead' && notification['conversation_id']=={{$this->selectedConversation->id}})
                        {
                            $wire.messageRead(notification['conversation_id']);
                        }
                    });
                "
        @scroll-bottom.window="
                $nextTick(()=>conversationElement.scrollTop=height); "
        class="chat-area">

        <header class="chat-header">
            <a
                href="{{ route('chat') }}"
                class="back-arrow"
                @click.prevent="
                    if (window.matchMedia('(max-width: 768px)').matches) {
                        $dispatch('mobile-back');
                    }
                "
                aria-label="Back to chats">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                </svg>
            </a>
            @php
                $chatUser = $selectedConversation->sender_id==auth()->id()
                ?$selectedConversation->receiver
                :$selectedConversation->sender
                @endphp
            <x-avatar :avatar="$chatUser->profile_picture" />

            <div>
               
                <h3>{{$chatUser->name}}</h3>

                <!-- <span>Online</span> -->

            </div>

        </header>
        <main
            id="conversation"
            class="messages"

            x-data="{
        previousHeight: 0,

        loadMore() {
            this.previousHeight = this.$el.scrollHeight;

            $wire.dispatch('loadMoreMessages');
        }
    }"

            @scroll="
        if ($event.target.scrollTop <= 10) {
            loadMore();
        }
    "

            x-on:messages-loaded.window="
        $nextTick(() => {
            $el.scrollTop = $el.scrollHeight - previousHeight;
        });
    ">
            @if($loadedMessages)

            @php
            $previousMessage=null;
            @endphp
            @foreach($loadedMessages as $key=> $message)
            @if($message->sender_id==auth()->id())
            <div class="message sent">

                <p>{{$message->content}}</p>

                <div class="message-info">
                    <small>{{$message->created_at->format('h:i A')}}</small>
                    <span>
                        @if($message->isRead())
                        <!-- Double check -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                            <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0" />
                            <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708" />
                        </svg>
                        @else
                        <!-- Single check -->
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                            </svg></span>
                        @endif
                    </span>
                </div>
            </div>
            @else
            <div
                wire:key="{{time().$key}}"
                class="message-container">
                @if($key>0)
                @php
                $previousMessage=$loadedMessages->get($key-1);
                @endphp
                @endif

                <div class="{{ $previousMessage?->sender_id == $message->sender_id ? 'invisible' : '' }}">
    @php
        $messageUser = $message->sender_id == auth()->id()
            ? $message->receiver
            : $message->sender;
    @endphp

    <x-avatar :avatar="$messageUser->profile_picture"/>
</div>
                <div class="message {{$message->sender_id==auth()->id()?'sent':'received'}}">
                    <p>{{$message->content}}</p>

                    <small>{{$message->created_at->format('h:i A')}}</small>

                </div>
            </div>
            @endif
            @endforeach
            @endif

        </main>

        <footer class="chat-input">
            <form x-data="{body:@entangle('body')}"
                @submit.prevent="$wire.sendMessage" method="post">
                @csrf
                <input type="hidden" name="receiver_id" value="">
                <input type="text" x-model="body" placeholder="Type a message...">

                <button
                    type="submit"
                    x-bind:disabled="!body || body.trim() === ''">
                    Send
                </button>
            </form>
        </footer>

    </section>