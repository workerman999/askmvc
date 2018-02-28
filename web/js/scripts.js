$(document).ready(function(){
    $('#tree').jstree({
        'core' : {
            'data':
                {
                    'url': 'tree',
                    'dataType': 'json',
                }
        },
        "plugins" : [ "themes", "json_data" ]
    });

    $('#tree').on("changed.jstree", function (e, data) {

        $.ajax({
            'url': 'device',
            'dataType': 'json',
            'data' : {
                id : data.selected[0],
            },
            success: function(rez){
                var properties = JSON.parse(rez);

                for (i = 0; i < 5; i++){
                    $("tablec" + i).empty();
                    for (j = 0; j < 10; j++){
                        $("tables" + j).empty();
                    }
                }

                if (properties.result == "ERROR"){
                    document.getElementById("rezult").innerHTML = 'Данная директория не является объектом';
                } else {
                    document.getElementById("rezult").innerHTML = '';
                    get_table(properties);
                }
            },
        })
    });
});

function get_table(properties) {

    var garnum = properties.objects[0].garnum;
    if  (typeof(garnum) != "undefined"){
        document.getElementById("garnum").innerHTML = garnum;
    } else {
        document.getElementById("garnum").innerHTML = '';
    }

    var gosnum = properties.objects[0].gosnum;
    if  (typeof(gosnum) != "undefined"){
        document.getElementById("gosnum").innerHTML = gosnum;
    } else {
        document.getElementById("gosnum").innerHTML = '';
    }

    var vin = properties.objects[0].vin;
    if  (typeof(vin) != "undefined"){
        document.getElementById("vin").innerHTML = vin;
    } else {
        document.getElementById("vin").innerHTML = '';
    }

    generate_table_controllers(properties);

}

function generate_table_controllers(properties) {

    var arrdevice = properties.objects[0].devices;

    for (i = 0; i < arrdevice.length; i++){

        var body = document.getElementsByTagName("tablec" + i)[0];
        var tbl = document.createElement("table");
        var tblBody = document.createElement("tbody");

        var row = document.createElement("tr");
        var device = properties.objects[0].devices[i];

        for (var j in device) {
            if ((j == 'sensors') || (j == 'id')){
                continue;
            } else {
                var cell = document.createElement("td");
                var cellText = document.createTextNode(j + " - " + device[j]);
                cell.appendChild(cellText);
                row.appendChild(cell);
            }

        }

        tblBody.appendChild(row);
        tbl.appendChild(tblBody);
        body.appendChild(tbl);
        tbl.setAttribute("border", "2");

        generate_table_sensors(properties, i);
    }
}

function generate_table_sensors(properties, i) {

    var body = document.getElementsByTagName("tables" + i)[0];

    var tbl = document.createElement("table");
    var tblBody = document.createElement("tbody");

    var arrdevice = properties.objects[0].devices[i];
    var arrsensors = properties.objects[0].devices[i].sensors;

    for (k = 0; k < arrsensors.length; k++){
        var sensors = properties.objects[0].devices[i].sensors[k];
        var row = document.createElement("tr");

        for (var j in sensors) {
            if ((j == 'conv') || (j == 'id') || (j == 'childs') || (j == 'did')){
                continue;
            } else {
                var cell = document.createElement("td");
                var cellText = document.createTextNode( j + ' - ' + sensors[j]);
                cell.appendChild(cellText);
                row.appendChild(cell);
            }

        }
        tblBody.appendChild(row);
    }

    tbl.appendChild(tblBody);
    body.appendChild(tbl);
    tbl.setAttribute("border", "2");
}

function initMap() {

    var uluru = {lat: 55.34, lng: 86.07};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: uluru
    });

    $.ajax({
        'url': 'http://195.93.229.66:4242/main?func=readdicts&dicts=objects&uid=1cdea3c3-957d-4789-afd9-2cbc18a5a1f7&out=json',
        'dataType': 'json',
        success: function (data) {
            for (i = 0; i < data.objects.length; i++){
                console.log(data.objects.length);
                var latvalue = Number(data.objects[i].state['lat']);
                var lngvalue = Number(data.objects[i].state['lon']);
                var myLatLng = {lat: latvalue, lng: lngvalue};
                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: data.objects[i].name,
                });
            }
        }
    });
}



