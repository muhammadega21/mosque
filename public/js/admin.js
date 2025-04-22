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
    }).then((confirm) => {
        if (confirm) {
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
    $("#updateKategori").on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget);
        const kategori = button.data("kategori");
        const idKategori = kategori.id;

        $("#updateKategori form").attr(
            "action",
            "kategori/update/" + idKategori
        );

        $("#nama_kategori2").val(kategori.nama_kategori);
    });
    $("#updateKeuangan").on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget);
        const keuangan = button.data("keuangan");
        const kategori = button.data("kategori");

        // Set form action URL
        const form = $(this).find("form");
        form.attr("action", "keuangan/update/" + keuangan.id);

        // Set form values
        $("#jenis_transaksi2").val(keuangan.jenis_transaksi);

        // Populate kategori options
        const kategoriSelect = $("#kategori2");
        kategoriSelect.empty();
        kategori.forEach((kategori) => {
            kategoriSelect.append(
                new Option(
                    kategori.nama_kategori,
                    kategori.id,
                    false,
                    kategori.id === keuangan.kategori_id
                )
            );
        });

        $("#jumlah2").val(keuangan.jumlah);
        $("#keterangan2").val(keuangan.keterangan);
        $("#tanggal2").val(keuangan.tanggal);
        $("#status_transaksi2").val(keuangan.status_transaksi);
    });
});
