<x-layout>
    <x-medium-card>
        <div class="container-fluid">
            <div class="row my-3 d-flex">
                <div class="col-6">
                    <header>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @if(isset($period))
                                    <li class="breadcrumb-item active" aria-current="page">{{$period->getDescription()}}</li>
                                @endif
                            </ol>
                        </nav>
                    </header>
                </div>
                <div class="col text-end">
                    <div class="dropend">
                        <button type="button" class="btn btn-info" data-bs-toggle="dropdown" aria-expanded="false">
                            Period
                        </button>
                        <ul class="dropdown-menu">
                            @unless ($periods->isEmpty())
                                @foreach($periods as $det)
                                    <li><a class="dropdown-item" href="{{route('block.manage', $det->id)}}">{{$det->getDescription()}}</a></li>
                                @endforeach
                            @else
                                <li><a class="dropdown-item disabled">Period is empty.</a></li>
                            @endunless
                        </ul>
                    </div>
                </div>
                <hr/>
            </div>
            <div class="row row-cols-4">
                @unless($block->isEmpty())
                        @php
                            $prevCourse = 0;
                        @endphp

                        @foreach ($block as $det)
                            @if($det->course_id !== $prevCourse)
                                <div class="col mb-3">
                                    <div class="card">
                                        <div class="card-header {{randomBg()}}">
                                            <div class="row d-flex">
                                                <div class="col">
                                                    <a href="{{route('block.show', ['period' => $det->period_id, 'course' => $det->course_id])}}" class="link-light"
                                                        onMouseOver="this.style.textDecoration='underline'"
                                                        onMouseOut="this.style.textDecoration='none'"
                                                    >
                                                        {{$det->course->name}}
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
                                                        <span class="fw-bold badge bg-primary text-wrap"> 
                                                            {{countBlocks($block, $det->course_id)}} 
                                                        </span>
                                                    </div>
                                                </div>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @php
                                $prevCourse = $det->course_id;
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
    function countBlocks($block, $course)
    {
        $count = 0;

        foreach($block as $dets)
            ($course == $dets->course_id)? $count += 1 : null;   

        return $count;
    }
@endphp
