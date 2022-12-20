<!-- OffCanvas -->
<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasfaculty" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasScrollingLabel">CritiKo - {{auth()->user()->faculties[0]->isDean? 'Dean' : 'Faculty'}}</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div>
            @php
                $period = periods();

                if(getSelected() == null && !$period->isEmpty())
                    setSelected($period[0]->id);
            @endphp            
            <form action="{{route('faculty.changePeriod')}}" method="POST">
                @csrf
                <select class="form-select" aria-label="Default select example" name="period" onchange="this.form.submit()">
                    @unless($period->isEmpty())
                        @foreach ($period as $p)
                            <option value="{{$p->id}}" {{getSelected() == $p->id? 'selected' : ''}}> {{$p->getDescription()}} </option>                    
                        @endforeach
                    @else
                        <option disabled selected> -Periods Empty- </option>
                    @endunless
                </select>
            </form>
        </div>
        <div class="ms-3 my-2">
            <span class="text-xs text-secondary"> Main Navigation </span>
        </div>
        <div class="list-group">
            <a href="{{route('home')}}" class="list-group-item list-group-item-action">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door mx-2" viewBox="0 0 16 16">
                    <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
                </svg>
                Dashboard
            </a>
            <a href="{{route('faculty.profile')}}" class="list-group-item list-group-item-action">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-badge mx-2" viewBox="0 0 16 16">
                    <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z"/>
                </svg>
                Update Profile
            </a>
            @if(auth()->user()->faculties->first()->isChairman || auth()->user()->faculties->first()->isDean)
            <a href="{{route('faculty.evaluate')}}" class="list-group-item list-group-item-action">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check mx-2" viewBox="0 0 16 16">
                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                </svg>
                Evaluate
            </a>
            <a href="{{route('dean.enrollment')}}" class="list-group-item list-group-item-action">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book mx-2" viewBox="0 0 16 16">
                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                </svg>
                Enrollment
            </a>
            <a href="{{route('dean.report')}}" class="list-group-item list-group-item-action">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-pulse mx-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 1.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Zm-5 0A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm-2 0h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Zm6.979 3.856a.5.5 0 0 0-.968.04L7.92 10.49l-.94-3.135a.5.5 0 0 0-.895-.133L4.232 10H3.5a.5.5 0 0 0 0 1h1a.5.5 0 0 0 .416-.223l1.41-2.115 1.195 3.982a.5.5 0 0 0 .968-.04L9.58 7.51l.94 3.135A.5.5 0 0 0 11 11h1.5a.5.5 0 0 0 0-1h-1.128L9.979 5.356Z"/>
                </svg>
                Faculty Report
            </a>
            @endif
        </div>
    </div>
    <div class="row mx-3 py-3 d-flex justify-content-between">
        <div class="col">
            <strong> DEPARTMENT </strong> 
        </div>
        <div class="col text-end">
            <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{auth()->user()->faculties->first()->department->description}}">
                {{auth()->user()->faculties->first()->department->name}}
            </span>
        </div>
    </div>
</div>
<!-- Off Canvas -->
<!-- Previous Limit Modal -->
<div class="modal fade" id="prevLimitModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Previous Limit</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('faculty.changePrevLimit')}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <select class="form-select rounded-pill" name="prevLimit" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="This setting is used to limit the view of previous semesters for performance purposes. Recommended and default number of limit: 1.">
                            <option value="7" {{Illuminate\Support\Facades\Session::get('prevLimit') == 7? 'selected' : ''}}> No Limit </option>
                            <option value="1" {{Illuminate\Support\Facades\Session::get('prevLimit') == 1 || Illuminate\Support\Facades\Session::get('prevLimit') == null? 'selected' : ' '}}> 1 </option>
                            <option value="2" {{Illuminate\Support\Facades\Session::get('prevLimit') == 2? 'selected' : ''}}> 2 </option>
                            <option value="3" {{Illuminate\Support\Facades\Session::get('prevLimit') == 3? 'selected' : ''}}> 3 </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary rounded-pill" data-bs-dismiss="modal">Set</button>
            </div>
        </form>
      </div>
    </div>
  </div>
<!-- Previous Limit Modal -->
@php
    function periods()
    {
        return App\Models\Period::latest('id')->get();        
    }
    function setSelected($period)
    {
        Illuminate\Support\Facades\Session::put('period', $period);
    }
    function getSelected()
    {
        return Illuminate\Support\Facades\Session::get('period');
    }
@endphp
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>