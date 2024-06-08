<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class ExceptionController extends Controller
{
    /**
     * Handle user not found exception.
     *
     * @return \Illuminate\Http\Response
     */
    public function userNotFound()
    {
        return response()->json([
            'error' => 'User not found'
        ], 404);
    }

    /**
     * Handle unauthorized access exception.
     *
     * @return \Illuminate\Http\Response
     */
    public function unauthorizedAccess()
    {
        return response()->json([
            'error' => 'Unauthorized access'
        ], 403);
    }

    /**
     * Handle generic exception.
     *
     * @param Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function handleException(Exception $exception)
    {
        return response()->json([
            'error' => 'An error occurred',
            'message' => $exception->getMessage()
        ], 500);
    }
}
