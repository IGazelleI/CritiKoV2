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
                        <div class="col">
                            Evaluation Date Not Set
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="row fw-bold p-3 rounded">
                <div class="col border-bottom">
                    Faculty Report
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="2"> Department </th>
                                <th> Name </th>
                                <th> Performance Rate </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td rowspan="3"> CCICT </td></tr>   
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
                                <td> Pet </td>
                                <td> 50% </td>
                            </tr>
                            <tr>
                                <td rowspan="3"> CCICT </td></tr>
                            <tr>
                                <td> Most Improved </td>
                                <td> Pet </td>
                                <td> 50% </td>
                            </tr>
                            <tr>
                                <td> Least Improved </td>
                                <td> Pet </td>
                                <td> 50% </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-medium-card>
    <x-admin-canvas/>
</x-layout>