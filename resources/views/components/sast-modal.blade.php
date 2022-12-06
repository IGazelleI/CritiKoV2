@inject('QType', 'App\Models\QType')
@inject('QCat', 'App\Models\QCategory')
@php
    $type = $QType->latest('id')->get();
    $cat = $QCat->latest('id')->get();
@endphp
<!-- Categories -->
<div class="modal fade" id="qCatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Categories</h1>
            <div class="col-sm me-5">
                <button type="button" class="btn btn-primary float-end" data-bs-target="#addDeptModal" data-bs-toggle="modal">
                    <span>New</span>
                </button>
            </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <ul class="list-group list-group-flush">
                @unless($cat->isEmpty())
                <table class="table table-hover">
                    <tbody>
                        @foreach($cat as $det)
                        <tr>
                            <th scope="row">
                                <a href="{{route('course.manage', $det->id)}}" class="link-dark">
                                    {{$det->name}}
                                </a>
                            </th>
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
                    <h3 class="text-center m-4 bg-light p-4 rounded text-uppercase">Category is empty</h3>
                @endunless
            </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- Categories -->
<!-- Add Category -->
<div class="modal fade" id="addQCatModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">New Category</h1>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-target="#qCatModal" data-bs-toggle="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Category -->
<!-- Edit Category -->
<div class="modal fade" id="editQCatModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Update Category</h1>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-target="#departmentModal" data-bs-toggle="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Category -->
<!-- Delete Category -->
<div class="modal fade" id="delQCatModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
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
<!-- Delete Category -->
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
    const editQCatModal = document.getElementById('editQCatModal')

    editQCatModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const name = button.getAttribute('data-bs-name');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = editQCatModal.querySelector('.modal-body .id');
        const nameInput = editQCatModal.querySelector('.modal-body .name');
        const descInput = editDeptModal.querySelector('.modal-body .description');
        console.log('aa');
        idInput.value = id;
        nameInput.value = name;
    });

    const delQCatModal = document.getElementById('delQCatModal')

    delQCatModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const description = button.getAttribute('data-bs-description');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const idInput = delQCatModal.querySelector('.modal-body .id');
        const message = delQCatModal.querySelector('.modal-body .message');

        idInput.value = id;
        message.textContent = "All data inside the " + description + " will be deleted. Proceed with caution.";
    });

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
