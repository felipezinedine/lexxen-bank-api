<?php

namespace App\Http\Controllers\Api;

use App\Application\DTOs\Account\CreateDTO;
use App\Domain\Account\Services\AccountService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function store (Request $request)
    {
        try {
            return response()->json($this->accountService->store($request));
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function alterStatus (Request $request)
    {
        try {
            return response()->json($this->accountService->alterStatus($request));
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
}
