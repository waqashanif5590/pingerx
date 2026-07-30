<!-- Users css -->
<div class="dashboard-container">
    <livewire:layout.mobile-header />
    <x-sidebar />
    <div class="users-container">
        <h1 class="heading-1">Find all users</h1>
        <div class="users-grid">

            @foreach($users as $user)
            <div class="user-card">
                <x-avatar />
                <h2 class="heading-2"><a href="{{route('userProfile',$user->id)}}">{{$user->name}}</a></h2>
                <p>{{$user->city}} - {{$user->country}}</p>

                <div class="button-container">
                    <x-secondary-button type="button" wire:click="addFriend({{$user->id}})">
                        Add Friend
                    </x-secondary-button>

                    <x-primary-button type="button" wire:click="message({{$user->id}})">
                        Message
                    </x-primary-button>

                </div>
            </div>
            @endforeach
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