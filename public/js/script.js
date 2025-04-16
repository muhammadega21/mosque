// Select2
$(document).ready(function () {
    const parent = $(".select2").data("parent");

    $(".select2").select2({
        theme: "bootstrap",
        dropdownParent: $("#" + parent),
    });
});

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
