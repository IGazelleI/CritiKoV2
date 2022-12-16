<x-layout>
    <x-general-card>
        <div class="card mask-custom">
            <div class="card-body p-4 text-dark">
              @unless(!isset($subjects) || $enrollment->status == 'Denied')
              <div class="text-center pt-3 pb-2">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-todo-list/check1.webp"
                  alt="Check" width="60">
                <h2 class="my-4" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                  Evaluation Status
                </h2>
              </div>
              <table class="table mb-0">
                <thead class="bg-light">
                  <tr>
                    <th scope="col">Instructor</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $det)
                    <tr class="fw-normal">
                        <th>
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                              alt="avatar 1" style="width: 45px; height: auto"/>

                            <span class="ms-2"> {{$det->klase->faculties->first()->fullName(1)}} </span>
                        </th>
                        <td class="align-middle">
                            <span> {{$det->klase->subject->descriptive_title}} </span>
                        </td>
                        <td class="align-middle">
                            <h6 class="mb-0">
                                @if($det->klase->faculties->first() != null)
                                  @if($det->klase->faculties->first()->evaluated->where('evaluator', auth()->user()->id)->isEmpty())
                                    <a href="{{route('student.evaluate', ['subject' => encrypt($det->id)])}}" class="btn btn-transparent shadow-none px-0"
                                      data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Click To Evaluate {{$det->klase->subject->code}} Instructor"
                                    >
                                      <span class="badge bg-warning rounded-circle px-2 py-2">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                              <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                              <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                          </svg>
                                      </span>  
                                    </a>
                                  @else
                                    <a href="{{route('student.evaluate', ['subject' => encrypt($det->id)])}}" class="btn btn-transparent shadow-none px-0"
                                      data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Click To View Summary"
                                    >
                                      <span class="badge bg-success rounded-circle px-2 py-2">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                              <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                          </svg>
                                      </span>
                                    </a>
                                  @endif
                                @endif
                          </h6>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
              @else
              <div class="text-center text-uppercase pt-3 pb-2">
                <h2 class="my-4" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                  Currently not enrolled in any subjects
                </h2>
              </div>
              @endunless
            </div>
        </div>
    </x-general-card> 
    <x-student-canvas/>
</x-layout>