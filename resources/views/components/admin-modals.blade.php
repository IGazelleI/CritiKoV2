<x-user-modal/>
<x-period-modal/>
<x-department-modal/>
<x-course-modal/>
<x-subject-modal/>
<x-block-modal/>
<x-klase-modal/>
<!-- Previous Limit Modal -->
<div class="modal fade" id="prevLimitModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Previous Limit</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('admin.changePrevLimit')}}" method="POST">
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