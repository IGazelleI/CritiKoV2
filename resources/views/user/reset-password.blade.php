<x-layout>
    <x-profile-card>
        <form action="{{route('password.update')}}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{$token}}"/>
            <!-- Email input -->
            <div class="form-outline mb-4">
                <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}"/>
                <label class="form-label" for="email">Email</label>
            </div>
            <div class="row">
                <div class="col">
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" name="password" id="password" class="form-control" />
                        <label class="form-label" for="password">Password</label>
                    </div>
                </div>
                <div class="col">
                    <!-- Repeat Password input -->
                    <div class="form-outline mb-6">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" />
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                    </div>
                </div>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-3">Sign in</button>
        </form>
    </x-profile-card>
</x-layout>