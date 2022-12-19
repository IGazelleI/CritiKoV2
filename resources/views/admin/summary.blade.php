<x-layout>
    <x-medium-card>
        <div class="container-fluid">
            <div class="row">
                <div class="col-8 p-3">
                    <form action="{{route('admin.summarySearch')}}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Search Faculty..." value="{{$search}}">
                            <button class="btn btn-outline-secondary" id="button-addon2">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            @if(isset($faculty))
                @if(!$faculty->isEmpty())
                <div class="row">
                    <div class="col text-secondary ms-3">
                        Results found ({{$faculty->count()}})
                    </div>
                </div>
                @endif
            <div class="row mb-5">
                <div class="col">
                    @unless($faculty->isEmpty())
                        @foreach ($faculty as $det)
                        <div class="row p-3">
                            <div class="col-2">
                                <img src="{{isset($det->imgPath)? '../' . $det->imgPath() : 'https://www.pngitem.com/pimgs/m/226-2267516_male-shadow-circle-default-profile-image-round-hd.png'}}" 
                                    class="img-fluid rounded-circle" alt="Report Icon"
                                />
                            </div>
                            <div class="col">
                                <div class="row mt-3 mb-2">
                                    <div class="col">
                                        <span  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="View Summary Report">
                                            <a href="{{route('admin.summaryReport', ['faculty' => $det->id])}}" class="link-dark">
                                                {{$det->fullName(true)}}
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col fw-bold">
                                        <span  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$det->department->description}}">
                                            {{$det->department->name}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                    <h3 class="text-center text-secondary m-4 bg-light p-4 rounded"> Results for '{{$search}}' is empty </h3>
                    @endunless
                </div>
            </div>
            @endif
        </div>
    </x-medium-card>
    <x-admin-canvas/>
</x-layout>