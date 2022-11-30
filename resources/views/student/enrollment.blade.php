<x-layout>
    <x-general-card>
        <div class="row">
            <div class="col bg-info text-white mx-3 rounded-top">
                <header>
                    <h2 class="m-2"> Enrollment Form </h2>
                </header>
            </div>
        </div>
        @if(isset($enrollment))
        <div class="row">
            <div class="col">
                <h3 class="text-center {{getEnrollmentBg($enrollment->status)}} text-secondary m-2 rounded"> {{$enrollment->status}} </h3>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col">
                <form action="{{route('student.submitEnroll')}}" method="POST">
                    @csrf
                    <div class="row m-4">
                        <div class="col-3">
                            <label class="form-label ms-2" for="id_number">ID Number</label>
                            <input type="text" name="id_number" id="id_number" class="form-control rounded-pill" value="{{$det->id_number}}" disabled/>
                        </div>
                        <div class="col-6">
                            <label class="form-label ms-2">Name</label>
                            <input type="text" class="form-control rounded-pill" placeholder="Name" value="{{$det->fullName(0)}}" disabled/>
                        </div>
                    </div>
                    <div class="row m-4">
                        <label class="form-label ms-2">Program</label>
                        <div class="col">
                            <div class="form-outline mb-4">
                                <select class="select form-select rounded-pill" {{isset($enrollment)? 'disabled' : ''}} name="course_id">
                                    <option selected disabled>Course</option>
                                    @unless ($course->isEmpty())
                                        @foreach($course as $c)
                                            <option value="{{$c->id}}" {{(isset($enrollment)? ($enrollment->course_id == $c->id? 'selected' : '') : '' )}}> {{$c->name}} {{$c->description}} </option>
                                        @endforeach
                                    @else
                                        <option disabled> Currently not offering any programs. </option>
                                    @endunless
                                  </select>

                                  @error('course_id')
                                    <p class="text-sm text-danger ms-3">
                                        {{$message}}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-outline mb-4">
                                <select class="select form-select rounded-pill" {{isset($enrollment)? 'disabled' : ''}} name="year_level">
                                    <option selected disabled>Year Level</option>
                                    @for($i = 1; $i <= 4; $i++)
                                        <option value="{{$i}}" {{(isset($enrollment)? ($enrollment->year_level == $i? 'selected' : '') : '' )}}>{{$i}}</option>
                                    @endfor
                                </select>

                                @error('year_level')
                                    <p class="text-sm text-danger ms-3">
                                        {{$message}}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-end m-4">
                        <div class="col-2 mx-4">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary rounded-pill {{isset($enrollment)? 'disabled' : ''}}" data-bs-toggle="modal" data-bs-target="#confirm">
                                Submit
                            </button>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="confirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Confirmation</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            <div class="modal-body">
                                I hereby enroll chu chu.
                            </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary rounded-pill">Proceed</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-general-card>
    <x-student-canvas/>
</x-layout>
@php
    function getEnrollmentBg($status)
    {
        if($status == 'Pending')
            return 'btn-outline-warning';
        else if($status == 'Approved')
            return 'btn-outline-success';
        else if($status == 'Denied')
            return 'btn-outline-danger';
    }
@endphp