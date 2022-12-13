
@inject('Department', 'App\Models\Department')
@inject('Course', 'App\Models\Course')
@php
    $dept = $Department->latest('id')->get();
    $course = $Course->latest('id')->get();
@endphp
<!-- Manage User Modals -->
<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">New User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('user.add')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="type" class="col-form-label ms-2">Role</label>
                                    <select class="form-control rounded-pill role" name="type" onchange="showDets()">
                                        <option selected disabled> -Role- </option>
                                        <option value="1"> Admin </option>
                                        <option value="2"> SAST Officer </option>
                                        <option value="3"> Faculty </option>
                                        <option value="4"> Student </option>
                                    </select>
                                 </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="email" class="col-form-label ms-2">Email</label>
                                    <input type="email" class="form-control rounded-pill email" name="email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="password" class="col-form-label ms-2">Password</label>
                                    <input type="text" class="form-control rounded-pill password" name="password">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="col-form-label ms-2">Confirm Password</label>
                                    <input type="text" class="form-control rounded-pill password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        <div id="notAdmin">
                            <div class="row mt-3">
                                <div class="col">
                                    <h4> Basic Information </h4> <hr/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" id="faculty" style="display: none">
                                    <div class="mb-3">
                                        <label for="department_id" class="col-form-label ms-2">Department</label>
                                        <select class="select form-select rounded-pill" name="department_id">
                                            <option selected disabled> -Select- </option>
                                            @unless($dept->isEmpty())
                                                @foreach($dept as $det)
                                                    <option value="{{$det->id}}"> {{$det->description}} </option>
                                                @endforeach
                                            @else
                                                <option disabled> Department is empty. </option>
                                            @endunless
                                        </select>
                                    </div>
                                </div>
                                <div class="col" id="student" style="display: none">
                                    <div class="mb-3">
                                        <label for="course_id" class="col-form-label ms-2">Course</label>
                                        <select class="select form-select rounded-pill" name="course_id">
                                            <option selected disabled> -Select- </option>
                                            @unless($course->isEmpty())
                                                @foreach($course as $det)
                                                    <option value="{{$det->id}}"> {{$det->description}} </option>
                                                @endforeach
                                            @else
                                                <option disabled> Course is empty. </option>
                                            @endunless
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5" id="SID" style="display: none">
                                    <!-- ID Number input -->
                                    <div class="mb-4">
                                        <label class="form-label ms-2" for="id_number">ID Number</label>
                                        <input type="text" name="id_number" id="id_number" class="form-control rounded-pill" value="{{old('id_number')}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <!-- First Name input -->
                                    <div class="mb-4">
                                        <label class="form-label ms-2" for="fname">First Name</label>
                                        <input type="text" name="fname" id="fname" class="form-control rounded-pill" value="{{old('fname')}}"/>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Middle Name input -->
                                    <div class="mb-4">
                                        <label class="form-label ms-2" for="mname">Middle Name</label>
                                        <input type="text" name="mname" id="mname" class="form-control rounded-pill" value="{{old('mname')}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <!-- Last Name input -->
                                    <div class="mb-4">
                                        <label class="form-label ms-2" for="lname">Last Name</label>
                                        <input type="text" name="lname" id="lname" class="form-control rounded-pill" value="{{old('lname')}}"/>
                                    </div>
                                </div>
                                <!-- Suffix input -->
                                <div class="col">
                                    <div class="mb-4">
                                        <label class="form-label ms-2" for="suffix">Suffix</label>
                                        <input type="text" name="suffix" id="suffix" class="form-control rounded-pill" value="{{old('suffix')}}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add User Modal -->
<!-- Manage User Modals -->
<script>
    //Add User Scripts
    function showDets()
    {
        const currentSelected = document.querySelector('.modal-body .role');
        const divA = document.getElementById('notAdmin');
        const divF = document.getElementById('faculty');
        const divS = document.getElementById('student');
        const divSID = document.getElementById('SID');

        if(currentSelected.value == 3)
        {
            divA.style.display = 'block';
            divF.style.display = 'block';
            divS.style.display = 'none';
            divSID.style.display = 'none';
        }
        else if(currentSelected.value == 4)
        {
            divA.style.display = 'block';
            divF.style.display = 'none';
            divS.style.display = 'block';
            divSID.style.display = 'block';
        }
        else if(currentSelected.value == 2)
        {
            divA.style.display = 'block';
            divF.style.display = 'none';
            divS.style.display = 'none';
            divSID.style.display = 'none';
        }
        else
            divA.style.display = 'none';
    }
</script>
