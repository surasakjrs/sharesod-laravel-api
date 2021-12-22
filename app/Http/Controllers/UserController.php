<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \App\Http\Resources\Api\UserResource
     */
    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Api\UpdateUserRequest $request
     * @return \App\Http\Resources\Api\UserResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request)
    {
        if (empty($attrs = $request->validated())) {
            return response()->json([
                'message' => trans('validation.invalid'),
                'errors' => [
                    'any' => [trans('validation.required_at_least_one')],
                ],
            ], 422);
        }

        /** @var \App\Models\User $user */
        $user = $request->user();

        $user->update($attrs);

        return new UserResource($user);
    }
}