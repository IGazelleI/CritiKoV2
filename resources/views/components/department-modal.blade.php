@inject('Department', 'App\Models\Department')
@php
    $dept = $Department->latest('id')->get();
@endphp
<!-- Department Modals -->
<div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 ms-5" id="exampleModalLabel">Departments</h1>
            <div class="col-sm me-5">
                <button type="button" class="btn btn-primary float-end" data-bs-target="#addDeptModal" data-bs-toggle="modal">
                    <span>New</span>
                </button>
            </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <ul class="list-group list-group-flush">
                @unless($dept->isEmpty())
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th> <strong> Name </strong> </th>
                            <th colspan="2"> <strong> Description </strong> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dept as $det)
                        <tr>
                            <th scope="row">
                                <a href="{{route('course.manage', $det->id)}}" class="link-dark">
                                    {{$det->name}}
                                </a>
                            </th>
                            <td>
                                <a href="{{route('course.manage', $det->id)}}" class="link-dark">
                                    {{$det->description}}
                                </a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="border border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 5%">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button" class="dropdown-item" data-bs-target="#editDeptModal" data-bs-toggle="modal"
                                                data-bs-id="{{$det->id}}"
                                                data-bs-name="{{$det->name}}"
                                                data-bs-description="{{$det->description}}"
                                            >
                                                Edit
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item text-danger" data-bs-target="#delDeptModal" data-bs-toggle="modal"
                                                data-bs-id="{{$det->id}}"
                                                data-bs-description="{{$det->description}}"
                                            >
                                                Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase">Department is empty</h3>
                @endunless
            </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- Add Department -->
<div class="modal fade" id="addDeptModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">New Department</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('department.store')}}" method="POST">
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
                            <label for="name" class="col-form-label ms-2">Name</label>
                            <input type="text" class="form-control rounded-pill name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="col-form-label ms-2">Description</label>
                            <input type="text" class="form-control rounded-pill description" name="description">
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
<div class="modal fade" id="editDeptModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Update Department</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('department.update')}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                        <input type="hidden" class="id" name="id"/>
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
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-target="#departmentModal" data-bs-toggle="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Department -->
<!-- Delete Department -->
<div class="modal fade" id="delDeptModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Confirmation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('department.delete')}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" class="id" name="id"/>
                    <p class="message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-target="#departmentModal" data-bs-toggle="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-pill">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Department -->
<!-- Department Modals -->
<script>
    //Department Scripts
    const editDeptModal = document.getElementById('editDeptModal')

    editDeptModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const name = button.getAttribute('data-bs-name');
        const description = button.getAttribute('data-bs-description');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = editDeptModal.querySelector('.modal-body .id');
        const nameInput = editDeptModal.querySelector('.modal-body .name');
        const descInput = editDeptModal.querySelector('.modal-body .description');

        idInput.value = id;
        nameInput.value = name;
        descInput.value = description;
    });

    const delDeptModal = document.getElementById('delDeptModal')

    delDeptModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const description = button.getAttribute('data-bs-description');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = delDeptModal.querySelector('.modal-body .id');
        const message = delDeptModal.querySelector('.modal-body .message');

        idInput.value = id;
        message.textContent = "All data inside the " + description + " will be deleted. Proceed with caution.";
    });
    //End of Department Scripts
</script>
