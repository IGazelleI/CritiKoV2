<x-layout>
    <x-medium-card>
        <div class="container-fluid">
            <div class="row mx-n4 bg-success text-light">
                <div class="col-2 p-2">
                    <img src="https://cdn-icons-png.flaticon.com/512/1632/1632670.png" class="img-fluid" alt="Task Complete Logo"/>
                </div>
                <div class="col p-2 align-self-center">
                    <header>
                        <h3 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif"> Completion Report </h3>
                        <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="e.g. CCICT: (420, 69, 489)" > Format: Department (Finished, Pending, Total) </span>
                    </header>
                </div>
                <div class="col text-end d-flex align-self-center ">
                    <a href="{{route('admin.completionFaculty')}}" class="btn btn-primary rounded-pill"> Faculty Completion Report </a>
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
            <div class="row mt-3">
                <div class="col text-secondary">
                    For more detailed list, click a certain department below:
                </div>
            </div>
            <div class="row mb-3">
                @if(isset($department))
                <div class="col"></div>
                    <ol class="list-group list-group-numbered list-group-horizontal">
                        @foreach($department as $det)
                        <li class="list-group-item">
                            <a href="{{route('admin.completionDetail', $det->id)}}" class="link-dark"
                                onMouseOver="this.style.textDecoration='underline'"
                                onMouseOut="this.style.textDecoration='none'"
                            >
                                {{$det->name}} <span class="badge bg-primary rounded-pill"> {{$det->faculties->count()}} </span>
                            </a>
                        </li>
                        @endforeach
                    </ol>
                </div>
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