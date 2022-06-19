<?php

namespace App\Http\Controllers\client;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\SubscribeClientRequest;
use App\Models\Website;

class ClientController extends Controller
{
    private function returnResponse($status, $message, $code)
    {
        return response([
            'status' => $status,
            'error'  => $message
        ], $code);
    }

    public function store(StoreClientRequest $request)
    {
        $validated = $request->validated();

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        return $this->returnResponse('create', 'client was created.', 201);
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

    public function subscribe(SubscribeClientRequest $request)
    {
        $validated = $request->validated();

        // Note that in real life we will be testing a token otherwise using the Auth facade.
        if (!($user = $this->checkIfExists(User::class, $validated, 'user'))) {
            return $this->returnResponse('error', 'user was not found.', 404);
        }

        if (!($website = $this->checkIfExists(Website::class, $validated, 'website'))) {
            return $this->returnResponse('error', 'website was not found', 404);
        }

        if (!$user->websites()->whereId($website->id)->exists()) {
            $user->websites()->attach($website->id);

            return $this->returnResponse('create', 'client subscribe to website.', 201);
        }

        return $this->returnResponse('exists', 'client already subscribed.', 409);
    }
}
