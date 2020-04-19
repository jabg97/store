<!-- Central Modal Medium Info -->
<div class="modal fade" id="modal_create_order" tabindex="-1" role="dialog" aria-labelledby="modal_create_order"
    aria-hidden="true">
    <div class="modal-dialog modal-notify modal-secondary modal-lg" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->

            <div class="modal-header bg-color-gradient-success">
                <p class="heading lead"><i class="fas fa-plus fa-lg"></i> Registrar Orden</p>


                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->


            <form id="order_form" method="POST" action="#" accept-charset="UTF-8">
                <input type="hidden" id="url_send" value="{{ route('order.store') }}" />
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-plus fa-4x mb-3 animated rotateIn text-success"></i>
                        <h4>
                            @if($product)
                            Comprar "{{$product->name}}"
                            @else
                            Registrar Orden
                            @endif
                        </h4>
                    </div>
                    <hr />
                    {{ csrf_field() }}


                    <!-- Grid row -->
                    <div class="form-row">

                        <!-- Grid column -->
                        <div class="col-md-6">

                            <!-- Material input -->
                            <div class="md-form">
                                <i class="far fa-user prefix"></i>
                                <input type="text" required id="costumer_name" name="costumer_name"
                                    class="form-control validate" maxlength="80">
                                <label for="costumer_name" data-error="Error" data-success="Correcto">Nombre *</label>
                            </div>

                        </div>

                        <!-- Grid column -->


                        <!-- Grid column -->
                        <div class="col-md-6">
                            <!-- Material input -->
                            <div class="md-form">
                                <i class="far fa-envelope prefix"></i>
                                <input type="email" required id="costumer_email" name="costumer_email"
                                    class="form-control validate" maxlength="120">
                                <label for="costumer_email" data-error="Error" data-success="Correcto">Email *</label>
                            </div>

                        </div>

                        <!-- Grid column -->

                    </div>
                    <!-- Grid row -->

                    <!-- Grid row -->
                    <div class="form-row">
                        <!-- Grid column -->
                        <div class="col-md-6">

                            <!-- Material input -->
                            <div class="md-form">
                                <i class="fas fa-mobile-alt prefix"></i>
                                <input type="tel" required id="costumer_mobile" name="costumer_mobile"
                                    class="form-control validate" maxlength="40">
                                <label for="costumer_mobile" data-error="Error" data-success="Correcto">Teléfono móvil
                                    *</label>
                            </div>

                        </div>

                        <!-- Grid column -->



                        <!-- Grid column -->
                        <div class="col-md-6" style="padding-top:5px;">
                            <i class="fas fa-box-open"></i>
                            <small for="product_id">Producto *</small>
                            <select required class="form-control" id="product_id" name="product_id">
                                @if($product)
                                <option selected value="{{ $product->id }}">{{ $product->name }}</option>
                                @endif
                                @if($products && $products->count() > 0)
                                @foreach($products as $key => $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                                @endif
                            </select>

                        </div>

                        <!-- Grid column -->


                    </div>
                    <!-- Grid row -->

                </div>

                <!--Footer-->
                <div class="modal-footer">
                    <a onclick="validar()"
                        class="waves-effect btn bg-color-gradient-success btn-success btn-lg hoverable">
                        <i class="fas fa-lg fa-plus"></i>
                        Registrar
                    </a>
                </div>

            </form>
        </div>
        <!--/.Content-->
    </div>
</div>
<!-- Central Modal Medium Info-->

<script type="text/javascript">
    $(document).ready(function (e) {
        $(".form-control").trigger("change");
    });

    $('#product_id').select2({
        placeholder: "Producto",
        theme: "material",
        language: "es"
    });

    $(".select2-selection__arrow")
        .addClass("fas fa-chevron-down");

    function validar() {
        $("#order_form").validate({
            lang: 'es',
            errorPlacement: function (error, element) {
                $(element).parent().after(error);
            }
        });

        if ($("#order_form").valid()) {
            $("#order_form").submit();
        }
    }

    $("#order_form").submit(function (e) {
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

</script>
