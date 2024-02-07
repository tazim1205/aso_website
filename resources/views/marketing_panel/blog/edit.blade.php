@extends('marketing_panel.layout.app')
@push('title') {{ __('Dashboard') }} @endpush
@push('head') 
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
         
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">{{ __('Blogs') }} </h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javaScript:void();">{{ __('ashooo') }}</a></li>
                        <li class="breadcrumb-item"><a href="javaScript:void();">{{ __('Blog List') }}</a></li> 
                    </ol>
                </div>
                {{-- <div class="col-sm-3">
                    <div class="btn-group float-sm-right">
                        <button type="button" id="add-new" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-plus"></i> {{ __('Add new Blog') }}</button>
                    </div>
                </div> --}}
            </div>
            <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-8">
                    <form action="{{ route('marketing_panel.blog.update',$blog->id) }}" id="add-new-from" method="POST" enctype="multipart/form-data">
                         @csrf
                         @method('PATCH')
                        <div class="input-group input-group-lg mb-3">
                           <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('Title') }}</span>
                           </div>
                           
                           <input type="text" class="form-control" name="title" id="title" value="{{ $blog->title }}">
                        </div>
                        <div class="input-group input-group-lg mb-3">
                            <input type="file" class="form-control valid" accept="image/*" id="thumbnail_img" name="thumbnail_img"  aria-invalid="false">
                        </div>

                        <div class="input-group input-group-lg mb-3">
                            <textarea id="description" name="description" rows="4" class="form-control detail" placeholder="Blog detail ...">
                                {{ $blog->description }} 
                            </textarea>
                         </div>

                        <div class="input-group input-group-lg mb-3">
                           <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('Category') }}</span>
                           </div>
                            <select class="form-control" name="category" id="category-id">
                                <option disabled selected value="">Chose category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if ($blog->category_id == $category->id)
                                    selected
                                @endif>{{ $category->name }}</option>
                                @endforeach
                            </select> 
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary text-center">Update</button>
                    </form>
                </div>  
<script>
    $('.detail').summernote({

        tabsize: 12,
        height: 120,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['view', ['fullscreen', 'codeview']]
        ]
    });
</script>

@endsection
@push('foot')
 
   
@endpush
