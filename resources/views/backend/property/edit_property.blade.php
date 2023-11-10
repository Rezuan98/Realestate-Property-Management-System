@extends('admin.admin_Dashboard')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@section('admin')
<div class="page-content">

<div class="row profile-body">
    <!-- left wrapper start -->

    <!-- left wrapper end -->
    <!-- middle wrapper start -->
    <div class="col-md-12 col-xl-12 middle-wrapper">
        <div class="row">

            <div class="card mb-6">
                <div class="card-body">
                    <h6 class="card-title">Edit Property</h6>



                    <form id="myForm" method="post" action="{{route('update.property')}}" enctype="multipart/form-data">

                        @csrf

                        <input type="hidden" name="id" value="{{$property->id}}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Property Name</label>
                                    <input type="text" value="{{$property->property_name}}" name="property_name" class="form-control">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Property Status</label>
                                    <select class="form-select" value="{{$property->property_status}}" name="property_status" id="exampleFormControlSelect1">
                                        <option selected="" disabled="">Select Property Status</option>
                                        <option value="rent" {{$property->property_status == 'rent' ? 'selected' : ''}} >For Rent</option>
                                        <option value="buy" {{$property->property_status == 'buy' ? 'selected' : ''}}>For Buy</option>

                                    </select>
                                </div>
                            </div><!-- Col -->

                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Lowest Price</label>
                                    <input type="text" value="{{$property->lowest_price}}"  name="lowest_price" class="form-control"
                                        placeholder="Enter Lowest Price">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Max Price</label>
                                    <input type="text" value="{{$property->max_price}}"  name="max_price" class="form-control"
                                        placeholder="Enter Max Price">
                                </div>
                            </div><!-- Col -->
                            
                           


                        </div><!-- Row -->

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Bedrooms</label>
                                    <input type="text" value="{{$property->bedrooms}}"  name="bedrooms" class="form-control"
                                        placeholder="Enter Bedrooms">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Bathrooms</label>
                                    <input type="text" value="{{$property->bathrooms}}"  name="bathrooms" class="form-control"
                                        placeholder="Enter Bathrooms">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Garage</label>
                                    <input type="text" value="{{$property->garage}}"  name="garage" class="form-control" placeholder="Garage">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Garage Size</label>
                                    <input type="text" value="{{$property->garage_size}}"  name="garage_size" class="form-control"
                                        placeholder="Enter Garage Size">
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Address</label>
                                    <input value="{{$property->address}}"  type="text" name="address" class="form-control"
                                        placeholder="Enter Address">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">City</label>
                                    <input value="{{$property->city}}"  type="text" name="city" class="form-control"
                                        placeholder="Enter city">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">State</label>
                                    <input value="{{$property->state}}" type="text" name="state" class="form-control"
                                        placeholder="Enter state">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Postal Code</label>
                                    <input value="{{$property->postal_code}}"  type="text" name="postal_code" class="form-control"
                                        placeholder="Enter postal code">
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Property Size</label>
                                    <input value="{{$property->property_size}}"  type="text" name="property_size" class="form-control"
                                        placeholder="Enter  Property size">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Property Video</label>
                                    <input type="text" value="{{$property->property_video}}"  name="property_video" class="form-control"
                                        placeholder="Enter Property video">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Neighborhood</label>
                                    <input type="text" value="{{$property->neighborhood}}"  name="neighborhood" class="form-control"
                                        placeholder="Neighborhood">
                                </div>
                            </div><!-- Col -->

                        </div><!-- Row -->



                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Latitude</label>
                                    <input type="text" value="{{$property->latitude}}"  name="latitude" class="form-control"
                                        placeholder="Latitude">
                                    <a href="https://www.latlong.net/">Click Here to know your Desired Latitude</a>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" value="{{$property->longitude}}"  name="longitude" class="form-control"
                                         placeholder="Longitude">
                                    <a href="https://www.latlong.net/">Click Here to know your Desired
                                        Longitude</a>
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->




                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Property Type</label>
                                    <select name="ptype_id"  class="form-select" id="exampleFormControlSelect1">
                                        <option selected="" disabled="">Select Type</option>
                                        @foreach ($propertyType as $ptype)
                                            <option value="{{ $ptype->id }} " {{$ptype->id == $property->ptype_id ? 'selected' : ''}}>{{ $ptype->type_name }}</option>
                                        @endforeach



                                    </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Property Amenities</label>
                                    <select name="amenities_id[]"   class="js-example-basic-multiple form-select"
                                        multiple="multiple" data-width="100%">


                                        @foreach ($amenities as $item)
                                            <option value="{{ $item->id }}" {{ (in_array($item->id,$property_amenities)) ? 'selected' : ''}}>{{ $item->amenities_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Agent</label>
                                    <select name="agent" value="{{$property->lowest_price}}"  class="form-select" id="exampleFormControlSelect1">
                                        <option selected="" disabled="">Select Agent</option>
                                        @foreach ($activeAgent as $agent)
                                            <option value="{{ $agent->id }}" {{$agent->id == $property->agent_id ? 'selected' : ''}}>{{ $agent->name }}</option>
                                        @endforeach



                                    </select>
                                </div>
                            </div><!-- Col -->

                        </div><!-- Row -->
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Short Description:</label>
                                <textarea class="form-control" name="short_des" id="exampleFormControlTextarea1" rows="3">
                                    {!! $property->short_des !!}</textarea>

                            </div>

                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Long Description</label>

                                    <textarea class="form-control" name="long_des"  name="tinymce" id="tinymceExample" rows="10">
                                        {!! $property->long_des !!}</textarea>

                                </div>
                            </div><!-- Col -->

                        </div><!-- Col -->






                        <div class="form-group mb-3">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" {{$property->featured == '1' ? 'checked' : ''}}  name="featured" value="1" class="form-check-input"
                                    id="checkInline">
                                <label class="form-check-label" for="checkInline">
                                    Feature Property
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" {{$property->hot == '1' ? 'checked' : ''}}  name="hot" value="" class="form-check-input"
                                    id="checkInlineChecked" checked="">
                                <label class="form-check-label" for="checkInlineChecked">
                                    Hot Property
                                </label>
                            </div>


                        </div>


                      


                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                
                </div>
            </div>
        </div>

    </div>
</div>
<!-- middle wrapper end -->

</div>


{{-- /////////// edit thumbnail start --}}

<div class="page-content" style="margin-top: -80px">

    <div class="row profile-body">
       
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
    
                <div class="card mb-12">
                    <div class="card-body">
                        <h6 class="card-title">Edit Property</h6>
    
    
    
                        <form id="myForm" method="post" action="{{route('update.property')}}" enctype="multipart/form-data">
    
                            @csrf

                            <input type="hidden" name="id" value="{{$property->id}}">
                            <input type="hidden" name="old_image" value="{{$property->property_thumnail}}">

                            <div class="row mb-3">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Edit Main Thumbnail</label>
                                    <input type="file" name="property_thumnail" class="form-control"
                                        onChange="mainThamUrl(this)">

                                    <img src="" id="mainThmb" alt="">
                                </div>
                                

                            </div><!-- Col -->
                            <div class="form-group col-md-6">
                                <label class="form-label"></label>
                                <img src="{{asset($property->property_thumnail)}}" alt="" style="width: 100px; height:100px;">
                               

                                
                            </div>

                           
                        </div><!-- Col -->

                           </form>

                              </div>
                            </div>
                        </div>
                    </div>
                
                
                </div>
         </div>



{{-- /////////// edit thumbnail end --}}














<script type="text/javascript">
$(document).ready(function() {
    $('#myForm').validate({
        rules: {
            property_name: {
                required: true,
            },
            property_status: {
                required: true,
            },

            lowest_price: {
                required: true,
            },

            max_price: {
                required: true,
            },
            property_thumnail: {
                required: true,
            },

            property_name: {
                required: true,
            },
            ptype_id: {
                required: true,
            },


        },
        
        messages: {
            property_name: {
                required: 'Please Enter Property Name',
            },
             },

             messages: {
                property_status: {
                required: 'Please select Property Status',
            },
             },

             messages: {
                lowest_price: {
                required: 'Please Enter Lowest Price',
            },
             },
             messages: {
                max_price: {
                required: 'Please Enter Maximum Price',
            },
             },
             messages: {
                property_thumnail: {
                required: 'Please Choose a Property Thumnail',
            },
             },
             messages: {
                ptype_id: {
                required: 'Please Enter Property Type ID',
            },
             },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
    });
});
</script>
<script type="text/javascript">
function mainThamUrl(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#mainThmb').attr('src', e.target.result).width(80).height(80);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>








<script>
$(document).ready(function() {
    $('#multiImg').on('change', function() { //on file input change
        if (window.File && window.FileReader && window.FileList && window
            .Blob) //check File API supported browser
        {
            var data = $(this)[0].files; //this file data

            $.each(data, function(index, file) { //loop though each file
                if (/(\.|\/)(gif|jpe?g|png|webp)$/i.test(file
                    .type)) { //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file) { //trigger function on successful read
                        return function(e) {
                            var img = $('<img/>').addClass('thumb').attr('src',
                                    e.target.result).width(100)
                                .height(80); //create image element 
                            $('#preview_img').append(
                            img); //append image to output element
                        };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });

        } else {
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
    });
});
</script>
@endsection
