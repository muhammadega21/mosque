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

$(document).ready(function () {
    $("#updateJamaah").on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget);
        const jamaah = button.data("jamaah");
        const idJamaah = jamaah.id;

        $("#updateJamaah form").attr("action", "jamaah/update/" + idJamaah);

        $("#nama2").val(jamaah.user_data.nama);
        $("#nomor_hp2").val(jamaah.user_data.nomor_hp);
        $("#alamat2").val(jamaah.user_data.alamat);
    });
});
