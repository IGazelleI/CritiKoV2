<x-layout>
    <x-medium-card>
        <div class="container-fluid">
            <div class="row mx-n4 mb-3 bg-success text-light">
                <div class="col-2 p-2">
                    <img src="https://cdn-icons-png.flaticon.com/512/1632/1632670.png" class="img-fluid" alt="Task Complete Logo"/>
                </div>
                <div class="col p-2 align-self-center">
                    <header>
                        <h3 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif"> Completion Report </h3>
                        {{$department->description}}
                    </header>
                </div>
                <div class="col text-end align-self-center">
                    <div class="dropdown">
                        <button class="btn btn-light btn-outline-primary shadow-none dropdown-toggle rounded-pill" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (isset($perSelected))
                                {{$periods->find($perSelected)->getDescription()}} 
                            @else
                                Period
                            @endif
                        </button>
                      
                        <ul class="dropdown-menu">
                            @unless($periods->isEmpty())
                                <li>
                                    <a  href="{{route('admin.completionDetail', $department->id)}}" class="dropdown-item">
                                        Latest
                                    </a>
                                </li>
                                @foreach($periods as $per)
                                <li>
                                    <a  href="{{route('admin.completionDetail', [$department->id, 'period' => $per->id])}}" class="dropdown-item">
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
            <div class="row row-cols-1">
                @foreach($faculty as $det)
                <div class="col mb-3">
                    <div class="card">
                        <div class="card-header {{randomBg()}}">
                            <div class="row">
                                <div class="col-1">
                                    <img src="{{isset($det->imgPath)? '../' . $det->imgPath() : 'https://www.pngitem.com/pimgs/m/226-2267516_male-shadow-circle-default-profile-image-round-hd.png'}}" 
                                        class="img-fluid rounded-circle" alt="Faculty Photo"
                                    />
                                </div>
                                <div class="col">
                                    <a href="#" class="link-light disabled"
                                        onMouseOver="this.style.textDecoration='underline'"
                                        onMouseOut="this.style.textDecoration='none'"
                                    >
                                        {{$det->fullName(true)}}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @php
                                    $block = App\Models\Block::where('period_id', isset($perSelected)? $perSelected : $periods->first()->id)
                                                        -> latest('id')
                                                        -> get();
                                    $klases = 0;

                                    foreach($block as $b)
                                        $klases += $b->klases->where('instructor', $det->user_id)->count();
                                @endphp
                                <div class="col">
                                    <button class="btn btn-transparent text-secondary shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$det->id}}" aria-expanded="false" aria-controls="collapseExample">
                                        Classes
                                    </button>
                                </div>
                                <div class="col text-end">
                                    <span class="fw-bold badge bg-primary text-wrap"> 
                                        {{$klases}} 
                                    </span>
                                </div>
                                <div class="collapse" id="collapse{{$det->id}}">
                                    @foreach($block as $b)
                                        @foreach($b->klases->where('instructor', $det->user_id) as $klase)
                                        @php
                                            $finished = $det->evaluated->where('period_id', isset($perSelected)? $perSelected : $periods->first()->id)->where('evaluatee', $det->user_id)->whereIn('evaluator', $student)->where('subject_id', $klase->subject_id)->count();
                                            $total = $klase->klaseStudents->count();
                                            $pending = $total - $finished;
                                        @endphp
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSub{{$klase->id}}" aria-expanded="false" aria-controls="collapseTwo">
                                            {{$klase->subject->descriptive_title}} &nbsp;
                                            <span class="fw-bold badge bg-success text-wrap"> Finished: {{$finished}} </span> &nbsp;
                                            <span class="fw-bold badge bg-warning text-wrap"> Pending: {{$pending}} </span> &nbsp;
                                            <span class="fw-bold badge bg-secondary text-wrap"> Total : {{$total}} </span>
                                        </button>
                                        <div id="collapseSub{{$klase->id}}" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <ul class="list-group">
                                            @foreach($klase->klaseStudents as $student)
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col">
                                                            {{$student->user->students->first()->fullName(true)}}
                                                        </div>
                                                        <div class="col text-end">
                                                            @if($det->evaluated->where('period_id', isset($perSelected)? $perSelected : $periods->first()->id)->where('evaluatee', $det->user_id)->where('evaluator', $student->user_id)->where('subject_id', $klase->subject_id)->isEmpty())
                                                            <span class="badge bg-warning rounded-circle px-2 py-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Pending" >
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                                                </svg>
                                                            </span>
                                                            @else
                                                            <span class="badge bg-success rounded-circle px-2 py-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{date('D, F d, Y @ g:i A', strToTime($det->evaluated->where('period_id', isset($perSelected)? $perSelected : $periods->first()->id)->where('evaluatee', $det->user_id)->where('evaluator', $student->user_id)->where('subject_id', $klase->subject_id)->first()->created_at))}}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                                                </svg>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                            </ul>
                                        </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </x-medium-card>
    <x-admin-canvas/>
</x-layout>
@php
    function randomBg()
    {
        $bg = ['bg-primary', 'bg-secondary', 'bg-info', 'bg-warning','bg-dark'];

        return $bg[random_int(0, count($bg) - 1)];
    }
@endphp