"use strict";

$("#swal-1").click(function () {
    swal("Hello");
});

$("#swal-2").click(function () {
    swal("Good Job", "You clicked the button!", "success");
});

$("#swal-3").click(function () {
    swal("Good Job", "You clicked the button!", "warning");
});

$("#swal-4").click(function () {
    swal("Good Job", "You clicked the button!", "info");
});

$("#swal-5").click(function () {
    swal("Good Job", "You clicked the button!", "error");
});

$(".swal-6").click(function () {
    swal({
        title: translations.deleteConfirmation,
        icon: "warning",
        buttons: {
            cancel: translations.cancel,
            confirm: translations.confirm,
        },
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $(this).closest("form").submit();
        }
    });
});

$("#swal-7").click(function () {
    swal({
        title: translations.deleteConfirmation,
        icon: "danger",
        buttons: {
            cancel: translations.cancel,
            confirm: translations.confirm,
        },
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $(this).closest("form").submit();
        }
    });
});

$("#swal-8").click(function () {
    swal("This modal will disappear soon!", {
        buttons: false,
        timer: 3000,
    });
});
