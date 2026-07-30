<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;
    public string $name = '';
    public string $email = '';
    public string $country = '';
    public string $city = '';
    public int $age = 0;
    public $profile_picture = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->country = Auth::user()->country;
        $this->city = Auth::user()->city;
        $this->age = Auth::user()->age;
        $this->profile_picture = Auth::user()->profile_picture;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:18'],
            'profile_picture' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
// Check if profile picture is changed, then delete the old one
        if ($this->profile_picture) {
            Storage::delete($user->profile_picture);
   $image_full_path = $this->profile_picture->store('images/profile_pictures', 'public');
   $image_path = str_replace('images/profile_pictures/', '', $image_full_path);
   $validated['profile_picture'] = $image_path;
        }
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="country" :value="__('Country')" />
            <x-text-input wire:model="country" id="country" name="country" type="text" class="mt-1 block w-full" required autocomplete="country" />
            <x-input-error class="mt-2" :messages="$errors->get('country')" />
        </div>

        <div>
            <x-input-label for="city" :value="__('City')" />
            <x-text-input wire:model="city" id="city" name="city" type="text" class="mt-1 block w-full" required autocomplete="city" />
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <div>
            <x-input-label for="age" :value="__('Age')" />
            <x-text-input wire:model="age" id="age" name="age" type="number" class="mt-1 block w-full" required autocomplete="age" />
            <x-input-error class="mt-2" :messages="$errors->get('age')" />
        </div>

        <!-- If image exists, show it -->
        @if ($profile_picture)
            <img src="{{ asset('storage/images/profile_pictures/' . $profile_picture) }}" alt="Profile Picture" class="w-20 h-20 rounded-full">
        @else
            <x-avatar wire:model="profile_picture" />
        @endif
        <div>
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
            <input type="file" wire:model="profile_picture" id="profile_picture" name="profile_picture" class="mt-1 block w-full" required autocomplete="profile_picture" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
