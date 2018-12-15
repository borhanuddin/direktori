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
                    '<dt>Gelaran Penyelia</dt>' +
                    '<dd>' + d.pjwn_penyelia_pjwn_gelaran + '</dd>' +
                    '<dt>No. Tel</dt>' +
                    '<dd>' + d.pjwn_tel + '</dd>' +
                    '<dt>Sambungan</dt>' +
                    '<dd>' + d.pjwn_tel_samb + '</dd>' +
                '</dl>' +
            '</div>' +
            '<div class="col-md-6" style="margin-bottom: 0;">' +
                '<dl class="dl-horizontal" style="margin-bottom: 0;">' +
                    '<dt>Hirarki</dt>' +
                    '<dd>' + d.pjwn_hirarki + '</dd>' +
                    '<dt>Catatan</dt>' +
                    '<dd>' + d.pjwn_catatan.replace(/\n/g, "<br />") + '</dd>' +
                '</dl>' +
            '</div>' +
        '</div>' +
        '<div class="row">' +
            '<div class="col-md-12 text-right" style="margin-bottom: 0;">' +
                '<a href="' + window.location.href + '/kemaskini/' + d.pjwn_id + '" class="btn bg-mdi waves-effect" style="margin-right: 10px;" role="button">KEMASKINI</a>' +
                '<button type="button" class="btn btn-danger waves-effect" onclick="deletePjwn(' + d.pjwn_id + ', \'' + d.pjwn_gelaran + '\')" data-id="' + d.pjwn_id + '">HAPUS</button>' +
            '</div>' +
        '</div>';
    }
    
    var table = $(".table").DataTable({
        stateSave: true,
        "order": [],
        language: {
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
        "ajax": base_url + '/pentadbir/penjawatan/ajax_datatables',
        "columns": [
            { "className": 'details-control', "data": "pjwn_id" },
            { "className": 'details-control', "data": "pjwn_gelaran" },
            { "className": 'details-control', "data": "staf_nama" },
            { "className": 'details-control', "data": "pjwn_kod" },
            { "className": 'details-control', "data": "pjwn_gred" },
            { "className": 'details-control', "data": "f_org_nama" }
        ],
        "columnDefs": [{ "targets": [0], "visible": false, "searchable": false}],
        "createdRow": function (row, data) {
            // highlight new added data
            if (data['pjwn_id'] === document.getElementById('inpNew').value) {
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
    
    $("#slcOrg").change(function() {
        var org_id = $("#slcOrg").val();
        var url = base_url + 'pentadbir/penjawatan/ajax_datatables/';
        
        if (0 < org_id) {
            url = base_url + 'pentadbir/penjawatan/ajax_datatables_reload/' + org_id;
        }
        table.ajax.url(url);
        table.ajax.reload();
    });
    
});

function deletePjwn(id, pjwn) {
    
    swal({
        html: true,
        title: "HAPUS PENJAWATAN INI?",
        text: "Penjawatan <strong>" + pjwn + "</strong> akan dihapuskan secara kekal di pangkalan data!",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "BATAL",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "HAPUS PENJAWATAN!",
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true
    }, function (isConfirm) {
        if (isConfirm) {

            $.ajax({
                type: "GET",
                url: base_url + "/pentadbir/penjawatan/hapus/" + id,
                success: function (status) {
                    if ('success' === status) {
                        swal({
                            html: true,
                            title: "HAPUS BERJAYA!",
                            text: "Penjawatan <strong>" + pjwn + "</strong> berjaya dihapuskan.",
                            type: "success"
                        });
                        $("#tblSenaraiPenjawatan").DataTable().ajax.reload();
                    } else {
                        console.log(status);
                        swal({
                            html: true,
                            title: "HAPUS GAGAL!",
                            text: "Operasi hapus penjawatan <strong>" + pjwn + "</strong> tidak berjaya!<br /><br /><code>" + status + "</code>",
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
                text: "Operasi hapus penjawatan <strong>" + pjwn + "</strong> dibatalkan.",
                type: "error"
            });
        }
    });
    
}