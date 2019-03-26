$(document).ready(function() {
    var datatable = setupDatatable();

    $(".filter").change(datatable.draw);
});

function setupDatatable() {
    return $('#table_phone_numbers').DataTable({
        dom: "tpri",
        ordering: false,
        serverSide: true,
        ajax: {
            url: '/phoneNumbers',
            data: function(data) {
                data.countryCode = $("#countryCode").val();
                data.phoneNumberState = $("#phoneNumberState").val();
            }
        }
    });
}

