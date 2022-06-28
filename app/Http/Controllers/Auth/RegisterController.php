<?php

namespace App\Http\Controllers\Auth;

use App\EntityServices\Auth\RegisterServiceController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function index(): void
    {
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        return RegisterServiceController::register($request);
    }
}
