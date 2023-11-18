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

                                <h6 class="card-title">Add Agent</h6>

                                <form id="myForm" method="POST" action="{{ route('update.agent') }}" class="forms-sample">
                                    @csrf

                                            <input type="hidden" name="id" value="{{$allAgent->id}}" id="">

                                    <div class="form-group mb-3">
                                        <label for="amenities_name" class="form-label">Agent Name</label>
                                        <input type="text" value="{{$allAgent->name}}" name="name" class="form-control">
                                            
                                        
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="amenities_name"  class="form-label">Agent Email</label>
                                        <input type="text" value="{{$allAgent->email}}" name="email"class="form-control">
                                            
                                        
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="amenities_name"  class="form-label">Agent Phone</label>
                                        <input type="text" value="{{$allAgent->phone}}" name="phone"
                                            class="form-control"
                                            >
                                        
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="amenities_name"  class="form-label">Agent Address</label>
                                        <input type="text" value="{{$allAgent->address}}" name="address"
                                            class="form-control">
                                        
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
                    name: {
                        required : true,
                    }, 
                    email: {
                        required : true,
                    },
                    phone: {
                        required : true,
                    },
                    address: {
                        required : true,
                    },
                    password: {
                        required : true,
                    },
                    
                },
                messages :{
                    name: {
                        required : 'Please Enter  Name',
                    }, 
                    email: {
                        required : 'Please Enter email',
                    }, 
                    phone: {
                        required : 'Please Enter Phone Number',
                    }, 
                    address: {
                        required : 'Please Enter Address',
                    }, 
                    password: {
                        required : 'Please Enter Password',
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