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
        /*$.ajax({
            url:"http://proagro.dev?get=areas",
            dataType:"jsonp", 
            jsonpCallback: "callback",
            success: function(data){
                console.log(data);

                dataLocations = data;
                clearLocations();
                loadLocations();
                loaded = true;

            }
            
        })*/

                dataLocations = {"Zona 1":{"message":[],"nextCut":[],"locations":[{"id":1,"lat":4.466879,"lng":-75.773491,"id_area":1},{"id":2,"lat":4.467467,"lng":-75.774613,"id_area":1},{"id":3,"lat":4.467838,"lng":-75.773984,"id_area":1},{"id":4,"lat":4.468099,"lng":-75.773269,"id_area":1}],"sowing":[{"id":26,"initial":"2015-12-18","cut":"2017-02-18","final":null,"count":null,"id_area":1}],"status":"sowing"},"Zona 2":{"message":[],"nextCut":[],"locations":[{"id":5,"lat":4.467472,"lng":-75.774631,"id_area":2},{"id":6,"lat":4.466862,"lng":-75.773503,"id_area":2},{"id":7,"lat":4.465217,"lng":-75.773664,"id_area":2},{"id":8,"lat":4.464803,"lng":-75.774041,"id_area":2},{"id":9,"lat":4.464741,"lng":-75.774233,"id_area":2},{"id":10,"lat":4.465244,"lng":-75.774765,"id_area":2},{"id":11,"lat":4.465767,"lng":-75.774976,"id_area":2}],"sowing":[{"id":36,"initial":"2016-03-15","cut":"2017-05-15","final":null,"count":null,"id_area":2}],"status":"sowing"},"Zona 3":{"message":[],"nextCut":[],"locations":[{"id":12,"lat":4.46881,"lng":-75.772058,"id_area":3},{"id":13,"lat":4.468938,"lng":-75.771796,"id_area":3},{"id":14,"lat":4.46916,"lng":-75.76958,"id_area":3},{"id":15,"lat":4.468633,"lng":-75.769519,"id_area":3},{"id":16,"lat":4.468505,"lng":-75.771181,"id_area":3}],"sowing":[{"id":28,"initial":"2016-03-15","cut":"2017-05-15","final":null,"count":null,"id_area":3}],"status":"sowing"},"Zona 4":{"message":[],"nextCut":[],"locations":[{"id":17,"lat":4.470695,"lng":-75.771792,"id_area":4},{"id":18,"lat":4.469721,"lng":-75.770883,"id_area":4},{"id":19,"lat":4.469219,"lng":-75.771372,"id_area":4},{"id":20,"lat":4.468822,"lng":-75.772065,"id_area":4},{"id":21,"lat":4.469028,"lng":-75.772197,"id_area":4},{"id":22,"lat":4.469094,"lng":-75.772527,"id_area":4},{"id":23,"lat":4.469348,"lng":-75.772641,"id_area":4},{"id":24,"lat":4.469486,"lng":-75.772835,"id_area":4}],"sowing":[{"id":37,"initial":"2015-07-28","cut":"2016-09-28","final":null,"count":null,"id_area":4}],"status":"sowing"},"Zona 5":{"message":["El lote Zona 5 Esta en proceso de corte, se identifica por el color rojo"],"nextCut":[],"locations":[{"id":25,"lat":4.468952,"lng":-75.771761,"id_area":5},{"id":26,"lat":4.469178,"lng":-75.769565,"id_area":5},{"id":27,"lat":4.46952,"lng":-75.769598,"id_area":5},{"id":28,"lat":4.469235,"lng":-75.771342,"id_area":5}],"sowing":[{"id":32,"initial":"2015-03-17","cut":"2016-05-17","final":null,"count":null,"id_area":5}],"status":"cut"},"Zona 6":{"message":["El lote Zona 6 Esta en proceso de corte, se identifica por el color rojo"],"nextCut":[],"locations":[{"id":56,"lat":4.470715,"lng":-75.771684,"id_area":6},{"id":57,"lat":4.47158,"lng":-75.771083,"id_area":6},{"id":58,"lat":4.471431,"lng":-75.7709,"id_area":6},{"id":59,"lat":4.471388,"lng":-75.770516,"id_area":6},{"id":60,"lat":4.47062,"lng":-75.770208,"id_area":6},{"id":61,"lat":4.470109,"lng":-75.770276,"id_area":6},{"id":62,"lat":4.469843,"lng":-75.770483,"id_area":6},{"id":63,"lat":4.469779,"lng":-75.77087,"id_area":6}],"sowing":[{"id":30,"initial":"2015-03-24","cut":"2016-05-24","final":null,"count":null,"id_area":6}],"status":"cut"},"Zona 7":{"message":[],"nextCut":[],"locations":[{"id":64,"lat":4.471283,"lng":-75.769143,"id_area":7},{"id":65,"lat":4.471266,"lng":-75.769911,"id_area":7},{"id":66,"lat":4.471377,"lng":-75.770535,"id_area":7},{"id":67,"lat":4.470922,"lng":-75.770328,"id_area":7},{"id":68,"lat":4.47047,"lng":-75.770191,"id_area":7},{"id":69,"lat":4.470022,"lng":-75.770294,"id_area":7},{"id":70,"lat":4.469839,"lng":-75.770451,"id_area":7},{"id":71,"lat":4.469728,"lng":-75.769593,"id_area":7},{"id":72,"lat":4.469866,"lng":-75.768998,"id_area":7},{"id":73,"lat":4.470169,"lng":-75.768589,"id_area":7},{"id":74,"lat":4.470688,"lng":-75.768849,"id_area":7}],"sowing":[{"id":35,"initial":"2015-05-27","cut":"2016-07-27","final":null,"count":null,"id_area":7}],"status":"sowing"},"Zona 8":{"message":["El lote Zona 8 Esta en proceso de corte, se identifica por el color rojo"],"nextCut":[],"locations":[{"id":75,"lat":4.470143,"lng":-75.768563,"id_area":8},{"id":76,"lat":4.469866,"lng":-75.768994,"id_area":8},{"id":77,"lat":4.469755,"lng":-75.769586,"id_area":8},{"id":78,"lat":4.468654,"lng":-75.769498,"id_area":8},{"id":79,"lat":4.468732,"lng":-75.768305,"id_area":8},{"id":80,"lat":4.468837,"lng":-75.767936,"id_area":8},{"id":81,"lat":4.469437,"lng":-75.768182,"id_area":8}],"sowing":[{"id":38,"initial":"2015-03-20","cut":"2016-05-20","final":null,"count":null,"id_area":8}],"status":"cut"},"Zona 9":{"message":["El lote Zona 9 Esta en proceso de corte, se identifica por el color rojo"],"nextCut":[],"locations":[{"id":82,"lat":4.469304,"lng":-75.771243,"id_area":9},{"id":83,"lat":4.46972,"lng":-75.770872,"id_area":9},{"id":84,"lat":4.469827,"lng":-75.770437,"id_area":9},{"id":85,"lat":4.469742,"lng":-75.769617,"id_area":9},{"id":86,"lat":4.469539,"lng":-75.769598,"id_area":9}],"sowing":[{"id":40,"initial":"2015-03-17","cut":"2016-05-17","final":null,"count":null,"id_area":9}],"status":"cut"},"Zona 10":{"message":[],"nextCut":[],"locations":[{"id":87,"lat":4.471549,"lng":-75.771123,"id_area":10},{"id":88,"lat":4.470691,"lng":-75.771772,"id_area":10},{"id":89,"lat":4.469508,"lng":-75.772864,"id_area":10},{"id":90,"lat":4.469059,"lng":-75.773402,"id_area":10},{"id":91,"lat":4.470074,"lng":-75.773973,"id_area":10},{"id":92,"lat":4.470175,"lng":-75.774818,"id_area":10},{"id":93,"lat":4.470347,"lng":-75.775157,"id_area":10},{"id":94,"lat":4.470125,"lng":-75.775603,"id_area":10},{"id":95,"lat":4.470275,"lng":-75.775609,"id_area":10},{"id":96,"lat":4.470469,"lng":-75.775332,"id_area":10},{"id":97,"lat":4.470636,"lng":-75.775154,"id_area":10},{"id":98,"lat":4.470448,"lng":-75.774356,"id_area":10},{"id":99,"lat":4.470376,"lng":-75.774032,"id_area":10},{"id":100,"lat":4.47113,"lng":-75.772906,"id_area":10},{"id":101,"lat":4.47113,"lng":-75.772906,"id_area":10},{"id":102,"lat":4.471392,"lng":-75.771551,"id_area":10}],"sowing":[],"status":"sowing"},"Zona 11":{"message":[],"nextCut":[],"locations":[{"id":103,"lat":4.469032,"lng":-75.773407,"id_area":11},{"id":104,"lat":4.470068,"lng":-75.773988,"id_area":11},{"id":105,"lat":4.470168,"lng":-75.774813,"id_area":11},{"id":106,"lat":4.469421,"lng":-75.774329,"id_area":11},{"id":107,"lat":4.468903,"lng":-75.775014,"id_area":11},{"id":108,"lat":4.468078,"lng":-75.774545,"id_area":11}],"sowing":[],"status":"sowing"},"Zona 12":{"message":[],"nextCut":[],"locations":[{"id":109,"lat":4.467868,"lng":-75.774454,"id_area":12},{"id":110,"lat":4.468788,"lng":-75.775122,"id_area":12},{"id":111,"lat":4.469382,"lng":-75.775352,"id_area":12},{"id":112,"lat":4.468999,"lng":-75.776012,"id_area":12},{"id":113,"lat":4.467939,"lng":-75.775458,"id_area":12},{"id":114,"lat":4.467739,"lng":-75.775679,"id_area":12},{"id":115,"lat":4.46744,"lng":-75.775503,"id_area":12},{"id":116,"lat":4.467713,"lng":-75.775215,"id_area":12},{"id":117,"lat":4.467451,"lng":-75.774971,"id_area":12}],"sowing":[],"status":"sowing"},"Zona 13":{"message":[],"nextCut":[],"locations":[{"id":118,"lat":4.469858,"lng":-75.774653,"id_area":13},{"id":119,"lat":4.47016,"lng":-75.774825,"id_area":13},{"id":120,"lat":4.470333,"lng":-75.775177,"id_area":13},{"id":121,"lat":4.46972,"lng":-75.776425,"id_area":13},{"id":122,"lat":4.469021,"lng":-75.776014,"id_area":13},{"id":123,"lat":4.469404,"lng":-75.775356,"id_area":13}],"sowing":[],"status":"sowing"},"Zona 14":{"message":[],"nextCut":[],"locations":[{"id":124,"lat":4.464792,"lng":-75.774042,"id_area":14},{"id":125,"lat":4.464767,"lng":-75.774257,"id_area":14},{"id":126,"lat":4.465232,"lng":-75.774789,"id_area":14},{"id":127,"lat":4.465006,"lng":-75.775061,"id_area":14},{"id":128,"lat":4.465013,"lng":-75.775313,"id_area":14},{"id":129,"lat":4.464749,"lng":-75.775585,"id_area":14},{"id":130,"lat":4.464295,"lng":-75.775266,"id_area":14},{"id":131,"lat":4.463817,"lng":-75.775269,"id_area":14},{"id":132,"lat":4.463766,"lng":-75.774972,"id_area":14},{"id":133,"lat":4.46355,"lng":-75.774759,"id_area":14},{"id":134,"lat":4.463582,"lng":-75.774655,"id_area":14},{"id":135,"lat":4.463894,"lng":-75.774614,"id_area":14}],"sowing":[],"status":"sowing"},"Zona 15":{"message":[],"nextCut":[],"locations":[{"id":136,"lat":4.464819,"lng":-75.773935,"id_area":15},{"id":137,"lat":4.464214,"lng":-75.774059,"id_area":15},{"id":138,"lat":4.464769,"lng":-75.773024,"id_area":15},{"id":139,"lat":4.464936,"lng":-75.773303,"id_area":15},{"id":140,"lat":4.464847,"lng":-75.773498,"id_area":15},{"id":141,"lat":4.46488,"lng":-75.773698,"id_area":15},{"id":142,"lat":4.464824,"lng":-75.773792,"id_area":15},{"id":143,"lat":4.464852,"lng":-75.773886,"id_area":15}],"sowing":[],"status":"sowing"},"Zona 16":{"message":[],"nextCut":[],"locations":[{"id":144,"lat":4.464763,"lng":-75.773017,"id_area":16},{"id":145,"lat":4.464184,"lng":-75.774083,"id_area":16},{"id":146,"lat":4.46343,"lng":-75.774363,"id_area":16},{"id":147,"lat":4.463227,"lng":-75.774367,"id_area":16},{"id":148,"lat":4.464057,"lng":-75.772803,"id_area":16}],"sowing":[],"status":"sowing"},"Zona 17":{"message":[],"nextCut":[],"locations":[{"id":149,"lat":4.464057,"lng":-75.772803,"id_area":17},{"id":150,"lat":4.463636,"lng":-75.772735,"id_area":17},{"id":151,"lat":4.463092,"lng":-75.77362,"id_area":17},{"id":152,"lat":4.462597,"lng":-75.774316,"id_area":17},{"id":153,"lat":4.463224,"lng":-75.774375,"id_area":17}],"sowing":[],"status":"sowing"},"Zona 18 ":{"message":[],"nextCut":[],"locations":[{"id":154,"lat":4.462593,"lng":-75.774311,"id_area":18},{"id":155,"lat":4.462176,"lng":-75.773946,"id_area":18},{"id":156,"lat":4.461582,"lng":-75.773822,"id_area":18},{"id":157,"lat":4.462197,"lng":-75.772436,"id_area":18},{"id":158,"lat":4.463636,"lng":-75.772735,"id_area":18},{"id":161,"lat":4.463092,"lng":-75.77362,"id_area":18}],"sowing":[],"status":"sowing"}};
                clearLocations();
                loadLocations();
                loaded = true;
        
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
