@inject('Department', 'App\Models\Department')
@php
    $dept = $Department->latest('id')->get();
@endphp
<!-- Add Course -->
<div class="modal fade" id="addCourseModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">New Course</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('course.store')}}" method="POST">
                @csrf
                <div class="modal-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="mb-3">
                            <label for="department_id" class="col-form-label ms-2">Department</label>
                            <select class="form-control rounded-pill" name="department_id" id="department_id">
                                <option selected disabled> -Select- </option>
                                @unless($dept->isEmpty())
                                    @foreach($dept as $det)
                                        <option value="{{$det->id}}"> {{$det->description}} </option>
                                    @endforeach
                                @else
                                    <option selected disabled> Department is empty. </option>
                                @endunless
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="col-form-label ms-2">Name</label>
                            <input type="text" class="form-control rounded-pill name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="col-form-label ms-2">Description</label>
                            <input type="text" class="form-control rounded-pill description" name="description">
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
<!-- Add Course -->
<!-- EditCourse -->
<div class="modal fade" id="editCourseModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Update Course</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('course.update')}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                        <input type="hidden" class="id" name="id"/>
                        <div class="mb-3">
                            <label for="department_id" class="col-form-label ms-2">Department</label>
                            <select class="form-control rounded-pill department" name="department_id" id="department_id">
                                <option selected disabled> -Select- </option>
                                @unless($dept->isEmpty())
                                    @foreach($dept as $det)
                                        <option value="{{$det->id}}"> {{$det->description}} </option>
                                    @endforeach
                                @else
                                    <option selected disabled> Department is empty. </option>
                                @endunless
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="col-form-label ms-2">Name</label>
                            <input type="text" class="form-control rounded-pill name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="col-form-label ms-2">Description</label>
                            <input type="text" class="form-control rounded-pill description" name="description">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Course -->
<!-- Delete Course -->
<div class="modal fade" id="delCourseModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Confirmation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('course.delete')}}" method="POST">
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
<!-- Delete Course -->
<!-- Course Modals -->
<script>
    //Course Scripts
    const editCourseModal = document.getElementById('editCourseModal')

    editCourseModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const department_id = button.getAttribute('data-bs-department_id');
        const name = button.getAttribute('data-bs-name');
        const description = button.getAttribute('data-bs-description');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = editCourseModal.querySelector('.modal-body .id');
        const deptInput = editCourseModal.querySelector('.modal-body .department');
        const nameInput = editCourseModal.querySelector('.modal-body .name');
        const descInput = editCourseModal.querySelector('.modal-body .description');

        idInput.value = id;
        deptInput.value = department_id;
        nameInput.value = name;
        descInput.value = description;
    });

    const delCourseModal = document.getElementById('delCourseModal')

    delCourseModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const description = button.getAttribute('data-bs-description');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = delCourseModal.querySelector('.modal-body .id');
        const message = delCourseModal.querySelector('.modal-body .message');

        idInput.value = id;
        message.textContent = "All data inside the " + description + " will be deleted. Proceed with caution.";
    });
    //End of Department Scripts
</script>