@php
    
    $notifCount = 0;
@endphp
<div class="btn-group dropstart shadow-none">
    <ul class="dropdown-menu">
        <li class="dropdown-item text-uppercase fw-bold text-warning"> Reminder </li>
        <li><hr class="dropdown-divider"></li>
        @if(auth()->user()->students->first()->fname == null ||
            auth()->user()->students->first()->lname == null ||
            auth()->user()->students->first()->dob == null ||
            auth()->user()->students->first()->address == null ||
            auth()->user()->students->first()->cnumber == null ||
            auth()->user()->students->first()->emergency_cPName == null ||
            auth()->user()->students->first()->emergency_cPNumber == null ||
            auth()->user()->students->first()->emergency_cPRelationship == null ||
            auth()->user()->students->first()->emergency_cPAddress == null
        )
            <li class="dropdown-item"> Please don't forget to update your profile. Thank you. </li>
            @php
                $notifCount += 1;
                Session::put('allowed', false);
            @endphp
        @else
            @php
                Session::put('allowed', true);
            @endphp
        @endif
        @if($notifCount == 0)
        <li class="dropdown-item"> No reminders this time. Have a great time! </li>
        @endif
    </ul>
    <button class="btn btn-trasparent shadow-none position-relative text-light mx-0 px-2"
        data-bs-toggle="dropdown"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
        </svg>
        @if($notifCount != 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{$notifCount}}
            <span class="visually-hidden">unread messages</span>
        </span>
        @endif
    </button>
</div>