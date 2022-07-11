<?php

namespace App\Http\Controllers\User;

use App\Dto\User\UserDto;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return response()->json(UserDto::fromModel(Auth::user())->toArray());
    }
}
