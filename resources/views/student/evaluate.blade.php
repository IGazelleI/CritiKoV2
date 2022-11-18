<x-layout>
    <x-profile-card class="p-5">
        <form action="{{route('student.evaluate')}}" method="POST">
            @csrf
            <header>
                <div class="d-flex justify-content-center align-items-center h-100">
                    <h1 class="mb-3">
                        Evaluate Instructor
                    </h1>
                </div>
                <input type="hidden" name="totalQuestion" value="{{$question->count()}}"/>
                <div class="row">
                    <div class="col d-flex justify-content-center align-self-center">     
                        <input type="hidden" id="imgPath"/>
                        
                        <select name="user_id" id="user_id" class="form-select form-select-lg rounded-pill" aria-label="Default select example" onchange="changeImage()">
                            <option selected disabled> -Select Instructor- </option>
                            @unless ($instructor->isEmpty())
                                @foreach ($instructor as $prof)
                                    @php
                                        /* $done = checkStatus($status, $prof->id); */
                                    @endphp
                                    <option value="{{$prof->id}}" 
                                        {{old('user_id') == $prof->id? 'selected' : ''}}
                                        {{-- {{$done? 'disabled' : ''}} --}} >
                                        {{-- {{$done ? '(Finished) ' : ''}} --}}
                                        {{-- {{$prof->subject}} - --}} {{$prof->fullName(true)}} 
                                    </option>
                                @endforeach
                            @else
                                <option selected disabled> Current block has no instructor. </option>
                            @endunless
                        </select>
        
                        @error('user_id')
                            <p class="text-red-500 text-xs mt-1">
                                {{$message}}
                            </p>
                        @enderror
                    </div>
                </div>
                <div class="row rounded border border-dark my-3">
                    <div class="col-3 d-flex justify-content-center align-items-center">
                        <img src="https://www.pngitem.com/pimgs/m/226-2267516_male-shadow-circle-default-profile-image-round-hd.png" id="evaluateeImg" class="img-circle w-75 h-75" alt="e">
                    </div>
                    <div class="col bg-info rounded border border-alert ps-5 text-white px-2">
                        1 = <span class="text-decoration-underline m-1"> Poor </span> <br/>
                        2 = <span class="text-decoration-underline m-1"> Bad </span> <br/> 
                        3 = <span class="text-decoration-underline m-1"> Average </span> <br/>
                        4 = <span class="text-decoration-underline m-1"> Bad </span> <br/>
                        5 = <span class="text-decoration-underline m-1"> Excellent </span> <br/>
                    </div>
                </div>
            </header>
            <div>
                @unless ($question->isEmpty())
                    @php
                        $count = 0;
                        $qnum = 1;
                        $prevCat = '';
                    @endphp
                    <div class="row d-flex justify-content-end border border-dark rounded-top">
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
                    @foreach($question as $q)
                        {{-- Static sa pagset nga quanti ni siya --}}
                        <input type="hidden" name="{{'qID' . $qnum}}" value="{{$q->id}}"/>
                        @if($q->q_type_id == 1)
                            @if($prevCat != $q->q_category_id)
                                @php
                                    $count = 0;
                                @endphp
                                <div class="row">
                                    <div class="col {{randomBg()}} border-bottom border-dark text-white rounded-bottom">
                                        <strong> {{$q->qCat->name}} </strong>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="row ms-1 d-flex align-items-center">
                                <div class="col border-end">
                                    <b> {{++$count}}. </b> {{$q->sentence}}
                                    <input type="hidden" name="{{'qCatID'  . $qnum}}" value="{{$q->q_category_id}}"/>
                                </div>
                                <div class="col-md-auto p-2">
                                    <input type="radio" name="{{'qAns' . $qnum}}" value="1" required/>
                                </div>
                                <div class="col-md-auto p-2">
                                    <input type="radio" name="{{'qAns' . $qnum}}" value="2" required/>
                                </div>
                                <div class="col-md-auto p-2">
                                    <input type="radio" name="{{'qAns' . $qnum}}" value="3" required/>
                                </div>
                                <div class="col-md-auto p-2">
                                    <input type="radio" name="{{'qAns' . $qnum}}" value="4" required/>
                                </div>
                                <div class="col-md-auto p-2">
                                    <input type="radio" name="{{'qAns' . $qnum}}" value="5" required/>
                                </div>
                            </div>
                            @php
                                $prevCat = $q->q_category_id;
                                $qnum++;
                            @endphp
                        @else
                            <div class="row">
                                <div class="col d-flex align-items-center ms-2 mt-5">
                                    {{$q->sentence}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-flex align-items-center">
                                    <input type="text" class="form-control w-100" name="{{'qAns' . $qnum}}"/>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="row d-flex justify-content-end me-5">
                        <div class="col-1 mt-5">
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary rounded-pill">Submit</button>
                        </div>
                    </div>
                @else
                    Question is empty.
                @endunless
            </div>
        </form>
    </x-profile-card>
    <x-student-canvas/>
</x-layout>
<script>
    function changeImage()
    {
        var newImg = document.getElementById('imgPath');
        document.getElementById("evaluateeImg").src = document.getElementById("evaluateeImg").src = 'https://risibank.fr/cache/medias/0/2/240/24099/full.png';
    }
</script>
@php
    function checkStatus($status, $facultyID)
    {
        if(!$status->isEmpty())
        {
            foreach($status as $detail)
            {
                if($facultyID == $detail->evaluatee)
                    return true;
            }
        }

        return false;
    }

    function randomBg()
    {
        $bg = ['bg-primary', 'bg-secondary', 'bg-info', 'bg-warning', 'bg-danger', 'bg-success'];

        return $bg[random_int(0, count($bg) - 1)];
    }
@endphp