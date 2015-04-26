/**
 * Created by Jacob on 4/26/15.
 */
function findUser(){
    var input = document.getElementById('searchText').value;
    $.ajax({
        data: 'searchText=' + input,
        url: 'Search.php',
        method: 'POST',
        success: function(msg) {
            var name = JSON.parse(msg);
            $("p").text(name);
        }

    })
}