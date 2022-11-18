<x-layout>
    <x-admin-card>
        <div class="container-fluid">
            <div class="row my-3">
                <div class="col">
                    <header>
                        <h3>
                            @if(isset($course))
                            {{$course->name}} Blocks
                            @else
                            Block <b>Management</b>
                            @endif
                        </h3>
                    </header>
                </div>
                <div class="col">
                    @if (isset($course))
                        <button type="button" class="btn btn-info">
                            Subjects
                        </button>
                    @else
                    <div class="dropend">
                        <button type="button" class="btn btn-info" data-bs-toggle="dropdown" aria-expanded="false">
                            Subjects
                        </button>
                        <ul class="dropdown-menu">
                            @unless ($courses->isEmpty())
                                @foreach($courses as $det)
                                    <li><a class="dropdown-item" href="#">{{$det->name}}</a></li>
                                @endforeach
                            @else
                                <li><a class="dropdown-item disabled">Course is empty.</a></li>
                            @endunless
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="col">
                    <button type="button" class="btn btn-primary" data-bs-target="#addBlockModal" data-bs-toggle="modal">
                        New
                    </button>
                </div>
                <hr/>
            </div>
            <div class="row row-cols-4">
                @unless($block->isEmpty())
                        @foreach ($block as $det)
                            <div class="col mb-3">
                                <div class="card">
                                    <div class="card-header {{randomBg()}}">
                                        <div class="row">
                                            <div class="col">
                                                <a href="#" class="link-light" 
                                                    onMouseOver="this.style.textDecoration='underline'" 
                                                    onMouseOut="this.style.textDecoration='none'"
                                                >
                                                {{$det->getDescription()}}
                                                </a>
                                            </div>
                                            <div class="col me-n4">
                                                <button class="bg-transparent border border-0" data-bs-target="#editBlockModal" data-bs-toggle="modal"
                                                    data-bs-id="{{$det->id}}"
                                                    data-bs-course="{{$det->course_id}}"
                                                    data-bs-period="{{$det->period_id}}"
                                                    data-bs-year="{{$det->year_level}}"
                                                    data-bs-section="{{$det->section}}"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                    </svg>
                                                </button>
                                                <button type="button" class="btn-close" data-bs-target="#delBlockModal" data-bs-toggle="modal"
                                                    data-bs-id="{{$det->id}}"
                                                    data-bs-description="{{$det->getDescription()}}"
                                                >
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Students: <b> 50 </b></h5>
                                        <a href="#" class="btn btn-primary">Go somewhere</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @for($i = 0; $i < 5; $i++)
                            <div class="col mb-3">
                                <div class="card">
                                    <div class="card-header bg-danger">
                                        <a href="#" class="link-light disabled" 
                                            onMouseOver="this.style.textDecoration='underline'" 
                                            onMouseOut="this.style.textDecoration='none'"
                                        > 
                                            Block is empty.
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Manually create from by clicking below:</h5>
                                        <button type="button" class="btn btn-primary" data-bs-target="#addBlockModal" data-bs-toggle="modal">
                                            Click here
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endfor
                @endunless
            </div>
        </div>
    </x-admin-card>
    <x-admin-canvas/>
</x-layout>
@php
    function randomBg()
    {
        $bg = ['bg-primary', 'bg-secondary', 'bg-info', 'bg-warning', 'bg-success', 'bg-dark'];

        return $bg[random_int(0, count($bg) - 1)];
    }
@endphp