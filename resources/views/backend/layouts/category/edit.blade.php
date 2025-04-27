@extends('backend.app')

@section('title', 'Category')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- start page title --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Categories
                                    Feedback</a>
                            </li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        {{-- end page title --}}

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('category.update',['id' => $category->id])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row gy-2">

                                <div class="col-md-12">
                                    <div>
                                        <label for="title" class="form-label">Title:</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" placeholder="Please Enter Title"
                                            value="{{ old('title',$category->title) }}">
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div>
                                        <label for="icon" class="form-label">Icon:</label>
                                        <input type="hidden" name="remove_icon" id="remove_icon" value="0">
                                        <input type="file" class="form-control dropify @error('icon') is-invalid @enderror"
                                               id="icon" name="icon" placeholder="Please Enter icon"
                                               data-default-file="{{ isset($category->icon) ? asset($category->icon) : '' }}">
                                                 <!-- Hidden field to track image removal -->
                                            <input type="hidden" name="remove_icon" id="remove_icon" value="0">
                                        @error('icon')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        
                                      
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{route('category.index')}}" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var drEvent = $('.dropify').dropify();
  
        drEvent.on('dropify.afterClear', function (event, element) {
            $('#remove_icon').val(1);
        });
    });
  </script>
@endpush