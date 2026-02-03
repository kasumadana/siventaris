<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Login extends Component
{
    #[Rule('required|email')]
    public $email = '';

    #[Rule('required')]
    public $password = '';

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();

            // Check if user is blocked
            if (Auth::user()->is_blocked) {
                Auth::logout();
                $this->addError('email', 'Your account is blocked. Please contact the Toolman.');
                return;
            }

            // Redirect based on role
            if (Auth::user()->role === 'student') {
                return redirect()->route('catalog');
            } else {
                return redirect('/admin');
            }
        }

        $this->addError('email', 'The provided credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.login');
    }
}
