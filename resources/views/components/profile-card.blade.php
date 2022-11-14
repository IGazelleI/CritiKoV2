<section class="h-100 gradient-custom-2">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7">
                <div {{$attributes->merge(['class' => 'card'])}}>
                    {{$slot}}
                </div>
            </div>
        </div>
    </div>
</section>  
<!-- Change Profile Modal -->
<div class="modal fade" id="changeProfileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('student.changePic', auth()->user()->students[0]->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <label for="formFileSm" class="form-label">Select Image</label>
                        <input class="form-control form-control-sm" name="imgPath" id="formFileSm" type="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill">Change</button>
                </div>
            </form>
        </div>
    </div>
</div>