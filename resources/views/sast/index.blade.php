<x-layout>
    <x-medium-card>
        <div class="container">
            <div class="row">
                <div class="col p-3 bg-info">
                    <div class="row bg-info">
                        <div class="col-1">
                            <img src="https://cdn0.iconfinder.com/data/icons/business-and-teamwork-1/64/04-Evaluation-512.png" class="img-fluid"/>
                        </div>
                        <div class="col">
                            <h2 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                                Evaluation Report
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-7-p-3">
                    @if(isset($period))
                        @if(isset($period->beginEval))
                            <!-- Pills navs -->
                            <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a
                                        class="nav-link active"
                                        id="tab-faculty"
                                        data-mdb-toggle="pill"
                                        href="#pills-faculty"
                                        role="tab"
                                        aria-controls="pills-faculty"
                                        aria-selected="true"
                                    >
                                        Faculty
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a
                                        class="nav-link rounded-pill"
                                        id="tab-student"
                                        data-mdb-toggle="pill"
                                        href="#pills-student"
                                        role="tab"
                                        aria-controls="pills-student"
                                        aria-selected="false"
                                    >
                                        Student
                                    </a>
                                </li>
                            </ul>
                            <!-- Pills navs -->
                            <!-- Pills content -->
                            <div class="tab-content mb-5 d-flex justify-content-center">
                                <div class="tab-pane fade show active" id="pills-faculty" role="tabpanel" aria-labelledby="tab-faculty">
                                    <div class="row">
                                        <div class="col-7 p-3">
                                            {!! $chartFaculty->container() !!}
                                        </div>
                                        <div class="col {{-- d-flex align-items-center --}}align-self-center p-3">
                                            <div class="mb-2 text-center" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                                                <h4> Progress {{number_format(($finishedf / $expectedf) * 100, 0)}}% </h4>
                                                <div class="progress h-100 rounded-pill">
                                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" 
                                                        aria-label="Animated striped example" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: {{number_format(($finishedf / $expectedf) * 100, 0)}}%"
                                                    >
                                                        {{number_format(($finishedf / $expectedf) * 100, 0)}}%
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="list-group fw-bold border border-dark">
                                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0">
                                                    Finished 
                                                    <span class="badge bg-success rounded-pill">{{number_format($finishedf)}}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0">
                                                    Pending
                                                    <span class="badge bg-warning rounded-pill">{{number_format($pendingf)}}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0">
                                                    Expected Total Evaluation
                                                    <span class="badge bg-primary rounded-pill">{{number_format($expectedf)}}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-student" role="tabpanel" aria-labelledby="tab-student">
                                    @if($expecteds == 0)
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase"> Current semmester has no enrollees. </h3>
                                        </div>
                                    </div>
                                    @else
                                    <div class="row">
                                        <div class="col-7 p-3">
                                            {!! $chartStudent->container() !!}
                                        </div>
                                        <div class="col {{-- d-flex align-items-center --}}align-self-center p-3">
                                            <div class="mb-2 text-center" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                                                <h4> Progress {{$expecteds == 0? 0 : number_format(($finisheds / $expecteds) * 100, 0)}}% </h4>
                                                <div class="progress h-100 rounded-pill">
                                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" 
                                                        aria-label="Animated striped example" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: {{$expecteds == 0? 0 : number_format(($finisheds / $expecteds) * 100, 0)}}%"
                                                    >
                                                        {{$expecteds == 0? 0 : number_format(($finisheds / $expecteds) * 100, 0)}}%
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="list-group fw-bold border border-dark">
                                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0">
                                                    Total Enrollee
                                                    <span class="badge bg-info rounded-pill">{{number_format($totalEnrollees)}}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0">
                                                    Finished
                                                    <span class="badge bg-success rounded-pill">{{number_format($finisheds)}}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0">
                                                    Pending
                                                    <span class="badge bg-warning rounded-pill">{{number_format($pendings)}}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0">
                                                    Expected Total Evaluation
                                                    <span class="badge bg-primary rounded-pill">{{number_format($expecteds)}}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <!-- Pills content --> 
                        @else
                        <h3 class="text-center text-uppercase bg-light mt-5 p-3 rounded"> Evaluation date not set </h3>
                        <div class="text-center p-2 pb-5">
                            <button type="button" class="btn btn-primary rounded-pill" data-bs-target="#setEvaluationDateModal" data-bs-toggle="modal">
                                Set
                            </button>
                            {{-- Checks if period is not empty so they can view previous semester --}}
                            @if($period->id > 1)
                            <form action="{{route('sast.changePeriod')}}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="period" value="{{$period->id - 1}}"/>
                                <button type="submit" class="btn btn-secondary rounded-pill">
                                    Check Previous Semester
                                </button>
                            </form>
                            @endif
                        </div>
                        @endif
                    @else
                    <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase"> Period is empty </h3>
                    @endif
                </div>
            </div>

        </div>
    </x-medium-card>
    <x-sast-canvas/>
</x-layout>
@if(isset($period->beginEval))
{!! $chartFaculty->script() !!}
{!! $chartStudent->script() !!}
@endif