$(document).ready(function () {
    function removeAccents(data) {
        if (data.normalize) {
            // Use I18n API if avaiable to split characters and accents, then remove
            // the accents wholesale. Note that we use the original data as well as
            // the new to allow for searching of either form.
            return data + ' ' + data
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '');
        }
        return data;
    }

    var searchType = jQuery.fn.DataTable.ext.type.search;
    searchType.string = function (data) {
        return !data ?
            '' :
            typeof data === 'string' ?
                removeAccents(data) :
                data;
    };
    searchType.html = function (data) {
        return !data ?
            '' :
            typeof data === 'string' ?
                removeAccents(data.replace(/<.*?>/g, '')) :
                data;
    };
});
$(function () {
    $(document).ready(function () {
        $('#tabela').fadeIn().css("display", "block");
    });
    $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
});