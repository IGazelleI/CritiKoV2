<x-layout>
    <x-medium-card>
        <div class="container-fluid">
            <div class="row my-3">
                <div class="col">
                    <header>
                        <h3>
                            {{$course->name}}
                            <span class="fs-6"> <p> {{$period->getDescription()}}  </p> </span>
                            @if(isset($year_level))
                            {{$year_level}}
                            @endif
                        </h3>
                    </header>
                </div>
                <div class="col">
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
                <div class="col">
                    <button type="button" class="btn btn-primary" data-bs-target="#addBlockModal" data-bs-toggle="modal">
                        New
                    </button>
                </div>
                <hr/>
            </div>
            @if(isset($year_level))
            <div class="row">
                <div class="col">
                    @unless($block->isEmpty())
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th> <strong> Section </strong> </th>
                                <th colspan="2"> Students </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($block as $det)
                            <tr>
                                <td class="col">
                                    <a href="{{route('klase.manage', $det->id)}}" class="link-dark">
                                        {{chr($det->section + 64)}}
                                    </a>
                                </td>
                                <td class="col">
                                    {{$det->blockStudents->count()}}
                                </td>
                                <td class="col-1 justify-self-end align-self-center">
                                    <div class="dropdown">
                                        <button class="border border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 5%">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                                <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button class="dropdown-item" data-bs-target="#editBlockModal" data-bs-toggle="modal"
                                                    data-bs-id="{{$det->id}}"
                                                    data-bs-course="{{$det->course_id}}"
                                                    data-bs-period="{{$det->period_id}}"
                                                    data-bs-year="{{$det->year_level}}"
                                                    data-bs-section="{{$det->section}}"
                                                >
                                                    Edit
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item text-danger" data-bs-target="#delBlockModal" data-bs-toggle="modal"
                                                        data-bs-id="{{$det->id}}"
                                                        data-bs-description="{{$det->getDescription(1)}}"
                                                        data-bs-period="{{$det->period->getDescription()}}"
                                                >
                                                    Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                                            {{-- <div class="col text-end justify-self-end">
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
                                                    data-bs-description="{{$det->getDescription(1)}}"
                                                >
                                                </button>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Blocks: <b> {{countBlocks($block, $det->year_level)}} </b></h5>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @php
                            $prevYear = $det->year_level;
                        @endphp
                    @endforeach
                @else
                    @for($i = 0; $i < 4; $i++)
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
            @endif
            {{-- <div class="row">
                <div class="col">
                    @unless($block->isEmpty())
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th> <strong> Description </strong> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($block as $det)
                            <tr>
                                <td class="col-4">
                                    {{$det->getDescription()}}
                                </td>
                                <td class="col-2">
                                    <a href="{{route('block.manage', $det->id)}}" class="link-dark">
                                        {{$det->year_level}}
                                    </a>
                                </td>
                                <td class="col-8">
                                    <a href="{{route('block.manage', $det->id)}}" class="link-dark">
                                        {{chr($det->section + 64)}}
                                    </a>
                                </td>
                                <td class="col d-flex justify-self-center align-self-center">
                                    <div class="dropdown">
                                        <button class="border border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 5%">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                                <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button class="dropdown-item" data-bs-target="#editBlockModal" data-bs-toggle="modal"
                                                    data-bs-id="{{$det->id}}"
                                                    data-bs-course="{{$det->course_id}}"
                                                    data-bs-period="{{$det->period_id}}"
                                                    data-bs-year="{{$det->year_level}}"
                                                    data-bs-section="{{$det->section}}"
                                                >
                                                    Edit
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item text-danger" data-bs-target="#delBlockModal" data-bs-toggle="modal"
                                                        data-bs-id="{{$det->id}}"
                                                        data-bs-description="{{$det->getDescription(1)}}"
                                                        data-bs-period="{{$det->period->getDescription()}}"
                                                >
                                                    Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase">Block is empty</h3>
                @endunless
                </div>
            </div>
             --}}
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
