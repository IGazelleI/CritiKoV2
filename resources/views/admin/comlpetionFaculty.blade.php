<x-layout>
    <x-medium-card>
        <div class="container-fluid">
            <div class="row {{randomBg()}} mx-n4 text-light">
                <div class="col p-3">
                    <header>
                        <h3 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif"> Faculty Evaluation Completion Report </h3>
                    </header>
                </div>
                <div class="col text-end align-self-center">
                    <div class="dropdown">
                        <button class="btn btn-light btn-outline-primary shadow-none dropdown-toggle rounded-pill" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (isset($perSelected))
                                {{$period->find($perSelected)->getDescription()}} 
                            @else
                                Period
                            @endif
                        </button>
                      
                        <ul class="dropdown-menu">
                            @unless($period->isEmpty())
                                <li>
                                    <a  href="{{route('admin.completionFaculty')}}" class="dropdown-item">
                                        Latest
                                    </a>
                                </li>
                                @foreach($period as $per)
                                <li>
                                    <a  href="{{route('admin.completionFaculty', ['period' => $per->id])}}" class="dropdown-item">
                                        {{$per->getDescription()}}
                                    </a>
                                </li>
                                @endforeach
                            @else
                            <li>
                                <a class="dropdown-item disabled"> Period is empty </a>
                            </li>
                            @endunless
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 mt-2">
                @foreach($department as $dept)
                    @if(!$dept->faculties->isEmpty())
                    <div class="col mb-3">
                        <div class="card">
                            <div class="card-header {{randomBg()}}">
                                <div class="row d-flex">
                                    <div class="col">
                                        <a href="#" class="link-light"
                                            onMouseOver="this.style.textDecoration='underline'"
                                            onMouseOut="this.style.textDecoration='none'"
                                        >
                                            {{$dept->name}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDept{{$dept->id}}" aria-expanded="false" aria-controls="collapseTwo">
                                    <h5 class="card-title text-secondary p-0 m-0">
                                        Faculties &nbsp; &nbsp; <span class="badge text-wrap bg-danger rounded-pill"> {{$dept->faculties->count()}} </span>
                                    </h5>
                                </button>
                                @foreach($dept->faculties->sortByDesc('isAssDean')->sortByDesc('isDean') as $fac)
                               <div class="collapse" id="collapseDept{{$dept->id}}">
                                    @php
                                        $finished = App\Models\Evaluate::where('period_id', isset($perSelected)? $perSelected : $periods->first()->id)
                                                                -> where('evaluator', $fac->user_id)
                                                                -> get()
                                                                -> count();
                                        $total = 0;
                                        foreach($dept->faculties->where('user_id', '!=', $fac->user_id) as $facEval)
                                        {
                                            $block = App\Models\Block::with('klases')
                                                    -> where('period_id', isset($perSelected)? $perSelected : $periods->first()->id)
                                                    -> get();

                                            foreach($block as $b)
                                                $total += $b->klases->where('instructor', $facEval->user_id)->count();
                                        }
                                        $pending = $total - $finished;
                                    @endphp
                                    <div class="row accordion-item">
                                        <div class="col-1 d-flex align-self-center">
                                            <img src="{{isset($fac->imgPath)? '../' . $fac->imgPath() : 'https://www.pngitem.com/pimgs/m/226-2267516_male-shadow-circle-default-profile-image-round-hd.png'}}" 
                                                class="img-fluid rounded-circle" alt="Faculty Photo"
                                            />
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFac{{$fac->id}}" aria-expanded="false" aria-controls="collapseTwo">
                                                        <strong> {{$fac->isDean? 'College Dean, ' : ''}} {{$fac->isAssDean? 'Associate Dean, ' : ''}} </strong> {{$fac->fullName(true)}} &nbsp;
                                                        <span class="fw-bold badge bg-success text-wrap"> Finished: {{$finished}} </span> &nbsp;
                                                        <span class="fw-bold badge bg-warning text-wrap"> Pending: {{$pending}} </span> &nbsp;
                                                        <span class="fw-bold badge bg-secondary text-wrap"> Total : {{$total}} </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapseFac{{$fac->id}}" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <ul class="list-group">
                                        @foreach($dept->faculties->where('user_id', '!=', $fac->user_id) as $facEval)
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-1">
                                                        <img src="{{isset($facEval->imgPath)? '../' . $facEval->imgPath() : 'https://www.pngitem.com/pimgs/m/226-2267516_male-shadow-circle-default-profile-image-round-hd.png'}}" 
                                                            class="img-fluid rounded-circle" alt="Faculty Photo"
                                                        />
                                                    </div>
                                                    <div class="col">
                                                        {{$facEval->fullName(true)}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    @php
                                                        $block = App\Models\Block::with('klases')
                                                                            -> where('period_id', isset($perSelected)? $perSelected : $periods->first()->id)
                                                                            -> latest('id')
                                                                            -> get();
                                                        $klases = 0;
                    
                                                        foreach($block as $b)
                                                            $klases += $b->klases->where('instructor', $facEval->user_id)->count();
                                                    @endphp
                                                    <div class="col">
                                                        <button class="btn btn-transparent text-secondary shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFacSubs{{$fac->id . $facEval->id}}" aria-expanded="false" aria-controls="collapseExample">
                                                            Classes
                                                        </button>
                                                    </div>
                                                    <div class="col text-end">
                                                        <span class="fw-bold badge bg-primary text-wrap"> 
                                                            {{$klases}} 
                                                        </span>
                                                    </div>
                                                    <div class="collapse" id="collapseFacSubs{{$fac->id . $facEval->id}}">
                                                        <ul class="list-group list-group-flushed">
                                                        @foreach($block as $b)
                                                            @foreach($b->klases->where('instructor', $facEval->user_id) as $klase)
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        {{$klase->subject->descriptive_title}} 
                                                                    </div>
                                                                    <div class="col-1 text-end">
                                                                        @if($facEval->evaluated->where('period_id', isset($perSelected)? $perSelected : $periods->first()->id)->where('evaluatee', $facEval->user_id)->where('evaluator', $fac->user_id)->where('subject_id', $klase->subject_id)->isEmpty())
                                                                        <span class="badge bg-warning rounded-circle px-2 py-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Pending" >
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                                                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                                                            </svg>
                                                                        </span>
                                                                        @else
                                                                        <span class="badge bg-success rounded-circle px-2 py-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{date('D, F d, Y @ g:i A', strToTime($facEval->evaluated->where('period_id', isset($perSelected)? $perSelected : $periods->first()->id)->where('evaluatee', $facEval->user_id)->where('evaluator', $fac->user_id)->where('subject_id', $klase->subject_id)->first()->created_at))}}">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                                                <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                                                            </svg>
                                                                        </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            @endforeach
                                                        @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                        </ul>
                                    </div>
                               </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </x-medium-card>
    <x-admin-canvas/>
</x-layout>
@php
    function randomBg()
    {
        $bg = ['bg-primary', 'bg-secondary', 'bg-info', 'bg-warning', 'bg-success', 'bg-dark'];

        return $bg[random_int(0, count($bg) - 1)];
    }
    function str_ordinal($value)
    {
        $superscript = false;
        $number = abs($value);
 
        $indicators = ['th','st','nd','rd','th','th','th','th','th','th'];
 
        $suffix = $superscript ? '<sup>' . $indicators[$number % 10] . '</sup>' : $indicators[$number % 10];
        if ($number % 100 >= 11 && $number % 100 <= 13) {
            $suffix = $superscript ? '<sup>th</sup>' : 'th';
        }
 
        return number_format($number) . $suffix;
    }
@endphp