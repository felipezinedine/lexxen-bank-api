<?php

namespace App\Http\Controllers\Api;

use App\Domain\Transfers\Services\TransfersService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransfersController extends Controller
{
    protected TransfersService $tranfersService;

    public function __construct (TransfersService $tranfersService)
    {
        $this->tranfersService = $tranfersService;
    }

    public function store (Request $request)
    {
        try {
            return response()->json($this->tranfersService->transfer($request));
        } catch (Exception | ValidationException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
}
