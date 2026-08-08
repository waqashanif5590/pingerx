<?php

use App\Models\User;
use App\Models\PasswordResetOtp;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    public function sendOtp(): void
    {
        $validated = $this->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            $this->addError('email', 'No account found with this email address.');

            return;
        }

        $otp = random_int(100000, 999999);

        PasswordResetOtp::where('email', $validated['email'])->delete();

        PasswordResetOtp::create([
            'email' => $validated['email'],
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::raw(
            "Your PingerX password reset OTP is: {$otp}\n\nThis OTP will expire in 10 minutes.",
            function ($message) use ($validated) {
                $message->to($validated['email'])
                    ->subject('PingerX Password Reset OTP');
            }
        );

        session([
            'password_reset_email' => $validated['email'],
        ]);
        session()->flash('status', 'OTP has been sent to your email address.');

        $this->redirect(
            route('password.verify-otp'),
            navigate: true
        );
    }
};
?>
<div>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>
    <!-- Session Status -->

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendOtp">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input
                wire:model="email"
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                required
                autofocus />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Send OTP') }}
            </x-primary-button>
        </div>

    </form>
</div>