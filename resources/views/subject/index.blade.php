<x-layout>
    <x-general-card>
        <div class="table">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col">
                            <h2>
                                @if(isset($course))
                                {{$course->name}} Subjects
                                @else
                                Subject <b>Management</b>
                                @endif
                            </h2>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-primary" data-bs-target="#addSubModal" data-bs-toggle="modal">
                                <span>
                                    New
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                @unless($subject->isEmpty())
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            @if(!isset($course))
                            <th> <strong> Course </strong> </th>
                            @endif
                            <th> <strong> Code </strong> </th>
                            <th class="text-start" colspan="2"> <strong> Description </strong> </th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($subject as $det)
                            <tr>
                                @if(!isset($course))
                                <td>{{$det->course->name}}</td>
                                @endif
                                <td class="col-3">{{$det->code}}</td>
                                <td class="col-8">{{$det->descriptive_title}}</td>
                                <td class="col d-flex justify-self-center align-self-center">
                                    <div class="dropdown">
                                        <button class="border border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 5%">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                                <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button type="button" class="dropdown-item" data-bs-target="#editSubModal" data-bs-toggle="modal"
                                                    data-bs-id="{{$det->id}}"
                                                    data-bs-course="{{$det->course_id}}"
                                                    data-bs-code="{{$det->code}}"
                                                    data-bs-description="{{$det->descriptive_title}}"
                                                    data-bs-semester="{{$det->semester}}"
                                                >
                                                    Edit
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item text-danger" data-bs-target="#delSubModal" data-bs-toggle="modal"
                                                    data-bs-id="{{$det->id}}"
                                                    data-bs-description="{{$det->descriptive_title}}"
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
                    <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase"> Subject is empty </h3>
                @endunless
                {{-- <div class="clearfix">
                    <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                    <ul class="pagination">
                        <li class="page-item disabled"><a href="#">Previous</a></li>
                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item active"><a href="#" class="page-link">3</a></li>
                        <li class="page-item"><a href="#" class="page-link">4</a></li>
                        <li class="page-item"><a href="#" class="page-link">5</a></li>
                        <li class="page-item"><a href="#" class="page-link">Next</a></li>
                    </ul>
                </div> --}}
            </div>
        </div>
    </x-general-card>
    <x-admin-canvas/>
</x-layout>
