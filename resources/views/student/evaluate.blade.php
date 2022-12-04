<x-layout>
    <x-profile-card class="p-5">
        @if(isset($enrollment))
            @if(isset($period->beginEval))
                @if($period->beginEval <= NOW()->format('Y-m-d'))
                <header>
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <h1 class="mb-3" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                            Evaluate Instructor
                        </h1>
                    </div>
                    <form action="{{route('student.changeSelected')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col d-flex justify-content-center align-self-center">     
                                <input type="hidden" id="imgPath"/>
                                <select name="user_id" id="user_id" class="form-select form-select-lg rounded-pill" aria-label="Default select example" onchange="this.form.submit()">
                                    <option selected disabled> -Select Instructor- </option>
                                    @unless ($instructor->isEmpty())
                                        @php
                                            $current = 0;
                                        @endphp
                                        @foreach ($instructor as $det)
                                            @if($det->klases->where('user_id', auth()->user()->id))
                                                @php
                                                    if($det->klases->count() > 1 && $current < $det->klases->count() - 1)
                                                        $current++;
                                                    else
                                                        $current = 0;
                                                @endphp
                                                <option value="{{$det->user_id}}" {{selected() == $det->user_id? 'selected' : ''}}>
                                                    ({{$det->klases[$current]->subject->descriptive_title}}) - {{$det->fullName(1)}}
                                                </option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option selected disabled> Current block has no instructor. </option>
                                    @endunless
                                </select>
                            </div>
                        </div>
                    </form>
                </header>
                <form action="{{route('student.evaluateProcess')}}" method="POST">
                    @csrf
                    <input type="hidden" name="totalQuestion" value="{{$question->count()}}"/>
                    <div class="row rounded border border-dark bg-info d-flex justify-content-center align-items-center my-3">
                        <div class="col-3 text-center p-2">
                            <img src="{{selected() != null? ($instructor->where('user_id', selected())->first()->imgPath != null? $instructor->where('user_id', selected())->first()->imgPath()
                            : "data:image/png;base64,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")
                            : "data:image/png;base64,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"
                            }}" class="img-fluid rounded"
                        />
                        </div>
                        <div class="col border-start border-dark ps-5 text-white px-2">
                            1 = <span class="text-decoration-underline text-danger  m-1"> Poor </span> <br/>
                            2 = <span class="text-decoration-underline text-warning m-1"> Bad </span> <br/> 
                            3 = <span class="text-decoration-underline m-1"> Average </span> <br/>
                            4 = <span class="text-decoration-underline text-primary m-1"> Great </span> <br/>
                            5 = <span class="text-decoration-underline text-success m-1"> Excellent </span> <br/>
                        </div>
                        <div class="col">
                            <div class="row px-5 py-2">
                                <div class="col">
                                    @if($instructor->where('user_id', selected())->first() != null)
                                    <img src="{{$instructor->where('user_id', selected())->first()->evaluated->where('evaluator', auth()->user()->id)->isEmpty()? asset('images/pending.png') : asset('images/finished.png')}}" 
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
                                        @if($instructor->where('user_id', selected())->first() != null)
                                        {{$instructor->where('user_id', selected())->first()->evaluated->where('evaluator', auth()->user()->id)->isEmpty()? 'Pending' : 'Finished'}} 
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
                                        <input type="radio" name="{{'qAns' . $qnum}}" value="1" 
                                            {{isset($evaluation)? checkQuestion($q->id, $evaluation->evalDetails[$i], 1) : null}}
                                        />
                                    </div>
                                    <div class="col-md-auto p-2">
                                        <input type="radio" name="{{'qAns' . $qnum}}" value="2"
                                            {{isset($evaluation)? checkQuestion($q->id, $evaluation->evalDetails[$i], 2) : null}}
                                        />
                                    </div>
                                    <div class="col-md-auto p-2">
                                        <input type="radio" name="{{'qAns' . $qnum}}" value="3" 
                                            {{isset($evaluation)? checkQuestion($q->id, $evaluation->evalDetails[$i], 3) : null}}
                                        />
                                    </div>
                                    <div class="col-md-auto p-2">
                                        <input type="radio" name="{{'qAns' . $qnum}}" value="4" 
                                            {{isset($evaluation)? checkQuestion($q->id, $evaluation->evalDetails[$i], 4) : null}}
                                        />
                                    </div>
                                    <div class="col-md-auto p-2">
                                        <input type="radio" name="{{'qAns' . $qnum}}" value="5" 
                                            {{isset($evaluation)? checkQuestion($q->id, $evaluation->evalDetails[$i], 5) : null}}
                                        />
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
                                        <input type="text" class="form-control w-100" name="{{'qAns' . $qnum}}"/>
                                    </div>
                                </div>
                            @endif
                            @php
                                $i += 1;
                            @endphp
                        @endforeach
                        <div class="row d-flex justify-content-end me-5">
                            <div class="col-1 mt-5">
                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary rounded-pill {{(selected() == null || isset($evaluation))? 'disabled' : null}}">Submit</button>
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
                @elseif($period->endEval < NOW()->format('Y-m-d'))
                <h3 class="text-center text-uppercase bg-light p-3 rounded"> Evaluation ended on {{date('F d, Y @ D', strToTime($period->endEval))}} </h3>
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
    function checkQuestion($question, $det, $value)
    {
        if($question == $det->question_id && $det->answer == $value)
            return 'checked disabled';

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