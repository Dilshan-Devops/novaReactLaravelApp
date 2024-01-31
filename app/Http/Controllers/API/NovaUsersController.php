<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\NovaStoreUserRequest;
use App\Http\Requests\NovaUpdateUserRequest;
use App\Http\Resources\NovaUserResource;

class NovaUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return NovaUserResource::collection(User::query()->orderBy('id', 'desc')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NovaStoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        return response(new NovaUserResource($user) , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new NovaUserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NovaUpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);

        return new NovaUserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response("", 204);
    }
}
