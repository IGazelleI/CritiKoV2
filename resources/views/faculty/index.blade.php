<x-layout>
    <div class="container mt-3">
        <div class="row">
          <div class="col-6">
            <div class="card mask-custom">
                <div class="card-body p-4 text-dark">
                @if(isset($period->beginEval))
                  @if($period->beginEval <= NOW()->format('Y-m-d'))
                    @unless(!isset($faculty))
                    <div class="text-center pt-3 pb-2">
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-todo-list/check1.webp"
                        alt="Check" width="60">
                      <h2 class="my-4" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                        Status
                      </h2>
                    </div>
                    <table class="table mb-0">
                      <thead class="bg-light">
                        <tr>
                          <th scope="col">Faculty</th>
                        </tr>
                      </thead>
                      <tbody>
                          @php
                            $current = 0;
                          @endphp
                          @foreach($faculty as $det)
                          <tr class="fw-normal">
                              <th>
                                  <div class="row">
                                    <div class="col">
                                      <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                        alt="avatar 1" style="width: 45px; height: auto"/>
          
                                      <span class="ms-2"> {{$det->fullName(1)}} </span> <br/> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                      <span class="text-secondary">
                                        @if($det->isDean)
                                        College Dean
                                        @endif
                                      </span>
                                    </div>
                                  </div>
                                  <div class="row">
                                    @php
                                        $block = App\Models\Block::where('period_id', $period->id)
                                                            -> latest('id')
                                                            -> get();
                                        $klases = 0;
  
                                        foreach($block as $b)
                                            $klases += $b->klases->where('instructor', $det->user_id)->count();
                                    @endphp
                                    <div class="col">
                                        <button class="btn btn-transparent text-secondary shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$det->id}}" aria-expanded="false" aria-controls="collapseExample">
                                            Subjects Handled
                                        </button>
                                    </div>
                                    <div class="col text-end">
                                        <span class="fw-bold badge bg-primary text-wrap"> 
                                            {{$klases}} 
                                        </span>
                                    </div>
                                    @if(!$block->isEmpty())
                                    <div class="collapse" id="collapse{{$det->id}}">
                                        @foreach($block as $b)
                                            @foreach($b->klases->where('instructor', $det->user_id) as $klase)
                                            @php
                                                $finished = $det->evaluated->where('period_id', $period->id)->where('evaluatee', $det->user_id)->whereIn('evaluator', $student)->where('subject_id', $klase->subject_id)->count();
                                                $total = $klase->klaseStudents->count();
                                                $pending = $total - $finished;
                                            @endphp
                                            <div class="row my-1">
                                              <div class="col">
                                                {{$klase->subject->descriptive_title}}
                                              </div>
                                              <div class="col-1 text-end">
                                                  @if($det->evaluated->where('period_id', $period->id)->where('evaluatee', $det->user_id)->where('evaluator', auth()->user()->id)->where('subject_id', $klase->subject_id)->isEmpty())
                                                  <span class="badge bg-warning rounded-circle px-2 py-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Pending" >
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                                          <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                                      </svg>
                                                  </span>
                                                  @else
                                                  <span class="badge bg-success rounded-circle px-2 py-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{date('D, F d, Y @ g:i A', strToTime($det->evaluated->where('period_id', $period->id)->where('evaluatee', $det->user_id)->where('evaluator', auth()->user()->id)->where('subject_id', $klase->subject_id)->first()->created_at))}}">
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                          <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                                      </svg>
                                                  </span>
                                                  @endif
                                              </div>
                                            </div>{{-- 
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSub{{$klase->id}}" aria-expanded="false" aria-controls="collapseTwo">
                                                
                                            </button> --}}{{-- 
                                            <div id="collapseSub{{$klase->id}}" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <ul class="list-group">
                                                @foreach($klase->klaseStudents as $student)
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col">
                                                                {{$student->user->students->first()->fullName(true)}}
                                                            </div>
                                                            <div class="col text-end">
                                                                @if($det->evaluated->where('period_id', $period->id)->where('evaluatee', $det->user_id)->where('evaluator', $student->user_id)->where('subject_id', $klase->subject_id)->isEmpty())
                                                                <span class="badge bg-warning rounded-circle px-2 py-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Pending" >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                                                    </svg>
                                                                </span>
                                                                @else
                                                                <span class="badge bg-success rounded-circle px-2 py-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{date('D, F d, Y @ g:i A', strToTime($det->evaluated->where('period_id', $period->id)->where('evaluatee', $det->user_id)->where('evaluator', $student->user_id)->where('subject_id', $klase->subject_id)->first()->created_at))}}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                                                    </svg>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                                </ul>
                                            </div> --}}
                                            @endforeach
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                              </th>{{-- 
                              <td class="align-middle">
                                  <h6 class="mb-0">
                                      @php
                                        $facFinished = true;
                                        //get blocks
                                        $block = App\Models\Block::where('period_id', $period->id)->get();

                                        if(!$block->isEmpty())
                                        {
                                          foreach($block as $b)
                                          {
                                            if($b->klases->where('instructor', $det->user_id)->isEmpty())
                                            {
                                              $facFinished = false;
                                                break;
                                            }
                                            
                                            foreach($b->klases->where('instructor', $det->user_id) as $klase)
                                            {
                                              if($det->evaluated->where('evaluator', auth()->user()->id)->where('evaluatee', $det->user_id)->where('subject_id', $klase->subject_id)->isEmpty())
                                              {
                                                $facFinished = false;
                                                break 2;
                                              }
                                            }
                                          }
                                        }
                                      @endphp
                                      @if($facFinished)
                                        <a href="{{route('faculty.evaluate', ['faculty' => encrypt($det->user_id)])}}" class="btn btn-transparent shadow-none px-0"
                                          data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Click To Evaluate {{$det->fullName(1)}}"  
                                        >
                                          <span class="badge bg-warning rounded-circle py-2 px-2">
                                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                                  <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                              </svg>
                                          </span>  
                                        </a>
                                      @else
                                        <a href="{{route('faculty.evaluate', ['faculty' => encrypt($det->user_id)])}}" class="btn btn-transparent shadow-none px-0"
                                          data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="View Summary on Evaluation of {{$det->fullName(1)}}"  
                                        >
                                          <span class="badge bg-success rounded-circle py-2 px-2">
                                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                  <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                              </svg>
                                          </span>
                                        </a>
                                      @endif
                                </h6>
                              </td> --}}
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                    @else
                    <div class="text-center text-uppercase pt-3 pb-2">
                      <h2 class="my-4" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                        Current department has no faculty
                      </h2>
                    </div>
                    @endunless
                    @elseif($period->endEval < NOW()->format('Y-m-d'))
                      <h3 class="text-center text-uppercase bg-light p-3 rounded"> Evaluation ended on {{date('F d, Y @ D', strToTime($period->endEval))}} </h3>
                    @else
                      <h3 class="text-center text-uppercase bg-light p-3 rounded"> Evaluation will open on {{date('F d, Y @ D', strToTime($period->beginEval))}} </h3>
                    @endif
                  @else
                  <h3 class="text-center text-uppercase bg-light p-3 rounded"> Evaluation date not set </h3>
                  @endif
                </div>
            </div>
          </div>
          <div class="col">
            <div class="row mx-1">
              <div class="card mask-custom">
                <div class="card-body p-0 text-dark">
                  <div class="ps-3">
                    <h5 class="mt-4" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                        Subjects Handled
                    </h5>
                    <p class="text-secondary" style="font-size: 12px">
                        {{$period->getDescription()}}
                    </p>
                    <hr/>
                  </div>
                  <div class="ps-2 pb-2">
                    @php
                      $block = App\Models\Block::where('period_id', $period->id)
                                  -> latest('id')
                                  -> get();
                    @endphp
                    @unless($block->isEmpty() || $block->first()->klases->where('instructor', auth()->user()->id)->first() == null && $block->last()->klases->where('instructor', auth()->user()->id)->first() == null)
                     <ul class="list-group pe-2">
                      <li class="list-group-item fw-bold">
                        <div class="row">
                          <div class="col-3">
                            Subject
                          </div>
                          <div class="col-3">
                            Schedule
                          </div>
                          <div class="col">
                            Progress
                          </div>
                        </div>
                      </li>
                      @foreach($block as $b)
                          @unless ($b->klases->where('instructor', auth()->user()->id)->first() == null)
                            @foreach($b->klases->where('instructor', auth()->user()->id) as $klase)
                              <li class="list-group-item">
                                <div class="row">
                                  <div class="col-3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$klase->subject->descriptive_title}}">
                                    {{$klase->subject->code}}
                                  </div>
                                  <div class="col-3">
                                    {{isset($klase->schedule)? $klase->schedule : 'TBA'}}
                                  </div>
                                  <div class="col">
                                    @php
                                         $students = App\Models\Enrollment::where('period_id', $period->id)
                                                            -> get();
  
                                        $student = array();
  
                                        foreach($students as $det)
                                              $student = array_merge($student, [$det->user_id]);
  
                                        $finished = auth()->user()->faculties->first()->evaluated->where('period_id', $period->id)->where('evaluatee', auth()->user()->id)->whereIn('evaluator', $student)->where('subject_id', $klase->subject_id)->count();
                                        $total = $klase->klaseStudents->count();
                                        $pending = $total - $finished;
                                    @endphp
                                    <span class="fw-bold badge bg-success text-wrap"> Finished: {{$finished}} </span> &nbsp;
                                    <span class="fw-bold badge bg-warning text-wrap"> Pending: {{$pending}} </span> &nbsp;
                                    <span class="fw-bold badge bg-secondary text-wrap"> Total : {{$total}} </span> 
                                    @if((isset($period->beginEval) && $period->endEval <= NOW()->format('Y-m-d')) && auth()->user()->faculties->first()->evaluated->where('period_id', $period->id)->where('evaluatee', auth()->user()->id)->whereIn('evaluator', $student)->where('subject_id', $klase->subject_id)->first() != null)
                                      &nbsp;
                                      <a href="{{route('admin.summaryReport', ['faculty' => auth()->user()->faculties->first()->id, 'period' => $period->id, 'subject' => $klase->subject_id])}}"
                                        target="_blank"
                                      >
                                        View Details
                                      </a>
                                    @endif
                                  </div>
                                </div>
                              </li>
                            @endforeach
                          @endunless
                      @endforeach
                    </ul>
                    @else
                    <h3 class="text-center m-1 bg-light p-1 rounded text-secondary text-uppercase">No subjects handled</h3>
                    @endunless
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="row mt-4">
                  <div class="col">
                    <div class="card mask-custom">
                      <div class="card-body p-0 text-dark">
                          <div class="ps-3">
                              <h5 class="mt-4" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                                  Summary
                              </h5>
                              <p class="text-secondary" style="font-size: 12px">
                                  Evaluation summary for {{$period->getDescription()}}
                              </p>
                              <hr/>
                          </div>
                          <div class="ps-2 pb-2">
                              @if(isset($period->beginEval) && $period->endEval <= NOW()->format('Y-m-d'))
                              <!-- Pills navs -->
                              <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a
                                        class="nav-link rounded-pill active"
                                        id="tab-student"
                                        data-mdb-toggle="pill"
                                        href="#pills-student"
                                        role="tab"
                                        aria-controls="pills-student"
                                        aria-selected="true"
                                    >
                                        Student
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a
                                        class="nav-link rounded-pill"
                                        id="tab-faculty"
                                        data-mdb-toggle="pill"
                                        href="#pills-faculty"
                                        role="tab"
                                        aria-controls="pills-faculty"
                                        aria-selected="false"
                                    >
                                        Faculty
                                    </a>
                                </li>
                            </ul>
                            <!-- Pills navs -->
                            <!-- Pills content -->
                            <div class="tab-content"> 
                                <div class="tab-pane fade show active" id="pills-student" role="tabpanel" aria-labelledby="tab-student"> 
                                  @if(isset($sumSt))  
                                  <div class="row d-flex justify-content-between p-2 px-4">
                                      <div class="col">
                                        <div class="row">
                                          <div class="col">
                                            <strong> Grand Mean: </strong> {{number_format($sumSt->avg('mean') / $sumSt->evalCount, 2)}}
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col">
                                            <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="1.00 - 1.79 Unsatisfactory, 1.80 - 2.59 Fair, 2.60 - 3.39 Satisfactory, 3.40 - 4.19 Very Satisfactory, 4.20 - 5.00 Outstanding">
                                              <p class="badge {{status(round($sumSt->avg('mean') / $sumSt->evalCount, 2))->background}} fs-6 text-wrap">
                                                {{status(round($sumSt->avg('mean') / $sumSt->evalCount, 2))->message}}
                                              </p>
                                            </span>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="col text-end align-self-center">
                                        <a href="#collapseStDetails" class="text-decoration-underline" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseExample">
                                            Show Details
                                        </a>
                                    </div>
                                    @else
                                    <div class="row">
                                      <div class="col">
                                        <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase"> Evaluation by student in selected semester is empty </h3>
                                      </div>
                                    </div>
                                    @endif
                                  </div>
                                  @if(isset($sumSt))
                                  <div class="row">
                                      <div class="col">
                                          <div class="collapse" id="collapseStDetails">
                                              <div class="card card-body">
                                                  <div class="row">
                                                    <div class="col">
                                                      <span class="fw-bold" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Based on the results of the Student Evaluation"> 
                                                        Specific points to improve: 
                                                      </span>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col">
                                                      <ul>
                                                          @foreach($recommendation['studentEvaluation'] as $rec)
                                                            <li> {{$rec->keyword}} </li>
                                                          @endforeach
                                                      </ul>
                                                    </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                                @endif
                                <div class="tab-pane fade show" id="pills-faculty" role="tabpanel" aria-labelledby="tab-faculty">
                                @if(isset($sumFac))
                                  <div class="row d-flex justify-content-between p-2 px-4">
                                    <div class="col">
                                        <div class="row">
                                          <div class="col">
                                            <strong> Grand Mean: </strong> {{number_format($sumFac->avg('mean') / $sumFac->evalCount, 0)}}
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col">
                                            <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="1 - Poor, 2 - Fair, 3 - Good, 4 - Very Good, 5 - Outstanding">
                                              <p class="badge {{status(round($sumFac->avg('mean') / $sumFac->evalCount, 0))->background}} fs-6 text-wrap">
                                                {{status(round($sumFac->avg('mean') / $sumFac->evalCount, 0))->messageF}}
                                              </p>
                                            </span>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="col text-end align-self-center">
                                        <a href="#collapseFacDetails" class="text-decoration-underline" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseExample">
                                            Show Details
                                        </a>
                                    </div>
                                    @else
                                    <div class="row">
                                      <div class="col">
                                        <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase"> Evaluation by co-faculty in selected semester is empty </h3>
                                      </div>
                                    </div>
                                    @endif
                                  </div>
                                  @if(isset($sumFac))
                                  <div class="row">
                                      <div class="col">
                                          <div class="collapse" id="collapseFacDetails">
                                            <div class="card card-body">
                                                <div class="row">
                                                  <div class="col">
                                                    <span class="fw-bold" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Based on the results of the Faculty Evaluation"> 
                                                      Specific points to improve
                                                    </span>
                                                  </div>
                                                </div>
                                                  @unless($recommendation['facultyEvaluation']->where('isLec', true) == null)
                                                  <div class="row">
                                                    <div class="col">
                                                      <div class="row">
                                                        <div class="col text-secondary">
                                                          In lecture classes:
                                                        </div>
                                                      </div>
                                                      <div class="row">
                                                        <div class="col">
                                                          <ul>
                                                              @foreach($recommendation['facultyEvaluation']->where('isLec', true) as $rec)
                                                                <li> {{$rec->keyword}} </li>
                                                              @endforeach
                                                          </ul>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  @endunless
                                                  @unless($recommendation['facultyEvaluation']->where('isLec', false) == null)
                                                  <div class="row">
                                                    <div class="col">
                                                      <div class="row">
                                                        <div class="col text-secondary">
                                                          While using the laboratory:
                                                        </div>
                                                      </div>
                                                      <div class="row">
                                                        <div class="col">
                                                          <ul>
                                                              @foreach($recommendation['facultyEvaluation']->where('isLec', false) as $rec)
                                                                <li> {{$rec->keyword}} </li>
                                                              @endforeach
                                                          </ul>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  @endunless
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                                  @endif
                                </div>
                            </div>
                            <!-- Pills content -->
                              @elseif($period->endEval >= NOW()->format('Y-m-d'))
                              <p class="my-4 text-center text-uppercase text-secondary" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                                  Expected date for summary on {{date('F d, Y @ D', strToTime($period->endEval))}}
                              </p>
                              @else
                              <p class="my-4 text-center text-uppercase text-secondary" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                                  Standby for evaluation summary
                              </p>
                              @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 mx-5">
            <div class="col">
                <div class="card mask-custom">
                    <div class="card-body p-0 text-dark">
                        <div class="row">
                          <div class="col pt-3 ms-5">
                            <h3 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">  Data Visualization </h3>
                          </div>
                        </div>
                        <div class="row p-5">
                            <div class="col">
                              <div class="row">
                                <div class="col ms-2 mt-2 text-secondary">
                                  <h5 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif"> Student Result </h5>
                                </div>
                              </div>
                              <div class="row">
                                  <div class="col pb-0">
                                      {!! $studentChart->container() !!}
                                      {!! $studentChart->script() !!}
                                  </div>
                              </div>
                              <div class="row mt-2">
                                <div class="col ms-2 mt-2 text-secondary">
                                  <h5 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif"> Faculty Result </h5>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col pb-0">
                                  {!! $facultyChart->container() !!}
                                  {!! $facultyChart->script() !!}
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-faculty-canvas/>
</x-layout>
@php
  function status($mean)
  {
    $detail = new Illuminate\Support\Collection();

    $background = ['bg-danger', 'bg-warning', 'bg-secondary', 'bg-primary', 'bg-success'];
    $message = ['Unsatisfactory', 'Fair', 'Satisfactory', 'Very Satisfactory', 'Outstanding'];
    $messageF = ['Poor', 'Fair', 'Good', 'Very Good', 'Outstanding'];

    if($mean >= 1.00 && $mean <= 1.79)
        {
             $detail->message= 'Unsatisfactory';
        }
        elseif($mean >= 1.80 && $mean <= 2.59)
        {
             $detail->message= 'Fair';
        }
        elseif($mean >= 2.60 && $mean <= 3.39)
        {
             $detail->message= 'Satisfactory';
        }
        elseif($mean >= 3.40 && $mean <= 4.19)
        {
             $detail->message= 'Very Satisfactory';
        }
        elseif($mean >= 4.20 && $mean <= 5.00)
        {
             $detail->message= 'Outstanding';
        }

    $detail->background = $background[$mean - 1];
    $detail->messageF = $messageF[$mean - 1];

    return $detail;
  }
@endphp