$(function() {
    //Submit checkEmp form
    $('#empLog-form').submit(function(e) {
        e.preventDefault();
        var empID = $("#empID").val();

        $.ajax({
            type: "POST",
            url: "ajax/getEmpLog_ajax.php",
            data: empID,
            cache: false,
            contentType: false,
            processData: false,
            dataType:"text",
            success: function(){},
            error: function () {
                alert ("Error");
            }, complete: function(){}
        });
    });
});