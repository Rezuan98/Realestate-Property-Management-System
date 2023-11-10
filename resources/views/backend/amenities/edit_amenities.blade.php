@extends('admin.admin_Dashboard')


@section('admin')

<div class="page-content">

    <div class="row profile-body">
        <!-- left wrapper start -->
       
        <!-- left wrapper end -->
        <!-- middle wrapper start -->
        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add Amenites</h6>

                        <form method="POST" action="{{ route('update.amenities') }}" class="forms-sample">
                            @csrf

                                 <input type="hidden" name="id" value="{{$amenities->id}}">

                            <div class="mb-3">
                                <label for="amenities_name" class="form-label">Amenities Name</label>
                                <input type="text" name="amenities_name" class="form-control  @error('amenities_name') is-invalid @enderror" id="amenities_name" value="{{$amenities->amenities_name}}">
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
    
@endsection