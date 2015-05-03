/**
 * Created by Jacob on 5/3/15.
 */
function showTable(classId){
    $.ajax({
        data: 'classId=' + classId,
        url: 'Assignments.php',
        method: 'POST',
        success: function(msg) {
            alert(msg);
            try{
                msg = JSON.parse(msg);
            }catch(e){
                alert("Error generating table");
                return;
            }
            var grade = msg[0][2];
            var table = "<table border='2' cellPadding='3'><tr><th colspan='2'>Assignments for " + classId + " Current Grade: "+ grade.toFixed(2) +"</th></tr><tr>";
            for(var i = 0; i<msg.length; i++){
                table += "<td>" + msg[i][0]+ "</td>";
                table += "<td>" + msg[i][1] + "</td></tr>";
            }
            table += "</table>";
            document.getElementById('tablePrint').innerHTML = table;
        },
        error: function(xhr, status, error) {
            // check status && error
            alert(msg);
            alert("Status: " + status + " Error: " + error);
        }
    });
}