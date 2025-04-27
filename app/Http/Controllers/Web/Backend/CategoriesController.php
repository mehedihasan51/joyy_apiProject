<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Helpers\Helper;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /** Display the Products page.
     *
     * @ return View
     * @ param Request request
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('icon', function ($category) {
                    if ($category->icon) {
                        return '<img src="' . asset($category->icon) . '" width="60" height="50" class="">';
                    }
                    return "No Icon Here";
                })
                ->addColumn('status', function ($category) {
                    $status = '<div class="form-check form-switch" style="margin-left: 40px; width: 50px; height: 24px;">';
                    $status .= '<input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck' . $category->id . '" ' . ($category->status == 'active' ? 'checked' : '') . ' onclick="showStatusChangeAlert(' . $category->id . ')">';
                    $status .= '</div>';

                    return $status;
                })
                ->addColumn('action', function ($category) {
                    return '
                            <div class="hstack gap-3 fs-base">
                                <a href="' . route('category.edit', ['id' => $category->id]) . '" class="link-primary text-decoration-none" title="Edit">
                                    <i class="ri-pencil-line" style="font-size: 24px;"></i>
                                </a>

                                <a href="javascript:void(0);" onclick="showDeleteConfirm(' . $category->id . ')" class="link-danger text-decoration-none" title="Delete">
                                    <i class="ri-delete-bin-5-line" style="font-size: 24px;"></i>
                                </a>
                            </div>
                        ';
                })

                ->rawColumns(['icon', 'status', 'action'])
                ->make();
        }


        return view('backend.layouts.category.index');
    }

    /**
     * Show the form for editing the specified client feedback.
     *
     * @param  int  $id
     * @return View
     */

    public function create()
    {

        return view('backend.layouts.category.create');
    }

    /**
     * Show the form for editing the specified client feedback.
     *
     * @param  int  $id
     * @return View
     */

    public function edit(int $id)
    {
        $category = Category::findOrFail($id);
        return view('backend.layouts.category.edit', compact('category'));
    }

    /**
     * Update the specified client feedback in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */

    public function update(Request $request, int $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'icon' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $category = Category::findOrFail($id);
            $category->title = $request->title;

            if ($request->input('remove_icon') == 1) {
                if (!empty($category->icon)) {
                    Helper::fileDelete(public_path($category->icon));
                    $category->icon = null;
                }
            }

            if ($request->hasFile('icon')) {
                if (!empty($category->icon)) {
                    Helper::fileDelete(public_path($category->icon));
                }

                $category->icon = Helper::fileUpload($request->file('icon'), 'category_icon');
            }

            // dd($category->icon, public_path($category->icon), file_exists(public_path($category->icon)));
            $category->save();

            return redirect()->route('category.index')->with('t-success', 'Category updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Failed to update');
        }
    }


    

    /**
     * Store a newly created clients category in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'icon' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $category = new Category();
            $category->title = $request->title;

            if ($request->boolean('remove_icon')) {
                if ($category->icon) {
                    Helper::fileDelete(public_path($category->icon));

                    $category->icon = null;
                }
            } elseif ($request->hasFile('icon')) {

                if ($category->icon) {
                    Helper::fileDelete(public_path($category->icon));
                }

                $category->icon = Helper::fileUpload($request->file('icon'), 'category_icon');
            }
            

            $category->save();
            return redirect()->route('category.index')->with('t-success', 'Category created successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Failed to create');
        }
    }

    /**
     * Change the status of the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */

    public function status(int $id)
    {

        try {
            $category = Category::findOrFail($id);
            $category->status = ($category->status == 'active') ? 'inactive' : 'active';
            $category->save();

            return response()->json([
                't-success' => true,
                'message' => 'Status updated successfully!'
            ]);
        } catch (Exception $e) {

            return response()->json([
                't-success' => false,
                'message' => 'Status updated Failed!'

            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {

        try {

            $category = Category::findOrFail($id);

            if ($category->icon) {
                $filePath = public_path(str_replace(url('/'), '', $category->icon));

                if (file_exists($filePath)) {
                    Helper::fileDelete($filePath);
                }
            }

            $category->delete();

            return response()->json([
                't-success'  => true,
                'message' => 'Deleted successfully.',
            ]);
        } catch (Exception $e) {

            return response()->json([
                't-success' => false,
                'message' => 'Deleted Failed!'
            ]);
        }
    }
}
