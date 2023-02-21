$(function() {
    //submit form
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
            dataType:"json",
            success: function(data){
                document.getElementById('hoursWorked').value = data[0];
                document.getElementById('minsLate').value = data[1];
            },
            error: function () {
                alert ("Error");
            }, complete: function(){}
        });
    });
});