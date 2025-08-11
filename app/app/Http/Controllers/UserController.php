<?php

namespace App\Http\Controllers;

use App\Domain\DTOs\UserDTO;
use App\Domain\Services\Interfaces\IUserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(private readonly IUserService $userService)
    {
    }

    public function index(): JsonResponse
    {
        $users = $this->userService->list();

        return response()->json([
            'data' => UserResource::collection($users),
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'total' => $users->total(),
            ],
        ]);
    }

    public function show(int $userId): UserResource
    {
        $userData = $this->userService->get($userId);

        return new UserResource($userData);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $userData = (array)UserDTO::fromRequest($request->validated());
        $user = $this->userService->create($userData);

        return response()->json(['data' => UserResource::make($user)], 201);
    }

    public function update(UpdateUserRequest $request,int $userId): JsonResponse
    {
        $userData = array_filter((array)UserDTO::fromRequest($request->validated()));
        $user = $this->userService->update($userId, $userData);

        return response()->json(['data' => UserResource::make($user)]);
    }

    public function destroy(int $userId): JsonResponse
    {
        $this->userService->delete($userId);

        return apiResponse(message: trans('message.deleted'));
    }
}
