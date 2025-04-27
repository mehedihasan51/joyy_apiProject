<?php

namespace App\Http\Controllers\Api\Booking;

use App\Models\Booking;

use App\Models\Branche;
use Illuminate\Http\Request;
use App\Mail\BookingCountMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $bookings = Booking::latest()->get();
        if ($bookings->isEmpty()) {
            return response()->json(['message' => 'No bookings found'], 404);
        }
        // Check if the branches have bookings associated with them
        return response()->json($bookings);
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
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'first_name'       => 'required|string|max:255',
    //         'last_name'        => 'nullable|string|max:255',
    //         'phone'            => 'required|string|max:20',
    //         'email'            => 'required|email|max:255',
    //         'agree'            => 'boolean',
    //         'branche_id'       => 'required|exists:branches,id',
    //         'day'              => 'required|date',
    //         'type'             => 'required|in:morning,midday,afternoon',
    //         'category'         => 'required|in:one_time,weekly,bi_weekly,monthly',
    //         'subcategory'      => 'required|in:basic,deep,steam,move',
    //         'square'           => 'required|integer|min:1',
    //         'bedroom'          => 'nullable|integer|min:0',
    //         'bathroom'         => 'nullable|integer|min:0',
    //         'carpet'           => 'nullable|integer|min:0',
    //         'interior'         => 'nullable|array',
    //         'price'            => 'required|numeric|min:0',
    //         'address'          => 'required|string|max:255',
    //         'apartment'        => 'nullable|string|max:255',
    //         'city'             => 'required|string|max:255',
    //         'state'            => 'required|string|max:255',
    //         'zip'              => 'required|string|max:10',
    //         'tc'               => 'boolean',
    //         'transaction_id'   => 'nullable|string|max:255',
    //         'status'           => 'in:unpaid,paid,failed',
    //     ]);

    //     // $validated['interior'] = $request->has('interior') ? json_encode($request->interior) : null;

    //     // $model = Booking::create($validated);

    //     // return response()->json(['message' => 'Booking created successfully.', 'data' => $model], 201);

    //     $booking = Booking::create($validated);

    //     if (!$booking) {
    //         return response()->json(['message' => 'Booking creation failed'], 500);
    //     }
    //     // Optionally, you can return the created booking data

    //     return response()->json([
    //         'message' => 'Booking created successfully.',
    //         'data' => $booking
    //     ], 201);
    // }



public function store(Request $request)
{
    $validated = $request->validate([
        'first_name'       => 'required|string|max:255',
        'last_name'        => 'nullable|string|max:255',
        'phone'            => 'required|string|max:20',
        'email'            => 'required|email|max:255',
        'agree'            => 'boolean',
        'branche_id'       => 'required|exists:branches,id',
        'day'              => 'required|date',
        'type'             => 'required|in:morning,midday,afternoon',
        'category'         => 'required|in:one_time,weekly,bi_weekly,monthly',
        'subcategory'      => 'required|in:basic,deep,steam,move',
        'square'           => 'required|integer|min:1',
        'bedroom'          => 'nullable|integer|min:0',
        'bathroom'         => 'nullable|integer|min:0',
        'carpet'           => 'nullable|integer|min:0',
        'interior'         => 'nullable|array',
        'price'            => 'required|numeric|min:0',
        'address'          => 'required|string|max:255',
        'apartment'        => 'nullable|string|max:255',
        'city'             => 'required|string|max:255',
        'state'            => 'required|string|max:255',
        'zip'              => 'required|string|max:10',
        'tc'               => 'boolean',
        'transaction_id'   => 'nullable|string|max:255',
        'status'           => 'in:unpaid,paid,failed',
    ]);

    $booking = Booking::create($validated);

    if (!$booking) {
        return response()->json(['message' => 'Booking creation failed'], 500);
    }

    // ✅ SEND MAIL AFTER BOOKING CREATED
    Mail::to('admin@gmail.com')->send(new BookingCountMail());

    return response()->json([
        'message' => 'Booking created successfully and email sent!',
        'data' => $booking
    ], 201);
}


    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return response()->json($booking);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking, $id)
    {

        $validated = $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'nullable|string|max:255',
            'phone'            => 'required|string|max:20',
            'email'            => 'required|email|max:255',
            'agree'            => 'boolean',
            'branche_id'       => 'required|exists:branches,id',
            'day'              => 'required|date',
            'type'             => 'required|in:morning,midday,afternoon',
            'category'         => 'required|in:one_time,weekly,bi_weekly,monthly',
            'subcategory'      => 'required|in:basic,deep,steam,move',
            'square'           => 'required|integer|min:1',
            'bedroom'          => 'nullable|integer|min:0',
            'bathroom'         => 'nullable|integer|min:0',
            'carpet'           => 'nullable|integer|min:0',
            'interior'         => 'nullable|array',
            'price'            => 'required|numeric|min:0',
            'address'          => 'required|string|max:255',
            'apartment'        => 'nullable|string|max:255',
            'city'             => 'required|string|max:255',
            'state'            => 'required|string|max:255',
            'zip'              => 'required|string|max:10',
            'tc'               => 'boolean',
            'transaction_id'   => 'nullable|string|max:255',
            'status'           => 'in:unpaid,paid,failed',
            // Add other fields as needed
        ]);
        $booking = Booking::findOrFail($id);
        $booking->update($validated);
        return response()->json([
            'message' => 'Booking updated successfully.',
            'data' => $booking
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Booking $booking, $id)
    {
        $booking = Booking::findOrFail($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }
        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully'], 200);

        
        

    }
}
