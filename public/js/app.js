$(document).ready(function () {
    $("#loading").fadeOut("slow");
    if (window.matchMedia('(max-width: 991px)').matches) {
        $(".page-wrapper").removeClass("toggled");
    }
});
$(".btn-card-fullscreen").click(function (e) {
    var $this = $(this);
    if ($this.children('svg').hasClass('fa-expand')) {
        $this.children('svg').removeClass('fa-expand');
        $this.children('svg').addClass('fa-compress');
    } else if ($this.children('svg').hasClass('fa-compress')) {
        $this.children('svg').removeClass('fa-compress');
        $this.children('svg').addClass('fa-expand');
    }
    $(this).closest('.card').toggleClass('card-fullscreen');
});

$(".btn-card-show").click(function (e) {
    var $this = $(this);
    if ($this.children('svg').hasClass('fa-eye-slash')) {
        $this.children('svg').removeClass('fa-eye-slash');
        $this.children('svg').addClass('fa-eye');
        $this.removeClass('btn-outline-danger');
        $this.addClass('btn-outline-success');
    } else if ($this.children('svg').hasClass('fa-eye')) {
        $this.children('svg').removeClass('fa-eye');
        $this.children('svg').addClass('fa-eye-slash');
        $this.removeClass('btn-outline-success');
        $this.addClass('btn-outline-danger');
    }
    $(this).closest('.card').children('.card-body').children('.card-content').toggleClass('card-show');
});

$(window).on('resize', function () {
    var win = $(this); //this = window
    if (window.matchMedia('(max-width: 991px)').matches) {
        $(".page-wrapper").removeClass("toggled");
    } else {
        $(".page-wrapper").addClass("toggled");
    }
});


$(".btn-float").on('touch click', function () {

    if ($("#float-menu").is(":visible")) {
        $("#float-menu").fadeOut("fast");
        $("ul.ul-share").hide();
    } else {
        $("#float-menu").fadeIn("fast");
        $("ul.ul-share").show();
    }
});


$("ul.ul-share li a").on('touch click', function () {
    $("#float-menu").fadeOut("fast");
    $("ul.ul-share").hide();
});

$("#float-menu").on('touch click', function () {
    $(this).fadeOut("fast");
    $("ul.ul-share").hide();
});

$("body").on('click', '.dataTables_filter label svg', function () {
    var inp = $(this).next();
    inp.animate({
        width: 'toggle'
    }, 400, "swing");
});

function cargar_div(url_send, method_send, data_send, div_target, asincronico, modal) {
    inicio_carga()
    $.ajax({
            method: method_send,
            url: url_send,
            async: asincronico,
            data: data_send
        })
        .done(function (response) {
            try {
                $("#container_" + div_target).html(response);
                if (modal) {
                    $("#modal_" + div_target).modal("show");
                }
            } catch (err) {
                console.log(err.message);
            }
        })
        .fail(function (response) {
            console.log(response.responseJSON);
            swal({
                title: 'Error ' + response.status,
                text: response.statusText,
                type: 'error',
                confirmButtonText: '<i class="fas fa-exclamation-triangle fa-lg"></i> Continuar',
                showCloseButton: true,
                confirmButtonClass: 'btn btn-danger bg-color-gradient-danger',
                buttonsStyling: false,
                animation: false,
                customClass: 'animated zoomIn',
            });
        })
        .always(function () {
            fin_carga()
        });
}

function inicio_carga() {
    $(".se-pre-con").fadeIn("slow");
}

function fin_carga() {
    $(".se-pre-con").fadeOut("slow");
}

function mostrar_modal(url_send, div_target) {
    cargar_div(url_send, "GET", {}, div_target, true, true);
}

function mostrar_div(url_send, div_target) {
    cargar_div(url_send, "GET", {}, div_target, true, false);
}
