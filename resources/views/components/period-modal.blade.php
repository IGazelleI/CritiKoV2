@inject('Period', 'App\Models\Period')
@php
    $per = $Period->latest('id')->get();
@endphp
<!-- Period Modals -->
<div class="modal fade" id="periodModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 ms-4" id="exampleModalLabel">Periods</h1>
            <div class="col-sm me-5">
                <button type="button" class="btn btn-primary float-end" data-bs-target="#addPerModal" data-bs-toggle="modal">
                    <span>New</span>
                </button>
            </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @unless($per->isEmpty())
            <ul class="list-group list-group-flush">
                <table class="table table-hover">
                    <tbody>
                        @foreach($per as $det)
                        <tr>
                            <td>{{$det->getDescription()}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="border border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 5%">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button" class="dropdown-item" data-bs-target="#editPerModal" data-bs-toggle="modal"
                                                data-bs-id="{{$det->id}}"
                                                data-bs-semester="{{$det->semester}}"
                                                data-bs-batch="{{$det->batch}}"
                                                data-bs-beginEval="{{$det->beginEval}}"
                                                data-bs-endEval="{{$det->endEval}}"
                                            >
                                                Edit
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item text-danger" data-bs-target="#delPerModal" data-bs-toggle="modal"
                                                data-bs-id="{{$det->id}}"
                                                data-bs-description="{{$det->getDescription()}}"
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
            </ul>
            @else
                <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase"> Period is empty </h3>
            @endunless
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- Add Period -->
<div class="modal fade" id="addPerModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">New Period</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('period.store')}}" method="POST">
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
                            <select class="select form-select rounded-pill" name="semester">
                                <option selected disabled>Semester</option>
                                @for($i = 1; $i <= 3; $i++)
                                    <option value="{{$i}}" >{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="col-form-label ms-2">Batch</label>
                            <input type="text" class="form-control rounded-pill" name="batch">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="col-form-label ms-2">Begin</label>
                            <input type="date" name="beginEval" id="beginEval" class="form-control"/>

                            <label for="description" class="col-form-label ms-2">End</label>
                            <input type="date" name="endEval" id="endEval" class="form-control"/>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-target="#periodModal" data-bs-toggle="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Period -->
<!-- Edit Period -->
<div class="modal fade" id="editPerModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Update Period</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('period.update')}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                        <input type="hidden" class="id" name="id"/>
                        <div class="mb-3">
                            <select class="select form-select rounded-pill semester" name="semester">
                                <option selected disabled>Semester</option>
                                @for($i = 1; $i <= 3; $i++)
                                    <option value="{{$i}}" >{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="col-form-label ms-2">Batch</label>
                            <input type="text" class="form-control rounded-pill batch" name="batch">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="col-form-label ms-2">Begin</label>
                            <input type="date" name="beginEval" id="beginEval" class="form-control beginEval"/>

                            <label for="description" class="col-form-label ms-2">End</label>
                            <input type="date" name="endEval" id="endEval" class="form-control endEval"/>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-target="#periodModal" data-bs-toggle="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Period -->
<!-- Delete Period -->
<div class="modal fade" id="delPerModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Confirmation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('period.delete')}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" class="id" name="id"/>
                    <p class="message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-target="#periodModal" data-bs-toggle="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-pill">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Period -->
<!-- Period Modals -->
<script>
    //Period Scripts
    const editPerModal = document.getElementById('editPerModal')

    editPerModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const semester = button.getAttribute('data-bs-semester');
        const batch = button.getAttribute('data-bs-batch');
        const beginEval = button.getAttribute('data-bs-beginEval');
        const endEval = button.getAttribute('data-bs-endEval');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = editPerModal.querySelector('.modal-body .id');
        const semesterInput = editPerModal.querySelector('.modal-body .semester');
        const batchInput = editPerModal.querySelector('.modal-body .batch');
        const beginEvalInput = editPerModal.querySelector('.modal-body .beginEval');
        const endEvalInput = editPerModal.querySelector('.modal-body .endEval');

        idInput.value = id;
        semesterInput.value = semester;
        batchInput.value = batch;
        beginEvalInput.value = beginEval;
        endEvalInput.value = endEval;
    });

    const delPerModal = document.getElementById('delPerModal')

    delPerModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const description = button.getAttribute('data-bs-description');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = delPerModal.querySelector('.modal-body .id');
        const message = delPerModal.querySelector('.modal-body .message');

        idInput.value = id;
        message.textContent = "All data inside the " + description + " will be deleted. Proceed with caution.";
    });
    //End of Period Scripts
</script>
