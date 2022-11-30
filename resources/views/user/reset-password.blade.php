<x-layout>
    <x-general-card class="p-5">
        <form action="{{route('password.update')}}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{$token}}"/>
            <!-- Email input -->
            <div class="col-8 mb-4">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control rounded-pill" value="{{old('email')}}"/>

                @error('email')
                    <p class="text-sm text-danger ms-3">
                        {{$message}}
                    </p>
                @enderror
            </div>
            <div class="row">
                <div class="col">
                    <!-- Password input -->
                    <div class="mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control rounded-pill" />

                        @error('password')
                            <p class="text-sm text-danger ms-3">
                                {{$message}}
                            </p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <!-- Repeat Password input -->
                    <div class="mb-6">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control rounded-pill" />

                        @error('password_confirmation')
                            <p class="text-sm text-danger ms-3">
                                {{$message}}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-3">Reset</button>
        </form>
    </x-general-card>
</x-layout>