<x-layout>
    <x-profile-card>
        
        @for($i = 0; $i < 3; $i++)
        <div class="row">
            <x-rates style="display:inline"/>
        </div>
        @endfor
    </x-profile-card>
    <x-student-canvas/>
</x-layout>