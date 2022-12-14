<x-layout>
    <div class="container mt-3">
        <div class="row">
            <div class="col">
                <div class="card mask-custom">
                    <div class="card-body p-0 text-dark">
                        <div class="row px-2">
                            <div class="col">
                              <div class="row">
                                  <div class="col pb-0">
                                      {!! $studentChart->container() !!}
                                      {!! $studentChart->script() !!}
                                  </div>
                                  <div class="col pb-0">
                                      {!! $facultyChart->container() !!}
                                      {!! $facultyChart->script() !!}
                                </div>
                              </div>
                            </div>
                        </div>
                        @if($period->endEval <= NOW()->format('Y-m-d'))
                          @if($recommendation != null)
                          <div class="row mx-0">
                              <div class="col">
                                  <div class="row bg-warning p-1 rounded text-uppercase px-3 mx-1 mb-3" 
                                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="The following is recommended to improve. Click Recommendation to view."
                                  >
                                      <div class="col align-self-center pt-1">
                                          <button type="button" class="btn btn-transparent p-0 m-0 shadow-none" data-bs-toggle="collapse" data-bs-target="#collapseRecommendation" aria-expanded="false">
                                              <h5>
                                                  Recommendation
                                              </h5>
                                          </button>
                                      </div>
                                      <div class="col-1">
                                        <img src="https://cdn0.iconfinder.com/data/icons/kuvio-basic-ui/32/warning-512.png"  class="img-fluid" alt="Caution Icon"/>
                                    </div>
                                  </div>
                                  <div class="collapse mt-n3" id="collapseRecommendation">
                                      <div class="card card-body">
                                          <div class="row">
                                              <div class="col justify-self-center">
                                                  <ul class="fw-bold text-danger">
                                                    @foreach($recommendation as $det)
                                                        <li class="fw-bold">{{$det->keyword}}</li>
                                                    @endforeach
                                                  </ul>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>  
                          </div>
                          @endif
                        @endif
                    </div>
                </div>
            </div>
            @if(auth()->user()->faculties[0]->isChairman)
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
                              <th scope="col">Status</th>
                            </tr>
                          </thead>
                          <tbody>
                              @php
                                $current = 0;
                              @endphp
                              @foreach($faculty as $det)
                              <tr class="fw-normal">
                                  <th>
                                      <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                        alt="avatar 1" style="width: 45px; height: auto"/>
          
                                      <span class="ms-2"> {{$det->fullName(1)}} </span>
                                  </th>
                                  <td class="align-middle">
                                      <h6 class="mb-0">
                                          @if($faculty->where('user_id', $det->user_id)->first() != null)
                                            @if($faculty->where('user_id', $det->user_id)->first()->evaluated->where('evaluator', auth()->user()->id)->isEmpty())
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
            @endif
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
                                <div class="row d-flex justify-content-between p-2 px-4">
                                  @if(isset($sumSt))
                                  <div class="col">
                                      <div class="row">
                                        <div class="col">
                                          <strong> Grand Mean: </strong> {{number_format($sumSt->avg('mean'), 0)}}
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col">
                                          <p class="badge {{status(number_format($sumSt->avg('mean'), 0))->background}} text-wrap">
                                            {{status(number_format($sumSt->avg('mean'), 0))->message}}
                                          </p>
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col text-end align-self-center">
                                      <a href="#collapseStDetails" class="text-decoration-underline" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseExample">
                                          Show Details
                                      </a>
                                  </div>
                                  @else
                                  <div class="col">
                                      <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase"> Evaluation by student in selected semester is empty </h3>
                                  </div>
                                  @endif
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="collapse" id="collapseStDetails">
                                            <div class="card card-body">
                                                @if(isset($sumSt))
                                                <table class="table table-hover text-start">
                                                    <thead>
                                                        <th> <strong> Question </strong> </th>
                                                        <th> <strong> Mean </strong> </th>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                          $count = 1;
                                                          $prevCat = 0;
                                                          $catPts = 0;
                                                          $catCount = 0;
                                                          $totalPts = 0;
                                                        @endphp
                                                        @foreach($sumSt as $det)
                                                          @if($prevCat != $det->q_category_id && $prevCat != 0)
                                                            <tr>
                                                                <td class="text-end"> <strong> Mean  </strong> </td>
                                                                <td> <strong> {{number_format($catPts / $catCount, 1)}} </strong> </td>
                                                            </tr>
                                                            @php
                                                              $catPts = 0;
                                                              $catCount = 0;
                                                            @endphp
                                                          @endif
                                                          @php
                                                            $catPts += $det->mean;
                                                          @endphp
                                                          <tr>
                                                              <td> <strong> {{$count}}. </strong> {{$det->sentence}} </td>
                                                              <td class="text-center"> {{$det->mean}}</td>
                                                          </tr>
                                                          @if($count == $sumSt->count())
                                                            @php
                                                              $catCount += 1;
                                                            @endphp
                                                            {{-- Last Row Will be shown as it is not counted in loop --}}
                                                            <tr>
                                                              <td class="text-end"> <strong> Mean  </strong> </td>
                                                              <td> <strong> {{number_format($catPts / $catCount, 1)}} </strong> </td>
                                                            </tr>
                                                            @php
                                                              $catPts = 0;
                                                              $catCount = 0;
                                                            @endphp
                                                          @endif
                                                          @php
                                                              $totalPts += $det->mean;
                                                              $count += 1;
                                                              $catCount += 1;
                                                              $prevCat = $det->q_category_id;
                                                          @endphp
                                                        @endforeach
                                                        <tr>
                                                          <td class="text-end"> <strong> Grand Mean </strong> </td>
                                                          <td> <strong> {{number_format($totalPts / ($count - 1), 1)}} </strong> </td>  
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="tab-pane fade show" id="pills-faculty" role="tabpanel" aria-labelledby="tab-faculty">
                                <div class="row d-flex justify-content-between p-2 px-4">
                                  @if(isset($sumFac))
                                  <div class="col">
                                      <div class="row">
                                        <div class="col">
                                          <strong> Grand Mean: </strong> {{number_format($sumFac->avg('mean'), 0)}}
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col">
                                          <p class="badge {{status(number_format($sumFac->avg('mean'), 0))->background}} fs-6 text-wrap">
                                            {{status(number_format($sumFac->avg('mean'), 0))->message}}
                                          </p>
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col text-end align-self-center">
                                      <a href="#collapseFacDetails" class="text-decoration-underline" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseExample">
                                          Show Details
                                      </a>
                                  </div>
                                  @else
                                  <div class="col">
                                    <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase"> Evaluation by chairman in selected semester is empty </h3>
                                  </div>
                                  @endif
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="collapse" id="collapseFacDetails">
                                            <div class="card card-body">
                                                @if(isset($sumFac))
                                                <table class="table table-hover text-start">
                                                    <thead>
                                                        <th> <strong> Question </strong> </th>
                                                        <th> <strong> Mean </strong> </th>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                          $count = 1;
                                                          $prevCat = 0;
                                                          $catPts = 0;
                                                          $catCount = 0;
                                                          $totalPts = 0;
                                                        @endphp
                                                        @foreach($sumFac as $det)
                                                          @if($prevCat != $det->q_category_id && $prevCat != 0)
                                                            <tr>
                                                                <td class="text-end"> <strong> Mean  </strong> </td>
                                                                <td> <strong> {{number_format($catPts / $catCount, 1)}} </strong> </td>
                                                            </tr>
                                                            @php
                                                              $catPts = 0;
                                                              $catCount = 0;
                                                            @endphp
                                                          @endif
                                                          @php
                                                            $catPts += $det->mean;
                                                          @endphp
                                                          <tr>
                                                              <td> <strong> {{$count}}. </strong> {{$det->sentence}} </td>
                                                              <td class="text-center"> {{$det->mean}}</td>
                                                          </tr>
                                                          @if($count == $sumFac->count())
                                                            @php
                                                              $catCount += 1;
                                                            @endphp
                                                            {{-- Last Row Will be shown as it is not counted in loop --}}
                                                            <tr>
                                                              <td class="text-end"> <strong> Mean  </strong> </td>
                                                              <td> <strong> {{number_format($catPts / $catCount, 1)}} </strong> </td>
                                                            </tr>
                                                            @php
                                                              $catPts = 0;
                                                              $catCount = 0;
                                                            @endphp
                                                          @endif
                                                          @php
                                                              $totalPts += $det->mean;
                                                              $count += 1;
                                                              $catCount += 1;
                                                              $prevCat = $det->q_category_id;
                                                          @endphp
                                                        @endforeach
                                                        <tr>
                                                          <td class="text-end"> <strong> Grand Mean </strong> </td>
                                                          <td> <strong> {{number_format($totalPts / ($count - 1), 1)}} </strong> </td>  
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                  </div>
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
    <x-faculty-canvas/>
</x-layout>
@php
  function status($mean)
  {
    $background = ['bg-danger', 'bg-warning', 'bg-secondary', 'bg-primary', 'bg-success'];
    $message = ['Poor', 'Bad', 'Average', 'Great', 'Excellent'];

    $detail = new Illuminate\Support\Collection();

    $detail->background = $background[$mean - 1];
    $detail->message = $message[$mean - 1];

    return $detail;
  }
@endphp