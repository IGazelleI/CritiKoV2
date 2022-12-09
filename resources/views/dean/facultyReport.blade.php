<x-layout>
    <x-medium-card>
        <div class="container">
            BUANG PA DI MUGAWAS ANG UNA OR AWAHI NAA SAYOP SA ALGO GAMIT PUTA
            @unless($faculty->isEmpty())
            @foreach($faculty as $det)
            <div class="row p-3 border-bottom">
                <div class="col-2">
                    <img src="{{isset($det->imgPath)? '../' . $det->imgPath() : 'https://www.pngitem.com/pimgs/m/226-2267516_male-shadow-circle-default-profile-image-round-hd.png'}}" 
                        class="img-fluid rounded-circle" alt=""
                    />
                </div>
                <div class="col">
                    <div class="row mt-3 mb-2">
                        <div class="col">
                            {{$det->fullName(true)}} &nbsp; {{-- {{$average[$det->id]}} --}}
                            @if(getImprovement($average[$det->id], $prevAvg[$det->id]) > 0)
                            <span class="badge bg-success text-wrap rounded-pill">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill pb-1" viewBox="0 0 16 16">
                                    <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                </svg> 
                                {{number_format(getImprovement($average[$det->id], $prevAvg[$det->id]), 1)}}%
                            </span>
                            @else
                            <span class="badge bg-danger text-wrap rounded-pill">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill pt-1" viewBox="0 0 16 16">
                                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                </svg>
                                {{number_format(getImprovement($average[$det->id], $prevAvg[$det->id]), 1)}}%
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-primary w-25" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$det->id}}" aria-expanded="true" aria-controls="collapseOne">
                                Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div id="collapse{{$det->id}}" class="accordion-collapse collapse border rounded" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col">
                                    {!! $chart[$det->id]->container() !!}
                                    {!! $chart[$det->id]->script() !!}
                                </div>{{-- 
                                <div class="col border border-dark rounded">
                                    <strong> Grand Mean: </strong> {{number_format($average[$det->id], 1)}}
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase"> Faculty under your department is empty </h3>
            @endunless
        </div>
    </x-medium-card>
    <x-faculty-canvas/>
</x-layout>
@php
    function getImprovement($current, $previous)
    {
        return (($current - $previous) / $previous) * 100;
    }
@endphp