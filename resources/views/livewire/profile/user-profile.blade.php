<div class="dashboard-container">

    <livewire:layout.mobile-header />

    <x-sidebar />

    <div class="user-details">

        <div class="profile-card">

            <div class="profile-cover"></div>

            <div class="profile-content">

                <x-avatar
                    :avatar="$user->profile_picture"
                    class="profile-avatar" />

                <h1>{{ $user->name }}</h1>

                <p class="location">
                    {{ $user->city }},
                    {{ $user->country }}
                </p>

                <p class="age">
                    {{ $user->age }} Years Old
                </p>

                <div class="profile-actions">

                    <x-secondary-button type="button" wire:click="addFriend({{$user->id}})">
                        Add Friend
                    </x-secondary-button>

                    <x-primary-button type="button" wire:click="message({{$user->id}})">
                        Message
                    </x-primary-button>

                </div>

            </div>

        </div>
        <div class="container">

            <div class="card">

                <div class="icon">
                    📢
                </div>

                <h1>Posts Coming Soon</h1>

                <p>
                    We're currently developing the Posts feature for PingerX.
                    Soon you'll be able to share updates, photos, and moments with your friends.
                </p>

                <div class="features">

                    <div class="feature">
                        <span>✓</span>
                        Share Photos
                    </div>

                    <div class="feature">
                        <span>✓</span>
                        Create Posts
                    </div>

                    <div class="feature">
                        <span>✓</span>
                        Like & Comment
                    </div>

                    <div class="feature">
                        <span>✓</span>
                        Engage with Friends
                    </div>

                </div>

                <a href="{{ route('chat') }}" class="btn">
                    Back to Chat
                </a>

            </div>

        </div>


    </div>



    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-alert', (event) => {
                alert("Add Friend feature is currently not implemented");
            });
        });
    </script>
</div>