<?php

namespace App\Http\Controllers\Auth;

use App\EntityServices\Auth\RegisterServiceController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    public function index(): void
    {
    }

    /**
     * @param RegisterRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function register(RegisterRequest $request)
    {
        return RegisterServiceController::register($request);
    }
}
