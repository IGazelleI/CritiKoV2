<x-layout>
    <x-general-card>
        @if(Illuminate\Support\Facades\Session::get('period') != null)
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
                <form action="{{route('student.changeEnrollmentType')}}" method="POST">
                    @csrf
                    <div class="row m-4">
                        <label class="form-label ms-2">Type</label>
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input" name="type" type="radio" value="0" 
                                    {{isset($enrollment)? ($enrollment->type == 0? 'checked disabled' : 'disabled') : (isset($enrollType)? ($enrollType == 0? 'checked' : '') : '')}}
                                    onchange="this.form.submit()"
                                />
                                <label class="form-check-label" for="defaultCheck1">
                                    Regular
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" name="type" type="radio" value="1" 
                                    {{isset($enrollment)? ($enrollment->type == 1   ? 'checked disabled' : 'disabled') : (isset($enrollType)? ($enrollType == 1? 'checked' : '') : '')}}
                                    onchange="this.form.submit()"
                                />
                                <label class="form-check-label" for="defaultCheck1">
                                    Irregular
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
                @if(isset($enrollType))
                <div class="row m-4">
                    <label class="form-label ms-2">Program</label>
                    <div class="col">
                        <form action="{{route('student.changeCourse')}}" method="POST">
                            @csrf
                            <div class="form-outline mb-4">
                                <select class="select form-select rounded-pill" {{isset($enrollment)? 'disabled' : ''}} name="course_id" onchange="this.form.submit()">
                                    <option selected disabled>Course</option>
                                    @unless ($course->isEmpty())
                                        @foreach($course as $c)
                                            <option value="{{$c->id}}" {{(isset($enrollment)? ($enrollment->course_id == $c->id? 'selected' : '') : ($courseSelected == $c->id? 'selected' : ''))}}> {{$c->description}} </option>
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
                        </form>
                    </div>
                    <div class="col-3">
                        <form action="{{route('student.changeYear')}}" method="POST">
                            @csrf
                            <div class="form-outline mb-4">
                                <select class="select form-select rounded-pill" {{isset($enrollment)? 'disabled' : ''}} name="year_level" onchange="this.form.submit()">
                                    <option selected disabled>Year Level</option>
                                    @for($i = 1; $i <= 4; $i++)
                                        <option value="{{$i}}" {{(isset($enrollment)? ($enrollment->year_level == $i? 'selected' : '') : ($yearSelected == $i? 'selected' : ''))}}>{{$i}}</option>
                                    @endfor
                                </select>

                                @error('year_level')
                                    <p class="text-sm text-danger ms-3">
                                        {{$message}}
                                    </p>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
                <form action="{{route('student.submitEnroll')}}" method="POST">
                    @csrf

                    @if($enrollType == 1 && isset($courseSelected) && isset($yearSelected))
                    <div class="row m-4">
                        <div class="col">
                            @unless($subjects->isEmpty())
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <strong> {{isset($enrollment)? 'Subject/s Taken' : 'Select Subject/s'}} </strong> <span class="badge text-bg-danger ms-3 rounded-pill">{{isset($enrollment)? $subjectsTaken->count() . ' of ' . $subjects->count() : $subjects->count()}}</span>
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                @php
                                                    $i = 0;
                                                @endphp
                                                <input type="hidden" name="subCount" value="{{$subjects->count()}}"/>
                                                @foreach($subjects as $det)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="subject_{{$i++}}" value="{{$det->id}}"
                                                        {{isset($enrollment)? (checkSubject($subjectsTaken, $det->id)? 'checked disabled' : 'disabled') : ' '}}
                                                    />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        <strong> {{$det->code}} </strong> - {{$det->descriptive_title}}
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase"> Subject with the following selection is empty. </h3>
                            @endunless
                        </div>
                    </div>
                    @endif
                    <div class="row d-flex justify-content-end m-4">
                        <div class="col-2 mx-4">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary rounded-pill 
                                {{isset($enrollment)? 'disabled' : (isset($subjects)? ($subjects->isEmpty()? 'disabled' : '') : '')}}" 
                                data-bs-toggle="modal" data-bs-target="#confirm"
                            >
                                Submit
                            </button>
                            
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
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
        @else
            <div class="row">
                <div class="col">
                    <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase"> Enrollment cannot proceed due to a system error. Please try again later </h3>
                </div>
            </div>
        @endif
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
    function checkSubject($taken, $current)
    {
        foreach($taken as $det)
        {
            if($det->subject_id == $current)
                return true;
        }
        
        return false;
    }
@endphp