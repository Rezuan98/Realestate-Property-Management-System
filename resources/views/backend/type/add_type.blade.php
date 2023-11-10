@extends('admin.admin_Dashboard')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@section('admin')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="row profile-body">
                <!-- left wrapper start -->
               
                <!-- left wrapper end -->
                <!-- middle wrapper start -->
                <div class="col-md-8 col-xl-8 middle-wrapper">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">

                                <h6 class="card-title">Add Property Type</h6>

                                <form method="POST" action="{{ route('store.type') }}" class="forms-sample">
                                    @csrf



                                    <div class="mb-3">
                                        <label for="type_name" class="form-label">Type Name</label>
                                        <input type="text" name="type_name"
                                            class="form-control @error('type_name') is-invalid @enderror"
                                            id="type_name">
                                        @error('type_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="type_icon" class="form-label">Type Icon</label>
                                        <input type="text" name="type_icon"
                                            class="form-control @error('type_icon') is-invalid @enderror"
                                            id="type_icon">
                                        @error('type_icon')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    
                                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                    
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
                <!-- middle wrapper end -->

            </div>

        </div>
    </div>
    <script>
        $(document).ready(function(){
    
          $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
              $('#showImage').attr('src',e.target.result);
    
            }
            reader.readAsDataURL(e.target.files['0']);
    
          });
        });
      </script>
@endsection