<x-layout>
    <x-medium-card>
        <div class="container">
            <div class="row">
                <div class="col shadow-sm">
                    <div class="row">
                        <div class="col mt-2 text-secondary ms-5">
                            <div class="row">
                                <div class="col">
                                    <strong> Faculty Performance </strong>
                                </div>
                                <div class="col text-end me-3">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary btn-sm rounded-pill" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            -Show By {{isset($sortByAcad)? 'Academic Year' : 'Semester'}}-
                                        </button>
                                      
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{route('home')}}" class="dropdown-item {{isset($sortByAcad)? '' : 'active'}}">
                                                    Semester
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('home', ['sortByAcad' => true])}}" class="dropdown-item {{isset($sortByAcad)? 'active' : ''}}">
                                                    Academic Year
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {!! $overAllChart->container() !!}
                            {!! $overAllChart->script() !!}
                        </div>
                    </div>
                </div>
                <div class="col-4 shadow-sm">
                    <div class="row mt-2 text-secondary">
                        <strong> Evaluation Progress </strong>
                        <span style="font-size: 10px"> {{$p->getDescription()}} </span>
                    </div>
                    <div class="row">
                        @if(isset($evalProgress))
                        <div class="col">
                            {!! $evalProgress->container() !!}
                            {!! $evalProgress->script() !!}
                        </div>
                        @else
                        <div class="col bg-light text-center p-3 rounded">
                            <h3 class="text-uppercase"> Evaluation date not set </h3>
                            <p class="text-secondary" style="font-size: 16px"> {{$p->getDescription()}} </p>
                            <button class="btn btn-primary rounded-pill" data-bs-target="#editPerModal" data-bs-toggle="modal"
                                data-bs-id="{{$p->id}}"
                                data-bs-semester="{{$p->semester}}"
                                data-bs-begin="{{$p->begin}}"
                                data-bs-end="{{$p->end}}"
                                data-bs-beginEnroll="{{$p->beginEnroll}}"
                                data-bs-endEnroll="{{$p->endEnroll}}"
                                data-bs-beginEval="{{$p->beginEval}}"
                                data-bs-endEval="{{$p->endEval}}"
                            >
                                Set
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-medium-card>
    <x-admin-canvas/>
</x-layout>