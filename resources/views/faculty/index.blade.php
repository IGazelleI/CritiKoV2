<x-layout>
    <div class="container mt-3">
        <div class="row">
            <div class="col">
                <div class="card mask-custom">
                    <div class="card-body p-0 text-dark">
                        <div class="row px-2">
                            <div class="col h-25 pb-0">
                                {!! $chart->container() !!}
                            </div>
                        </div>
                        <div class="row mx-0">
                            <div class="col text-center">
                                <h5 class="bg-warning p-2 rounded text-uppercase">
                                    Recommendation
                                </h5>
                                <hr/>
                                @unless($recommendation->isEmpty())
                                <table class="table table-hover text-danger">
                                  <thead>
                                    @foreach($recommendation as $det)
                                    <tr>
                                      <th scope="col">{{$det->keyword}}</th>
                                    </tr>
                                    @endforeach
                                  </thead>
                                </table>
                                @else
                                Wa recommendation undang
                                @endunless
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
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
                                              <span class="badge bg-success rounded-circle py-2">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                      <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                                  </svg>
                                              </span>
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
            <div class="col">
                <div class="card mask-custom">
                    <div class="card-body p-0 text-dark">
                        <div class="ps-3">
                            <h5 class="my-4" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                                Summary
                            </h5>
                            <hr/>
                        </div>
                        {{-- @unless(!isset($faculty)) --}}
                        
                        {{-- @else --}}
                        <div class="text-center text-uppercase pt-3 pb-2">
                            <p class="my-4 text-secondary" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                                Standby for evaluation summary
                            </p>
                        </div>
                        {{-- @endunless --}}
                      </div>
                </div>
            </div>
        </div>
    </div>
    <x-faculty-canvas/>
</x-layout>
{!! $chart->script() !!}
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script> 
