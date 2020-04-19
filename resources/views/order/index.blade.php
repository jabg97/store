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
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between">
                        <h5 class="d-flex justify-content-start">
                            <span><i class="fas fa-shipping-fast fa-lg mr-1"></i>
                                @if ($orders->count() === 1)
                                Una orden
                                @elseif ($orders->count() > 1)
                                {{ $orders->count() }} ordenes
                                @else
                                No hay ordenes
                                @endif
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
                        <div class="table-responsive">
                            <!-- Table  -->
                            <table id="dtorders" class="table table-borderless table-hover display dt-responsive nowrap"
                                cellspacing="0" width="100%">
                                <thead class="bg-color-gradient-primary white-text">
                                    <tr class="z-depth-2">
                                        <th class="th-sm">#
                                        </th>
                                        <th class="th-sm">Cliente
                                        </th>
                                        <th class="th-sm">Producto
                                        </th>
                                        <th class="th-sm">Estado
                                        </th>

                                        <th class="th-sm">Acciones
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $key => $order)
                                    <tr class="hoverable">
                                        <td>{{$order->id}}</td>
                                        <td><i class="mr-1 far fa-user"></i>{{$order->costumer_name}}<br>
                                            <a class="link-text" href="mailto:{{$order->costumer_email}}"><i
                                                    class="mr-1 far fa-envelope"></i>{{$order->costumer_email}}<br></a>
                                            <a class="link-text" href="tel:{{$order->costumer_mobile}}"><i
                                                    class="mr-1 fas fa-mobile-alt"></i>{{$order->costumer_mobile}}</a>
                                        </td>
                                        <td>{{$order->product->name}}<br>
                                            <span class="h5">
                                                <span class="hoverable badge bg-color-gradient-success">
                                                    @money($order->product->price)
                                                </span>
                                            </span>
                                        </td>
                                        <td>
                                            <h5>
                                                <span class="hoverable badge {{$order->status()->css}}">
                                                    <i
                                                        class="mr-1 {{$order->status()->icon}}"></i>{{$order->status()->name}}
                                                </span>
                                            </h5>
                                        </td>

                                        <td>

                                            <a href="{{ route('order.show',$order->id) }}" class="text-primary m-1"
                                                data-toggle="tooltip" data-placement="bottom"
                                                title='Información de la orden #{{ $order->id }}'>
                                                <i class="fas fa-2x fa-info-circle"></i>
                                            </a>
                                            @if($order->status()->code == 'CREATED' || $order->status()->code == 'REJECTED')
                                            <a onclick="mostrar_modal('{{ route("order.edit",$order->id) }}','edit_order')"
                                                class="text-warning m-1" data-toggle="tooltip" data-placement="bottom"
                                                title='Editar la orden #{{ $order->id }}'>
                                                <i class="fas fa-2x fa-pencil-alt"></i>
                                            </a>

                                            <a onclick="eliminar_orden({{ $order->id }})" class="text-danger m-1"
                                                data-toggle="tooltip" data-placement="bottom"
                                                title='Eliminar la orden #{{ $order->id }}'>
                                                <i class="fas fa-2x fa-trash-alt"></i>
                                            </a>
                                            <form id="eliminar{{ $order->id }}" method="POST"
                                                action="{{ route('order.destroy',$order->id) }}" accept-charset="UTF-8">
                                                <input name="_method" type="hidden" value="DELETE"/>
                                                {{ csrf_field() }}
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Table  -->
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
    $(document).ready(function () {
        var currentdate = new Date();
        moment.locale('es');
        var datetime = moment().format('DD MMMM YYYY, h-mm-ss a');
        var titulo_archivo = "Lista de orders (" + datetime + ")";
        $('#dtorders').DataTable({
            mark: true,
            dom: 'Bfrtip',
            lengthMenu: [
                [2, 5, 10, 20, 30, 50, 100, -1],
                ['2 registros', '5 registros', '10 registros', '20 registros', '30 registros',
                    '50 registros', '100 registros', 'Mostrar todo'
                ]
            ],
            oLanguage: {
                sProcessing: 'Procesando...',
                sLengthMenu: 'Mostrar _MENU_ registros',
                sZeroRecords: 'No se encontraron resultados',
                sEmptyTable: 'Ningún dato disponible en esta tabla',
                sInfo: 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
                sInfoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
                sInfoFiltered: '(filtrado de un total de _MAX_ registros)',
                sInfoPostFix: '',
                sSearch: '<i class="fas fa-search fa-lg"></i>',
                sUrl: '',
                sInfoThousands: ',',
                sLoadingRecords: 'Cargando...',
                oPaginate: {
                    sFirst: 'Primero',
                    sLast: 'Último',
                    sNext: 'Siguiente',
                    sPrevious: 'Anterior'
                },
                oAria: {
                    sSortAscending: ': Activar para ordenar la columna de manera ascendente',
                    sSortDescending: ': Activar para ordenar la columna de manera descendente'
                }
            },
            buttons: [

                {
                    extend: 'collection',
                    text: '<i class="fas fa-2x fa-cog fa-spin"></i>',
                    titleAttr: 'Opciones',
                    buttons: [{
                            extend: 'copyHtml5',
                            text: '<i class="fas fa-copy"></i> Copiar',
                            titleAttr: 'Copiar',
                            title: titulo_archivo
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print"></i> Imprimir',
                            titleAttr: 'Imprimir',
                            title: titulo_archivo
                        },
                        {
                            extend: 'collection',
                            text: '<i class="fas fa-cloud-download-alt"></i> Exportar',
                            titleAttr: 'Exportar',
                            buttons: [{
                                    extend: 'csvHtml5',
                                    text: '<i class="fas fa-file-csv"></i> Csv',
                                    titleAttr: 'Csv',
                                    title: titulo_archivo
                                },
                                {
                                    extend: 'excelHtml5',
                                    text: '<i class="fas fa-file-excel"></i> Excel',
                                    titleAttr: 'Excel',
                                    title: titulo_archivo
                                },
                                {
                                    extend: 'pdfHtml5',
                                    text: '<i class="fas fa-file-pdf"></i> Pdf',
                                    titleAttr: 'Pdf',
                                    title: titulo_archivo
                                }
                            ]
                        },

                        {
                            extend: 'colvis',
                            text: '<i class="fas fa-low-vision"></i> Ver/Ocultar',
                            titleAttr: 'Ver/Ocultar',
                        }

                    ]
                },
                'pageLength'
            ],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return '<i class="fas fa-shipping-fast fa-lg"></i> Datos de la orden #' +
                                data[0];
                        }
                    }),
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            }
        });


        $('.dataTables_length').addClass('bs-select');
        $('.dataTables_filter label input').attr("placeholder", "Buscar");
        $('.dataTables_filter label input').hide(0);
    });

</script>
@endsection
