<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class MainPage extends Component
{
    public function render()
    {
        return view('livewire.main-page', ['users' => User::all()]);
    }
}
