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