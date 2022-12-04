<x-layout>
    <x-medium-card>
        <div class="container">
            <div class="row my-3">
                <div class="col">
                    <header>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('block.manage', $klase[0]->block->period->id)}}">
                                        {{$klase[0]->block->period->getDescription()}}
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{route('block.show', ['period' => $klase[0]->block->period->id, 'course' => $klase[0]->block->course->id])}}">
                                        {{$klase[0]->block->course->name}}
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{route('block.show', ['period' => $klase[0]->block->period->id, 'course' => $klase[0]->block->course->id, 'year_level' => $klase[0]->block->year_level])}}">
                                        {{$klase[0]->block->getYear()}}
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    {{chr($klase[0]->block->section + 64)}}
                                </li>
                            </ol>
                          </nav>
                    </header>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    @unless($klase->isEmpty())
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th> <strong> Code </strong> </th>
                            <th> <strong> Description </strong> </th>
                            <th> <strong> Schedule </strong> </th>
                            <th colspan="2"> <strong> Instructor </strong> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($klase as $det)
                        <tr>
                            <td>
                                <a href="#" class="link-dark">
                                    {{$det->subject->code}}
                                </a>
                            </td>
                            <td class="col-4">
                                <a href="#" class="link-dark">
                                    {{$det->subject->descriptive_title}}
                                </a>
                            </td>
                            <td>
                                Monday, 7:00 AM - 10:00 AM
                            </td>
                            <td>
                                @if(isset($det->instructor))
                                {{$det->faculties[0]->fullName(1)}}
                                @else
                                <span class="text-uppercase text-danger fw-bold"> Unassigned </span>
                                @endif
                            </td>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase">Course is empty</h3>
                @endunless
                </div>
            </div>
        </div>
    </x-medium-card>
    <x-admin-canvas/>
</x-layout>