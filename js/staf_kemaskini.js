/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    
    $(":input").inputmask({ greedy: false });
    
    //Textare auto growth
    autosize($('textarea.auto-growth'));
    
    $(".typeahead").focus(function () {
        $(this).typeahead({
            source: $(this).data("json")
        });
    });
    
    // SELECT to follow material design animation
    $("select").change(function () {
        if ($(this).val() === "") {
            $(this).closest( "div.form-line" ).removeClass('focused');
        } else {
            $(this).closest( "div.form-line" ).addClass('focused');
        }
    });
    
});
