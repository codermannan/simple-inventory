
//==========================================================
//  Time and Date Pickers
//==========================================================

$(function() {
    $('.timepicker').timepicker();

    $('.datepicker').datepicker({
        autoclose: true,
        todayBtn: "linked"
    });

    $('.monthyear').datepicker({
        autoclose: true,
        startView: 1,
        format: 'yyyy-mm',
        minViewMode: 1
    });
    $('.years').datepicker({
        startView: 2,
        format: 'yyyy',
        minViewMode: 2,
        autoclose: true
    });
});


//==========================================================
//  Tooltips icon
//==========================================================

$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})

//==========================================================
//  Alert hide time set
//==========================================================

setTimeout(function() {
    $(".alert").fadeOut("slow", function() {
        $(".alert").remove();
    });

}, 3000);

//==========================================================
//  Select All Checkbox
//==========================================================

$(function() {

    $('#parent_present').on('change', function() {
        $('.child_present').prop('checked', $(this).prop('checked'));
    });
    $('.child_present').on('change', function() {
        $('#parent_present').prop($('.child_present:checked').length ? true : false);
    });
    $('#parent_absent').on('change', function() {
        $('.child_absent').prop('checked', $(this).prop('checked'));
    });
    $('.child_absent').on('change', function() {
        $('#parent_absent').prop($('.child_absent:checked').length ? true : false);
    });
});


//==========================================================
//  Print Area Select
//==========================================================
function print_invoice(printableArea) {

    var table = $('#dataTables-example').DataTable();
    table.destroy();

    //$('#dataTables-example').attr('id','none');
    var printContents = document.getElementById(printableArea).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    //$('table').attr('id','dataTables-example');
    location.reload(document.body.innerHTML = originalContents);
    //document.body.innerHTML = originalContents;
}
