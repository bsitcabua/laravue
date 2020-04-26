<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function validateRequest($request = null)
    {
        // https://www.tutorialspoint.com/http/http_status_codes.htm
        // 200 OK - The request is OK.
        // 201 Created - The request is complete, and a new resource is created.
        // 422 Validation field.
        // 403 Forbidden - Access is forbidden to the requested page.
        // 404 Not Found - The server can not find the requested page.
        // 409 Conflict	The request could not be completed because of a conflict.
        // 500 Internal Server Error - The request was not completed. The server met an unexpected condition.

        try {

            if($request->validator->fails())
                $response = [ 'status' => 422, 'validator' => $request->validator->errors()];
            else
                $response = null;

            return $response;

        } catch(\Throwable $e) {
            throw $e;
        }

    }
}
