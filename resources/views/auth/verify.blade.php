<x-layout>
    <x-general-card>
        <div class="card">
            <div class="card-header">
              Email Verification
            </div>
            <div class="card-body">
              <form action="{{route('verification.resend')}}" method="POST">
                @csrf
                <h5 class="card-title">Verify Email to Proceed</h5>
                <p class="card-text">Please click the link below to verify email address.</p>
                <button type="submit" class="btn btn-primary">Verify</button>
              </form>
            </div>
        </div>
    </x-general-card>
</x-layout>