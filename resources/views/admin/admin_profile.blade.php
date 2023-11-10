    @extends('admin.admin_Dashboard')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @section('admin')
        <div class="page-wrapper">
            <div class="page-content">

                <div class="row profile-body">
                    <!-- left wrapper start -->
                    <div class="d-none d-md-block col-md-4 col-xl-4 left-wrapper">
                        <div class="card rounded">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-2">

                                    <div>
                                        <img class="wd-100 rounded-circle"
                                            src="{{ !empty($profileData->photo) ? url('upload/admin_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                                            alt="profile">
                                        <span class="h4 ms-3">{{$profileData->name}}</span>
                                    </div>

                                </div>
                                <p>Hi! I'm Amiah the Senior UI Designer at NobleUI. We hope you enjoy the design and quality of
                                    Social.</p>
                                <div class="mt-3">
                                    <label class="tx-11 fw-bolder mb-0 text-uppercase">Username:</label>
                                    <p class="text-muted">{{$profileData->username}}</p>
                                </div>
                                <div class="mt-3">
                                    <label class="tx-11 fw-bolder mb-0 text-uppercase">phone</label>
                                    <p class="text-muted">{{$profileData->phone}}</p>
                                </div>
                                <div class="mt-3">
                                    <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                                    <p class="text-muted">{{$profileData->email}}</p>
                                </div>
                                <div class="mt-3">
                                    <label class="tx-11 fw-bolder mb-0 text-uppercase">Address</label>
                                    <p class="text-muted">{{$profileData->address}}</p>
                                </div>
                                <div class="mt-3 d-flex social-links">
                                    <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                                        <i data-feather="github"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                                        <i data-feather="twitter"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                                        <i data-feather="instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- left wrapper end -->
                    <!-- middle wrapper start -->
                    <div class="col-md-8 col-xl-8 middle-wrapper">
                        <div class="row">
                            <div class="card">
                                <div class="card-body">

                                    <h6 class="card-title">Basic Form</h6>

                                    <form method="POST" action="{{route('admin.profile.update')}}" enctype="multipart/form-data" class="forms-sample">
                                      @csrf
                                      <div class="mb-3">
                                            <label for="exampleInputUsername1" class="form-label">Username</label>
                                            <input type="text" name="username" class="form-control" id="exampleInputUsername1"
                                                autocomplete="off" value="{{$profileData->username}}">
                                        </div>


                                        <div class="mb-3">
                                          <label for="exampleInputUsername1" class="form-label">Photo</label>
                                          <input name="photo" class="form-control" type="file" id="image">
                                      </div>

                                      <div class="mb-3">
                                        <label for="exampleInputUsername1" class="form-label"></label>
                                        <img id="showImage" name="photo" class="wd-70 rounded-circle"
                                            src="{{ !empty($profileData->photo) ? url('upload/admin_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                                            alt="profile">
                                    </div>




                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                            value="{{$profileData->email}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputUsername1" class="form-label">Address</label>
                                            <input type="text" name="address" class="form-control" id="exampleInputUsername1"
                                            autocomplete="off" value="{{$profileData->address}}">
                                        </div>
                                        <div class="mb-3">
                                          <label for="exampleInputPassword1" class="form-label">Phone</label>
                                          <input type="text" name="phone" class="form-control" id="exampleInputUsername1"
                                          autocomplete="off" value="{{$profileData->phone}}">
                                      </div>
                                        
                                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                        <button class="btn btn-secondary">Cancel</button>
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
