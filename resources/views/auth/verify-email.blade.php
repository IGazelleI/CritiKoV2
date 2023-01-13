<x-layout>
    <x-general-card>
        <div class="card">
            <div class="card-header">
              Featured
            </div>
            <div class="card-body">
              <h5 class="card-title">Special title treatment</h5>
              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </x-general-card>
    @if(auth()->user()->type= == 1)
    <x-admin-canvas/>
    @elseif(auth()->user()->type= == 2)
    <x-sast-canvas/>
    @elseif(auth()->user()->type= == 3)
    <x-faculty-canvas/>
    @else
    <x-student-canvas/>
</x-layout>