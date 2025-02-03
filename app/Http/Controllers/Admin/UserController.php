<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use App\Service\Admin\UserService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->set_service(new UserService());
    }


    /**
     * Display a listing of the resource.
     */
    public function index():AnonymousResourceCollection
    {
        return UserResource::collection(User::paginate(10)
                                            ->withPath('/admin/users')
                                            ->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request):UserResource
    {
        $data = $request->validated();
        $user = $this->service->store($data);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user):UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $update_user = $this->service->update($data,$user);
        return new UserResource($update_user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response([
            'message' => "User deleted successfully"
        ],200);
    }
}
