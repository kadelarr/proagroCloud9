function closeMessage(event){
  var container = document.getElementById("main-container");
  container.removeChild(event);
}

function calcularPanela(){
	var viewRestult = document.getElementById("result");
	var cana = document.getElementById("cana").value;
	var panela = document.getElementById("panela").value;
    var operacionPanela=panela*24;
    var operacionCana=(1000*cana);
	var result = (1000*operacionPanela)/operacionCana;
	viewRestult.value = Math.round(result);
    if (result<110) {
     var div=document.getElementById('error');
     var h1=document.createElement("h1");
     
    h1.innerHTML="El Rendimiento de la Producción es Bajo";
     div.appendChild(h1);
    }else{
         var div=document.getElementById('correcto');
         var h2=document.createElement("h2");
     
    h2.innerHTML="El Rendimiento de la Producción es Óptimo";
     div.appendChild(h2);
    }
	console.info(result);
}

function promedio(){

   /* $.ajax({
            url:"http://proagro.dev?get=promedio",
            dataType:"jsonp", 
            jsonpCallback: "callback",
            success: function(data){
                console.log(data);

                dataLocations = data;
                new Chartist.Bar('.ct-chart', dataLocations);*/
	 var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                dataLocations = JSON.parse(xhttp.responseText);
                new Chartist.Bar('.ct-chart', dataLocations);
            }
        };
        xhttp.open("GET", "http://proagro.dev?get=promedio", true);
        xhttp.send();
        
}

promedio();


