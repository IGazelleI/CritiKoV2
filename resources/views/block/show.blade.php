<x-layout>
    <x-medium-card>
        <div class="container-fluid">
            <div class="row my-3">
                <div class="col">
                    <header>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('block.manage', $period->id)}}"> {{$period->getDescription()}} </a>
                                </li>
                                <li class="breadcrumb-item {{isset($year_level)? null : 'active'}}" {{isset($year_level)? null : "aria-current='page'"}}>
                                    @if(isset($year_level))
                                        <a href="{{route('block.show', ['period' => $period->id, 'course' => $course->id])}}"> {{$course->name}} </a>
                                    @else
                                        {{$course->name}}
                                    @endif
                                </li>
                                @if(isset($year_level))
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{$year_level}} 
                                    </li>
                                @endif
                            </ol>
                        </nav>
                    </header>
                </div>
                @if(isset($year_level))
                    <div class="col text-end">
                        <button type="button" class="btn btn-primary" data-bs-target="#addBlockModal" data-bs-toggle="modal">
                            New
                        </button>
                    </div>
                @endif
                <hr/>
            </div>
            @if(isset($year_level))
            <div class="row row-cols-4">
                <div class="col">
                    @unless($block->isEmpty())
                        @foreach ($block as $det)
                        <div class="col mb-3">
                            <div class="card">
                                <div class="card-header {{randomBg()}}">
                                    <div class="row d-flex">
                                        <div class="col">
                                            <a href="{{route('klase.manage', $det->id)}}" class="link-light"
                                                onMouseOver="this.style.textDecoration='underline'"
                                                onMouseOut="this.style.textDecoration='none'"
                                            >
                                                {{chr($det->section + 64)}}
                                            </a>
                                        </div>
                                        <div class="col-2 me-3 pb-n3 mb-n3">
                                            <button class="btn btn-transparent shadow-none" data-bs-target="#editBlockModal" data-bs-toggle="modal"
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
                                        </div>
                                        <div class="col-2 me-1 pt-1 mb-n3   ">
                                            <button type="button" class="btn-close" data-bs-target="#delBlockModal" data-bs-toggle="modal"
                                                    data-bs-id="{{$det->id}}"
                                                    data-bs-description="{{$det->getDescription(1)}}"
                                                    data-bs-period="{{$det->period->getDescription()}}"
                                            >
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <div class="row">
                                            <div class="col text-secondary">
                                                Students
                                            </div>
                                            <div class="col text-end">
                                                <span class="fw-bold badge bg-danger text-wrap">
                                                    {{$det->blockStudents->count()}} 
                                                </span>
                                            </div>
                                        </div>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase">Block is empty</h3>
                    @endunless
                </div>
            </div>
            @else
            <div class="row row-cols-4">
                @unless($block->isEmpty())
                    @php
                        $prevYear = 0;
                    @endphp

                    @foreach ($block as $det)
                        @if($det->year_level !== $prevYear)
                            <div class="col mb-3">
                                <div class="card">
                                    <div class="card-header {{randomBg()}}">
                                        <div class="row d-flex">
                                            <div class="col">
                                                <a href="{{route('block.show', ['period' => $det->period_id, 'course' => $det->course_id, 'year_level' => $det->year_level])}}" class="link-light"
                                                    onMouseOver="this.style.textDecoration='underline'"
                                                    onMouseOut="this.style.textDecoration='none'"
                                                >
                                                    {{$det->getYear()}} 
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <div class="row">
                                                <div class="col text-secondary">
                                                    Blocks
                                                </div>
                                                <div class="col text-end">
                                                    <span class="fw-bold badge bg-warning text-wrap"> 
                                                        {{countBlocks($block, $det->year_level)}} 
                                                    </span>
                                                </div>
                                            </div>
                                        </h5>
                                        <h5 class="card-title">
                                            <div class="row">
                                                <div class="col text-secondary">
                                                    Students
                                                </div>
                                                <div class="col text-end">
                                                    <span class="fw-bold badge bg-danger text-wrap">
                                                        {{$det->blockStudents->count()}} 
                                                    </span>
                                                </div>
                                            </div>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @php
                            $prevYear = $det->year_level;
                        @endphp
                    @endforeach
                @else
                    <div class="col mb-3">
                        <div class="card">
                            <div class="card-header {{randomBg()}}">
                                <a href="#" class="link-light disabled"
                                    onMouseOver="this.style.textDecoration='underline'"
                                    onMouseOut="this.style.textDecoration='none'"
                                >
                                    Block is empty.
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-secondary">No Student has been enrolled in selected period.</h5>
                            </div>
                        </div>
                    </div>
                @endunless
            </div>
            @endif
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
    function countBlocks($block, $year)
    {
        $count = 0;

        foreach($block as $det)
            ($year == $det->year_level)? $count += 1 : null;   

        return $count;
    }   
@endphp
