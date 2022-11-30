@inject('Course', 'App\Models\Course')
@inject('Period', 'App\Models\Period')
@php
    $course = $Course->latest('id')->get();
    $period = $Period->latest('id')->get();
@endphp
<!-- Block Modals -->
<!-- Add Block -->
<div class="modal fade" id="addBlockModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">New Block</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('block.store')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="course_id" class="col-form-label ms-2">Course</label>
                            <select class="form-control rounded-pill" name="course_id" id="course_id">
                                <option selected disabled> -Select- </option>
                                @unless($course->isEmpty())
                                    @foreach($course as $det)
                                        <option value="{{$det->id}}"> {{$det->description}} </option>
                                    @endforeach
                                @else
                                    <option selected disabled> Course is empty. </option>
                                @endunless
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <div class="mb-3">
                                <label for="period_id" class="col-form-label ms-2">Period</label>
                                <select class="select form-select rounded-pill" name="period_id">
                                    <option selected disabled> -Select- </option>
                                @unless($period->isEmpty())
                                    @foreach($period as $det)
                                        <option value="{{$det->id}}"> {{$det->getDescription()}} </option>
                                    @endforeach
                                @else
                                    <option selected disabled> Period is empty. </option>
                                @endunless
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="year_level" class="col-form-label ms-2">Year Level</label>
                                <select class="select form-select rounded-pill" name="year_level">
                                    <option selected disabled>-Select-</option>
                                    @for($i = 1; $i <= 4; $i++)
                                        <option value="{{$i}}" >{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="section" class="col-form-label ms-2">Section</label>
                                <select class="select form-select rounded-pill" name="section">
                                    <option selected disabled>-Select-</option>
                                    @for($i = 1; $i <= 4; $i++)
                                        <option value="{{$i}}" >{{chr($i + 64)}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Block -->
<!-- Edit Block -->
<div class="modal fade" id="editBlockModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Update Block</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('block.update')}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" class="id" name="id"/>
                        <div class="mb-3">
                            <label for="course_id" class="col-form-label ms-2">Course</label>
                            <select class="select form-select rounded-pill course" name="course_id" id="course_id">
                                <option selected disabled> -Select- </option>
                                @unless($course->isEmpty())
                                    @foreach($course as $det)
                                        <option value="{{$det->id}}"> {{$det->description}} </option>
                                    @endforeach
                                @else
                                    <option selected disabled> Course is empty. </option>
                                @endunless
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <div class="mb-3">
                                <label for="period_id" class="col-form-label ms-2">Period</label>
                                <select class="select form-select rounded-pill period" name="period_id">
                                    <option selected disabled> -Select- </option>
                                    @unless($period->isEmpty())
                                        @foreach($period as $det)
                                            <option value="{{$det->id}}"> {{$det->getDescription()}} </option>
                                        @endforeach
                                    @else
                                        <option selected disabled> Period is empty. </option>
                                    @endunless
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="year_level" class="col-form-label ms-2">Year Level</label>
                                <select class="select form-select rounded-pill year_level" name="year_level">
                                    <option selected disabled>-Select-</option>
                                    @for($i = 1; $i <= 4; $i++)
                                        <option value="{{$i}}" >{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="section" class="col-form-label ms-2">Section</label>
                                <select class="select form-select rounded-pill section" name="section">
                                    <option selected disabled>-Select-</option>
                                    @for($i = 1; $i <= 4; $i++)
                                        <option value="{{$i}}" >{{chr($i + 64)}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Block -->
<!-- Delete Block -->
<div class="modal fade" id="delBlockModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Confirmation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('block.delete')}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" class="id" name="id"/>
                    <p class="message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-pill">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Block -->
<!-- Block Modals -->
<script>
    //Block Scripts
    const editBlockModal = document.getElementById('editBlockModal')

    editBlockModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const course = button.getAttribute('data-bs-course');
        const period = button.getAttribute('data-bs-period');
        const year = button.getAttribute('data-bs-year');
        const section = button.getAttribute('data-bs-section');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = editBlockModal.querySelector('.modal-body .id');
        const courseInput = editBlockModal.querySelector('.modal-body .course');
        const periodInput = editBlockModal.querySelector('.modal-body .period');
        const yearInput = editBlockModal.querySelector('.modal-body .year_level');
        const secInput = editBlockModal.querySelector('.modal-body .section');

        idInput.value = id;
        courseInput.value = course;
        periodInput.value = period;
        yearInput.value = year;
        secInput.value = section;
    });

    const delBlockModal = document.getElementById('delBlockModal')

    delBlockModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const description = button.getAttribute('data-bs-description');
        const period = button.getAttribute('data-bs-period');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = delBlockModal.querySelector('.modal-body .id');
        const message = delBlockModal.querySelector('.modal-body .message');

        idInput.value = id;
        message.textContent = "All data inside the " + description + " on " + period + " will be deleted. Proceed with caution.";
    });
    //End of Department Scripts
</script>
