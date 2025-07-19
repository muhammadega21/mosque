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
    $("#updatePengurus").on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget);
        const pengurus = button.data("pengurus");
        const idPengurus = pengurus.id;

        $("#updatePengurus form").attr(
            "action",
            "pengurus/update/" + idPengurus
        );
        $("#nama2").val(pengurus.nama);
        $("#username2").val(pengurus.username);
        $("#nomor_hp2").val(pengurus.nomor_hp);
    });
    $("#updateKategori").on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget);
        const kategori = button.data("kategori");
        const idPengurus = kategori.id;

        $("#updateKategori form").attr(
            "action",
            "kategori/update/" + idKategori
        );

        $("#nama_kategori2").val(kategori.nama_kategori);
    });
    $("#updateKasMasjid").on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget);
        const kas = button.data("kas");
        const kategori = button.data("kategori");

        // Set form action URL
        const form = $(this).find("form");
        form.attr("action", "kas_masjid/update/" + kas.id);

        // Populate kategori options
        const kategoriSelect = $("#kategori2");
        kategoriSelect.empty();
        kategori.forEach((kategori) => {
            kategoriSelect.append(
                new Option(
                    kategori.nama_kategori,
                    kategori.id,
                    false,
                    kategori.id === kas.kategori_id
                )
            );
        });

        $("#jumlah2").val(kas.jumlah);
        $("#keterangan2").val(kas.keterangan);
        $("#tanggal2").val(kas.tanggal);
        $("#status_transaksi2").val(kas.status_transaksi);
    });

    $("#updateKegiatan").on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget);
        const kegiatan = button.data("kegiatan");
        const idKegiatan = kegiatan.id;

        $("#updateKegiatan form").attr(
            "action",
            "kegiatan_masjid/update/" + idKegiatan
        );

        $("#judul2").val(kegiatan.judul);
        $("#tgl_post2").val(kegiatan.tgl_post);
        $("#deskripsi2").val(kegiatan.deskripsi);
        $("#oldImage").val(kegiatan.gambar);
    });

    $("#updateInformasi").on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget);
        const informasi = button.data("informasi");
        const idInformasi = informasi.id;

        $("#updateInformasi form").attr(
            "action",
            "informasi_masjid/update/" + idInformasi
        );

        $("#judul2").val(informasi.judul);
        $("#tgl_post2").val(informasi.tgl_post);
        $("#deskripsi2").val(informasi.deskripsi);
        $("#oldImage").val(informasi.gambar);
    });

    $("#showBuktiDonasi").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);

        modal.find("#buktiDonasiImage").attr("src", button.data("gambar"));
        modal.find("#donaturNama").text(button.data("nama"));
        modal.find("#donaturTanggal").text(button.data("tanggal"));
        modal.find("#donaturJumlah").text(button.data("jumlah"));
    });

    $("#showValidasiDonasi").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);

        $("#showValidasiDonasi form").attr(
            "action",
            "kas_masjid/validasi_donasi/" + button.data("id")
        );

        modal.find("#buktiDonasiImage").attr("src", button.data("gambar"));
        modal.find("#donaturNama").text(button.data("nama"));
        modal.find("#donaturTanggal").text(button.data("tanggal"));
    });
});
function approvePayment() {
    $("#action").val("approve");
    $("#approvalForm").attr("action", "keuangan/approve").submit();
}

function rejectPayment() {
    $("#action").val("reject");
    $("#approvalForm").attr("action", "keuangan/reject").submit();
}

$(document).ready(function () {
    $(document).on("keyup", ".search-table", function () {
        const searchText = $(this).val().toLowerCase();
        const table = $(this)
            .closest("section, .card, .container")
            .find("table");

        table.find("tbody tr").each(function () {
            const rowText = $(this).text().toLowerCase();
            $(this).toggle(rowText.indexOf(searchText) > -1);
        });
    });
});
