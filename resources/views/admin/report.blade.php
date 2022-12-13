<x-layout>
    <x-medium-card>
        <div class="container">
            <div class="row bg-info text-white mt-3 p-4 rounded">
                <div class="col-1">
                    <img src="https://www.pngall.com/wp-content/uploads/3/Report.png" class="img-fluid" alt="Report Logo"/>
                </div>
                <div class="col align-self-center">
                    <h2 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                        Faculty Report
                    </h2>
                </div>
            </div>
            <div class="row p-3">
                <div class="col text-end">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle rounded-pill" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (isset($deptSelected))
                                {{$department->find($deptSelected)->name}}
                            @else
                                Department
                            @endif
                        </button>
                      
                        <ul class="dropdown-menu">
                            @unless($department->isEmpty())
                                <li>
                                    <a  href="{{route('admin.report', ['period' => isset($perSelected)? encrypt($perSelected) : null])}}" class="dropdown-item">
                                        All
                                    </a>
                                </li>
                                @foreach($department as $dept)
                                <li>
                                    <a  href="{{route('admin.report', ['department' => encrypt($dept->id), 'period' => isset($perSelected)? encrypt($perSelected) : null])}}" class="dropdown-item">
                                        {{$dept->name}}
                                    </a>
                                </li>
                                @endforeach
                            @else
                            <li>
                                <a class="dropdown-item disabled"> Department is empty </a>
                            </li>
                            @endunless
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle rounded-pill" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (isset($perSelected))
                                {{$periodAll->find($perSelected)->getDescription()}} 
                            @else
                                Period
                            @endif
                        </button>
                      
                        <ul class="dropdown-menu">
                            @unless($periodAll->isEmpty())
                                <li>
                                    <a  href="{{route('admin.report', ['department' => isset($deptSelected)? encrypt($deptSelected) : null])}}" class="dropdown-item">
                                        Latest
                                    </a>
                                </li>
                                @foreach($periodAll as $per)
                                <li>
                                    <a  href="{{route('admin.report', ['period' => encrypt($per->id), 'department' => isset($deptSelected)? encrypt($deptSelected) : null])}}" class="dropdown-item">
                                        {{$per->getDescription()}}
                                    </a>
                                </li>
                                @endforeach
                            @else
                            <li>
                                <a class="dropdown-item disabled"> Department is empty </a>
                            </li>
                            @endunless
                        </ul>
                    </div>
                </div>
            </div>
            @unless($faculty->isEmpty())
                @foreach($faculty as $det)
                <div class="row p-3 border-bottom">
                    <div class="col-2">
                        <img src="{{isset($det->imgPath)? '../' . $det->imgPath() : 'https://www.pngitem.com/pimgs/m/226-2267516_male-shadow-circle-default-profile-image-round-hd.png'}}" 
                            class="img-fluid rounded-circle" alt="Report Icon"
                        />
                    </div>
                    <div class="col">
                        <div class="row mt-3 mb-2">
                            <div class="col">
                                {{$det->fullName(true)}} &nbsp;
                                @if($prevAvgFac[$det->id] > 0 && $prevAvgSt[$det->id] > 0)
                                    @if(getImprovement(($averageFac[$det->id] + $averageSt[$det->id]) / 2, ($prevAvgFac[$det->id] + $prevAvgSt[$det->id]) / 2) > 0)
                                    <span class="badge bg-success text-wrap rounded-pill">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill pb-1" viewBox="0 0 16 16">
                                            <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                        </svg> 
                                        {{number_format(getImprovement(($averageFac[$det->id] + $averageSt[$det->id]) / 2, ($prevAvgFac[$det->id] + $prevAvgSt[$det->id]) / 2), 1)}}%
                                    </span>
                                    @else
                                    <span class="badge bg-danger text-wrap rounded-pill">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill pt-1" viewBox="0 0 16 16">
                                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                        </svg>
                                        {{number_format(getImprovement(($averageFac[$det->id] + $averageSt[$det->id]) / 2, ($prevAvgFac[$det->id] + $prevAvgSt[$det->id]) / 2), 1)}}%
                                    </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#collapse{{$det->id}}" class="text-decoration-underline" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                    Show Details
                                </a>
                            </div>
                        </div>
                    </div>                    
                    @if(isset($recommendation[$det->id]))
                    <div class="col">
                        <div style="min-height: 120px;">
                            <div class="collapse collapse-horizontal" id="recCollapse{{$det->id}}">
                                <div class="card card-body" style="width: 300px;">
                                    <h5> Improvement Guide </h5>
                                    <ul class="list-group list-group-numbered fw-bold">
                                        @foreach($recommendation[$det->id] as $rec)
                                            <li class="list-group-item text-danger"> {{$rec->keyword}} </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-1 align-self-center rounded"
                        data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Recommendations"
                    >
                        <button type="button" class="btn btn-transparent btn-warning shadow-none p-3 text-dark rounded-circle" 
                            data-bs-toggle="collapse" data-bs-target="#recCollapse{{$det->id}}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                            </svg>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col px-5">
                        <div id="collapse{{$det->id}}" class="accordion-collapse collapse border rounded" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col text-center ms-5 me-n4">
                                                Faculty Evaluation &nbsp;
                                                @if($prevAvgFac[$det->id] > 0)
                                                    @if(getImprovement($averageFac[$det->id], $prevAvgFac[$det->id]) > 0)
                                                    <span class="text-success fw-bold rounded-pill">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill pb-1" viewBox="0 0 16 16">
                                                            <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                                        </svg> 
                                                        {{number_format(getImprovement($averageFac[$det->id], $prevAvgFac[$det->id]), 1)}}%
                                                    </span>
                                                    @else
                                                    <span class="text-danger fw-bold rounded-pill">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill pt-1" viewBox="0 0 16 16">
                                                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                                        </svg>
                                                        {{number_format(getImprovement($averageFac[$det->id], $prevAvgFac[$det->id]), 1)}}%
                                                    </span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                {!! $facultyChart[$det->id]->container() !!}
                                                {!! $facultyChart[$det->id]->script() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col text-center ms-5 me-n4">
                                                Student Evaluation &nbsp;
                                                @if($prevAvgSt[$det->id] > 0)
                                                    @if(getImprovement($averageSt[$det->id], $prevAvgSt[$det->id]) > 0)
                                                    <span class="text-success fw-bold rounded-pill">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill pb-1" viewBox="0 0 16 16">
                                                            <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                                        </svg> 
                                                        {{number_format(getImprovement($averageSt[$det->id], $prevAvgSt[$det->id]), 1)}}%
                                                    </span>
                                                    @else
                                                    <span class="text-danger fw-bold rounded-pill">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill pt-1" viewBox="0 0 16 16">
                                                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                                        </svg>
                                                        {{number_format(getImprovement($averageSt[$det->id], $prevAvgSt[$det->id]), 1)}}%
                                                    </span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                {!! $studentChart[$det->id]->container() !!}
                                                {!! $studentChart[$det->id]->script() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                @if(isset($deptSelected))
                <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase"> Faculty in {{$department->find($deptSelected)->description}} is empty </h3>
                @else
                <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase"> Faculty is empty </h3>
                @endif
            @endunless
        </div>
    </x-medium-card>
    <x-admin-canvas/>
</x-layout>
@php
    function getImprovement($current, $previous)
    {
        return (($current - $previous) / $previous) * 100;
    }
@endphp