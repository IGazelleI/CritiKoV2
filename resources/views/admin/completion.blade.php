<x-layout>
    <x-medium-card>
        <div class="container-fluid">
            <div class="row">
                <div class="col p-2 bg-secondary rounded">
                    <header>
                        <h3 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif"> Completion Report </h3>
                    </header>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <strong> Legend </strong> <br/>
                    <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="e.g. CCICT: (420, 69, 489)" > Format: Department (Finished, Pending, Total) </span>
                </div>
            </div>
            <div class="row">
                @if(isset($chart))
                <div class="col">
                    {!! $chart->container() !!}
                    {!! $chart->script() !!}
                </div>
                @else
                <div class="col">
                    <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase">Data not found</h3>
                </div>
                @endif
            </div>
            <div class="row row-cols-3">
                @if(isset($department))
                    @foreach($department as $det)
                    <div class="col mb-3">
                        <div class="card">
                            <div class="card-header {{randomBg()}}">
                                <div class="row d-flex">
                                    <div class="col">
                                        <a href="#" class="link-light"
                                            onMouseOver="this.style.textDecoration='underline'"
                                            onMouseOut="this.style.textDecoration='none'"
                                        >
                                            {{$det->name}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <div class="row">
                                        <div class="col text-secondary">
                                            Faculty
                                        </div>
                                        <div class="col text-end">
                                            <span class="fw-bold badge bg-primary text-wrap"> 
                                                {{$det->faculties->count()}}
                                            </span>
                                        </div>
                                    </div>
                                </h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                
                @endif
            </div>
        </div>
    </x-medium-card>
    <x-admin-canvas/>
</x-layout>
@php
    function randomBg()
    {
        $bg = ['bg-primary', 'bg-secondary', 'bg-info', 'bg-warning', 'bg-success', 'bg-dark'];

        return $bg[random_int(0, count($bg) - 1)];
    }
@endphp