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

    $("#cekBukti").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var transaksi = button.data("bukti");
        var modal = $(this);

        // Format number dengan titik sebagai pemisah ribuan
        var jumlahFormat = new Intl.NumberFormat("id-ID").format(
            transaksi.jumlah
        );

        // Set data ke modal
        modal
            .find("#buktiPembayaranImg")
            .attr(
                "src",
                transaksi.gambar
                    ? "/storage/" + transaksi.gambar
                    : "https://via.placeholder.com/500x300?text=Bukti+Tidak+Tersedia"
            );
        modal.find("#jenisTransaksiText").text(transaksi.jenis_transaksi);
        modal.find("#jumlahTransaksiText").text(jumlahFormat);
        modal.find("#tanggalTransaksiText").text(transaksi.tanggal);
        modal.find("#statusTransaksiText").text(transaksi.status_transaksi);
        modal
            .find("#keteranganTransaksiText")
            .text(transaksi.keterangan || "-");
        modal.find("#transaksiId").val(transaksi.id);
        modal.find("#userId").val(transaksi.user_id);
        modal.find("#jumlah").val(transaksi.jumlah);

        // Tampilkan tombol action hanya untuk status pending
        if (transaksi.status_transaksi === "pending") {
            modal.find("#actionButtons").show();
        } else {
            modal.find("#actionButtons").hide();
        }
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
