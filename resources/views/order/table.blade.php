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
         <button class="btn-card-show btn btn-outline-danger btn-circle waves-effect hoverable" data-toggle="tooltip"
             data-placement="bottom" title="Mostrar/Ocultar">
             <i class="far fa-2x fa-eye-slash"></i>
         </button>
         <button class="btn-card-fullscreen btn btn-outline-secondary btn-circle waves-effect hoverable"
             data-toggle="tooltip" data-placement="bottom" title="Pantalla Completa">
             <i class="fas fa-2x fa-expand"></i>
         </button>
     </div>
 </div>
 <hr />
 <div class="card-content">
<div class="row" style="padding-bottom: 40px; padding-left: 20px;">
    <div class="btn-group ">
        <button type="button" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false"
          class="btn dropdown-toggle right mr-2 mt-2 waves-effect hoverable {{ ($status) ? $status->css : 'btn-secondary' }}">
         
<i class="mr-1 fas fa-lg {{ ($status) ? $status->icon : 'fa-tasks' }}"></i>
{{ ($status) ? $status->name : 'Mostrar todo' }}
        </button>
        <div class="dropdown-menu dropdown-menu-right">
                <button onclick="mostrar_div('{{route('order.table',array('null'))}}', 'table')" class="dropdown-item waves-effect hoverable {{(!$status) ? 'ocultar' : ''}}" type="button">
                        <i class="mr-1 fas fa-lg  fa-tasks danger-text"></i>
                        Mostrar todo</button>
                @foreach($list as $key => $row)
                <button onclick="mostrar_div('{{route('order.table',array($row->code))}}', 'table')" class="dropdown-item waves-effect hoverable {{($status && $status->code == $row->code) ? 'ocultar' : ''}}" type="button">
                        <i class="mr-1 fas fa-lg {{ $row->icon }}"></i>
                    {{$row->name}}</button>
                @endforeach
               
        </div>
      </div></div>
     <div class="table-responsive">
         <!-- Table  -->
         <table id="dtorders" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0"
             width="100%">
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
                                 <i class="mr-1 {{$order->status()->icon}}"></i>{{$order->status()->name}}
                             </span>
                         </h5>
                     </td>

                     <td>

                         <a href="{{ route('order.show',$order->id) }}" class="text-primary m-1" data-toggle="tooltip"
                             data-placement="bottom" title='Información de la orden #{{ $order->id }}'>
                             <i class="fas fa-2x fa-info-circle"></i>
                         </a>
                         @if($order->status()->code == 'CREATED' || $order->status()->code ==
                         'REJECTED')
                         <a onclick="mostrar_modal('{{ route("order.edit",$order->id) }}','edit_order')"
                             class="text-warning m-1" data-toggle="tooltip" data-placement="bottom"
                             title='Editar la orden #{{ $order->id }}'>
                             <i class="fas fa-2x fa-pencil-alt"></i>
                         </a>

                         <a onclick="eliminar_orden({{ $order->id }})" class="text-danger m-1" data-toggle="tooltip"
                             data-placement="bottom" title='Eliminar la orden #{{ $order->id }}'>
                             <i class="fas fa-2x fa-trash-alt"></i>
                         </a>
                         <form id="eliminar{{ $order->id }}" method="POST"
                             action="{{ route('order.destroy',$order->id) }}" accept-charset="UTF-8">
                             <input name="_method" type="hidden" value="DELETE" />
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
 <script type="text/javascript">
     $(function () {
         $('[data-toggle="tooltip"]').tooltip()
     })
     $(document).ready(function () {
         var currentdate = new Date();
         moment.locale('es');
         var datetime = moment().format('DD MMMM YYYY, h-mm-ss a');
         var titulo_archivo = "Lista de ordenes (" + datetime + ")";
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
