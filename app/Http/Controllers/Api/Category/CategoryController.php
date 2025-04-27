<?php

namespace App\Http\Controllers\Api\Category;

use App\Helpers\Helper;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Fetch all categories from the database

        $categories = Category::all();
        return response()->json($categories);
    }



    public function details(Request $request)
    {

        $numberOfCategories = $request->input('details');
        $category = Category::where('status', 'active')
            ->latest()
            ->take($numberOfCategories)
            ->get();
        if ($category->isEmpty()) {
            return Helper::jsonResponse(
                false,
                'No Category found',
                404,
                []
            );
        }
        return Helper::jsonResponse(
            true,
            'Category fetched successfully',
            200,
            $category
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
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'slug' => 'required|string|max:255|unique:categories,slug',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

    //     ]);

    //     $category = new Category();
    //     $category->name = $request->name;
    //     $category->slug = $request->slug;

    //     if ($request->hasFile('image')) {
    //         $category->image = $request->file('image')->store('categories', 'public');
    //     }

    //     $category->save();

    //     return response()->json(['message' => 'Category created successfully', 'category' => $category], 201);
    // }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;

        if ($request->hasFile('image')) {
            // Use your helper instead of store()
            $uploadedPath = Helper::fileUpload($request->file('image'), 'categories', $request->name);

            if ($uploadedPath) {
                $category->image = $uploadedPath;
            } else {
                // Handle upload failure if needed
                return response()->json(['message' => 'Image upload failed'], 500);
            }
        }

        $category->save();

        return response()->json(['message' => 'Category created successfully', 'category' => $category], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Category $category, $id)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $category = Category::find($id);

    //     if (!$category) {
    //         return response()->json(['message' => 'Category not found'], 404);
    //     }

    //     $category->name = $request->name;
    //     $category->slug = $request->slug;

    //     if ($request->hasFile('image')) {
    //         // Delete the old image if it exists
    //         if ($category->image) {
    //             Helper::fileDelete($category->image);
    //         }

    //         // Use your helper instead of store()
    //         $uploadedPath = Helper::fileUpload($request->file('image'), 'categories', $request->name);

    //         if ($uploadedPath) {
    //             $category->image = $uploadedPath;
    //         } else {
    //             // Handle upload failure if needed
    //             return response()->json(['message' => 'Image upload failed'], 500);
    //         }
    //     }

    //     $category->save();

    //     return response()->json(['message' => 'Category updated successfully', 'category' => $category], 200);
    // }


    public function update(Request $request, $id)
    {
        $category = Category::find($id);
    
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
    
        // 1. Validate first
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($category->name === $validated['name']) {
           return response()->json(['message' => 'No changes detected'], 200);
        }
        if ($category->slug === $validated['slug']) {
            return response()->json(['message' => 'No changes detected'], 200);
        }
    
        // 2. Prepare Image (if uploaded)
        $imagePath = $category->image;
    
        if ($request->hasFile('image')) {
            if ($category->image) {
                Helper::fileDelete($category->image);
            }
    
            $uploadedPath = Helper::fileUpload($request->file('image'), 'categories', $validated['name']);
    
            if ($uploadedPath) {
                $imagePath = $uploadedPath;
            } else {
                return response()->json(['message' => 'Image upload failed'], 500);
            }
        }
    
        // 3. Update safely
        $category->updateOrFail([
            'name' => $validated['name'],   // now guaranteed to not be NULL
            'slug' => $validated['slug'],   // now guaranteed to not be NULL
            'image' => $imagePath,
        ]);
    
        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category,
        ], 200);
    }
    
    
    


    /**
     * Remove the specified resource from storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Delete the image file if it exists
        if ($category->image) {
            Helper::fileDelete($category->image);
        }

        // Delete the category from the database
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        // Delete the image file if it exists
        if ($category->image) {
            Helper::fileDelete($category->image);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
