@inject('QType', 'App\Models\QType')
@inject('QCat', 'App\Models\QCategory')
@php
    $type = $QType->latest('id')->get();
    $cat = $QCat->latest('id')->get();
@endphp
<!-- Add Question -->
<div class="modal fade" id="addQModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">New Question</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('question.store')}}" method="POST">
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
                    <div class="row">
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="type" class="col-form-label ms-2"> For </label>
                                <select class="select form-select rounded-pill answer" name="type">
                                    <option selected disabled>-Select-</option>
                                    <option value="3"> Faculty </option>
                                    <option value="4"> Student </option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="q_type_id" class="col-form-label ms-2"> Type </label>
                                <select class="select form-select rounded-pill type" name="q_type_id">
                                    <option selected disabled>-Select-</option>
                                    @unless ($type->isEmpty())
                                        @foreach($type as $det)
                                            <option value="{{$det->id}}"> {{$det->name}} </option>
                                        @endforeach
                                    @else
                                        <option disabled> Question type is empty. </option>
                                    @endunless
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="q_category_id" class="col-form-label ms-2"> Category </label>
                                <select class="select form-select rounded-pill category" name="q_category_id">
                                    <option selected disabled>-Select-</option>
                                    @unless ($cat->isEmpty())
                                        @foreach($cat as $det)
                                            <option value="{{$det->id}}"> {{$det->name}} </option>
                                        @endforeach
                                    @else
                                        <option disabled> Question category is empty. </option>
                                    @endunless
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="sentence" class="col-form-label ms-2">Sentence</label>
                                <input type="text" class="form-control rounded-pill" name="sentence">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="keyword" class="col-form-label ms-2">Keyword</label>
                                <input type="text" class="form-control rounded-pill" name="keyword">
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
<!-- Add Question -->
<!-- Update Question -->
<div class="modal fade" id="editQModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Update Question</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('question.update')}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" class="id" name="id"/>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="type" class="col-form-label ms-2"> For </label>
                                <select class="select form-select rounded-pill answer" name="type">
                                    <option selected disabled>-Select-</option>
                                    <option value="3"> Faculty </option>
                                    <option value="4"> Student </option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="q_type_id" class="col-form-label ms-2"> Type </label>
                                <select class="select form-select rounded-pill type" name="q_type_id">
                                    <option selected disabled>-Select-</option>
                                    @unless ($type->isEmpty())
                                        @foreach($type as $det)
                                            <option value="{{$det->id}}"> {{$det->name}} </option>
                                        @endforeach
                                    @else
                                        <option disabled> Question type is empty. </option>
                                    @endunless
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="q_category_id" class="col-form-label ms-2"> Category </label>
                                <select class="select form-select rounded-pill category" name="q_category_id">
                                    <option selected disabled>-Select-</option>
                                    @unless ($cat->isEmpty())
                                        @foreach($cat as $det)
                                            <option value="{{$det->id}}"> {{$det->name}} </option>
                                        @endforeach
                                    @else
                                        <option disabled> Question category is empty. </option>
                                    @endunless
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="sentence" class="col-form-label ms-2">Sentence</label>
                                <input type="text" class="form-control rounded-pill sentence" name="sentence">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="keyword" class="col-form-label ms-2">Keyword</label>
                                <input type="text" class="form-control rounded-pill keyword" name="keyword">
                            </div>
                        </div>
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
<!-- Edit Question -->
<!-- Delete  Question -->
<div class="modal fade" id="delQModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Confirmation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('question.delete')}}" method="POST">
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
<!-- Delete Question -->
<script>
    const addQModal = document.getElementById('addQModal')

    addQModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const type = button.getAttribute('data-bs-type');
        const cat = button.getAttribute('data-bs-category');
        const answer = button.getAttribute('data-bs-answer');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        if(type != null && cat != null)
        {
            const typeInput = addQModal.querySelector('.modal-body .type');
            const catInput = addQModal.querySelector('.modal-body .category');

            typeInput.value = type;
            catInput.value = cat;
        }
        if(answer != null)
        {
            const answerInput = addQModal.querySelector('.modal-body .answer');
            answerInput.value = answer;
        }
    });

    const editQModal = document.getElementById('editQModal')

    editQModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const answer = button.getAttribute('data-bs-answer');
        const type = button.getAttribute('data-bs-type');
        const cat = button.getAttribute('data-bs-category');
        const sentence = button.getAttribute('data-bs-sentence');
        const keyword = button.getAttribute('data-bs-keyword');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = editQModal.querySelector('.modal-body .id');
        const answerInput = editQModal.querySelector('.modal-body .answer');
        const typeInput = editQModal.querySelector('.modal-body .type');
        const catInput = editQModal.querySelector('.modal-body .category');
        const sentInput = editQModal.querySelector('.modal-body .sentence');
        const keyInput = editQModal.querySelector('.modal-body .keyword');

        idInput.value = id;
        answerInput.value = answer;
        typeInput.value = type;
        catInput.value = cat;
        sentInput.value = sentence;
        keyInput.value = keyword;
    });

    const delQModal = document.getElementById('delQModal')

    delQModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const description = button.getAttribute('data-bs-description');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = delQModal.querySelector('.modal-body .id');
        const message = delQModal.querySelector('.modal-body .message');

        idInput.value = id;
        message.textContent = "Are you sure? Proceed with caution.";
    });
    
</script>
