<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MainController
{
    public function menu(): View
    {
        /* @var User $user */
        $user = Auth::user();

        return view('main.' . $user->role->value . '-menu', [
            'store' => $user->store?->name,
        ]);
    }
}
