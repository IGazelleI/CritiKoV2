<x-layout>
    <x-medium-card>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col text-center">
                            <h4> Improvement Rate </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {!! $overAllChart->container() !!}
                            {!! $overAllChart->script() !!}
                        </div>
                    </div>
                </div>
                <div class="col-4 pt-5">
                    @if(isset($evalProgressF) && isset($evalProgressS))
                    <div class="row">
                        <div class="col">
                            {!! $evalProgressF->container() !!}
                            {!! $evalProgressF->script() !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {!! $evalProgressS->container() !!}
                            {!! $evalProgressS->script() !!}
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col">
                            Evaluation Date Not Set
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </x-medium-card>
    <x-admin-canvas/>
</x-layout>
{{-- @if(isset($open))
<script type="text/javascript">
    $(window).on('load', function() {
        $('#departmentModal').modal('show');
    });
</script>
@endif --}}