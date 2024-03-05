@extends('carousels.app')
@section('title', 'Carousels')
@section('content')
<style>
    img{
        width: 50px;
    }
</style>
    <div class="container mt-5 d-flex justify-content-center align-items-center">
        <a href="{{route('carousels-create_page')}}" class="btn btn-primary">Create New Carousel Image</a>
    </div>
    <div class="container mt-5">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Image Title</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carousels as $carousel)
                    <tr>
                        <td>{{optional($carousel)->image_type}}</td>
                        <td><img src="{{asset('/images/'.optional($carousel)->image_name)}}" alt="Image 1" class="img-fluid"></td>
                        <td>
                            <button data-id="{{$carousel->id}}" class="btn btn-danger deleteCarousel"><i class="fas fa-trash-alt"></i></button>
                            <a href="{{route('edit_page',[base64_encode($carousel->id)])}}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
    </div>
@endsection
@push('scripts')
<script>
     $(document).ready(function() {
        $('.deleteCarousel').click(function() {
            let id = $(this).data('id');
            let url = "{{route('carousel-delete')}}";
            let deleteUrl = url+"?id="+btoa(id);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        method: 'GET',
                        success: function(response) {
                            if(response.success){
                                Swal.fire({
                                    title: "Carousel Delete",
                                    text: response.message,
                                    icon: "success"
                                }).then(function (){
                                    location.reload();
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
                }
                });
            
        });
    });
</script>
@endpush