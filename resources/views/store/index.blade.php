@extends('layouts.dashboard.main')
@section('template_title')
Página principal | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css" />
<link href="{{ asset('css/store/style.css') }}" rel="stylesheet">
@endsection
@section('content')
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
                            <span>
                                <i class="fas fa-home fa-lg"></i>
                                <a href="{{ route("store.index") }}">Página principal</a>
                                /
                                @if ($products->count() === 1)
                                Un producto
                                @elseif ($products->count() > 1)
                                {{ $products->count() }} productos
                                @else
                                No hay productos
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
                        <section class="section pt-4">

                            <!-- Grid row -->
                            <div class="row">

                                @if($products->count() > 0)

                                @foreach($products as $key => $product)
                                <!--Grid column-->
                                <div class="col-6 col-lg-4 mb-4">

                                    <!--Card-->
                                    <div
                                        class="card card-ecommerce card-producto-img-store hoverable h-100 z-depth-1 list-card">

                                        <!--Card image-->
                                        <div
                                            class="view overlay hoverable waves-effect z-depth-1 zoom div img-list-card">
                                            <img src="{{ asset($product->image_url) }}"
                                                class="img-fluid rounded img-thumbnail img-store" alt="img"
                                                onerror=this.src="{{ asset('img/dashboard/404.png')  }}">
                                            <a
                                                onclick="mostrar_modal('{{ route("order.create",$product->id) }}','create_order')">
                                                <div class="mask rgba-white-slight"></div>
                                            </a>
                                        </div>
                                        <!--Card image-->

                                        <!--Card content-->
                                        <div class="card-body">
                                            <!--Category & Title-->

                                            <h5 class="card-title mb-1 h5-responsive navy-text  hover-red"><strong><a
                                                        onclick="mostrar_modal('{{ route("order.create",$product->id) }}','create_order')">{{ $product->name }}</a></strong>
                                            </h5>


                                            <!--Card footer-->
                                            <div class="card-footer pb-0">
                                                <div class="row mb-0">
                                                    <span class="float-left">
                                                        <h5 class="h5-responsive"><span
                                                                class="badge bg-color-gradient-success hoverable">
                                                                @money($product->price)
                                                            </span></h5>
                                                    </span>
                                                    <span class="float-left">
                                                        <a onclick="mostrar_modal('{{ route("order.create",$product->id) }}','create_order')"
                                                            class="float-right" data-toggle="tooltip"
                                                            data-placement="bottom" title="Comprar"><i
                                                                class="fas fa-lg fa-shopping-cart ml-3 hover-red"></i></a>
                                                    </span>

                                                </div>
                                            </div>

                                        </div>
                                        <!--Card content-->

                                    </div>
                                    <!--Card-->

                                </div>
                                <!--Grid column-->

                                @endforeach
                                @else
                                <div class="col-12">
                                    <div class="d-flex justify-content-center">
                                        <h1 class="h1-responsive error-display hoverable">
                                            No se encontraron productos
                                        </h1>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <!--Grid row-->

                            <!--Grid row-->
                            <div class="row justify-content-center mb-4">
                                {{ $products->links() }}
                            </div>
                            <!--Grid row-->
                        </section>
                        <!-- /.Products Grid -->
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
@endsection
@section('js_links')
<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/messages_es.js') }}"></script>


<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

</script>
@endsection
