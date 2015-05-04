/**
 * Created by Jacob on 5/3/15.
 */
function showTable(classId){
    $.ajax({
        data: 'classId=' + classId,
        url: 'Assignments.php',
        method: 'POST',
        success: function(msg) {
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
        }
    });
}
function showList(classId){
    $.ajax({
        data: 'classId=' + classId,
        url: 'Assignments.php',
        method: 'POST',
        success: function (msg) {
            alert(msg);
            try {
                msg = JSON.parse(msg);
            } catch (e) {
                alert("Error generating table");
                return;
            }
            var list = "Select Assignment:<br><select name='assignmentName' onchange='showAssignmentTable(this.value)'>";
            for(var i=0; i<msg.length; i++){
                list += "\r\n<option value='"+msg[i]+"'>"+msg[i]+"</option>";
            }
            document.getElementById('listPrint').innerHTML = list;
        }
    });
}
function showAssignmentTable(assignmentName){
    $.ajax({
        data: 'assignmentName=' + assignmentName,
        url: 'Assignments.php',
        method: 'POST',
        success: function (msg) {
            alert(msg);
            if(msg.length == 0){
                alert("No assignments in that class");
                return;
            }
            try {
                msg = JSON.parse(msg);
            } catch (e) {
                alert("Error generating table");
                return;
            }
            var table = "<table border='2' cellPadding='3'><tr><th colspan='3'>Grades for " + assignmentName +"</th></tr><tr>";
            for(var i = 0; i<msg.length; i++){
                table += "<td>" + msg[i][0] + "</td>";
                table += "<td>" + msg[i][1] + "</td>";
                table += "<td>" + msg[i][2] + "</td></tr>";
            }
            table += "</table>";
            document.getElementById('tablePrint').innerHTML = table;
        }
    });
}