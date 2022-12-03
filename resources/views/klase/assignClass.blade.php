<x-layout>
    <x-general-card>
        <div class="row">
            <div class="col text-center p-5">
                <h1 class="p-3 m-0 rounded-top {{randomBg()}}"> <span class="p-3"> {{$klase->subject->code}} </span> </h1>
                <p class="border border-dark rounded-bottom text-secondary p-1"> {{$klase->subject->descriptive_title}} </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{route('klase.assignInstructorProcess', $klase->id)}}" method="POST">
                    @csrf
                    <div class="row m-4 d-flex justify-content-center">
                        <div class="col-8">
                            <div class="form-outline mb-4">
                                <h4 class="ms-3"> Instructor </h4> 
                                <p class="text-secondary" style="font-size: 15px"> 
                                    Select Faculty member to be assigned as the instructor of {{$klase->subject->descriptive_title}} 
                                </p>
                                <select class="select form-select rounded-pill" name="instructor">
                                    <option selected disabled>-Select-</option>
                                    @unless ($faculty->isEmpty())
                                        @foreach($faculty as $det)
                                            <option value="{{$det->user_id}}"> {{$det->fullName(1)}} </option>
                                        @endforeach
                                    @else
                                        <option disabled> Current department has no faculty. </option>
                                    @endunless
                                  </select>

                                  @error('instructor')
                                    <p class="text-sm text-danger ms-3">
                                        {{$message}}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-end m-4">
                        <div class="col-2 mx-4 me-5">
                            <!-- Button trigger modal -->
                            <button type="submit" class="btn btn-primary rounded-pill">
                                Assign
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-general-card>
    <x-admin-canvas/>
</x-layout>
@php
    function randomBg()
    {
        $bg = ['bg-primary', 'bg-secondary', 'bg-info', 'bg-warning', 'bg-danger', 'bg-success'];

        return $bg[random_int(0, count($bg) - 1)];
    }
@endphp