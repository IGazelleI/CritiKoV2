<section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="{{asset('images/logo.png')}}"
            class="img-fluid" alt="Cebu Technological University">
        </div>
        <div {{$attributes->merge(['class' => 'col-md-8 col-lg-6 col-xl-4 offset-xl-1'])}}>
            {{$slot}}
        </div>
      </div>
    </div>
</section>