<x-layout>
    <x-medium-card>
        <div class="container-fluid">
            <div class="row">
                <div class="col-8 p-3">
                    <form action="{{route('admin.summarySearch')}}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Search Faculty...">
                            <button class="btn btn-outline-secondary" id="button-addon2">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            @if($faculty != null)
            <div class="row">
                <div class="col text-end">
                    <button class="btn btn-transparent shadow-none" onclick="window.print()" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Print Report">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <img src="{{isset($faculty->imgPath)? '../' . $faculty->imgPath() : 'https://www.pngitem.com/pimgs/m/226-2267516_male-shadow-circle-default-profile-image-round-hd.png'}}" 
                        class="img-fluid rounded-circle" alt="Report Icon"
                    />
                </div>
                <div class="col">
                    <div class="row mt-3 mb-2">
                        <div class="col">
                            {{$faculty->fullName(true)}}
                        </div>
                        <div class="col text-end">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle rounded-pill" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (isset($perSelected))
                                        {{$periods->find($perSelected)->getDescription()}} 
                                    @else
                                        Period
                                    @endif
                                </button>
                              
                                <ul class="dropdown-menu">
                                    @unless($periods->isEmpty())
                                        <li>
                                            <a  href="{{route('admin.summaryReport', ['faculty' => $faculty->id, 'period' => $periods->first()->id])}}" class="dropdown-item">
                                                Latest
                                            </a>
                                        </li>
                                        @foreach($periods as $per)
                                        <li>
                                            <a  href="{{route('admin.summaryReport', ['faculty' => $faculty->id, 'period' => $per->id])}}" class="dropdown-item">
                                                {{$per->getDescription()}}
                                            </a>
                                        </li>
                                        @endforeach
                                    @else
                                    <li>
                                        <a class="dropdown-item disabled"> Department is empty </a>
                                    </li>
                                    @endunless
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col fw-bold">
                            {{$faculty->department->description}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link active"
                                id="tab-student"
                                data-mdb-toggle="pill"
                                href="#pills-student"
                                role="tab"
                                aria-controls="pills-student"
                                aria-selected="true"
                            >
                                Student
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link"
                                id="tab-faculty"
                                data-mdb-toggle="pill"
                                href="#pills-faculty"
                                role="tab"
                                aria-controls="pills-faculty"
                                aria-selected="false"
                            >
                                Faculty
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pills-student" role="tabpanel" aria-labelledby="tab-student">
                    @if($summaryS != null)
                    <div class="row print-container">
                        <div class="col">
                            @if($summaryS->where('q_type_id', 1) != null)
                            <div class="row" id="my-section">
                                <div class="col">
                                    <table class="table table-hover text-start">
                                        <thead>
                                            <th> <strong> Question </strong> </th>
                                            <th> <strong> Mean </strong> </th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count = 1;
                                                $prevCat = 0;
                                                $catPts = 0;
                                                $catCount = 0;
                                                $totalPts = 0;
                                            @endphp
                                            @foreach($summaryS->where('q_type_id', 1) as $det)
                                              @if($prevCat != $det->q_category_id && $prevCat != 0)
                                                <tr>
                                                    <td class="text-end"> <strong> Mean  </strong> </td>
                                                    <td> <strong> {{number_format($catPts / $catCount, 1)}} </strong> </td>
                                                </tr>
                                                @php
                                                  $catPts = 0;
                                                  $catCount = 0;
                                                @endphp
                                              @endif
                                              @php
                                                    $catPts += $det->mean;
                                              @endphp
                                              <tr>
                                                  <td> <strong> {{$count}}. </strong> {{$det->sentence}} </td>
                                                  <td class="text-center"> {{number_format($det->mean, 1)}}</td>
                                              </tr>
                                              @if($count == $summaryS->where('q_type_id', 1)->count())
                                                @php
                                                  $catCount += 1;
                                                @endphp
                                                {{-- Last Row Will be shown as it is not counted in loop --}}
                                                <tr>
                                                  <td class="text-end"> <strong> Mean  </strong> </td>
                                                  <td> <strong> {{number_format($catPts / $catCount, 1)}} </strong> </td>
                                                </tr>
                                                @php
                                                  $catPts = 0;
                                                  $catCount = 0;
                                                @endphp
                                              @endif
                                              @php
                                                  $totalPts += $det->mean;
                                                  $count += 1;
                                                  $catCount += 1;
                                                  $prevCat = $det->q_category_id;
                                              @endphp
                                            @endforeach
                                            <tr>
                                              <td class="text-end"> <strong> Grand Mean </strong> </td>
                                              <td> <strong> {{number_format($totalPts / ($count - 1), 1)}} </strong> </td>  
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                            @if($summaryS->where('q_type_id', 2) != null)
                            <div class="row">
                                <div class="col">
                                    <table class="table table-hover text-start">
                                        <thead>
                                            <th colspan="2"> <strong> Qualititative </strong> </th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count = 1;
                                            @endphp
                                            @foreach($summaryS->where('q_type_id', 2) as $det)
                                                <tr>
                                                    <td class="col-3"> <strong> {{$count}}. </strong> {{ucfirst($det->sentence)}} </td>
                                                    <td>
                                                        @php
                                                            $mesCount = 1;
                                                        @endphp
                                                        @foreach($det->message as $message)
                                                            @if($mesCount < count($det->message))
                                                                {{ucfirst($message)}}, 
                                                            @else
                                                                {{ucfirst($message)}}
                                                            @endif
                                                            @php
                                                                $mesCount += 1;
                                                            @endphp
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                @php
                                                    $count += 1;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div> 
                    @else
                    <h3 class="text-center text-uppercase text-secondary m-4 bg-light p-4 rounded"> Summary for student evaluation is empty </h3>
                    @endif
                </div>
                <div class="tab-pane fade" id="pills-faculty" role="tabpanel" aria-labelledby="tab-faculty">
                    @if($summaryF != null)
                    <div class="row print-container">
                        <div class="col">
                            @if($summaryF->where('q_type_id', 1) != null)
                            <div class="row" id="my-section">
                                <div class="col">
                                    <table class="table table-hover text-start">
                                        <thead>
                                            <th> <strong> Quantitative </strong> </th>
                                            <th> <strong> Mean </strong> </th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count = 1;
                                                $prevCat = 0;
                                                $catPts = 0;
                                                $catCount = 0;
                                                $totalPts = 0;
                                            @endphp
                                            @foreach($summaryF->where('q_type_id', 1) as $det)
                                                @if($prevCat != $det->q_category_id && $prevCat != 0)
                                                    <tr>
                                                        <td class="text-end"> <strong> Mean  </strong> </td>
                                                        <td> <strong> {{number_format($catPts / $catCount, 1)}} </strong> </td>
                                                    </tr>
                                                    @php
                                                        $catPts = 0;
                                                        $catCount = 0;
                                                    @endphp
                                                @endif
                                                @php
                                                    $catPts += $det->mean;
                                                @endphp
                                                <tr>
                                                    <td> <strong> {{$count}}. </strong> {{ucfirst($det->sentence)}} </td>
                                                    <td class="text-center"> {{number_format($det->mean, 1)}} </td>
                                                </tr>
                                                @if($count == $summaryF->where('q_type_id', 1)->count())
                                                    @php
                                                        $catCount += 1;
                                                    @endphp
                                                    {{-- Last Row Will be shown as it is not counted in loop --}}
                                                    <tr>
                                                    <td class="text-end"> <strong> Mean  </strong> </td>
                                                    <td> <strong> {{number_format($catPts / $catCount, 1)}} </strong> </td>
                                                    </tr>
                                                    @php
                                                        $catPts = 0;
                                                        $catCount = 0;
                                                    @endphp
                                                @endif
                                                @php
                                                    $totalPts += $det->mean;
                                                    $count += 1;
                                                    $catCount += 1;
                                                    $prevCat = $det->q_category_id;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td class="text-end"> <strong> Grand Mean </strong> </td>
                                                <td> <strong> {{number_format($totalPts / ($count - 1), 1)}} </strong> </td>  
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                            @if($summaryF->where('q_type_id', 2) != null)
                            <div class="row">
                                <div class="col">
                                    <table class="table table-hover text-start">
                                        <thead>
                                            <th colspan="2"> <strong> Qualititative </strong> </th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count = 1;
                                            @endphp
                                            @foreach($summaryF->where('q_type_id', 2) as $det)
                                                <tr>
                                                    <td class="col-3"> <strong> {{$count}}. </strong> {{ucfirst($det->sentence)}} </td>
                                                    <td>
                                                        @php
                                                            $mesCount = 1;
                                                        @endphp
                                                        @foreach($det->message as $message)
                                                            @if($mesCount < count($det->message))
                                                                {{ucfirst($message)}}, 
                                                            @else
                                                                {{ucfirst($message)}}
                                                            @endif
                                                            @php
                                                                $mesCount += 1;
                                                            @endphp
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                @php
                                                    $count += 1;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div> 
                    @else
                    <h3 class="text-center text-uppercase text-secondary m-4 bg-light p-4 rounded"> Summary for faculty evaluation is empty </h3>
                    @endif
                </div>
            </div>
            @else
            <h3 class="text-center text-uppercase text-secondary m-4 bg-light p-4 rounded"> Faculty not found </h3>
            @endif
        </div>
    </x-medium-card>
    <x-admin-canvas/>
</x-layout>