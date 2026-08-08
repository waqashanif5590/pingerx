<?php

use App\Models\PasswordResetOtp;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Support\Facades\Password;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';
    public string $otp = '';

    public function mount(): void
    {
        $this->email = session('password_reset_email', '');
    }

    public function verifyOtp(): void
    {
        $this->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        if (!$this->email) {
            $this->addError(
                'otp',
                'Your password reset session has expired. Please request a new OTP.'
            );

            return;
        }

        $otpRecord = PasswordResetOtp::where('email', $this->email)
            ->where('otp', $this->otp)
            ->first();

        if (!$otpRecord) {
            $this->addError(
                'otp',
                'Invalid OTP. Please check the code and try again.'
            );

            return;
        }

        if ($otpRecord->expires_at->isPast()) {
            $otpRecord->delete();

            $this->addError(
                'otp',
                'This OTP has expired. Please request a new one.'
            );

            return;
        }

        // Find the user
        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $this->addError(
                'otp',
                'No account was found with this email address.'
            );

            return;
        }

        /*
    |--------------------------------------------------------------------------
    | Create Laravel's normal password reset token
    |--------------------------------------------------------------------------
    */

        $token = Password::broker()->createToken($user);

        /*
    |--------------------------------------------------------------------------
    | Store verified status
    |--------------------------------------------------------------------------
    */

        session([
            'password_reset_verified' => true,
            'password_reset_email' => $this->email,
        ]);

        // OTP is no longer needed
        $otpRecord->delete();

        /*
    |--------------------------------------------------------------------------
    | Redirect to Laravel's existing reset-password page
    |--------------------------------------------------------------------------
    */

        $this->redirect(
            route('password.reset', [
                'token' => $token,
                'email' => $this->email,
            ]),
            navigate: true
        );
    }
}; ?>

<div>

    <x-auth-session-status
        class="mb-4"
        :status="session('status')" />

    <form wire:submit="verifyOtp">

        <!-- OTP -->
        <div>
            <x-input-label
                for="otp"
                :value="__('Enter OTP')" />

            <x-text-input
                wire:model="otp"
                id="otp"
                class="block mt-1 w-full"
                type="text"
                inputmode="numeric"
                maxlength="6"
                autocomplete="one-time-code"
                placeholder="Enter 6-digit OTP"
                required
                autofocus />

            <x-input-error
                :messages="$errors->get('otp')"
                class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">

            <x-primary-button>
                {{ __('Verify OTP') }}
            </x-primary-button>

        </div>

    </form>
</div>