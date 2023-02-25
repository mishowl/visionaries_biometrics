$(function() {
    //submit form
    $('#empLog-form').submit(function(e) {
        e.preventDefault();
        var empID = $("#empID").val();

        $.ajax({
            type: "POST",
            url: "ajax/getEmpLog_ajax.php",
            data: {"empID" : empID},
            cache: false,
            dataType:"json",
            success: function(data){
                document.getElementById('hoursWorked').value = data[0];
                document.getElementById('minsLate').value = data[1];
                document.getElementById('logDate').value = data[2];
                document.getElementById('morningTimeIn').value = data[3];
                document.getElementById('morningTimeOut').value = data[4];
                document.getElementById('morningStatus').value = data[5];
                document.getElementById('afternoonTimeIn').value = data[6];
                document.getElementById('afternoonTimeOut').value = data[7];
                document.getElementById('afternoonStatus').value = data[8];
            },
            error: function () {
                document.getElementById('hoursWorked').value = "";
                document.getElementById('minsLate').value ="";
                document.getElementById('logDate').value = "";
                document.getElementById('morningTimeIn').value = "";
                document.getElementById('morningTimeOut').value = "";
                document.getElementById('morningStatus').value = "";
                document.getElementById('afternoonTimeIn').value = "";
                document.getElementById('afternoonTimeOut').value = "";
                document.getElementById('afternoonStatus').value = "";

                swal.fire({
                    icon: 'error',
                    text: 'Employee not found in Database!'
                })
            }, complete: function(){}
        });
    });
});