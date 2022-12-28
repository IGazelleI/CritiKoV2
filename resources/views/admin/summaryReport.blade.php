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
                    <div class="row">
                        <div class="col">
                            <a href="{{route('pdf.view', [$perSelected == null? $periods->first()->id : $perSelected, 4, $faculty->id])}}" class="btn btn-transparent btn-outline-secondary" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill me-2" viewBox="0 0 16 16">
                                    <path d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z"/>
                                    <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.651 11.651 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.697 19.697 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z"/>
                                </svg>
                                Export
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            @if($summaryS->where('q_type_id', 1) != null)
                            <div class="row" id="my-section">
                                <div class="col">
                                    <table class="table table-hover text-start p-0">
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
                                                    <td> <strong> {{number_format($catPts / $catCount, 2)}} </strong> </td>
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
                                                  <td class="text-center"> {{number_format($det->mean, 2)}}</td>
                                              </tr>
                                              @if($count == $summaryS->where('q_type_id', 1)->count())
                                                @php
                                                  $catCount += 1;
                                                @endphp
                                                {{-- Last Row Will be shown as it is not counted in loop --}}
                                                <tr>
                                                  <td class="text-end"> <strong> Mean  </strong> </td>
                                                  <td> <strong> {{number_format($catPts / $catCount, 2)}} </strong> </td>
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
                                              <td> <strong> {{number_format($totalPts / ($count - 1), 2)}} </strong> </td>  
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
                    <div class="row">
                        <div class="col">
                            <a href="{{route('pdf.view', [$perSelected == null? $periods->first()->id : $perSelected, 3, $faculty->id])}}" class="btn btn-transparent btn-outline-secondary" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill me-2" viewBox="0 0 16 16">
                                    <path d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z"/>
                                    <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.651 11.651 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.697 19.697 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z"/>
                                </svg>
                                Export
                            </a>
                        </div>
                    </div>
                    <div class="row">
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
                                                        <td> <strong> {{number_format($catPts / $catCount, 2)}} </strong> </td>
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
                                                    <td class="text-center"> {{number_format($det->mean, 2)}} </td>
                                                </tr>
                                                @if($count == $summaryF->where('q_type_id', 1)->count())
                                                    @php
                                                        $catCount += 1;
                                                    @endphp
                                                    {{-- Last Row Will be shown as it is not counted in loop --}}
                                                    <tr>
                                                    <td class="text-end"> <strong> Mean  </strong> </td>
                                                    <td> <strong> {{number_format($catPts / $catCount, 2)}} </strong> </td>
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
                                                <td> <strong> {{number_format($totalPts / ($count - 1), 2)}} </strong> </td>  
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