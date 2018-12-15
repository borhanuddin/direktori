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
                    '<dt>Alamat</dt>' +
                    '<dd>' + d.org_alamat + '</dd>' +
                    '<dt>Poskod</dt>' +
                    '<dd>' + d.org_poskod + '</dd>' +
                    '<dt>Negeri</dt>' +
                    '<dd>' + d.org_negeri + '</dd>' +
                    '<dt>No. Tel</dt>' +
                    '<dd>' + d.org_tel + '</dd>' +
                    '<dt>No. Fax</dt>' +
                    '<dd>' + d.org_fax + '</dd>' +
                    '<dt>Emel</dt>' +
                    '<dd>' + d.org_emel + '</dd>' +
                '</dl>' +
            '</div>' +
            '<div class="col-md-6" style="margin-bottom: 0;">' +
                '<dl class="dl-horizontal" style="margin-bottom: 0;">' +
                    '<dt>Papar Sub-Organisasi</dt>' +
                    '<dd>' + d.org_papar_sub + '</dd>' +
                    '<dt>Bilangan Sub-Organisasi</dt>' +
                    '<dd>' + d.org_sub_bil + '</dd>' +
                    '<dt>Bilangan Penjawatan</dt>' +
                    '<dd>' + d.org_pjwn_bil + '</dd>' +
                    '<dt>Catatan</dt>' +
                    '<dd>' + d.org_catatan.replace(/\n/g, "<br />") + '</dd>' +
                '</dl>' +
            '</div>' +
        '</div>' +
        '<div class="row">' +
            '<div class="col-md-12 text-right" style="margin-bottom: 0;">' +
                '<a href="' + window.location.href + '/kemaskini/' + d.org_id + '" class="btn bg-mdi waves-effect" style="margin-right: 10px;" role="button">KEMASKINI</a>' +
                '<button type="button" class="btn btn-danger waves-effect" onclick="deleteOrg(' + d.org_id + ', \'' + d.org_nama + '\')" data-id="' + d.org_id + '">HAPUS</button>' +
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
        "ajax": base_url + '/pentadbir/organisasi/ajax_datatables',
        "columns": [
            { "className": 'details-control', "data": "org_id" },
            { "className": 'details-control', "data": "org_nama" },
            { "className": 'details-control', "data": "f_org_sub" },
            { "className": 'details-control', "data": "org_hirarki" }
        ],
        "columnDefs": [{ "targets": [0], "visible": false, "searchable": false}],
        "createdRow": function (row, data) {
            // highlight new added data
            if (data['org_id'] === document.getElementById('inpNew').value) {
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

function deleteOrg(id, org) {
    
    swal({
        html: true,
        title: "HAPUS ORGANISASI INI?",
        text: "Organisasi <strong>" + org + "</strong> akan dihapuskan secara kekal di pangkalan data!",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "BATAL",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "HAPUS ORGANISASI!",
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true
    }, function (isConfirm) {
        if (isConfirm) {

            $.ajax({
                type: "GET",
                url: base_url + "/pentadbir/organisasi/hapus/" + id,
                success: function (status) {
                    if ('success' === status) {
                        swal({
                            html: true,
                            title: "HAPUS BERJAYA!",
                            text: "Organisasi <strong>" + org + "</strong> berjaya dihapuskan.",
                            type: "success"
                        });
                        $("#tblSenaraiOrganisasi").DataTable().ajax.reload();
                    } else {
                        console.log(status);
                        swal({
                            html: true,
                            title: "HAPUS GAGAL!",
                            text: "Operasi hapus organisasi <strong>" + org + "</strong> tidak berjaya!<br /><br /><code>" + status + "</code>",
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
                text: "Operasi hapus organisasi <strong>" + org + "</strong> dibatalkan.",
                type: "error"
            });
        }
    });
    
}