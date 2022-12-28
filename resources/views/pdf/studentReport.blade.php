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
                margin: 10px;
                padding: 3px
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
        </style>
    </head>
    <body>
        <header style="margin-top:-30px; text-align:center">
            Student's Assesment ST <br/>
            {{$period->getDescription()}}
        </header> <br/>
        <div>
            <table class="no-border center" style="padding: 1px 5px">
                <tr>
                    <td class="no-border" style="padding: 1px 5px"> </td>
                    <td class="no-border" style="padding: 1px 5px"> </td>
                    <td class="no-border" style="padding: 1px 5px"> </td>
                    <td colspan="2" class="no-border" style="text-align: center; padding: 1px 5px"> <strong> RANGE and Verbal Description (VD) </strong> </td>
                </tr>
                <tr>
                    <td class="no-border" style="padding: 1px 5px"> Name of Instructor/Professor </td>
                    <td class="no-border" style="padding: 1px 5px"> : &nbsp; {{$faculty->fullName(true)}} </td>
                    <td class="no-border" style="padding: 1px 5px"> Campus : Main </td>
                    <td class="no-border" style="padding: 1px 5px"> 4.20 - 5.00 Outstanding (O) </td>
                    <td class="no-border" style="padding: 1px 5px"> 2.60 - 3.39 Satisfactory (S) </td>
                </tr>
                <tr>
                    <td class="no-border" style="padding: 1px 5px"> Course Taught </td>
                    <td class="no-border" style="padding: 1px 5px"> : &nbsp; {{$faculty->klases->first()->subject->descriptive_title}} </td>
                    <td class="no-border" style="padding: 1px 5px"> </td>
                    <td class="no-border" style="padding: 1px 5px"> 3.40 - 4.19 Very Satisfactory (VS) </td>
                    <td class="no-border" style="padding: 1px 5px"> 1.80 - 2.59 Fair (F) </td>
                </tr>
                <tr>
                    <td class="no-border" style="padding: 1px 5px"> No. of Student Evaluators </td>
                    <td class="no-border" style="padding: 1px 5px"> : &nbsp; {{$faculty->evaluated->where('period_id', $period->id)->count()}} </td>
                    <td class="no-border" style="padding: 1px 5px"> </td>
                    <td colspan="2" class="no-border" style="text-align: center; padding: 1px 5px"> 1.00 - 1.79 Unsatisfactory (US) </td>
                </tr>
            </table>
        </div>
        <table style="width: 69%" class="center">
            @php
                $prevCat = 0;
                $catCount = 0;
                $cat = 0;
            @endphp
            @foreach($data->where('q_type_id', 1) as $det)
                @if($prevCat != $det->q_category_id)
                    @php
                        $catCount = 0;
                        $cat += 1;
                    @endphp
                    </table>
                    <table style="width: 69%" class="center">
                        <thead>
                            <tr>
                                <th> <strong> {{numberToRoman($cat)}}. {{$det->qCat->name}} </strong> </th>
                                <th style="width: 10%" class="text-center"> <strong> Mean </strong> </th>
                                <th style="width: 10%" class="text-center"> <strong> VD </strong> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> <strong> {{$catCount + 1}}. </strong> {{ucfirst($det->sentence)}} </td>
                                <td class="text-center"> {{isset($det->mean)? number_format($det->mean, 2) : 'N/A'}}</td>
                                <td class="text-center"> {{isset($det->mean)? rating($det->mean)['vd'] : 'N/A'}} </td>
                            </tr>
                        </tbody>
                @else
                <tbody>
                    <tr>
                        <td> <strong> {{$catCount + 1}}. </strong> {{ucfirst($det->sentence)}} </td>
                        <td class="text-center"> {{isset($det->mean)? number_format($det->mean, 2) : 'N/A'}}</td>
                        <td class="text-center"> {{isset($det->mean)? rating($det->mean)['vd'] : 'N/A'}} </td>
                    </tr>
                </tbody>
                @endif
                @php
                    $catCount += 1;
                    $prevCat = $det->q_category_id;
                @endphp
            @endforeach
        </table>
        @php
            $prevCat = 0;
            $catCount = 0;
            $cat = 0;
        @endphp
        <div style="margin-top: 30px;" class="center">
            <div style="display: inline-table">
                <table class="no-border" style="padding: 2px">
                    <thead>
                        <tr class="no-border" style="padding: 2px">
                            <th class="no-border" style="padding: 2px"> <strong> Summary Statistics </strong> </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $det)
                        @php
                            $catCount = 0;
                            $cat += 1;
                        @endphp
                        @if($prevCat != $det->q_category_id)
                        <tr class="no-border" style="padding: 2px">
                            <td class="no-border" style="padding: 2px"> {{$det->qCat->name}} Mean ({{$det->qCat->name[0]}}M) </td>
                            <td class="no-border" style="padding: 2px"> &nbsp; : &nbsp; <span style="font-weight: bold; font-size: 12"> {{number_format($data->where('q_category_id', $det->q_category_id)->avg('mean'), 2)}} </span> </td>
                        </tr>
                        @endif
                        @php
                            $prevCat = $det->q_category_id;
                        @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div style="display: inline-table; margin-left: auto">
                <table class="text-center no-border" style="padding: 2px">
                    <tbody>
                        <tr>
                            <td class="fw-bold no-border" style="padding: 2px"> You are a/an </td>
                        </tr>
                        <tr>
                            <td class="text-uppercase fw-bold no-border" style="font-size: 16; padding: 2px"> {{rating($data->avg('mean'))['message']}} </td>
                        </tr>
                        <tr>
                            <td class="no-border" style="padding: 2px"> General Average &nbsp; {{number_format($data->avg('mean'), 2)}} </td>
                        </tr>
                        <tr>
                            <td class="fw-bold no-border" style="padding: 2px"> Instructor/Professor </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br/>
        <table class="text-center no-border center" style="width: 90%">
            <tbody>
                <tr>
                    <td class="text-start no-border"> Prepared by: </td>
                    <td class="no-border">  </td>
                    <td class="text-start no-border"> Checked and Verified: </td>
                </tr>
                <tr>
                    <td class="fw-bold text-decoration-underline no-border"> ROBERT JAY N. ANGOD, LPT, M. Ed-Math </td>
                    <td class="no-border"> </td>
                    <td class="fw-bold text-decoration-underline no-border"> IRVIN A. NARCISO, LPT </td>
                </tr>
                <tr>
                    <td class="no-border"> SAST Focal Person </td>
                    <td class="no-border"> </td>
                    <td class="no-border"> OIC Dean, Student Affairs and Services </td>
                </tr>
                <tr>
                    <td class="no-border"> </td>
                    <td class="text-start no-border"> Certified Proper and In Order: </td>
                    <td class="no-border"> </td>
                </tr>
                <tr>
                    <td class="no-border"> </td>
                    <td class="fw-bold text-decoration-underline no-border"> JOSEPH C. PEPITO, Ph.D. </td>
                    <td class="no-border"> </td>
                </tr>
                <tr>
                    <td class="no-border"> </td>
                    <td class="no-border"> Campus Director, Main </td>
                    <td class="no-border"> </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
@php
    function rating($mean)
    {
        $result = number_format($mean, 2);
        $rate = array();

        if($result >= 1.00 && $result <= 1.79)
        {
            $rate['message'] = 'Unsatisfactory';
            $rate['vd'] = 'US';

            return $rate;
        }
        elseif($result >= 1.80 && $result <= 2.59)
        {
            $rate['message'] = 'Fair';
            $rate['vd'] = 'F';

            return $rate;
        }
        elseif($result >= 2.60 && $result <= 3.39)
        {
            $rate['message'] = 'Satisfactory';
            $rate['vd'] = 'S';

            return $rate;
        }
        elseif($result >= 3.40 && $result <= 4.19)
        {
            $rate['message'] = 'Very Satisfactory';
            $rate['vd'] = 'VS';

            return $rate;
        }
        elseif($result >= 4.20 && $result <= 5.00)
        {
            $rate['message'] = 'Outstanding';
            $rate['vd'] = 'O';

            return $rate;
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