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
                padding: 3px
            }
            .center
            {
                margin-left: auto;
                margin-right: auto;
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
            <span class="fw-bold text-uppercase"> {{$type == 3? 'Faculty' : 'Student'}} Evaluation Report </span>
        </header> <br/>
        <div style="margin-left: 69px">
            <strong> Instructor/Professor: </strong> {{$faculty->fullName(true)}} &nbsp; <strong> Date: </strong> {{date('M. d, Y @ g:i A',  strtotime(NOW()))}} <br/>
            <strong> Period: </strong> {{$period->getDescription()}} &nbsp;
        </div> <br/> <br/>
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
                @foreach($data->where('q_type_id', 1) as $det)
                    @if($prevCat != $det->q_category_id && $prevCat != 0)
                    <tr>
                        <td class="text-end"> <strong> Mean  </strong> </td>
                        <td class="text-center"> <strong> {{number_format($catPts / $catCount, 1)}} </strong> </td>
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
                        <td class="text-center"> {{number_format($det->mean, 1)}}</td>
                    </tr>
                    @if($count == $data->where('q_type_id', 1)->count())
                    @php
                        $catCount += 1;
                    @endphp
                    {{-- Last Row Will be shown as it is not counted in loop --}}
                    <tr>
                        <td class="text-end"> <strong> Mean  </strong> </td>
                        <td class="text-center"> <strong> {{number_format($catPts / $catCount, 1)}} </strong> </td>
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
                    <td class="text-center"> <strong> {{number_format($totalPts / ($count - 1), 1)}} </strong> </td>  
                </tr>
                <tr>
                    <td class="text-end"> <strong> Descriptive Rating </strong> </td>
                    <td class="text-center"> <strong> {{rating($totalPts / ($count - 1))}} </strong> </td>  
                </tr>
            </tbody>
        </table>
        <br/>
        <div style="margin-left: 55px">
            @foreach($data->where('q_type_id', 2) as $det)
                <span style="font-weight: bold"> {{ucfirst($det->sentence)}}{{Str::contains($det->sentence, '?')? '' : ':'}} </span>
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