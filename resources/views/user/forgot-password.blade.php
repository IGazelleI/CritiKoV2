<x-layout>
    <x-profile-card>
        <form action="{{route('password.email')}}" method="POST">
            @csrf
            <div class="row my-2 justify-content-center">
                <div class="col-5">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="email" name="email" id="email" class="form-control" value=""/>
                            <label class="form-label" for="email">Email</label>
        
                            @error('email')
                                <p class="text-sm text-danger ms-3">
                                    {{$message}}
                                </p>
                            @enderror
                        </div>
                </div>
            </div>       
            <div class="row justify-content-end">
                <div class="col-3 me-5">
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4"> Check </button>
                </div>
            </div>
        </form>
    </x-profile-card>
</x-layout>