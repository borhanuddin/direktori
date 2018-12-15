$(function () {
    $('.js-basic-example').DataTable({
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
        }
    });

    //Show Hide Card or Table
    $("#paparan_kad").show();
    $("#paparan_jadual").hide();
    $("#chkPaparan").prop('checked', true).change(function() {
        if ($(this).is(':checked')) {
            $('#paparan_jadual').slideUp( function() { $('#paparan_kad').slideDown(); });
        } else {
            $('#paparan_kad').slideUp( function() { $('#paparan_jadual').slideDown(); });
        }
    });
    
    $("#chkSidebar").click(function(){
        if($(this).is(':checked')) {
            $("#leftsidebar").show();
            $(".content").css("margin-left","315px");
        } else {
            $("#leftsidebar").hide();
            $(".content").css("margin-left","15px");
        }
    });
    
});
