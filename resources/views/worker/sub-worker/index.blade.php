@extends('worker.layout.app')
@push('title') {{ __('Sub Worker') }} @endpush
@push('head')
<style>
    #imagePreview {
        max-width: 64px;
        max-height: 64px;
        margin-top: 10px;
    }
</style>
@endpush
@section('content')
<div class="container">
    <div class="card shadow mt-4">
        <div class="card-header">
            <h4 class="card-title">Worker List
                <a class="btn btn-primary float-right" href="{{ route('worker.sub-worker.create') }}"
                    data-toggle="modal" data-target="#addModal">Add Worker</a>
            </h4>

        </div>
        <div class="card-body">
            @if ($message = Session::get('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div>
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>SI</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>NID</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ asset('uploads/images/worker') }}/{{ $user->image }}"
                                    class="img-thumbnail img-circle" alt="" width="48px"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->nid }}</td>
                            <td>{{ Str::ucfirst($user->is_verified) }}</td>
                            <td title="">
                                {{ $user->created_at->diffForHumans() }}
                                <br>
                                <small>{{ $user->created_at }}</small>
                            </td>
                            <td>
                                <a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#addModal">Edit</a>
                                <a class="btn btn-danger btn-sm dltBtn">Delete</a>
                                <form id="dltForm" action="{{route('worker.sub-worker.destroy', $user->id)}}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <!-- Your form fields here -->
                                    {{-- <button type="button" id="submitButton">Submit</button> --}}
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


{{-- Worker Add Modal --}}
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add/ Edit Worker</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('worker.sub-worker.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">(*)</span></label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp"
                            placeholder="Enter name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" id="phone" aria-describedby="emailHelp"
                            placeholder="Enter phone number" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                            placeholder="Enter email" name="email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                            else.</small>
                    </div>
                    <div class="form-group">
                        <label for="nid">NID Number <span class="text-danger">(*)</span></label>
                        <input type="number" class="form-control" name="nid" id="nid" placeholder="nid" required>
                    </div>
                    <input type="hidden" name="sp_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        <label for="customFile">Upload Photo <span class="text-danger">(*)</span></label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div id="imagePreview"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Worker</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

// Delete data
$(".dltBtn").click(function() {
        // Submit the form
if(confirm('Are you sure want to delete this data?')){
            $("#dltForm").submit(); 
}
    });


    $('#customFile').on('change', function(e) {
    var file = e.target.files[0];
    if (file) {
    var reader = new FileReader();
    reader.onload = function(e) {
    $('#imagePreview').html('<img src="' + e.target.result + '" class="img-thumbnail img-circle" alt="Image Preview">');
    };
    reader.readAsDataURL(file);
    }
    });
    });
</script>
@endsection