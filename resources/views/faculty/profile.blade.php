<x-layout>
    <x-profile-card>
        <div class="rounded-top text-white d-flex flex-row" style="height:200px; background-image: url('{{asset('images/profile-background.png')}}')">
            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px; height: 150px; opacity:1.0">
            <img src="{{isset($det->imgPath)? '../' . $det->imgPath() : 'https://www.pngitem.com/pimgs/m/226-2267516_male-shadow-circle-default-profile-image-round-hd.png'}}"
                alt="Profile Image" class="img-fluid img-thumbnail border border-2 border-dark h-100 mt-4 mb-2"
                style="width: 150px; z-index: 1">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline pb-2 mt-n5 changeBg" data-bs-toggle="modal" data-bs-target="#changeProfileModal" style="z-index: 1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera" viewBox="0 0 16 16">
                        <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                        <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                    </svg>
                    <span style="font-size: 10px"> Change </span>
                </button>
            </div>
            <div class="ms-3 text-dark" style="margin-top: 150px; ">
            <h5 class="bg-light"> {{$det->fullName(true)}} </h5>
            </div>
        </div>
        <div class="card-body p-4 text-black mt-5">
            <div class="mb-5">
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill mx-3" viewBox="0 0 16 16">
                                <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                            </svg>
                            About
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{route('faculty.update')}}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="user_id" value="{{$det->user_id}}"/>
                                    {{-- <div class="row my-2">
                                        <div class="col-4">
                                            ID Number
                                        </div>
                                        <div class="col">
                                            <input type="text" name="id_number" id="id_number" class="form-control rounded-pill" value="{{$det->id_number}}" disabled/>
                                        </div>
                                    </div> --}}
                                <div class="row my-2">
                                    <div class="col-4">
                                        Name
                                    </div>
                                    <div class="col">
                                        <input type="text" name="fname" id="fname" class="form-control rounded-pill" placeholder="First Name" value="{{$det->fname}}"/>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" name="mname" id="mname" class="form-control rounded-pill" placeholder="Middle Name" value="{{$det->mname}}"/>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-4">

                                    </div>
                                    <div class="col">
                                        <input type="text" name="lname" id="lname" class="form-control rounded-pill" placeholder="Last Name" value="{{$det->lname}}"/>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" name="suffix" id="suffix" class="form-control rounded-pill" placeholder="Suffix" value="{{$det->suffix}}"/>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-4">
                                        Birthday
                                    </div>
                                    <div class="col">
                                        <input type="date" name="dob" id="dob" class="form-control rounded-pill" value="{{$det->dob}}"/>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-4">
                                        Email
                                    </div>
                                    <div class="col ms-3">
                                        {{$det->user->email}}
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-4">
                                        Contact Number
                                    </div>
                                    <div class="col">
                                        <input type="text" name="cnumber" id="cnumber" class="form-control rounded-pill" placeholder="Contact Number" value="{{$det->cnumber}}"/>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-4">
                                        Address
                                    </div>
                                    <div class="col">
                                        <input type="text" name="address" id="address" class="form-control rounded-pill" placeholder="Address" value="{{$det->address}}"/>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-4">
                                        Emergency Contact
                                    </div>
                                    <div class="col">
                                        <input type="text" name="emergency_cPName" id="emergency_cPName" class="form-control rounded-pill" placeholder="Name" value="{{$det->emergency_cPName}}"/>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-4">

                                    </div>
                                    <div class="col-3">
                                        <input type="text" name="emergency_cPRelationship" id="emergency_cPRelationship" class="form-control rounded-pill" placeholder="Relationship" value="{{$det->emergency_cPRelationship}}"/>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="emergency_cPNumber" id="emergency_cPNumber" class="form-control rounded-pill" placeholder="Contact Number" value="{{$det->emergency_cPNumber}}"/>
                                    </div>
                                </div>
                                <div class="row justify-content-end mt-5 me-xl-5">
                                    <div class="col-1">
                                        <!-- Submit button -->
                                        <button type="submit" class="btn btn-primary rounded-pill">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>  
                </div>
            </div>
            </div>
        </div>
    </x-profile-card>
    <x-faculty-canvas/>
</x-layout>