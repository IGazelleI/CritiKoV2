@inject('Period', 'App\Models\Period')
@php
    $per = $Period->latest('id')->get();
@endphp
<!-- Period Modals -->
<div class="modal fade" id="periodModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 ms-5" id="exampleModalLabel">Periods</h1>
            <div class="col-sm me-5">
                <button type="button" class="btn btn-primary float-end" data-bs-target="#addPerModal" data-bs-toggle="modal"> 
                    <span>New</span>
                </button>					
            </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <ul class="list-group list-group-flush">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="2"> <strong> Description </strong> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @unless($per->isEmpty())
                            @foreach($per as $det)
                            <tr>
                                <td>{{$det->getDescription()}}</td>
                                <td>
                                    <button type="button" class="btn btn-info p-1" data-bs-target="#editPerModal" data-bs-toggle="modal"
                                        data-bs-id="{{$det->id}}"
                                        data-bs-semester="{{$det->semester}}"
                                        data-bs-batch="{{$det->batch}}"
                                        data-bs-beginEval="{{$det->beginEval}}"
                                        data-bs-endEval="{{$det->endEval}}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-danger p-1" data-bs-target="#delPerModal" data-bs-toggle="modal"
                                        data-bs-id="{{$det->id}}"
                                        data-bs-description="{{$det->getDescription()}}"
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
                                <th scope="row">Period is empty.</th>
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