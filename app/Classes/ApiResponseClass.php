<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ApiResponseClass
{
    /**
     * Rollback the database transaction and throw a response error
     */
    public static function rollback($e, $message = "Something went wrong!")
    {
        DB::rollBack();
        self::throw($e, $message);
    }

    /**
     * Throw a generic HTTP response error
     */
    public static function throw($e, $message = "Something went wrong!")
    {
        Log::error($e);
        throw new HttpResponseException(response()->json(["message" => $message], 500));
    }

    /**
     * Send a successful response
     */
    public static function sendResponse($result = "", $message, $code = 200)
    {
        $response = [
            'success' => true,
            'data' => $result,
        ];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }

    /**
     * Handle validation errors and send a formatted response
     */
    public static function sendValidationError(ValidationException $exception)
    {
        // Extract the validation error messages
        $errors = $exception->errors();
        $message = 'Validation failed';

        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], 422); // Unprocessable Entity
    }
}
