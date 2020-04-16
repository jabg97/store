@extends('layouts.dashboard.main')
@section('template_title')
Información de la orden | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css" />
@endsection

@section('content')
<a href="javascript:void(0);" class="btn-float hoverable">
    <i class="fa fa-bars my-float"></i>
</a>
<ul class="ul-share">
    <li><small class="label-float hoverable">Eliminar la orden</small>
        <a onclick="eliminar_orden({{ $order->id }})"
            class="bg-color-gradient-danger hoverable">
            <i class="fas fa-trash-alt my-float"></i>
        </a>
        <form id="eliminar{{ $order->id }}" method="POST"
                action="{{ route('order.destroy', $order->id) }}"
                accept-charset="UTF-8">
                <input name="_method" type="hidden" value="DELETE">
                {{ csrf_field() }}
            </form></li>
    <li><small class="label-float hoverable">Editar la orden</small>
        <a onclick="mostrar_modal('{{ route("order.edit",$order->id) }}','edit_order')" class="bg-color-gradient-warning hoverable">
            <i class="fas fa-pencil-alt my-float"></i>
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
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between">
                        <h5 class="d-flex justify-content-start">
                            <span><i class="fas fa-shipping-fast mr-1 fa-lg"></i>
                                <a href="{{ route('order.index') }}">Lista de ordenes</a>
                                /
                                Información de la orden #{{ $order->id }}
                            </span>
                        </h5>
                        <div class="d-flex justify-content-center">
                            <button class="btn-card-show btn btn-outline-danger btn-circle waves-effect hoverable"
                                data-toggle="tooltip" data-placement="bottom" title="Mostrar/Ocultar">
                                <i class="far fa-2x fa-eye-slash"></i>
                            </button>
                            <button
                                class="btn-card-fullscreen btn btn-outline-secondary btn-circle waves-effect hoverable"
                                data-toggle="tooltip" data-placement="bottom" title="Pantalla Completa">
                                <i class="fas fa-2x fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <hr />
                    <div class="card-content">
                        <div class="list-group hoverable">
                            <a class="bg-color-gradient-primary list-group-item active z-depth-2 white-text waves-light hoverable">
                                <i class="fas fa-shipping-fast mr-2"></i><strong>Orden #{{ $order->id }}</strong>
                            </a>
                            <a class="list-group-item waves-effect hoverable"><strong>Nombre:
                                </strong>{{ $order->costumer_name }}</a>
                            <a class="list-group-item waves-effect hoverable"><strong>Email:
                                </strong>{{ $order->costumer_email }}</a>
                                <a class="list-group-item waves-effect hoverable"><strong>Teléfono móvil:
                                </strong>{{ $order->costumer_email }}</a>
                                <a class="list-group-item waves-effect hoverable"><strong>Producto:
                                </strong>{{ $order->product->name }}</a>
                            <a class="list-group-item waves-effect hoverable"><strong>Estado: </strong>

                                <span class="h5">
                                    <span class="hoverable badge {{$order->status()->css}}">
                                        <i
                                            class="mr-1 {{$order->status()->icon}}"></i>{{$order->status()->name}}
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <!--/.Card-->

        </div>
        <!--Grid column-->

    </div>
    <!--Grid row-->

</div>
<div id="container_edit_order">
</div>
@endsection
@section('js_links')
<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/messages_es.js') }}"></script>


<script type="text/javascript">
     function eliminar_orden(id) {
        swal({
            title: 'Eliminar la orden',
            text: '¿Desea eliminar la orden #' + id + '?',
            type: 'question',
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
                swal({
                    position: 'top-end',
                    type: 'error',
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
</script>
@endsection
