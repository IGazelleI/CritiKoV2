<x-layout>
    <x-medium-card>
        <div class="container">
            <div class="row d-flex">
                <div class="col-2">
                    <div class="my-3">
                        <a href="{{route('question.manage', 3)}}" class="btn btn-primary {{$type == 3? 'btn-outline-dark' : ''}} rounded-pill"> Faculty </a>
                    </div>
                </div>
                <div class="col-2">
                    <div class="my-3">
                        <a href="{{route('question.manage', 4)}}" class="btn btn-secondary {{$type == 4? 'btn-outline-dark' : ''}} rounded-pill"> Student </a>
                    </div>
                </div>
                {{-- <div class="col-2">
                    <div class="my-3">
                        <select class="select form-select rounded-pill" name="answerer" onchange="this.form.submit()">
                            <option selected disabled> Version </option>
                            <option> v1.0 </option>
                        </select>
                    </div>
                </div> --}}
            </div>
            <div class="row">
                <div class="col border-bottom border-dark bg-light shadow-3">
                    <h3> {{$type == 3? 'Faculty' : 'Student'}} Questionnaire </h3>
                </div>
            </div>
            @unless ($question->isEmpty())
                @php
                    $count = 0;
                    $qnum = 1;
                    $prevCat = '';
                @endphp
                <div class="row d-flex justify-content-end border border-dark rounded-top mt-3">
                    <div class="col-md-auto p-2 pe-3">
                        1
                    </div>
                    <div class="col-md-auto p-2 ps-1 pe-3">
                        2
                    </div>
                    <div class="col-md-auto p-2 ps-1 pe-3">
                        3
                    </div>
                    <div class="col-md-auto p-2 ps-1 pe-3">
                        4
                    </div>
                    <div class="col-md-auto p-2 ps-1">
                        5
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        @if ($errors->any())
                              <div class="alert alert-danger">
                                  <ul>
                                      @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                      @endforeach
                                  </ul>
                              </div>
                          @endif
                    </div>
                </div>
                @foreach($question as $det)
                    {{-- Static sa pagset nga quanti ni siya --}}
                    <input type="hidden" name="{{'qID' . $qnum}}" value="{{$det->id}}"/>
                    @if($det->q_type_id == 1)
                        @if($prevCat != $det->q_category_id)
                            @php
                                $count = 0;
                            @endphp
                            <div class="row {{randomBg()}}">
                                <div class="col border-bottom border-dark text-white rounded-bottom">
                                    <strong> {{$det->qCat->name}} </strong>
                                </div>
                                <div class="col-1 border-bottom border-dark text-white rounded-bottom">
                                    <button type="button" 
                                        class="btn btn-transparent btn-outline-primary shadow-none text-white btn-sm ms-4" data-bs-target="#addQModal"    data-bs-toggle="modal"
                                        data-bs-answer="{{$type}}"
                                        data-bs-type="{{$det->q_type_id}}"
                                        data-bs-category="{{$det->q_category_id}}"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div class="row ms-1 d-flex align-items-center">
                            <div class="col border-end">
                                <b> {{++$count}}. </b> {{$det->sentence}}
                                <button type="button" class="btn btn-sm shadow-none text-secondary" data-bs-target="#editQModal" data-bs-toggle="modal"
                                    data-bs-id={{$det->id}}
                                    data-bs-answer="{{$type}}"
                                    data-bs-type="{{$det->q_type_id}}"
                                    data-bs-category="{{$det->q_category_id}}"
                                    data-bs-sentence="{{$det->sentence}}"
                                    data-bs-keyword="{{$det->keyword}}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                    </svg>
                                </button>
                                <button type="button" class="btn btn-sm shadow-none text-danger" data-bs-target="#delQModal" data-bs-toggle="modal"
                                    data-bs-id="{{$det->id}}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </button>
                                <input type="hidden" name="{{'qCatID'  . $qnum}}" value="{{$det->q_category_id}}"/>
                            </div>
                            <div class="col-md-auto p-2">
                                <input type="radio" name="{{'qAns' . $qnum}}" value="1" disabled/>
                            </div>
                            <div class="col-md-auto p-2">
                                <input type="radio" name="{{'qAns' . $qnum}}" value="2" disabled/>
                            </div>
                            <div class="col-md-auto p-2">
                                <input type="radio" name="{{'qAns' . $qnum}}" value="3" disabled/>
                            </div>
                            <div class="col-md-auto p-2">
                                <input type="radio" name="{{'qAns' . $qnum}}" value="4" disabled/>
                            </div>
                            <div class="col-md-auto p-2">
                                <input type="radio" name="{{'qAns' . $qnum}}" value="5" disabled/>
                            </div>
                        </div>
                        @php
                            $prevCat = $det->q_category_id;
                            $qnum++;
                        @endphp
                    @else
                        <div class="row">
                            <div class="col d-flex align-items-center ms-5 mt-5 mb-2">
                                {{$det->sentence}}
                                <button type="button" class="btn btn-sm shadow-none text-secondary" data-bs-target="#editQModal" data-bs-toggle="modal"
                                    data-bs-id={{$det->id}}
                                    data-bs-answer="{{$type}}"
                                    data-bs-type="{{$det->q_type_id}}"
                                    data-bs-category="{{$det->q_category_id}}"
                                    data-bs-sentence="{{$det->sentence}}"
                                    data-bs-keyword="{{$det->keyword}}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                    </svg>
                                </button>
                                <button type="button" class="btn btn-sm shadow-none text-danger" data-bs-target="#delQModal" data-bs-toggle="modal"
                                    data-bs-id="{{$det->id}}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex align-items-center ms-2 mb-5">
                                <input type="text" class="form-control rounded w-75" disabled/>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="row">
                    <div class="col">
                        <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase">Question is empty</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center mb-5">
                        <button type="button" 
                            class="btn btn-info" data-bs-target="#addQModal" data-bs-toggle="modal"
                            data-bs-answer="{{$type}}"
                        >
                                Click to Add
                        </button>
                    </div>
                </div>
            @endunless
        </div>
    </x-medium-card>
    <x-sast-canvas/>
</x-layout>
@php
    function randomBg()
    {
        $bg = ['bg-secondary', 'bg-info', 'bg-warning', 'bg-danger', 'bg-success'];

        return $bg[random_int(0, count($bg) - 1)];
    }
@endphp
