<x-layout>
    <x-medium-card>
        <div class="container">
            <div class="row my-3">
                <div class="col">
                    <header>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('block.manage', $klase->first()->block->period->id)}}">
                                        {{$klase->first()->block->period->getDescription()}}
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{route('block.show', ['period' => $klase->first()->block->period->id, 'course' => $klase->first()->block->course->id])}}">
                                        {{$klase->first()->block->course->name}}
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{route('block.show', ['period' => $klase->first()->block->period->id, 'course' => $klase->first()->block->course->id, 'year_level' => $klase->first()->block->year_level])}}">
                                        {{$klase->first()->block->getYear()}}
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    {{chr($klase->first()->block->section + 64)}}
                                </li>
                            </ol>
                          </nav>
                    </header>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-info"
                            data-bs-toggle="collapse" data-bs-target="#collapseSubjects" aria-expanded="false" aria-controls="collapseExample"
                        >
                            Class Details
                        </button>
                        <button type="button" class="btn btn-secondary"
                            data-bs-toggle="collapse" data-bs-target="#collapseStudents" aria-expanded="false" aria-controls="collapseExample"
                        >
                            Students
                        </button>
                    </div>
                </div>
            </div>
            <div class="collapse show" id="collapseSubjects">
                <div class="card card-body">
                    <div class="row">
                        <div class="col">
                            @unless($klase->isEmpty())
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> <strong> Code </strong> </th>
                                        <th> <strong> Description </strong> </th>
                                        <th> <strong> Schedule </strong> </th>
                                        <th> <strong> Instructor </strong> </th>
                                        <th colspan="2"> <strong> # </strong> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($klase as $det)
                                    <tr>
                                        <a href="#">
                                        <td data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Click To View {{$det->subject->code}} Students">
                                            <a href="{{route('klase.students', $det->id)}}" class="link-dark">
                                                {{$det->subject->code}}
                                            </a>
                                        </td>
                                        <td class="col-4" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Click To View {{$det->subject->descriptive_title}} Students">
                                            <a href="{{route('klase.students', $det->id)}}" class="link-dark">
                                                {{$det->subject->descriptive_title}}
                                            </a>
                                        </td>
                                        <td>
                                            Monday, 7:00 AM - 10:00 AM
                                        </td>
                                        <td>
                                            @if(isset($det->instructor))
                                            {{$det->faculties->first()->fullName(1)}}
                                            @else
                                            <span class="text-uppercase text-danger fw-bold"> Unassigned </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-danger rounded-pill"> {{$det->klaseStudents->count()}} </span>
                                        </td>
                                        @if(!isset($det->block->period->beginEval) || $det->block->period->beginEval > NOW()->format('Y-m-d'))
                                        <td class="d-flex justify-self-center align-self-center">
                                            <div class="dropdown">
                                                <button class="border border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 5%">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                                        <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{route('klase.assignInstructor', ['department' => encrypt($det->subject->course->department_id), 'klase' => encrypt($det->id)])}}" class="dropdown-item">
                                                            Assign Instructor
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button type="button" class="dropdown-item" data-bs-target="#editCourseModal" data-bs-toggle="modal"
                                                            data-bs-id="{{$det->id}}"
                                                            data-bs-department_id="{{$det->department_id}}"
                                                            data-bs-name="{{$det->name}}"
                                                            data-bs-description="{{$det->description}}"
                                                        >
                                                            Modify
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button type="button" class="dropdown-item text-danger" data-bs-target="#delCourseModal" data-bs-toggle="modal"
                                                            data-bs-id="{{$det->id}}"
                                                            data-bs-description="{{$det->description}}"
                                                        >
                                                            Delete
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase">Class is empty</h3>
                            @endunless
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse" id="collapseStudents">
                <div class="card card-body">
                    @unless($students->isEmpty())
                        <ol class="list-group list-group-numbered">
                            @foreach($students as $det)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"> {{$det->user->students->first()->fullName(1)}}</div>
                                    Content for list item
                                </div>
                                <span class="badge bg-primary rounded-pill">14</span>
                            </li>
                            @endforeach
                        </ol>
                            {{-- <td class="d-flex justify-self-center align-self-center">
                                @if(!isset($det->block->period->beginEval) || $det->block->period->beginEval > NOW()->format('Y-m-d'))
                                <div class="dropdown">
                                    <button class="border border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 5%">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{route('klase.assignInstructor', ['department' => encrypt($det->subject->course->department_id), 'klase' => encrypt($det->id)])}}" class="dropdown-item">
                                                Assign Instructor
                                            </a>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item" data-bs-target="#editCourseModal" data-bs-toggle="modal"
                                                data-bs-id="{{$det->id}}"
                                                data-bs-department_id="{{$det->department_id}}"
                                                data-bs-name="{{$det->name}}"
                                                data-bs-description="{{$det->description}}"
                                            >
                                                Modify
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item text-danger" data-bs-target="#delCourseModal" data-bs-toggle="modal"
                                                data-bs-id="{{$det->id}}"
                                                data-bs-description="{{$det->description}}"
                                            >
                                                Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                @endif
                            </td> --}}
                    @else
                    <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase">Students inside block is empty</h3>
                    @endunless
                </div>
            </div>
        </div>
    </x-medium-card>
    <x-admin-canvas/>
</x-layout>