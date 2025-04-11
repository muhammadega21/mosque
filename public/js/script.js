// Data table
new DataTable("#datatable", {
    layout: {
        bottomEnd: {
            paging: {
                firstLast: false,
            },
        },
    },
    scrollX: true,
});

// Confirm Delete
function confirm(e) {
    e.preventDefault();
    const url = e.currentTarget.getAttribute("href");

    swal({
        title: "Anda Yakin?",
        text: "Data ini akan dihapus permanent",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((cancel) => {
        if (cancel) {
            window.location.href = url;
        }
    });
}

// Select2
$(document).ready(function () {
    const parent = $(".select2").data("parent");

    $(".select2").select2({
        theme: "bootstrap",
        dropdownParent: $("#" + parent),
    });
});
