// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages':['corechart']});

function ranking(){
    let json = {
      peticion: 1
    };

    fetch("charts.php", {
      method: "POST",
      body: JSON.stringify(json),
      headers: {

        "Content-Type": "application/json",
      },
    })
      .then((response) => {
        if (response.status >= 200 && response.status < 300) {
          return Promise.resolve(response);
        }
        if (response.status == 404) {
            document.getElementById("lbl_error_usuario").innerHTML =
              "ERROR SERVIDOR";
            alert("error");
          }
        return Promise.reject(new Error(response.statusText));

      })
      .then((response) => response.json()) // parsea la respuesta en texto plano
      .then((datos) => {
        //Llamamos a drawChart
        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart1(datos));
      })
      .catch((error) => {
        console.error(error);
        return null;
      });
}
function ratioVictorias(){
    let json = {
      peticion: 2
    };

    fetch("charts.php", {
      method: "POST",
      body: JSON.stringify(json),
      headers: {

        "Content-Type": "application/json",
      },
    })
      .then((response) => {
        if (response.status >= 200 && response.status < 300) {
          return Promise.resolve(response);
        }
        if (response.status == 404) {
            
          }
        return Promise.reject(new Error(response.statusText));

      })
      .then((response) => response.json()) // parsea la respuesta en texto plano
      .then((datos) => {
        //Llamamos a drawChart
        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart2(datos));
      })
      .catch((error) => {
        console.error(error);
        return null;
      });
}

//Crear el grafico Piecharts. Ratio victoria/conexiones
function drawChart2(datos) {
    console.log(datos);
     // Crear la tabla de datos 
     var data = new google.visualization.DataTable();
   
     data.addColumn('string', 'Tipo');
     data.addColumn('number', 'porcentaje');
   
     //Recorre el JSON devuelto por el server, añadiendo un array por fila
     for (var i in datos){ 
       data.addRow([datos[i].tipo, parseInt(datos[i].porcentaje)]);
     }
     // Set chart options
     var options = {'title':'Numero de Victorias en Total de conexiones',
                    'width':500,
                    'height':400};
   
     // Instantiate and draw our chart, passing in some options.
     var chart = new google.visualization.PieChart(document.getElementById('ratio'));
     chart.draw(data, options);
   
   }

   //Crear el rankin. Diagrama de barras
function drawChart1(datos) {
    console.log(datos);
     // Crear la tabla de datos 
     var data = google.visualization.arrayToDataTable([
    ['Usuario','Victorias', { role: 'style' }, { role: 'annotation' }],
    [`${datos[0].nombre}`, parseInt(datos[0].victorias), 'gold', 'El pirata máximo' ],
    [`${datos[1].nombre}`, parseInt(datos[1].victorias), 'silver', 'Teniente Coronel' ],
    [`${datos[2].nombre}`, parseInt(datos[2].victorias), 'color:#b87333', 'Comandante' ],
    [`${datos[3].nombre}`, parseInt(datos[3].victorias), 'color: #10fbd0', 'Capitan' ],
    [`${datos[4].nombre}`, parseInt(datos[4].victorias), 'color: #10fbd0', 'Teniente' ]
  ]);
        
    
   
     
     

     // Set chart options
     var options = {
      title: 'RANKING TOP 5',
      chartArea: {width: '50%'},
      hAxis: {
        title: 'Total Victorias',
        minValue: 0
      },
      vAxis: {
        title: 'Usuarios'
      }
    };
     // Instantiate and draw our chart, passing in some options.
     var chart1 = new google.visualization.BarChart(document.getElementById('ranking'));

     chart1.draw(data, options);
     //let imgOculta= document.getElementById["oculto"].innerHTML = '<img src="' + chart1.getImageURI() + '">';
   
   } 


document.addEventListener("DOMContentLoaded", () => {
    //Estadísticas, se actualizará cada 2 segundos
    setInterval(ranking,1000);
   datosUsu(); //Visualizar datos de usuario




});