<?php

namespace Modules\Users\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\Users\App\Http\Requests\SettingsRequest;
use Modules\Users\App\Resources\UserResource;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(15);
        //return users resource
        $resource = UserResource::collection($users);
        return response($resource, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //get allowed roles from helper function
        $allowed_roles = allowed_roles();
        return response()->json(['roles' => $allowed_roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingsRequest $request): Response
    {
        //let's create the user
        try {
            $data = $request->validated();
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);
            $resource = new UserResource($user);
            return response($resource, 201);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }

    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $user = User::query()->findOrFail($id);
        $resource = new UserResource($user);
        return response($resource, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::query()->findOrFail($id);
        //get allowed roles from helper function
        $allowed_roles = allowed_roles();
        // if user is operator and trying to edit admin, return forbidden
        if ($this->operatorAccess($user)) {
            return response('Forbidden', 403);
        }
        $resource = UserResource::collection($user);
        $data = [
            'user' => $resource,
            'roles' => $allowed_roles
        ];
        return response($data, 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SettingsRequest $request, $id): Response
    {
        $user = User::query()->findOrFail($id);
        if ($this->operatorAccess($user)) {
            return response('Forbidden', 403);
        }
        try {
            $data = $request->all();
            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }
            $user->update($data);
            $resource = new UserResource($user);
            return response($resource, 200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::query()->findOrFail($id);
        if ($this->operatorAccess($user)) {
            return response('Forbidden', 403);
        }
        $user->delete();
        return response(['status'=>'success'], 200);
    }

    private function operatorAccess($user): bool
    {
        // if user is operator and trying to edit or create admin return false
        return (auth()->user()->role == 'operator' && $user->role == 'admin');
    }
}
