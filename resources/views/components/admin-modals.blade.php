@inject('Department', 'App\Models\Department')
@php
    $dept = $Department->latest('id')->get();
@endphp
<div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Departments</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <ul class="list-group list-group-flush">
                <table class="table table-hover">
                    <tbody>
                        @unless($dept->isEmpty())
                            @foreach($dept as $det)
                            <tr>
                                <th scope="row">{{$det->name}}</th> 
                                <td>{{$det->description}}</td>
                                <td>
                                    <button type="button" class="btn btn-info p-1" data-bs-target="#editDeptModal" data-bs-toggle="modal"
                                        data-bs-name="{{$det->name}}"
                                        data-bs-description="{{$det->description}}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-danger p-1" data-bs-target="#delDeptModal" data-bs-toggle="modal"
                                        data-bs-id="{{$det->id}}"
                                        data-bs-description="{{$det->description}}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                          </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <th scope="row">Department is empty.</th>
                            </tr>
                        @endunless
                    </tbody>
                </table>
            </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="editDeptModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Update Department</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="col-form-label">Name</label>
                        <input type="text" class="form-control rounded-pill name" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="col-form-label">Description</label>
                        <input type="text" class="form-control rounded-pill description" id="description">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-target="#departmentModal" data-bs-toggle="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delDeptModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Confirmation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    All data inside the deparment will also be deleted. Click delete to proceed.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-target="#departmentModal" data-bs-toggle="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    const exampleModal = document.getElementById('editDeptModal')

    exampleModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const name = button.getAttribute('data-bs-name');
        const description = button.getAttribute('data-bs-description');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const nameInput = exampleModal.querySelector('.modal-body .name');
        const descInput = exampleModal.querySelector('.modal-body .description');
        console.log(name);
        nameInput.value = name;
        descInput.value = description;
    });

    const exampleModal = document.getElementById('delDeptModal')

    exampleModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const description = button.getAttribute('data-bs-description');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = exampleModal.querySelector('.modal-body .id');
        const message = exampleModal.querySelector('.modal-body .message');

        idInput.value = id;
        message.textContent = "All data inside the " + description + " will be deleted.";
    });
</script>