<x-layout>
    <x-medium-card>
        <div class="container">
            <div class="row">
                <div class="col p-3 bg-info">
                    <div class="row bg-info">
                        <div class="col-1">
                            <img src="https://cdn0.iconfinder.com/data/icons/business-and-teamwork-1/64/04-Evaluation-512.png" class="img-fluid"/>
                        </div>
                        <div class="col">
                            <h2 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                                Evaluation Report
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-7 p-3">
                    {!! $chart->container() !!}
                </div>
                <div class="col {{-- d-flex align-items-center --}}align-self-center p-3">
                    <ul class="list-group fw-bold border border-dark">
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0">
                            Total Enrollee
                            <span class="badge bg-info rounded-pill">{{number_format($totalEnrollee)}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0">
                            Finished
                            <span class="badge bg-success rounded-pill">{{number_format($finished)}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0">
                            Pending
                            <span class="badge bg-warning rounded-pill">{{number_format($pending)}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0">
                            Expected Total Evaluation
                            <span class="badge bg-primary rounded-pill">{{number_format($expected)}}</span>
                        </li>
                      </ul>
                </div>
            </div>
        </div>
    </x-medium-card>
    <x-sast-canvas/>
</x-layout>
{!! $chart->script() !!}