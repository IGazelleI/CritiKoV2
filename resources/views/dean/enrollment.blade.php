<x-layout>
    <x-medium-card>
        <div class="card mask-custom">
            @unless($enrollment->isEmpty())
            <div class="card-body p-4 text-dark">
              <div class="text-center pt-3 pb-2">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-todo-list/check1.webp"
                  alt="Check" width="60">
                <h2 class="my-4">Enrollment</h2>
              </div>
              <table class="table mb-0">
                <thead class="bg-light">
                  <tr>
                    <th scope="col">ID Number</th>
                    <th scope="col">Period</th>
                    <th scope="col">Name</th>
                    <th scope="col">Course</th>
                    <th scope="col">Year Level</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($enrollment as $det)
                    <tr class="fw-normal">
                        <td class="align-middle">
                            <span>{{$det->user->students[0]->id_number}}</span>
                        </td>
                        <td class="align-middle">
                            <span>{{$det->period->getDescription()}}</span>
                        </td>
                        <th>
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                alt="avatar 1" style="width: 45px; height: auto;">
                            <span class="ms-2">{{$det->user->students[0]->fullName(true)}}</span>
                        </th>
                        <td class="align-middle">
                            <span>{{$det->course->name}}</span>
                        </td>
                        <td class="align-middle">
                            <span>{{$det->year_level}}</span>
                        </td>
                        <td class="align-middle">
                            <form action="{{route('dean.processEnrollment', $det->id)}}" method="POST">
                                @csrf
                                <input type="hidden" name="decision" value="1"/>
                                <button type="submit" class="btn btn-transparent shadow-none p-0 n-0">
                                    <span class="badge bg-success rounded-circle p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                        </svg>
                                    </span>
                                </button>
                            </form>
                            <form action="{{route('dean.processEnrollment', $det->id)}}" method="POST">
                                @csrf
                                <input type="hidden" name="decision" value="0"/>
                                <button type="submit" class="btn btn-transparent shadow-none p-0 n-0">
                                    <span class="badge bg-danger rounded-circle p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                        </svg>
                                    </span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase">Enrollment is empty </h3>
        @endunless
    </div>
    </x-medium-card>
    <x-faculty-canvas/>
</x-layout>