<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> PDF Preview-{{$type == 3? 'Faculty' : 'Student'}} SAST Report </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <style>
            body
            {
                font-size: 10;
            }
            table, th, td
            {
                border-width: 2px;
                padding: 1px
            }
            .center
            {
                margin-left: auto;
                margin-right: auto;
            }
            .no-border
            {
                border-width: 0px;
                padding: 5px 10px;
            }
            div.page-break
            {
                page-break-before: always;
            }
        </style>
    </head>
    <body>
        <header style="margin-top:-30px; text-align:center">
            {{-- <img src="{{asset('images/logo.png')}}" alt="CTU Logo"/> --}}
            Republic of the Philippines <br/>
            <span style="font-weight: bold"> CEBU TECHNOLOGICAL UNIVERSITY </span> <br/>
            MAIN CAMPUS <br/>
            M.J. Cuenco Avenue Cor. R. Palma Street, Cebu City, Philippines <br/>
            Website: http://www.ctu.edu.ph E-mail: <span class="text-lowercase">{{$faculty->department->name}}</span>dean@ctu.edu.ph <br/>
            Phone: +6332-402-4060 loc. 1104 <br/> <br/>
            <span class="fw-bold text-uppercase"> Faculty Evaluation Report </span> <br/>
            <span style="text-decoration: italic"> 
                (For
                @if($subject->isLec == 1 || $subject->isLec == 3)
                Lecture
                @elseif($subject->isLec == 2)
                Laboratory
                @endif
                Classes) 
            </span> <br/>
            {{$period->getDescription()}}
        </header> <br/>
        <div style="margin-left: 69px">
            <strong> Instructor/Professor: </strong> {{$faculty->fullName(true)}} &nbsp;
            <strong> Subject: </strong> {{$subject->descriptive_title}} <br/>
            <span style="text-align: end"> <strong> Date: </strong> {{date('M. d, Y @ g:i A',  strtotime(NOW()))}} </span> <br/>
        </div> <br/>
        <div>
            <table class="center no-border">
                <thead>
                    <tr class="no-border" style="text-align: center">
                        <th class="no-border" colspan="2"> Rating Scale </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="no-border">
                        <td class="no-border"> 5 - Outstanding </td>
                        <td class="no-border"> 2 - Fair </td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border"> 4 - Very Good </td>
                        <td class="no-border"> 1 - Poor </td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border" colspan="2"> 3 - Good </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <table class="center">
            <tbody>
                @php
                    $count = 1;
                    $prevCat = 0;
                    $catPts = 0;
                    $catCount = 0;
                    $totalPts = 0;
                    $cat = 0;
                    $loop = ($subject->isLec == 1 || $subject->isLec == 3)? $data->where('isLec', true) : $data;
                    $all = $loop->where('q_type_id', 1)->count();
                @endphp
                @foreach($loop->where('q_type_id', 1) as $det)
                    @if($prevCat != $det->q_category_id && $prevCat != 0)
                    <tr>
                        <td class="text-end"> <strong> Mean  </strong> </td>
                        <td class="text-center"> <strong> {{number_format($catPts / $catCount, 2)}} </strong> </td>
                    </tr>
                    @php
                        $catPts = 0;
                        $catCount = 0;
                    @endphp
                    @endif
                    @if($prevCat != $det->q_category_id)
                        @php
                            $cat += 1;
                        @endphp
                       <tr>
                            <th colspan="2"> Area of Concern {{numberToRoman($cat)}}: {{$det->qCat->name}} </th>
                       </tr>
                    @endif
                    @php
                        $catPts += $det->mean;
                    @endphp
                    <tr>
                        <td> <strong> {{$catCount + 1}}. </strong> {{ucfirst($det->sentence)}} </td>
                        <td class="text-center"> {{number_format($det->mean, 2)}}</td>
                    </tr>
                    @if($count == $all)
                    @php
                        $catCount += 1;
                    @endphp
                    {{-- Last Row Will be shown as it is not counted in loop --}}
                    <tr>
                        <td class="text-end"> <strong> Mean  </strong> </td>
                        <td class="text-center"> <strong> {{number_format($catPts / $catCount, 2)}} </strong> </td>
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
                    <td class="text-center"> <strong> {{number_format($totalPts / $all, 2)}} </strong> </td>  
                </tr>
                <tr>
                    <td class="text-end"> <strong> Descriptive Rating </strong> </td>
                    <td class="text-center"> <strong> {{rating($totalPts / $all)}} </strong> </td>  
                </tr>
            </tbody>
        </table>
        <br/>
        <div style="margin-left: 55px">
            @php
                $loop1 = ($subject->isLec == 1 || $subject->isLec == 3)? $data->where('q_type_id', 2)->where('isLec', true) : $data->where('q_type_id', 2)->where('isLec', false);
            @endphp
            @foreach($loop1 as $det)
                <span style="font-weight: bold" class="text-capitalize"> {{ucfirst($det->sentence)}}{{Str::contains($det->sentence, '?')? '' : ':'}} </span>
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
                <br/> <br/>
            @endforeach
        </div>
        <table class="text-center center" style="margin-top: 69px; width: 80%; border-left: 0px; border-right: 0px; border-bottom: 0px">
            <tbody>
                <tr>
                    <td style="border-left: 0px; border-right: 0px; border-bottom: 0px"> Signature of Instructor/Professor Observed </td>
                    <td style="border: 0px; color: white"> TTB Pangag Agtang </td>
                    <td style="border-left: 0px; border-right: 0px; border-bottom: 0px"> Signature of Supervisor/Observer </td>
                </tr>
            </tbody>
        </table>
        @if($subject->isLec == 3)
        <div class="page-break">
            <header style="margin-top:-30px; text-align:center">
                {{-- <img src="{{asset('images/logo.png')}}" alt="CTU Logo"/> --}}
                Republic of the Philippines <br/>
                <span style="font-weight: bold"> CEBU TECHNOLOGICAL UNIVERSITY </span> <br/>
                MAIN CAMPUS <br/>
                M.J. Cuenco Avenue Cor. R. Palma Street, Cebu City, Philippines <br/>
                Website: http://www.ctu.edu.ph E-mail: <span class="text-lowercase">{{$faculty->department->name}}</span>dean@ctu.edu.ph <br/>
                Phone: +6332-402-4060 loc. 1104 <br/> <br/>
                <span class="fw-bold text-uppercase"> Faculty Evaluation Report </span> <br/>
                <span style="text-decoration: italic"> (For Laboratory Classes) </span> <br/>
                {{$period->getDescription()}}
            </header> <br/>
            <div style="margin-left: 69px">
                <strong> Instructor/Professor: </strong> {{$faculty->fullName(true)}} &nbsp;
                <strong> Subject: </strong> {{$subject->descriptive_title}} <br/>
                <span style="text-align: end"> <strong> Date: </strong> {{date('M. d, Y @ g:i A',  strtotime(NOW()))}} </span> <br/>
            </div>
            <div>
                <table class="center no-border">
                    <thead>
                        <tr class="no-border" style="text-align: center">
                            <th class="no-border" colspan="2"> Rating Scale </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="no-border">
                            <td class="no-border"> 5 - Outstanding </td>
                            <td class="no-border"> 2 - Fair </td>
                        </tr>
                        <tr class="no-border">
                            <td class="no-border"> 4 - Very Good </td>
                            <td class="no-border"> 1 - Poor </td>
                        </tr>
                        <tr class="no-border">
                            <td class="no-border" colspan="2"> 3 - Good </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <table class="center">
                <tbody>
                    @php
                        $count = 1;
                        $prevCat = 0;
                        $catPts = 0;
                        $catCount = 0;
                        $totalPts = 0;
                        $cat = 0;
                    @endphp
                    @foreach($data->where('q_type_id', 1)->where('isLec', false) as $det)
                        @if($prevCat != $det->q_category_id && $prevCat != 0)
                        <tr>
                            <td class="text-end"> <strong>  Mean  </strong> </td>
                            <td class="text-center"> <strong> {{number_format($catPts / $catCount, 2)}} </strong> </td>
                        </tr>
                        @php
                            $catPts = 0;
                            $catCount = 0;
                        @endphp
                        @endif
                        @if($prevCat != $det->q_category_id)
                            @php
                                $cat += 1;
                            @endphp
                           <tr>
                                <th colspan="2"> Area of Concern {{numberToRoman($cat)}}: {{$det->qCat->name}} </th>
                           </tr>
                        @endif
                        @php
                            $catPts += $det->mean;
                        @endphp
                        <tr>
                            <td> <strong> {{$catCount + 1}}. </strong> {{ucfirst($det->sentence)}} </td>
                            <td class="text-center"> {{number_format($det->mean, 2)}} </td>
                        </tr>
                        @if($count == $data->where('q_type_id', 1)->where('isLec', false) ->count())
                        @php
                            $catCount += 1;
                        @endphp
                        {{-- Last Row Will be shown as it is not counted in loop --}}
                        <tr>
                            <td class="text-end"> <strong>  Mean  </strong> </td>
                            <td class="text-center"> <strong> {{number_format($catPts / $catCount, 2)}} </strong> </td>
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
                        <td class="text-center"> <strong> {{number_format(($totalPts / $data->where('isLec', false)->where('q_type_id', 1)->count()), 2)}} </strong> </td>  
                    </tr>
                    <tr>
                        <td class="text-end"> <strong> Descriptive Rating </strong> </td>
                        <td class="text-center"> <strong> {{rating($totalPts / $data->where('isLec', false)->where('q_type_id', 1)->count())}} </strong> </td>  
                    </tr>
                </tbody>
            </table>
            <br/>
            <div style="margin-left: 55px">
                @foreach($data->where('q_type_id', 2)->where('isLec', false) as $det)
                    <span style="font-weight: bold" class="text-capitalize"> {{ucfirst($det->sentence)}}{{Str::contains($det->sentence, '?')? '' : ':'}} </span>
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
                    <br/> <br/>
                @endforeach
            </div>
            <table class="text-center center" style="margin-top: 69px; width: 80%; border-left: 0px; border-right: 0px; border-bottom: 0px">
                <tbody>
                    <tr>
                        <td style="border-left: 0px; border-right: 0px; border-bottom: 0px"> Signature of Instructor/Professor Observed </td>
                        <td style="border: 0px; color: white"> TTB Pangag Agtang </td>
                        <td style="border-left: 0px; border-right: 0px; border-bottom: 0px"> Signature of Supervisor/Observer </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
    </body>
</html>
@php
    function rating($mean)
    {
        switch(number_format($mean, 0))
        {
            case 1: return 'Poor';
                    break;
            case 2: return 'Fair';
                    break;
            case 3: return 'Good';
                    break;
            case 4: return 'Very Good';
                    break;
            case 5: return 'Outstanding';
                    break;
        }
    }

    function numberToRoman($num)  
    { 
        // Be sure to convert the given parameter into an integer
        $n = intval($num);
        $result = ''; 
    
        // Declare a lookup array that we will use to traverse the number: 
        $lookup = array(
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
        ); 
    
        foreach ($lookup as $roman => $value)  
        {
            // Look for number of matches
            $matches = intval($n / $value); 
    
            // Concatenate characters
            $result .= str_repeat($roman, $matches); 
    
            // Substract that from the number 
            $n = $n % $value; 
        } 

        return $result; 
    } 
@endphp