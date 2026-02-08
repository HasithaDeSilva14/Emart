<?php

namespace App\Livewire\Profile;

use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdatePasswordForm extends Component
{
    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public function updatePassword(UpdateUserPassword $updater)
    {
        $this->resetErrorBag();

        $updater->update(Auth::user(), $this->state);

        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('profile.update-password-form');
    }
}
