<x-layout>
    <x-general-card>
        <div class="row">
            <div class="col">
                <form action="{{route('student.submitEnroll')}}" method="POST">
                    @csrf
                    <div class="row m-4">
                        <div class="col">
                            <div class="form-outline mb-4">
                                <label class="form-label ms-2">Faculty</label>
                                <select class="select form-select rounded-pill" name="user_id">
                                    <option selected disabled>-Select-</option>
                                    @foreach($dept as $det)
                                        <option value="{{$det->id}}"> {{$det->fullName(1)}} </option>
                                    @endforeach
                                  </select>

                                  @error('user_id')
                                    <p class="text-sm text-danger ms-3">
                                        {{$message}}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-outline mb-4">
                                <label class="form-label ms-2">Faculty</label>
                                <select class="select form-select rounded-pill" name="user_id">
                                    <option selected disabled>-Select-</option>
                                    @unless ($faculty->isEmpty())
                                        @foreach($faculty as $det)
                                            <option value="{{$det->id}}"> {{$det->fullName(1)}} </option>
                                        @endforeach
                                    @else
                                        <option disabled> Current department has no faculty. </option>
                                    @endunless
                                  </select>

                                  @error('user_id')
                                    <p class="text-sm text-danger ms-3">
                                        {{$message}}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-end m-4">
                        <div class="col-2 mx-4">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#confirm">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-general-card>
    <x-admin-canvas/>
</x-layout>