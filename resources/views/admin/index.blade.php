<x-layout>
    <x-medium-card>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col text-center">
                            {{-- <h4> Improvement Rate </h4> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {!! $overAllChart->container() !!}
                            {!! $overAllChart->script() !!}
                        </div>
                    </div>
                </div>
                <div class="col-4 pt-5">
                    @if(isset($evalProgress))
                    <div class="row">
                        <div class="col">
                            {!! $evalProgress->container() !!}
                            {!! $evalProgress->script() !!}
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col bg-light text-center p-3 rounded">
                            <h3 class="text-uppercase"> Evaluation date not set </h3>
                            <p class="text-secondary" style="font-size: 16px"> {{$p->getDescription()}} </p>
                            <button class="btn btn-primary rounded-pill" data-bs-target="#editPerModal" data-bs-toggle="modal"
                                data-bs-id="{{$p->id}}"
                                data-bs-semester="{{$p->semester}}"
                                data-bs-batch="{{$p->batch}}"
                                data-bs-beginEval="{{$p->beginEval}}"
                                data-bs-endEval="{{$p->endEval}}"
                            >
                                Set
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="row fw-bold p-3 mt-2 rounded">
                <div class="col border-bottom">
                    <h3 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif"> 
                        Faculty Report 
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="2"> <strong> Department </strong> </th>
                                <th> <strong> Name </strong> </th>
                                <th> <strong> Performance Rate </strong> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($department as $det)
                                <tr>
                                    <td rowspan="3"> {{$det->name}} </td>
                                </tr>   
                                @unless($det->faculties->isEmpty())
                                <tr>
                                    <td> Most Improved </td>
                                    <td>
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                            alt="avatar 1" style="width: 45px; height: auto"/>
                                        Pet 
                                    </td>
                                    <td> 50% </td>
                                </tr>
                                <tr>
                                    <td> Least Improved </td>
                                    <td>
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                            alt="avatar 1" style="width: 45px; height: auto"/>
                                        Pet
                                    </td>
                                    <td> 50% </td>
                                </tr>
                                @else
                                <tr>
                                    <td colspan="3" class="text-center"> Faculty is empty. </td>
                                </tr>
                                @endunless
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-medium-card>
    <x-admin-canvas/>
</x-layout>