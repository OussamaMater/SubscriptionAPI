<?php

namespace App\Http\Controllers\client;

use App\Models\User;
use App\Models\Website;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\SubscribeClientRequest;

class ClientController extends Controller
{
    private function returnResponse($status, $message, $code)
    {
        return response([
            'status'  => $status,
            'message' => $message
        ], $code);
    }

    public function register(StoreClientRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        $token = $user->createToken(Str::random(10))->plainTextToken;

        return $this->returnResponse('success', $token, 201);
    }

    private function checkIfExists($model, $data, $attribue)
    {
        try {
            $model = $model::findOrFail($data[$attribue]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return false;
        }

        return $model;
    }

    public function authenticate(UserLoginRequest $request)
    {
        $validated = $request->validated();

        $user = User::whereEmail($validated['email'])->first();
        if (is_null($user)) {
            return $this->returnResponse('failed', 'could not find a matching account.', 404);
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return $this->returnResponse('failed', 'invalid credentials.', 401);
        }

        $token = $user->createToken(Str::random(10))->plainTextToken;

        return $this->returnResponse('success', $token, 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->returnResponse('success', 'user logged out.', 200);
    }

    public function subscribe(SubscribeClientRequest $request)
    {
        $validated = $request->validated();

        if (!($website = $this->checkIfExists(Website::class, $validated, 'website'))) {
            return $this->returnResponse('error', 'website was not found', 404);
        }

        $user = auth()->user();

        if (!$user->websites()->whereId($website->id)->exists()) {
            $user->websites()->attach($website->id);

            return $this->returnResponse('created', 'client subscribed to website.', 201);
        }

        return $this->returnResponse('exists', 'client already subscribed.', 409);
    }
}
