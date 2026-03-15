<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function viewListOfUsers(): View
    {
        return view('admin.userlist', [
            'users' => User::query()->latest()->get(),
        ]);
    }
}
