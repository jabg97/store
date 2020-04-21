@extends('layouts.dashboard.main')
@section('template_title')
Información de la orden | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css" />
@endsection

@section('content')
@if($order->status()->code == 'CREATED' || $order->status()->code == 'REJECTED')
<a href="javascript:void(0);" class="btn-float hoverable">
    <i class="fa fa-bars my-float"></i>
</a>
<ul class="ul-share">

    <li><small class="label-float hoverable">Pagar la orden</small>
        <a onclick="pagar_orden({{ $order->id }})" class="bg-color-gradient-success hoverable">
            <i class="fas fa-cash-register my-float"></i>
        </a>
        <form id="formulario_pagar" method="POST" action="#" accept-charset="UTF-8">
            <input type="hidden" id="url_send" name="url_send" value="{{ route('p2p.session', $order->id) }}" />
            <input name="_method" type="hidden" value="PUT" />
            {{ csrf_field() }}
        </form>
    </li>

    <li><small class="label-float hoverable">Eliminar la orden</small>
        <a onclick="eliminar_orden({{ $order->id }})" class="bg-color-gradient-danger hoverable">
            <i class="fas fa-trash-alt my-float"></i>
        </a>
        <form id="eliminar{{ $order->id }}" method="POST" action="{{ route('order.destroy', $order->id) }}"
            accept-charset="UTF-8">
            <input name="_method" type="hidden" value="DELETE" />
            {{ csrf_field() }}
        </form>
    </li>
    <li><small class="label-float hoverable">Editar la orden</small>
        <a onclick="mostrar_modal('{{ route("order.edit",$order->id) }}','edit_order')"
            class="bg-color-gradient-warning hoverable">
            <i class="fas fa-pencil-alt my-float"></i>
        </a></li>

</ul>
@endif
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
                            <a
                                class="bg-color-gradient-primary list-group-item active z-depth-2 white-text waves-light hoverable">
                                <i class="fas fa-shipping-fast mr-2"></i><strong>Orden #{{ $order->id }}</strong>
                            </a>
                            <a class="list-group-item waves-effect hoverable"><strong>Nombre:
                                </strong>{{ $order->costumer_name }}</a>
                            <a class="list-group-item waves-effect hoverable"><strong>Email:
                                </strong>{{ $order->costumer_email }}</a>
                            <a class="list-group-item waves-effect hoverable"><strong>Teléfono móvil:
                                </strong>{{ $order->costumer_mobile }}</a>
                            <a class="list-group-item waves-effect hoverable"><strong>Producto:
                                </strong>{{ $order->product->name }}</a>
                            <a class="list-group-item waves-effect hoverable"><strong>Precio:
                                </strong>
                                <span class="h5">
                                    <span class="hoverable badge bg-color-gradient-success">
                                        @money($order->product->price)
                                    </span>
                                </span>
                            </a>
                            <a class="list-group-item waves-effect hoverable"><strong>Estado: </strong>

                                <span class="h5">
                                    <span class="hoverable badge {{$order->status()->css}}">
                                        <i class="mr-1 {{$order->status()->icon}}"></i>{{$order->status()->name}}
                                    </span>
                                </span>
                            </a>
                            @if($order->status()->code == 'CREATED' || $order->status()->code == 'REJECTED')
                            <a class="list-group-item waves-effect hoverable">

                            <span class="btn btn-outline-success" onclick="pagar_orden({{ $order->id }})">

                                <i class="fas fa-lg fa-cash-register"></i> Pagar
                            </span>
                        </a>
                            @endif

                            @if($order->process_url && ($order->status()->code == 'PENDING' ))
                            <a class="list-group-item waves-effect hoverable">

                            <span class="btn btn-outline-danger"
                             onclick="document.location.href= '{{ $order->process_url }}'">

                                <i class="fas fa-lg fa-sync"></i> Reintentar
                            </span>
                        </a>
                            @endif
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
    $("#formulario_pagar").submit(function (e) {
        e.preventDefault();
        var url_send = $("#url_send").val();
        var _token = "{{ csrf_token() }}";
        inicio_carga();
        $.ajax({
                method: "POST",
                url: url_send,
                async: true,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                data: new FormData(this),
            })
            .done(function (response) {
                try {
                    console.log(response);
                    if (response.status == 200) {
                        Swal.fire({
                            title: 'Éxito',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: '<i class="fas fa-check fa-lg"></i> Continuar',
                            showCloseButton: true,
                            confirmButtonClass: 'btn btn-success bg-color-gradient-success',
                            buttonsStyling: false,
                            animation: false,
                            customClass: 'animated zoomIn',
                        });

                        window.location.href = response.url;

                    } else {
                        Swal.fire({
                            title: 'Error ' + response.status,
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: '<i class="fas fa-exclamation-triangle fa-lg"></i> Continuar',
                            showCloseButton: true,
                            confirmButtonClass: 'btn btn-danger bg-color-gradient-danger',
                            buttonsStyling: false,
                            animation: false,
                            customClass: 'animated zoomIn',
                        });
                    }

                } catch (err) {
                    console.log(err.message);
                }
            })
            .fail(function (response) {
                console.log(response.responseJSON);
                Swal.fire({
                    title: 'Error ' + response.status,
                    text: response.statusText,
                    icon: 'error',
                    confirmButtonText: '<i class="fas fa-exclamation-triangle fa-lg"></i> Continuar',
                    showCloseButton: true,
                    confirmButtonClass: 'btn btn-danger bg-color-gradient-danger',
                    buttonsStyling: false,
                    animation: false,
                    customClass: 'animated zoomIn',
                });
            })
            .always(function () {
                fin_carga();
            });
    });

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

    function pagar_orden(id) {
        Swal.fire({
            title: 'Pagar la orden',
            text: '¿Desea Pagar la orden #' + id + '?',
            icon: 'question',
            confirmButtonText: '<i class="fas fa-cash-register fa-lg"></i> Pagar',
            cancelButtonText: '<i class="fas fa-times fa-lg"></i> Cancelar',
            showCancelButton: true,
            showCloseButton: true,
            confirmButtonClass: 'btn btn-success bg-color-gradient-success',
            cancelButtonClass: 'btn btn-dark bg-color-gradient-primary',
            buttonsStyling: false,
            animation: false,
            customClass: 'animated zoomIn',
        }).then((result) => {
            if (result.value) {
                $("#formulario_pagar").submit();
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

</script>
@endsection
