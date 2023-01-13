<x-layout>
    <x-medium-card>
        <div class="container-fluid">
            <div class="row {{randomBg()}} mx-n4 text-light">
                <div class="col p-3">
                    <header>
                        <h3 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif"> Student Evaluation Progress Report </h3>
                    </header>
                </div>
            </div>
            <div class="row row-cols-1 mt-2">
                @foreach($department as $dept)
                    @if(!$dept->faculties->isEmpty())
                    <div class="col mb-3">
                        <div class="card">
                            <div class="card-header {{randomBg()}}">
                                <div class="row d-flex">
                                    <div class="col">
                                        <a href="#" class="link-light"
                                            onMouseOver="this.style.textDecoration='underline'"
                                            onMouseOut="this.style.textDecoration='none'"
                                        >
                                            {{$dept->name}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-secondary">
                                    Faculties &nbsp; &nbsp; <span class="badge text-wrap bg-danger rounded-pill"> {{$dept->faculties->count()}} </span>
                                </h5>
                                <ul class="list-group list-group-flushed">
                                    @php
                                        $dean = $dept->faculties->where('isDean', true)->first();
                                    @endphp
                                    @if(isset($dean))
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-1">
                                                <img src="{{isset($dean->imgPath)? '../../' . $dean->imgPath() : 'https://www.pngitem.com/pimgs/m/226-2267516_male-shadow-circle-default-profile-image-round-hd.png'}}" 
                                                    class="img-fluid rounded-circle" alt="Faculty Photo"
                                                />
                                            </div>
                                            <div class="col">
                                                <strong> College Dean </strong> - {{$dean->fullName(true)}}
                                            </div>
                                            <div class="col text-end">
                                                @php
                                                    $facFinished = true;

                                                    $faculties = App\Models\Faculty::where('department_id', $dean->department_id)
                                                                        -> where('user_id', '!=', $dean->user_id)
                                                                        -> get();
                                                    foreach($faculties as $facEval)
                                                    {
                                                        if($evaluation->where('evaluator', $dean->user_id)->where('evaluatee', $facEval->user_id)->isEmpty())
                                                        {
                                                            $facFinished = false;
                                                            break;
                                                        }                                                                    
                                                    }
                                                @endphp
                                                @if($facFinished)
                                                <span class="badge bg-success rounded-circle px-2 py-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Finished">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                                    </svg>
                                                </span>
                                                @else
                                                <span class="badge bg-warning rounded-circle px-2 py-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Pending" >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                                    </svg>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    @php
                                        $chairman = $dept->faculties->where('isChairman', true)->first();
                                    @endphp
                                    @if(isset($chairman))
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-1">
                                                <img src="{{isset($chairman->imgPath)? '../../' . $chairman->imgPath() : 'https://www.pngitem.com/pimgs/m/226-2267516_male-shadow-circle-default-profile-image-round-hd.png'}}" 
                                                    class="img-fluid rounded-circle" alt="Faculty Photo"
                                                />
                                            </div>
                                            <div class="col">
                                                <strong> Chairman </strong> - {{$chairman->fullName(true)}}
                                            </div>
                                            <div class="col text-end">
                                                @php
                                                    $facFinished = true;

                                                    $faculties = App\Models\Faculty::where('department_id', $chairman->department_id)
                                                                        -> where('user_id', '!=', $chairman->user_id)
                                                                        -> where('isDean', false)
                                                                        -> where('isAssDean', false)
                                                                        -> get();
                                                                
                                                    foreach($faculties as $facEval)
                                                    {
                                                        if($evaluation->where('evaluator', $chairman->user_id)->where('evaluatee', $facEval->user_id)->isEmpty())
                                                        {
                                                            $facFinished = false;
                                                            break;
                                                        }    
                                                    }
                                                @endphp
                                                @if($facFinished)
                                                <span class="badge bg-success rounded-circle px-2 py-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Finished">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                                    </svg>
                                                </span>
                                                @else
                                                <span class="badge bg-warning rounded-circle px-2 py-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Pending" >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                                    </svg>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </x-medium-card>
    <x-sast-canvas/>
</x-layout>
@php
    function randomBg()
    {
        $bg = ['bg-primary', 'bg-secondary', 'bg-info', 'bg-warning', 'bg-success', 'bg-dark'];

        return $bg[random_int(0, count($bg) - 1)];
    }
    function str_ordinal($value)
    {
        $superscript = false;
        $number = abs($value);
 
        $indicators = ['th','st','nd','rd','th','th','th','th','th','th'];
 
        $suffix = $superscript ? '<sup>' . $indicators[$number % 10] . '</sup>' : $indicators[$number % 10];
        if ($number % 100 >= 11 && $number % 100 <= 13) {
            $suffix = $superscript ? '<sup>th</sup>' : 'th';
        }
 
        return number_format($number) . $suffix;
    }
@endphp