<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Helpers\Helper;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;


class ServicesController extends Controller
{

    /** Display the Products page.
     *
     * @ return View
     * @ param Request request
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Service::with('category')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($service) {
                    if ($service->image) {
                        return '<img src="' . asset($service->image) . '" width="60" height="50" class="">';
                    }
                    return "No image Here";
                })
                ->addColumn('status', function ($service) {
                    $status = '<div class="form-check form-switch" style="margin-left: 40px; width: 50px; height: 24px;">';
                    $status .= '<input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck' . $service->id . '" ' . ($service->status == 'active' ? 'checked' : '') . ' onclick="showStatusChangeAlert(' . $service->id . ')">';
                    $status .= '</div>';

                    return $status;
                })
                ->addColumn('category_title', function ($service) {
                    return $service->category ? $service->category->title : 'No Category';
                })
                ->addColumn('action', function ($service) {
                    return '
                            <div class="hstack gap-3 fs-base">
                                <a href="' . route('service.edit', ['id' => $service->id]) . '" class="link-primary text-decoration-none" title="Edit">
                                    <i class="ri-pencil-line" style="font-size: 24px;"></i>
                                </a>

                                 <a href="javascript:void(0);" onclick="viewService(' . $service->id . ')"  class="link-primary text-decoration-none" title="View" data-bs-toggle="modal" data-bs-target="#viewServiceModal">
                                 <i class="ri-eye-line" style="font-size: 24px;"></i>
                               </a>

                                <a href="javascript:void(0);" onclick="showDeleteConfirm(' . $service->id . ')" class="link-danger text-decoration-none" title="Delete">
                                    <i class="ri-delete-bin-5-line" style="font-size: 24px;"></i>
                                </a>
                                
                            </div>
                        ';
                })

                ->rawColumns(['category_title', 'image', 'status', 'action'])
                ->make();
        }
        return view('backend.layouts.services.index');
    }

    /**
     * Display the specified service details.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $service = Service::findOrFail($id);
            $title = $service->title ?? 'N/A';
            $description = $service->description ?? 'N/A';
            $description = $service->description ?? 'N/A';
            $subDescription = $service->sub_description ?? 'N/A';

            return response()->json([
                'id'              => $service->id,
                'title'          => $title,
                'description'     => $description,
                'sub_description' => $subDescription,
                'image'           => $service->image_url
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                't-error'   => 'Failed to Show',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified Service create.
     *
     *
     * @return View
     */

    public function create()
    {
        $categories = Category::all();
        return view('backend.layouts.services.create', compact('categories'));
    }

    /**
     * Store a newly created clients Service in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'            => 'required|string|max:50',
            'image'            => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:10240',
            'description'      => 'required|string',
            'sub_description'  => 'required|string',
            'category_id'      => 'required|exists:categories,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $service = new Service();
            $service->title = $request->title;
            $service->description = $request->description;
            $service->sub_description = $request->sub_description;
            $service->category_id = $request->category_id;

            if ($request->input('remove_image') == 1) {
                if (!empty($service->image)) {
                    Helper::fileDelete(public_path($service->image));
                    $service->image = null;
                }
            }

            if ($request->hasFile('image')) {
                $service->image = Helper::fileUpload($request->file('image'), 'service_image');
            } else {
                return redirect()->back()->with('t-error', 'Image file is required');
            }

            $service->save();

            return redirect()->route('service.index')->with('t-success', 'Service created successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Failed to save: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified Service Edit.
     *
     * @param  int  $id
     * @return View
     */

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $categories = Category::all();
        return view('backend.layouts.services.edit', compact('service', 'categories'));
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
            'title'            => 'required|string|max:50',
            'image'            => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:10240',
            'description'      => 'required|string',
            'sub_description'  => 'required|string',
            'category_id'      => 'required|exists:categories,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $service = Service::findOrFail($id);
            $service->title = $request->title;
            $service->description = $request->description;
            $service->sub_description = $request->sub_description;
            $service->category_id = $request->category_id;

            if ($request->input('remove_image') == 1) {
                if (!empty($service->image)) {
                    Helper::fileDelete(public_path($service->image));
                    $service->image = null;
                }
            }

            if ($request->hasFile('image')) {
                if (!empty($service->image)) {
                    Helper::fileDelete(public_path($service->image));
                }

                $service->image = Helper::fileUpload($request->file('image'), 'service_image');
            }

            $service->save();
            return redirect()->route('service.index')->with('t-success', 'Service updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Failed to update');
        }
    }

    /**
     * Change the status of the specified service.
     *
     * @param int $id
     * @return JsonResponse
     */

    public function status(int $id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->status = ($service->status == 'active') ? 'inactive' : 'active';
            $service->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status!',
            ], 500);
        }
    }

    /**
     * Remove the specified service from storage.
     *
     * @param int $id
     * @return JsonResponse
     */

    public function destroy(int $id)
    {
        try {
            $service = Service::findOrFail($id);

            if ($service->image) {
                $filePath = public_path(str_replace(url('/'), '', $service->image));

                if (file_exists($filePath)) {
                    Helper::fileDelete($filePath);
                }
            }

            $service->delete();

            return response()->json([
                't-success' => true,
                'message'   => 'Deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                't-success' => false,
                'message'   => 'An error occurred while deleting the service.',
                'error'     => $e->getMessage(),
            ], 500);
        }
    }
}
