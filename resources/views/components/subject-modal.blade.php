@inject('Course', 'App\Models\Course')
@php
    $course = $Course->latest('id')->get();
@endphp
<!-- Add Subject -->
<div class="modal fade" id="addSubModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">New Subject</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('subject.store')}}" method="POST">
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
                            <label for="course_id" class="col-form-label ms-2"> Course </label>
                            <select class="select form-select rounded-pill" name="course_id">
                                <option selected disabled>Course</option>
                                @unless ($course->isEmpty())
                                    @foreach($course as $c)
                                        <option value="{{$c->id}}"> {{$c->name}} {{$c->description}} </option>
                                    @endforeach
                                @else
                                    <option disabled> Course is empty. </option>
                                @endunless
                              </select>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="col-form-label ms-2">Code</label>
                            <input type="text" class="form-control rounded-pill" name="code">
                        </div>
                        <div class="mb-3">
                            <label for="descriptive_title" class="col-form-label ms-2">Descriptive Title</label>
                            <input type="text" class="form-control rounded-pill" name="descriptive_title">
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="col-form-label ms-2">Semester</label>
                            <select class="select form-select rounded-pill" name="semester">
                                <option selected disabled>Semester</option>
                                @for($i = 1; $i <= 3; $i++)
                                    <option value="{{$i}}" >{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-target="#departmentModal" data-bs-toggle="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Department -->
<!-- Edit Department -->
<div class="modal fade" id="editSubModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Update Subject</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('subject.update')}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" class="id" name="id"/>
                    <div class="mb-3">
                        <label for="course_id" class="col-form-label ms-2"> Course </label>
                        <select class="select form-select rounded-pill course" name="course_id">
                            <option selected disabled>Course</option>
                            @unless ($course->isEmpty())
                                @foreach($course as $c)
                                    <option value="{{$c->id}}"> {{$c->name}} {{$c->description}} </option>
                                @endforeach
                            @else
                                <option disabled> Course is empty. </option>
                            @endunless
                          </select>
                    </div>
                    <div class="mb-3">
                        <label for="code" class="col-form-label ms-2">Code</label>
                        <input type="text" class="form-control rounded-pill code" name="code">
                    </div>
                    <div class="mb-3">
                        <label for="descriptive_title" class="col-form-label ms-2">Descriptive Title</label>
                        <input type="text" class="form-control rounded-pill description" name="descriptive_title">
                    </div>
                    <div class="mb-3">
                        <label for="semester" class="col-form-label ms-2">Semester</label>
                        <select class="select form-select rounded-pill semester" name="semester">
                            <option selected disabled>Semester</option>
                            @for($i = 1; $i <= 3; $i++)
                                <option value="{{$i}}" >{{$i}}</option>
                            @endfor
                        </select>
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
<!-- Edit Subject -->
<!-- Delete Subject -->
<div class="modal fade" id="delSubModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Confirmation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('subject.delete')}}" method="POST">
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
<!-- Subject Department -->
<!-- Subject Modals -->
<script>
    //Subject Scripts
    const editSubModal = document.getElementById('editSubModal')

    editSubModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const course = button.getAttribute('data-bs-course');
        const code = button.getAttribute('data-bs-code');
        const description = button.getAttribute('data-bs-description');
        const semester = button.getAttribute('data-bs-semester');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = editSubModal.querySelector('.modal-body .id');
        const courseInput = editSubModal.querySelector('.modal-body .course');
        const codeInput = editSubModal.querySelector('.modal-body .code');
        const descInput = editSubModal.querySelector('.modal-body .description');
        const semInput = editSubModal.querySelector('.modal-body .semester');

        idInput.value = id;
        courseInput.value = course;
        codeInput.value = code;
        descInput.value = description;
        semInput.value = semester;
    });

    const delSubModal = document.getElementById('delSubModal')

    delSubModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const description = button.getAttribute('data-bs-description');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = delSubModal.querySelector('.modal-body .id');
        const message = delSubModal.querySelector('.modal-body .message');

        idInput.value = id;
        message.textContent = "All data involving " + description + " will be deleted. Proceed with caution.";
    });
    //End of Department Scripts
</script>
