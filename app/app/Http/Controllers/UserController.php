<?php
namespace App\Http\Controllers;

use App\Domain\Services\Interfaces\IUserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class UserController extends Controller
{
  public function __construct(private readonly IUserService $userService)
  {
      $this->middleware('auth:sanctum');           // only logged-in
      $this->middleware('can:manage-users,App\Models\User');       // define in policy/gate
  }

  public function index(): JsonResponse
  {
     $users = $this->userService->list(request('per_page', 15));
     return response()->json([
          'data' => UserResource::collection($users),
          'meta' => [
               'current_page' => $users->currentPage(),
               'last_page'    => $users->lastPage(),
               'total'        => $users->total(),
          ],
     ]);
  }

  public function show(User $user): JsonResponse
  {
     return response()->json(['data' => UserResource::make($this->userService->get($user))]);
  }

  public function store(StoreUserRequest $request): JsonResponse
  {
     $user = $this->userService->create($request->validated());
     return response()->json(['data' => UserResource::make($user)], 201);
  }

  public function update(UpdateUserRequest $request, User $user): JsonResponse
  {
     $user = $this->userService->update($user, $request->validated());
     return response()->json(['data' => UserResource::make($user)]);
  }

  public function destroy(User $user): JsonResponse
  {
     $this->userService->delete($user);
     return response()->json(null, 204);
  }
}
