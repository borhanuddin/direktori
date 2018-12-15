/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    
    function format(d, base_url) {
        // `d` is the original data object for the row
        return '' + 
        '<div class="row">' +
            '<div class="col-md-6" style="margin-bottom: 0;">' +
                '<dl class="dl-horizontal" style="margin-bottom: 0;">' + 
                    '<dt>MyKad</dt>' +
                    '<dd>' + d.staf_mykad + '</dd>' +
                    '<dt>Taraf</dt>' +
                    '<dd>' + d.staf_taraf + '</dd>' +
                    '<dt>Emel</dt>' +
                    '<dd>' + d.staf_emel + '</dd>' +
                '</dl>' +
            '</div>' +
            '<div class="col-md-6" style="margin-bottom: 0;">' +
                '<dl class="dl-horizontal" style="margin-bottom: 0;">' +
                    '<dt>Status</dt>' +
                    '<dd>' + d.staf_status + '</dd>' +
                    '<dt>Catatan</dt>' +
                    '<dd>' + d.staf_catatan.replace(/\n/g, "<br />") + '</dd>' +
                '</dl>' +
            '</div>' +
        '</div>' +
        '<div class="row">' +
            '<div class="col-md-12 text-right" style="margin-bottom: 0;">' +
                '<a href="' + window.location.href + '/kemaskini/' + d.staf_id + '" class="btn bg-mdi waves-effect" style="margin-right: 10px;" role="button">KEMASKINI</a>' +
                '<button type="button" class="btn btn-danger waves-effect" onclick="deleteStaf(' + d.staf_id + ', \'' + d.staf_nama.replace(/"/g, "&rdquo;").replace(/'/g, "&rsquo;") + '\')" data-id="' + d.staf_id + '">HAPUS</button>' +
            '</div>' +
        '</div>';
    }
    
    var table = $(".table").DataTable({
        "stateSave": true, // Disable and enable this after makin changes to below coding, or clear cookies on browser
        "order": [],
        "language": {
            search : "Carian Dalam Jadual:",
            lengthMenu : "Papar _MENU_ rekod",
            info: "Papar _START_ hingga _END_ daripada _TOTAL_ rekod",
            paginate: {
                first:      "Mula",
                previous:   "Sebelumnya",
                next:       "Seterusnya",
                last:       "Akhir"
            }
        },
        "ajax": base_url + '/pentadbir/staf/ajax_datatables',
        "columns": [
            { "className": 'details-control', "data": "staf_id", "visible": false },
            { "className": 'details-control', "data": "staf_mykad", "visible": false },
            { "className": 'details-control', "data": "staf_gelaran" },
            { "className": 'details-control', "data": "staf_nama" },
            { "className": 'details-control', "data": "staf_jawatan" },
            { "className": 'details-control', "data": "staf_gred" },
            { "className": 'details-control', "data": "staf_taraf", "visible": false },
            { "className": 'details-control', "data": "staf_emel", "visible": false },
            { "className": 'details-control', "data": "staf_status", "visible": false }
        ], 
        "columnDefs": [ { "targets": 0, "searchable": false } ],
        "createdRow": function (row, data) {
            // highlight new added data
            if (data['staf_id'] === document.getElementById('inpNew').value) {
                $('td', row).parent().addClass('info');
            }
        },
        "initComplete": function (settings, json) {
            // if new data added, go to page
            if (0 < document.getElementById('inpNew').value) {
                table.page.jumpToData( document.getElementById('inpNew').value, 0 );
            }
        }
    });
    
    // Add event listener for opening and closing details
    $('.table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });
    
});

function deleteStaf(id, staf) {
    
    swal({
        html: true,
        title: "HAPUS STAF INI?",
        text: "Staf <strong>" + staf + "</strong> akan dihapuskan secara kekal di pangkalan data!<br />Sila pastikan staf ini <strong>bukan pentadbir</strong> dan <strong>tiada dalam penjawatan</strong>.",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "BATAL",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "HAPUS STAF!",
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true
    }, function (isConfirm) {
        if (isConfirm) {

            $.ajax({
                type: "GET",
                url: base_url + "/pentadbir/staf/hapus/" + id,
                success: function (status) {
                    if ('success' === status) {
                        swal({
                            html: true,
                            title: "HAPUS BERJAYA!",
                            text: "Staf <strong>" + staf + "</strong> berjaya dihapuskan.",
                            type: "success"
                        });
                        $("#tblSenaraiStaf").DataTable().ajax.reload();
                    } else {
                        console.log(status);
                        swal({
                            html: true,
                            title: "HAPUS GAGAL!",
                            text: "Operasi hapus staf <strong>" + staf + "</strong> tidak berjaya!<br /><br /><code>" + status + "</code>",
                            type: "error"
                        });
                    }
                }
            }).error(function () {
                swal({
                    html: true,
                    title: "RALAT AJAX!",
                    text: "Operasi hapus tidak berjaya dilaksanakan kerana masalah AJAX!<br />Sila hubungi pembangun sistem ini (bob).",
                    type: "error"
                });
            });

        } else {
            swal({
                html: true,
                title: "OPERASI DIBATALKAN!",
                text: "Operasi hapus staf <strong>" + staf + "</strong> dibatalkan.",
                type: "error"
            });
        }
    });
    
}