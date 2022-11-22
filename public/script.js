$(document).ready(function () {

    //Save
    $("#save").click(function () {
        var lname = $("#lname").get(0).value;
        var fname = $("#fname").get(0).value;
        $.post("http://www.localhost/api/public/postName",
            JSON.stringify({
                fname: fname,
                lname: lname
            }),
            function (data, status) {
                alert("Data: " + data + "\nStatus: " + status);
            });
    });

    //Display Function
    $("#display").click(function () {

        $.post("http://localhost/api/public/printName",
            function (data, status) {
                var json = JSON.parse(data);
                var row = "";
                for (var i = 0; i < json.data.length; i++) {

                    row = row + "<tr><td>" + json.data[i].lname + "</td><td>" + json.data[i].fname + "</td></tr>";

                }
                $("#data").get(0).innerHTML = row;
            });
    });

    //Search Button
    $("#search").click(function () {

        id = prompt("Enter Student ID");
        //endpoint
        $.post("http://localhost/api/public/searchStudent",
            JSON.stringify(
                //payload
                {
                    id: id
                }
            ),
            function (data, status) {
                //result
                var json = JSON.parse(data);
                $("#fname").get(0).value = json.data[0].fname;
                $("#lname").get(0).value = json.data[0].lname;
                console.log(json);

            });
    });

    //Update
    $("#update").click(function () {

        var fname = $("#fname").get(0).value;
        var lname = $("#lname").get(0).value;
        $.post("http://localhost/api/public/updateStudent",
            JSON.stringify({
                id: id,
                lname: lname,
                fname: fname
            }),
            function (data, status) {

                alert("Data: " + data + "\nStatus: " + status);

            });

    });

    //delete
    $("#delete").click(function () {

        $.post("http://localhost/api/public/deleteStudent",
            JSON.stringify({
                id: id
            }),
            function (data, status) {

                alert("Data: " + data + "\nStatus: " + status);

            });
    });
});