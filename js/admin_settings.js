/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    
    $('.number').countTo();
    
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