<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Laravel\Fortify\Features;
use Livewire\Component;

class TwoFactorAuthenticationForm extends Component
{
    public $showingQrCode = false;
    public $showingConfirmation = false;
    public $showingRecoveryCodes = false;
    public $code;

    public function enableTwoFactorAuthentication(EnableTwoFactorAuthentication $enable)
    {
        $enable(Auth::user());

        $this->showingQrCode = true;
        $this->showingConfirmation = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm');
        $this->showingRecoveryCodes = false;
    }

    public function confirmTwoFactorAuthentication()
    {
        $user = Auth::user();

        $this->resetErrorBag();

        if (! $user->confirmTwoFactorAuth($this->code)) {
            $this->addError('code', __('The provided code was invalid.'));

            return;
        }

        $this->showingQrCode = false;
        $this->showingConfirmation = false;
        $this->showingRecoveryCodes = true;
    }

    public function showRecoveryCodes()
    {
        $this->showingRecoveryCodes = true;
    }

    public function regenerateRecoveryCodes(GenerateNewRecoveryCodes $generate)
    {
        $generate(Auth::user());

        $this->showingRecoveryCodes = true;
    }

    public function disableTwoFactorAuthentication(DisableTwoFactorAuthentication $disable)
    {
        $disable(Auth::user());

        $this->showingQrCode = false;
        $this->showingConfirmation = false;
        $this->showingRecoveryCodes = false;
    }

    public function getEnabledProperty()
    {
        return ! empty(Auth::user()->two_factor_secret);
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('profile.two-factor-authentication-form');
    }
}
