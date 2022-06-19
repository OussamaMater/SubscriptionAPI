<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWebsiteRequest;
use App\Models\Website;

class WebsiteController extends Controller
{
    public function store(StoreWebsiteRequest $request)
    {
        $validated = $request->validated();

        Website::create([
            'name'     => $validated['name']
        ]);

        return response([
            'status'  => 'created',
            'message' => 'website was created.'
        ], 201);
    }
}
