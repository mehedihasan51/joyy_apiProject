@extends('backend.app')

@section('title', 'Services')

@section('content')

<div class="page-content">
    <div class="container-fluid">
        {{-- start page title --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('service.index')}}">Services
                                    Section</a>
                            </li>
                            <li class="breadcrumb-item active">Create</li>
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
                        <form action="{{route('service.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-2">

                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="title" class="form-label">Title:</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                id="title" name="title" placeholder="Please Enter Title"
                                                value="{{ old('title') }}">
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                        <div class="col-md-6">

                                            <label for="category_id" class="form-label">Category:</label>
                                            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="container">
                                    <div class="row mt-3">
                                        <!-- First Column: Description -->
                                        <div class="col-md-6">
                                            <label for="description" class="form-label">Description:</label>
                                            <textarea class="form-control description @error('description') is-invalid @enderror"
                                                id="description" name="description" placeholder="Please Enter Description">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                
                                        <!-- Second Column: Sub Description -->
                                        <div class="col-md-6">
                                            <label for="sub_description" class="form-label">Sub Description:</label>
                                            <textarea class="form-control description @error('sub_description') is-invalid @enderror"
                                                id="sub_description" name="sub_description" placeholder="Please Enter Sub Description">{{ old('sub_description') }}</textarea>
                                            @error('sub_description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div>
                                        <label for="image" class="form-label">Image:</label>
                                        <input type="file" class="form-control dropify @error('image') is-invalid @enderror"
                                            id="image" name="image" placeholder="Please Enter image"
                                            value="{{ old('image') }}">
                                            
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{route('service.index')}}" class="btn btn-danger">Cancel</a>
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
    $(document).ready(function() {
        $('.dropify').dropify();
    });
  </script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.description').forEach(textarea => {
            ClassicEditor
                .create(textarea)
                .catch(error => {
                    console.error(error);
                });
        });
    });
</script>
@endpush