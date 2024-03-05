@extends('carousels.app')
@section('title', 'Carousels')
@section('content')
    <div class="container mt-5">
        <form id="imageForm" action="{{ route('carousels-create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="image_type" class="form-label">Image Type</label>
                        <input type="text" class="form-control" id="image_type" name="image_type">
                        <span id="image_type-error" class="alert text-danger"></span>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="image" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <span id="image-error" class="alert text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="container d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
<script>
     $(document).ready(function() {
        $('#imageForm').submit(function(event) {
            event.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                url: url,
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.success){
                        Swal.fire({
                            title: "Carousel Creation",
                            text: response.message,
                            icon: "success"
                        }).then(function (){
                            location.href = "{{route('carousels')}}";
                        });
                    }
                    if(!response.success && 'errors' in response){
                        $.each(response.errors, function(name , value) {
                            $(`#${name}-error`).text(value);
                        });
                    }
                    if(!response.success && 'error' in response){
                        alert(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
@endpush