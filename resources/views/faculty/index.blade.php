<x-layout>
    <div class="container mt-3">
        <div class="row">
            <div class="col">
                <div class="card mask-custom">
                    <div class="card-body p-0 text-dark">
                        <div class="row px-2">
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
            @if(auth()->user()->faculties->first()->isDean || auth()->user()->faculties->first()->isChairman)
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
          
                                      <span class="ms-2"> {{$det->fullName(1)}} </span> <br/> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                      <span class="text-secondary">
                                        @if($det->isDean)
                                        College Dean
                                        @elseif($det->isAssDean)
                                        Associate Dean
                                        @elseif($det->isChairman)
                                        Chairman
                                        @endif
                                      </span>
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
                                          <p class="badge {{status(number_format($sumSt->avg('mean'), 0))->background}} fs-6 text-wrap">
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
                                                @php
                                                    $block = App\Models\Block::where('period_id', $period->id)
                                                                        -> latest('id')
                                                                        -> get();
                                                @endphp
                                                <div class="btn-group dropend">
                                                    <button class="btn btn-transparent btn-outline-secondary" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill me-2" viewBox="0 0 16 16">
                                                            <path d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z"/>
                                                            <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.651 11.651 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.697 19.697 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z"/>
                                                        </svg>
                                                        Export
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @foreach($block as $b)
                                                            @foreach($b->klases->where('instructor', auth()->user()->id) as $klase)
                                                            <li>
                                                                <a href="{{route('pdf.view', [$period->id, 4, auth()->user()->faculties->first()->id, $klase->subject_id])}}" 
                                                                    class="dropdown-item {{auth()->user()->faculties->first()->evaluated->where('period_id', $period->id)->where('evaluatee', auth()->user()->id)->where('subject_id', $klase->subject->id)->isEmpty()? 'disabled' : ''}}" target="_blank"
                                                                >
                                                                    {{$klase->subject->descriptive_title}}
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                        @endforeach
                                                    </ul>
                                                </div>
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
                                                        @foreach($sumSt->where('q_type_id', 1) as $det)
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
                                                              <td> <strong> {{$count}}. </strong> {{ucfirst($det->sentence)}} </td>
                                                              <td class="text-center"> {{number_format($det->mean, 1)}}</td>
                                                          </tr>
                                                          @if($count == $sumSt->where('q_type_id', 1)->count())
                                                            @php
                                                              $catCount += 1;
                                                            @endphp
                                                            {{-- Last Row Will be shown as it is not counted in loop --}}
                                                            <tr>
                                                              <td class="text-end"> <strong>  Mean  </strong> </td>
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
                                                <div class="row">
                                                  <div class="col">
                                                      <table class="table table-hover text-start">
                                                          <thead>
                                                              <th colspan="2"> <strong> Qualititative </strong> </th>
                                                          </thead>
                                                          <tbody>
                                                              @php
                                                                  $count = 1;
                                                              @endphp
                                                              @foreach($sumSt->where('q_type_id', 2) as $det)
                                                                  <tr>
                                                                      <td class="col-3"> <strong> {{$count}}. </strong> {{ucfirst($det->sentence)}} </td>
                                                                      <td>
                                                                          @php
                                                                              $mesCount = 1;
                                                                          @endphp
                                                                          @foreach($det->message as $message)
                                                                              @if($mesCount < count($det->message))
                                                                                  {{ucfirst($message)}}, 
                                                                              @else
                                                                                  {{ucfirst($message)}}
                                                                              @endif
                                                                              @php
                                                                                  $mesCount += 1;
                                                                              @endphp
                                                                          @endforeach
                                                                      </td>
                                                                  </tr>
                                                                  @php
                                                                      $count += 1;
                                                                  @endphp
                                                              @endforeach
                                                          </tbody>
                                                      </table>
                                                  </div>
                                              </div>
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
                                                <a href="{{route('pdf.view', [$period->id, 3, auth()->user()->faculties->first()->id])}}" class="btn btn-transparent btn-outline-secondary link-dark" target="_blank">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill me-2" viewBox="0 0 16 16">
                                                      <path d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z"/>
                                                      <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.651 11.651 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.697 19.697 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z"/>
                                                  </svg>
                                                  Export
                                              </a>
                                                <table class="table table-hover text-start">
                                                    <thead>
                                                        <th> <strong> Quantitative </strong> </th>
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
                                                        @foreach($sumFac->where('q_type_id', 1) as $det)
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
                                                              <td> <strong> {{$count}}. </strong> {{ucfirst($det->sentence)}} </td>
                                                              <td class="text-center"> {{number_format($det->mean, 1)}}</td>
                                                          </tr>
                                                          @if($count == $sumFac->where('q_type_id', 1)->count())
                                                            @php
                                                              $catCount += 1;
                                                            @endphp
                                                            {{-- Last Row Will be shown as it is not counted in loop --}}
                                                            <tr>
                                                              <td class="text-end"> <strong>  Mean  </strong> </td>
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
                                                <div class="row">
                                                  <div class="col">
                                                      <table class="table table-hover text-start">
                                                          <thead>
                                                              <th colspan="2"> <strong> Qualititative </strong> </th>
                                                          </thead>
                                                          <tbody>
                                                              @php
                                                                  $count = 1;
                                                              @endphp
                                                              @foreach($sumFac->where('q_type_id', 2) as $det)
                                                                  <tr>
                                                                      <td class="col-3"> <strong> {{$count}}. </strong> {{ucfirst($det->sentence)}} </td>
                                                                      <td>
                                                                          @php
                                                                              $mesCount = 1;
                                                                          @endphp
                                                                          @foreach($det->message as $message)
                                                                              @if($mesCount < count($det->message))
                                                                                  {{ucfirst($message)}}, 
                                                                              @else
                                                                                  {{ucfirst($message)}}
                                                                              @endif
                                                                              @php
                                                                                  $mesCount += 1;
                                                                              @endphp
                                                                          @endforeach
                                                                      </td>
                                                                  </tr>
                                                                  @php
                                                                      $count += 1;
                                                                  @endphp
                                                              @endforeach
                                                          </tbody>
                                                      </table>
                                                  </div>
                                              </div>
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
    $message = ['Unsatisfactory', 'Fair', 'Satisfactory', 'Very Satisfactory', 'Outstanding'];

    $detail = new Illuminate\Support\Collection();

    $detail->background = $background[$mean - 1];
    $detail->message = $message[$mean - 1];

    return $detail;
  }
@endphp