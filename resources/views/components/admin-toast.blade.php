@inject('Department', 'App\Models\Department')
@php
    $dept = $Department->with('faculties')->latest('id')->get();
    $latestPer = App\Models\Period::latest('id')->get()->first();
    $block = App\Models\Block::where('period_id', $latestPer->id)->latest('id')->get();
@endphp
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    @if(isset($latestPer))
        @if(!isset($latestPer->beginEnroll))
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger">
                <strong class="me-auto text-uppercase text-light">Unset</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                The enrollment date for the current period is not set.
            </div>
        </div>
        @endif
    @endif
    @unless($dept->isEmpty())
        @foreach($dept as $det)
            @if($det->faculties->where('isAssDean', true)->first() == null || $det->faculties->where('isChairman', true)->first() == null || $det->faculties->where('isAssDean', true)->first() == null)
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger">
                    <strong class="me-auto text-uppercase text-light">Unassigned</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    It appears there are unassigned department heads.
                </div>
            </div>
            @endif
            @if($det->courses->isEmpty())
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger">
                    <strong class="me-auto text-uppercase text-light">Empty</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    It appears there are some department with no courses.
                </div>
            </div>
            @php
                break;
            @endphp
            @else
                @foreach($det->courses as $course)
                    @if($course->subjects->isEmpty())
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-danger">
                            <strong class="me-auto text-uppercase text-light">Empty</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            It appears there are courses whose subjects are empty.
                        </div>
                    </div>
                    @php
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
                        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header bg-danger">
                                <strong class="me-auto text-uppercase text-light">Unassigned</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                It appears there are unassigned classes.
                            </div>
                        </div>
                        @php
                            break 2;
                        @endphp
                    @endif
                @endforeach
            @endunless
        @endforeach
    @endunless
</div>
