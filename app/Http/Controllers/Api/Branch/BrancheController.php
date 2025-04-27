<?php

namespace App\Http\Controllers\Api\Branch;
use Google\Rpc\Help;

use App\Helpers\Helper;
use App\Models\Branche;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrancheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $branches = Branche::latest()->get();

        // if ($branches->isEmpty()) {
        //     return response()->json(['message' => 'No branches found'], 404);
        // }

        // return response()->json($branches);


        $branches = Branche::with('bookings')->latest()->get();
        if ($branches->isEmpty()) {
            return response()->json(['message' => 'No branches found'], 404);
        }
        // Check if the branches have bookings associated with them
        return response()->json($branches);
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
        
        $request->validate([
            'zip' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'state' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $branche = Branche::create($request->all());

        if (!$branche) {
            return response()->json(['message' => 'Branch creation failed'], 500);

        }

        return response()->json($branche, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Branche $branche)
    {
        return response()->json($branche);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branche $branche)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branche $branche)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branche $branche)
    {
        //
    }
}
