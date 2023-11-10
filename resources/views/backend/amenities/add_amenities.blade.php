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

                                <h6 class="card-title">Add Amenities</h6>

                                <form id="myForm" method="POST" action="{{ route('store.amenities') }}" class="forms-sample">
                                    @csrf



                                    <div class="form-group mb-3">
                                        <label for="amenities_name" class="form-label">Amenities Name</label>
                                        <input type="text" name="amenities_name"
                                            class="form-control @error('amenities_name') is-invalid @enderror"
                                            id="amenities_name">
                                        @error('amenities_name')
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
    
      <script type="text/javascript">
        $(document).ready(function (){
            $('#myForm').validate({
                rules: {
                    amenities_name: {
                        required : true,
                    }, 
                    
                },
                messages :{
                    field_name: {
                        required : 'Please Enter Amenities Name',
                    }, 
                     
    
                },
                errorElement : 'span', 
                errorPlacement: function (error,element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight : function(element, errorClass, validClass){
                    $(element).addClass('is-invalid');
                },
                unhighlight : function(element, errorClass, validClass){
                    $(element).removeClass('is-invalid');
                },
            });
        });
        
    </script>
@endsection