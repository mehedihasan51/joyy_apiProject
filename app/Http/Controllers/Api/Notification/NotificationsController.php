<?php

namespace App\Http\Controllers\Api\Notification;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\notifications;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation for incoming data
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'notifiable_type' => 'required|string|max:255',
            'notifiable_id' => 'required|integer',
            'data' => 'required|string',
            'read_at' => 'nullable|date',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create a new notification
        $notification = Notification::create([
            'id' => Str::uuid()->toString(), // Generates a unique UUID
            'type' => $request->type,
            'notifiable_type' => $request->notifiable_type,
            'notifiable_id' => $request->notifiable_id,
            'data' => $request->data,
            'read_at' => $request->read_at,
        ]);

        // Return a success response
        return response()->json([
            'status' => 'success',
            'message' => 'Notification created successfully.',
            'notification' => $notification
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(notifications $notification)
    {
        return response()->json(['data' => $notification], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(notifications $notifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, notifications $notifications)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(notifications $notifications)
    {
        //
    }
}
