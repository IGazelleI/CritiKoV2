@inject('Department', 'App\Models\Department')
@php
    $dept = $Department->with('faculties')->latest('id')->get();
    $latestPer = App\Models\Period::latest('id')->get()->first();
    $block = App\Models\Block::where('period_id', $latestPer->id)->latest('id')->get();
    $notifCount = 0;
@endphp
<div class="btn-group dropstart shadow-none">
    <ul class="dropdown-menu">
        <li class="dropdown-item text-uppercase fw-bold text-warning"> Reminder </li>
        <li><hr class="dropdown-divider"></li>
        @if(isset($latestPer))
            @if(!isset($latestPer->beginEnroll))
            <li class="dropdown-item"> The enrollment date for the latest period is not set. </li>
            @php
                $notifCount += 1;
            @endphp
            @endif
        @endif
        @unless($dept->isEmpty())
            @foreach($dept as $det)
                @if($det->faculties->where('isAssDean', true)->first() == null || $det->faculties->where('isChairman', true)->first() == null || $det->faculties->where('isAssDean', true)->first() == null)
                
                <li class="dropdown-item"> It appears there are unassigned department heads. </li>
                @php
                    $notifCount += 1;
                @endphp
                @endif
                @if($det->courses->isEmpty())
                <li class="dropdown-item"> It appears there are some department with no courses.</li>
                @php
                    $notifCount += 1;
                    break;
                @endphp
                @else
                    @foreach($det->courses as $course)
                        @if($course->subjects->isEmpty())
                        <li class="dropdown-item"> It appears there are courses whose subjects are empty. </li>
                        @php
                            $notifCount += 1;
                            break 2;
                        @endphp
                        @endif
                    @endforeach
                @endif
            @endforeach
        @endunless
        @unless($block->isEmpty())
            @foreach($block as $b)
                @unless($b->klases->isEmpty())
                    @foreach($b->klases as $klase)
                        @if($klase->instructor == null)
                            {{-- <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header bg-danger">
                                    <strong class="me-auto text-uppercase text-light">Unassigned</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    It appears there are unassigned classes.
                                </div>
                            </div> --}}
                            <li class="dropdown-item"> It appears there are unassigned classes. </li>
                            @php
                                $notifCount += 1;
                                break 2;
                            @endphp
                        @endif
                    @endforeach
                @endunless
            @endforeach
        @endunless
    </ul>
    <button class="btn btn-trasparent shadow-none position-relative text-light mx-0 px-2"
        data-bs-toggle="dropdown"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
        </svg>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{$notifCount}}
            <span class="visually-hidden">unread messages</span>
        </span>
    </button>
</div>