@if(session()->has('message'))
    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed-bottom alert alert-dark text-white ms-2 mb-2" role="alert" style="width: 250px">
        <p>
            {{session('message')}}
        </p>
    </div>
@endif