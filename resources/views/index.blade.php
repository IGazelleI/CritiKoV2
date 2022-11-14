<x-layout>
    <x-auth-card class="border border-secondary rounded p-3 my-5">
        <!-- Pills navs -->
        <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
            <li class="nav-item" role="presentation">
            <a
                class="nav-link active"
                id="tab-login"
                data-mdb-toggle="pill"
                href="#pills-login"
                role="tab"
                aria-controls="pills-login"
                aria-selected="true"
                >Login</a
            >
            </li>
            <li class="nav-item" role="presentation">
            <a
                class="nav-link"
                id="tab-register"
                data-mdb-toggle="pill"
                href="#pills-register"
                role="tab"
                aria-controls="pills-register"
                aria-selected="false"
                >Register</a
            >
            </li>
        </ul>
        <!-- Pills navs -->
        <!-- Pills content -->
        <div class="tab-content">
            <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                <form action="{{route('auth')}}" method="POST">
                    @csrf
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" name="email" id="email" class="form-control" value=""/>
                        <label class="form-label" for="email">Email</label>

                        @error('email')
                            <p class="text-sm text-danger ms-3">
                                {{$message}}
                            </p>
                        @enderror
                    </div>
            
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" name="password" id="password" class="form-control" />
                        <label class="form-label" for="password">Password</label>

                        @error('password')
                            <p class="text-sm text-danger ms-3">
                                {{$message}}
                            </p>
                        @enderror
                    </div>
            
                    <!-- 2 column grid layout -->
                    <div class="row mb-4">
                        <div class="col-md-6 d-flex justify-content-center">
                            <!-- Checkbox -->
                            <div class="form-check mb-3 mb-md-0">
                                <input class="form-check-input" type="checkbox" value="" id="loginCheck"/>
                                <label class="form-check-label" for="loginCheck"> Remember me </label>
                            </div>
                        </div>
                
                        <div class="col-md-6 d-flex justify-content-center">
                            <!-- Simple link -->
                            <a href="{{route('password.request')}}">Forgot password?</a>
                        </div>
                    </div>
            
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
                </form>
            </div>
            <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{route('register')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <!-- ID Number input -->
                            <div class="form-outline mb-4">
                                <input type="text" name="id_number" id="id_number" class="form-control" value="{{old('id_number')}}"/>
                                <label class="form-label" for="id_number">ID Number</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <!-- First Name input -->
                            <div class="form-outline mb-4">
                                <input type="text" name="fname" id="fname" class="form-control" value="{{old('fname')}}"/>
                                <label class="form-label" for="fname">First Name</label>
                            </div>
                        </div>
                        <div class="col">
                            <!-- Middle Name input -->
                            <div class="form-outline mb-4">
                                <input type="text" name="mname" id="mname" class="form-control" value="{{old('mname')}}"/>
                                <label class="form-label" for="mname">Middle Name</label>
                            </div>
                        </div>
                        <div class="col">
                            <!-- Last Name input -->
                            <div class="form-outline mb-4">
                                <input type="text" name="lname" id="lname" class="form-control" value="{{old('lname')}}"/>
                                <label class="form-label" for="lname">Last Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Suffix input -->
                        <div class="col">
                            <div class="form-outline mb-4">
                                <input type="text" name="suffix" id="suffix" class="form-control" value="{{old('suffix')}}"/>
                                <label class="form-label" for="suffix">Suffix</label>
                            </div>
                        </div>
                        <!-- Gender input -->
                        <div class="col">
                            <div class="form-outline mb-4">
                                <select class="select form-select" name="gender">
                                    <option selected disabled>Gender</option>
                                    <option value="Male" >Male</option>
                                    <option value="Female">Female</option>
                                  </select>
                            </div>
                        </div>
                    </div>
                    <!-- Address input -->
                    <div class="form-outline mb-4">
                        <input type="text" name="address" id="address" class="form-control" value="{{old('address')}}"/>
                        <label class="form-label" for="address">Address</label>
                    </div>
                    <div class="row">
                        <!-- DOB input -->
                        <div class="col">
                            <div class="form-outline mb-4">
                                <input type="date" name="dob" id="dob" class="form-control" value="{{old('dob')}}"/>
                                <label class="form-label active" for="dob">Date of Birth</label>
                            </div>
                        </div>
                        <!-- Contact Number input -->
                        <div class="col">
                            <div class="form-outline mb-4">
                                <input type="text" name="cnumber" id="cnumber" class="form-control" value="{{old('cnumber')}}"/>
                                <label class="form-label" for="cnumber">Contact Number</label>
                            </div>
                        </div>
                    </div>
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}"/>
                        <label class="form-label" for="email">Email</label>
                    </div>
                    <div class="row">
                        <div class="col">
                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" name="password" id="password" class="form-control" />
                                <label class="form-label" for="password">Password</label>
                            </div>
                        </div>
                        <div class="col">
                            <!-- Repeat Password input -->
                            <div class="form-outline mb-6">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" />
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                            </div>
                        </div>
                    </div>
            
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-3">Sign up</button>
                </form>
            </div>
        </div>
        <!-- Pills content -->
    </x-auth-card>
</x-layout>