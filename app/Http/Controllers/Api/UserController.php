<?php

namespace App\Http\Controllers\Api;

use App\Application\DTOs\User\UpdateDTO;
use App\Domain\User\Services\UserService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index ()
    {
        try {
            return response()->json($this->userService->fetchAllUsers(), 200);
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function show (int $userId)
    {
        try {
            return response()->json($this->userService->fetchUserById($userId), 200);
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function update (Request $request, int $userId)
    {
        try {
            $dto = new UpdateDTO($request->all());
            return response()->json($this->userService->update($dto, $userId), 200);
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function store (Request $request)
    {
        try {
            return response()->json($this->userService->store($request), 200);
        } catch (Exception | ValidationException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function delete (int $userId)
    {
        try {
            return response()->json($this->userService->delete($userId), 200);
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
}
