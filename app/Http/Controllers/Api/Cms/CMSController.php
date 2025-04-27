<?php

namespace App\Http\Controllers\Api\Cms;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;

use App\Models\c_m_s;
use Illuminate\Http\Request;

class CMSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all categories from the database
        $cms = c_m_s::all();
        if ($cms->isEmpty()) {
            return Helper::jsonResponse(
                false,
                'No CMS found',
                404,
                []
            );
        }
        return Helper::jsonResponse(
            true,
            'CMS fetched successfully',
            200,
            $cms
        );
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
        $validated = $request->validate([
            'page' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:c_m_s,slug',
            'title' => 'nullable|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sub_description' => 'nullable|string',
            'bg' => 'nullable|string',
            'image' => 'nullable',
            'btn_text' => 'nullable|string|max:255',
            'btn_link' => 'nullable|string|max:255',
            'btn_color' => 'nullable|string|max:255',
            'metadata' => 'nullable|array',
            'status' => 'nullable|in:active,inactive',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
        ]);

        // If metadata is an array, convert it to JSON
        // if (isset($validated['metadata']) && is_array($validated['metadata'])) {
        //     $validated['metadata'] = json_encode($validated['metadata']);
        // }

        // Handle file upload for 'image' field
        if ($request->hasFile('image')) {
            $validated['image'] = Helper::fileUpload($request->file('image'), 'cms');
        }
        // Handle file upload for 'bg' field

        

        $cms = c_m_s::create($validated);

        return response()->json([
            'message' => 'CMS section created successfully.',
            'data' => $cms,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(c_m_s $c_m_s)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(c_m_s $c_m_s)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, c_m_s $c_m_s)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(c_m_s $c_m_s)
    {
        //
    }
}
