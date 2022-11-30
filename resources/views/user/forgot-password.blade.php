<x-layout>
    <x-general-card>
        <div class="row">
            <div class="col m-5">
                <h3> Reset Password </h3>
                <p class="text-secondary">
                    Please enter your email address so we can send a reset link.
                </p>
            </div>
        </div>
        <form action="{{route('password.email')}}" method="POST">
            @csrf
            <div class="row my-2 justify-content-center">
                <div class="col-5">
                        <!-- Email input -->
                        <div class="mb-4">
                            <label class="form-label ms-2" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control rounded-pill"/>
        
                            @error('email')
                                <p class="text-sm text-danger ms-3">
                                    {{$message}}
                                </p>
                            @enderror
                        </div>
                </div>
            </div>       
            <div class="row justify-content-center">
                <div class="col-3 text-center">
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4"> Check </button>
                </div>
            </div>
        </form>
    </x-general-card>
</x-layout>