(function($) {
    Map = {};

    var dataLocations = {};
    var locations = [];
    var map;
    var infoWindow;
    //Se utiliza para indicar si se cargo ya el contenido por primera vez
    var loaded = false;
    var statusByArea = {};

    Map.init = function() {
        var myOptions = {
            zoom: 15,
            scrollwheel: false,
            navigationControl: false,
            mapTypeControl: false,
            scaleControl: false,
            draggable: true,
            streetViewControl: false,
            center: new google.maps.LatLng(4.4682798, -75.7728834),
            mapTypeId: google.maps.MapTypeId.HYBRID
        };
        map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
        infoWindow = new google.maps.InfoWindow;
        Map.positionMap();
        Map.getDataAjax();
        timerRefresh();
    }

    /**
     * Consulta la base de datos por medio de ajax
     */
    Map.getDataAjax = function() {
        $.ajax({
            url:"https://proagro-kadelarr7.c9users.io?get=areas",
            dataType:"jsonp", 
            jsonpCallback: "callback",
            success: function(data){
                console.log(data);

                dataLocations = data;
                clearLocations();
                loadLocations();
                loaded = true;

            }
            
        })
    /*    var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                dataLocations = JSON.parse(xhttp.responseText);
                clearLocations();
                loadLocations();
                loaded = true;
            }
        };
        xhttp.open("GET", "http://proagro.dev?get=areas", true);
        xhttp.send();*/
    }

    Map.positionMap = function() {
        var height = window.innerHeight - 80;
        var divMap = document.getElementById("gmap_canvas");
        var containerMap = document.getElementById("container-map");
        divMap.style.height = height + "px";
        containerMap.style.height = height + "px";
    }

    function loadLocations() {
        for (var row in dataLocations) {
            var area = dataLocations[row]['locations'];
            var sowing = dataLocations[row]['sowing'];
            var status = dataLocations[row]['status'];
            var message = dataLocations[row]['message'];
            var newLocation = {};
            var color = getColorLocation(sowing, status);
            newLocation.name = row;
            newLocation.sowing = sowing;
            newLocation.area = new google.maps.Polygon({
                paths: area,
                strokeColor: color,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: color,
                fillOpacity: 0.35
            });
            newLocation.area.setMap(map);
            locations.push(newLocation);
            loadListenerLocations(newLocation);
            if (message.length > 0 && (!loaded || statusByArea[row] != status)) {
                showMessage(message[0]);
            }
            statusByArea[row] = status;
        }
    }

    /**
     * Agrega el color a las zonas para indicar una acción especial
     * Gris es normal sin siembra.
     * Azul es que tiene siembra.
     * Rojo es que esta en proceso de corte.
     */
    function getColorLocation(sowing, status) {
        var gray = "#B5B6B7";
        var blue = "#367AC7";
        var yellow = "#C5BB0D";
        var red = "#BF0303";
        var color = gray;
        if (sowing.length > 0 && status == "cut") {
            color = red;
        }
        if (sowing.length > 0 && status == "sowing") {
            color = blue;
        }
        if (sowing.length > 0 && status == "next") {
            color = yellow;
        }
        return color;
    }

    function clearLocations() {
        if (locations.length > 0) {
            for (var i = 0; i < locations.length; i++) {
                locations[i].area.setMap(null);
            }
            locations = [];
        }
    }

    function showAlert(event, area) {
        console.info(event, area);
        var message = "" +
            "<b><center>" + area.name + "</center></b>" +
            "<br/>";
        if (area.sowing.length > 0) {
            var cut = area.sowing[0].cut == null ? 'Sin programar' : area.sowing[0].cut;
            message += "" +
                "<b>Sembrado:</b> " + area.sowing[0].initial + "<br/>" +
                "<b>Corte:</b> " + cut + "<br/>";
        }
        infoWindow.setContent(message);
        infoWindow.setPosition(event.latLng);
        infoWindow.open(map);
    }

    function timerRefresh() {
        setInterval(Map.getDataAjax, 5000);
    }

    function loadListenerLocations(object) {
        object.area.addListener('click', function(event) {
            showAlert(event, object);
        });
    }

    function showMessage(message) {
        var divParent = document.getElementById("main-container");
        var divMap = document.getElementById("google-map");
        var div = document.createElement("div");
        var a = document.createElement("a");
        var p = document.createElement("p");
        div.className = "menssage";
        a.innerHTML = "x";
        a.setAttribute("onclick","closeMessage(this.parentNode)");
        a.setAttribute("href","#");
        p.innerHTML = message;
        div.appendChild(a);
        div.appendChild(p);
        divParent.insertBefore(div, divMap);
    }

})(jQuery);
google.maps.event.addDomListener(window, 'load', Map.init);
window.addEventListener('resize', Map.positionMap, true);
