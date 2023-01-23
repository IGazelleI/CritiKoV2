@php
    $default = 'data:image/png;base64,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';
@endphp
<x-layout>
    <x-profile-card class="p-5">
        @if(isset($enrollment))
            @if(isset($period->beginEval))
                @if($period->beginEval <= NOW()->format('Y-m-d'))
                <header>
                    @if($period->endEval < NOW()->format('Y-m-d'))
                    <div class="row">
                        <div class="col">
                            <h3 class="text-center text-uppercase bg-light p-3 mt-n5 mx-n5 text-danger fw-bold rounded fs-6"> Evaluation ended on {{date('F d, Y @ D', strToTime($period->endEval))}} </h3>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <h1 class="mb-3" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                                    Evaluate Instructor <br/>{{--  <span class="text-danger text-uppercase alert-danger"> Bisag nakadisabled makailis gapon sila sa radio </span> --}}
                                </h1>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('student.changeSelected')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col d-flex justify-content-center align-self-center">
                                <input type="hidden" id="imgPath"/>
                                <select name="subject" id="subject" class="form-select form-select-lg rounded-pill" aria-label="Default select example" onchange="this.form.submit()">
                                    <option selected disabled> -Select Instructor- </option>
                                    @unless ($subjects->isEmpty())
                                        @foreach ($subjects as $det)
                                            <option value="{{$det->id}}" {{selected() == $det->id? 'selected' : ''}}>
                                                ({{$det->klase->subject->descriptive_title}}) - {{isset($det->klase->instructor)? $det->klase->faculties->first()->fullName(true) : 'TBA'}}
                                            </option>
                                        @endforeach
                                    @else
                                        <option selected disabled> Current not enrolled in any subjects. </option>
                                    @endunless
                                </select>
                            </div>
                        </div>
                    </form>
                </header>
                <form action="{{route('student.evaluateProcess')}}" method="POST">
                    @csrf
                    <input type="hidden" name="subject_id" value="{{$subject_id}}"/>
                    <input type="hidden" name="totalQuestion" id="totalQuestion" value="{{$question->count()}}"/>
                    <div class="row rounded border border-dark bg-info d-flex justify-content-center align-items-center my-3">
                        <div class="col-3 text-center p-2">
                            <img src="{{(selected() != null? (isset($subjects->where('id', selected())->first()->klase->instructor)? ($subjects->where('id', selected())->first()->klase->faculties->first()->imgPath != null? $subjects->where('id', selected())->first()->klase->faculties->first()->imgPath()
                            : $default) : $default) : $default)}}" class="img-fluid rounded"
                            />
                        </div>
                        <div class="col border-start border-dark ps-5 text-white px-2">
                            1 = <span class="text-decoration-underline text-danger  m-1"> Unsatisfactory </span> <br/>
                            2 = <span class="text-decoration-underline text-warning m-1"> Fair </span> <br/> 
                            3 = <span class="text-decoration-underline m-1"> Satisfactory </span> <br/>
                            4 = <span class="text-decoration-underline text-primary m-1"> Very Satisfactory </span> <br/>
                            5 = <span class="text-decoration-underline text-success m-1"> Outstanding </span> <br/>
                        </div>
                        <div class="col">
                            <div class="row px-5 py-2">
                                <div class="col">
                                    @if($subjects->where('id', selected())->first() != null && isset($subjects->where('id', selected())->first()->klase->instructor))
                                    <img src="{{$subjects->where('id', selected())->first()->klase->faculties->first()->evaluated->where('evaluator', auth()->user()->id)->where('subject_id', $subject_id)->isEmpty()? asset('images/pending.png') : asset('images/finished.png')}}" 
                                        class="img-fluid" alt="Status"
                                    />
                                    @else
                                    <img src="{{asset('images/status_default.png')}}" class="img-fluid" alt="Status"/>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <h4 class="fw-bold"> 
                                        @if($subjects->where('id', selected())->first() != null && isset($subjects->where('id', selected())->first()->klase->instructor))
                                        {{($subjects->where('id', selected())->first()->klase->faculties->first()->evaluated->where('evaluator', auth()->user()->id)->where('subject_id', $subject_id)->isEmpty()? 'Pending' : 'Finished')}} 
                                        @else
                                        Status
                                        @endif
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col m-2">
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
                    @unless ($question->isEmpty())
                        @php
                            $count = 0;
                            $qnum = 1;
                            $prevCat = '';
                        @endphp
                        <div class="row d-flex justify-content-end border border-dark rounded-top pe-3 fw-bold">
                            <div class="col-md-auto p-2 pe-4 text-danger">
                                1
                            </div>
                            <div class="col-md-auto p-2 ps-1 pe-3 text-warning">
                                2
                            </div>
                            <div class="col-md-auto p-2 ps-1 pe-3">
                                3
                            </div>
                            <div class="col-md-auto p-2 ps-1 pe-3 text-primary">
                                4
                            </div>
                            <div class="col-md-auto p-2 ps-1 text-success">
                                5
                            </div>
                        </div>
                        @php
                            $i = 0;
                        @endphp
                        @foreach($question as $q)
                            {{-- Static sa pagset nga quanti ni siya --}}
                            <input type="hidden" name="{{'qID' . $qnum}}" value="{{$q->id}}"/>
                            @if($q->q_type_id == 1)
                                @if($prevCat != $q->q_category_id)
                                    @php
                                        $count = 0;
                                    @endphp
                                    <div class="row">
                                        <div class="col {{randomBg()}} border-bottom border-dark text-white rounded-bottom">
                                            <strong> {{$q->qCat->name}} </strong>
                                        </div>
                                    </div>
                                @endif
                                <div class="row ms-1 m-2 d-flex align-items-center">
                                    <div class="col border-end">
                                        <b> {{++$count}}. </b> {{ucfirst($q->sentence)}}
                                        <input type="hidden" name="{{'qCatID'  . $qnum}}" value="{{$q->q_category_id}}"/>
                                    </div>
                                    <div class="col-md-auto p-2">
                                        <label for="{{'qAns' . $qnum}}">
                                            <input type="radio" class="{{'qAns' . $qnum}}" name="{{'qAns' . $qnum}}" id="{{'qAns' . $qnum}}a1" value="1"
                                                @if(isset($evaluation))
                                                    @if($evaluation->evalDetails->where('question_id', $q->id)->first() != null)
                                                        {{checkQuestion($q->id, $evaluation, 1)}}
                                                    @endif
                                                @endif
                                                required
                                            />
                                        </label>
                                    </div>
                                    <div class="col-md-auto p-2">
                                        <label for="{{'qAns' . $qnum}}">
                                            <input type="radio" class="{{'qAns' . $qnum}}" name="{{'qAns' . $qnum}}" id="{{'qAns' . $qnum}}a2" value="2" 
                                                @if(isset($evaluation))
                                                    @if($evaluation->evalDetails->where('question_id', $q->id)->first() != null)
                                                        {{checkQuestion($q->id, $evaluation, 2)}}
                                                    @endif
                                                @endif
                                            />
                                        </label>
                                    </div>
                                    <div class="col-md-auto p-2">
                                        <label for="{{'qAns' . $qnum}}">
                                            <input type="radio" class="{{'qAns' . $qnum}}" name="{{'qAns' . $qnum}}" id="{{'qAns' . $qnum}}a3" value="3" 
                                                @if(isset($evaluation))
                                                    @if($evaluation->evalDetails->where('question_id', $q->id)->first() != null)
                                                        {{checkQuestion($q->id, $evaluation, 3)}}
                                                    @endif
                                                @endif
                                            />
                                        </label>
                                    </div>
                                    <div class="col-md-auto p-2">
                                        <label for="{{'qAns' . $qnum}}">   
                                            <input type="radio" class="{{'qAns' . $qnum}}" name="{{'qAns' . $qnum}}" id="{{'qAns' . $qnum}}a4" value="4" 
                                                @if(isset($evaluation))
                                                    @if($evaluation->evalDetails->where('question_id', $q->id)->first() != null)
                                                        {{checkQuestion($q->id, $evaluation, 4)}}
                                                    @endif
                                                @endif
                                            />
                                        </label>
                                    </div>
                                    <div class="col-md-auto p-2">
                                        <label for="{{'qAns' . $qnum}}">
                                            <input type="radio" class="{{'qAns' . $qnum}}" name="{{'qAns' . $qnum}}" id="{{'qAns' . $qnum}}a5" value="5" 
                                                @if(isset($evaluation))
                                                    @if($evaluation->evalDetails->where('question_id', $q->id)->first() != null)
                                                        {{checkQuestion($q->id, $evaluation, 5)}}
                                                    @endif
                                                @endif
                                            />
                                        </label>
                                    </div>
                                </div>
                                @php
                                    $prevCat = $q->q_category_id;
                                    $qnum++;
                                @endphp
                            @else
                                <div class="row">
                                    <div class="col d-flex align-items-center ms-2 mt-5">
                                        {{ucfirst($q->sentence)}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex align-items-center">
                                        <input type="text" class="form-control w-100 {{'qAns' . $qnum}}" name="{{'qAns' . $qnum}}" id="{{'qAns' . $qnum}}"
                                            @if(isset($evaluation))
                                                @if($evaluation->evalDetails->where('question_id', $q->id)->first() != null)
                                                    value="{{$evaluation->evalDetails->where('question_id', $q->id)->first()->answer}}"
                                                    disabled
                                                @else
                                                    value="Not Answered"
                                                    disabled
                                                @endif
                                            @endif
                                        />
                                    </div>
                                </div>
                                @php
                                    $qnum++;
                                @endphp
                            @endif
                            @php
                                $i += 1;
                            @endphp
                        @endforeach
                        <div class="row d-flex justify-content-end me-5">
                            <div class="col-1 me-5 mt-5">
                                <!-- Reset button -->
                                <button type="button" id="btnReset" class="btn btn-secondary rounded-pill {{(selected() == null || !isset($subjects->where('id', selected())->first()->klase->instructor) || isset($evaluation)) || ($period->endEval < NOW()->format('Y-m-d'))? 'disabled' : null}}">Reset</button>
                            </div>
                            <div class="col-1 mt-5">
                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary rounded-pill {{(selected() == null || !isset($subjects->where('id', selected())->first()->klase->instructor) || isset($evaluation)) || ($period->endEval < NOW()->format('Y-m-d'))? 'disabled' : null}}">Submit</button>
                            </div>
                        </div>
                    @else
                    <div class="row">
                        <div class="col">
                            <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase">Question is empty</h3>
                        </div>
                    </div>
                    @endunless
                </form>
                @else
                <h3 class="text-center text-uppercase bg-light p-3 rounded"> Evaluation will open on {{date('F d, Y @ D', strToTime($period->beginEval))}} </h3>
                @endif
            @else
            <h3 class="text-center text-uppercase bg-light p-3 rounded"> Evaluation date not set </h3>
            @endif
        @else
        <h3 class="text-center text-uppercase bg-light p-3 rounded"> Currently not enrolled in any subjects</h3>
        @endif
    </x-profile-card>
    <x-student-canvas/>
</x-layout>
@php
    function checkQuestion($question, $evaluation, $value)
    {
        foreach($evaluation->evalDetails as $det)
        {
            if($question == $det->question_id && $det->answer == $value)
                return 'checked disabled';
        }

        return null;
    }

    function randomBg()
    {
        $bg = ['bg-primary', 'bg-secondary', 'bg-info', 'bg-warning', 'bg-danger', 'bg-success'];

        return $bg[random_int(0, count($bg) - 1)];
    }

    function selected()
    {
        return Illuminate\Support\Facades\Session::get('selected');
    }
@endphp
<script>
    const totalInput = document.getElementById('totalQuestion');
    
    var input = [];

    for(var i = 1; i <= totalInput.value; i++)
    {
        var inputQuery = 'input[name="qAns' + i + '"]';
        input[i] = document.querySelector(inputQuery);

        input[i].addEventListener('invalid', function (event) {
            if (event.target.validity.valueMissing) {
                event.target.setCustomValidity('Please rate all questions first before submitting.');
            }
        });

        input[i].addEventListener('change', function (event) {
            event.target.setCustomValidity('');
        });
    }

    const resetBtnEl = document.getElementById('btnReset');

    resetBtnEl.addEventListener('click', function (){

        //get all question inputs
        for(var i = 1; i <= totalInput.value; i++)
        {
            var inputElC = document.querySelector('.qAns' + i); ;

            if(inputElC.value != null)
            {
                if(inputElC.type == 'radio')
                {
                    for(var j = 1; j <= 5; j++)
                        document.getElementById('qAns' + i + 'a' + j).checked = false;
                }
                else
                    inputElC.value = null;
            }
        }
    });
</script>