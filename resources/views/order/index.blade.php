@extends('layouts.dashboard.main')
@section('template_title')
Lista de ordenes | {{ config('app.name', 'Laravel') }}
@endsection

@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-responsive-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-buttons-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css" />
@endsection
@section('content')
<a href="javascript:void(0);" class="btn-float hoverable">
    <i class="fa fa-bars my-float"></i>
</a>
<ul class="ul-share">
    <li><small class="label-float hoverable">Registrar una orden</small>
        <a onclick="mostrar_modal('{{ route("order.create",0) }}','create_order')"
            class="bg-color-gradient-success hoverable">
            <i class="fas fa-plus my-float"></i>
        </a></li>

</ul>
<div class="container-fluid">


    <!--Grid row-->
    <div class="row">

        <!--Grid column-->
        <div class="col-12">

            <!--Card-->
            <div class="card hoverable">
                <!--Card content-->
                <div class="card-body" id="container_table">
                </div>

            </div>
            <!--/.Card-->

        </div>
        <!--Grid column-->

    </div>
    <!--Grid row-->


</div>
<div id="container_create_order">
</div>
<div id="container_edit_order">
</div>
@endsection
@section('js_links')
<!-- DataTables core JavaScript -->
<script type="text/javascript" src="{{ asset('js/addons/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bt4-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/responsive-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bt4-responsive-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bt4-buttons-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons.html5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/jszip.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/vfs_fonts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons.print.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons.colVis.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/mark.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/datatables.mark.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/messages_es.js') }}"></script>
<script type="text/javascript">
    function eliminar_orden(id) {
        Swal.fire({
            title: 'Eliminar la orden',
            text: '¿Desea eliminar la orden #' + id + '?',
            icon: 'question',
            confirmButtonText: '<i class="fas fa-trash-alt fa-lg"></i> Eliminar',
            cancelButtonText: '<i class="fas fa-times fa-lg"></i> Cancelar',
            showCancelButton: true,
            showCloseButton: true,
            confirmButtonClass: 'btn btn-danger bg-color-gradient-danger',
            cancelButtonClass: 'btn btn-dark bg-color-gradient-primary',
            buttonsStyling: false,
            animation: false,
            customClass: 'animated zoomIn',
        }).then((result) => {
            if (result.value) {
                $("#eliminar" + id).submit();
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Operación cancelada por el usuario',
                    showConfirmButton: false,
                    toast: true,
                    animation: false,
                    customClass: 'animated lightSpeedIn',
                    timer: 3000
                })
            }
        })
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $(document).ready(function () {
        mostrar_div("{{ route('order.table','null') }}",'table');
    });

</script>
@endsection
