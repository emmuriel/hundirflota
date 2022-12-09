// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages':['corechart']});

function ranking(){
    let json = {
      peticion: 1
    };

    fetch("estadisticas.php", {
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
        crearRanking(datos);
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

    fetch("estadisticas.php", {
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
                    'width':300,
                    'height':200,
                    'backgroundColor' : {fill:grey}
                  };
   
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
      title: 'TOP 5 Jugadores',
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

  function crearRanking(datos){
    let tablaRanking= document.querySelector('#tabla-ranking');

    //remove and create child tblBody
    var tbodyDeleted = document.getElementById("tblBody");
      tablaRanking.removeChild(tbodyDeleted);
  
    let tblBody = document.createElement("tbody");
    tblBody.setAttribute('id','tblBody');
    //Cabecera de tabla
    let cabecera=document.createElement('tr');
    cabecera.classList.add('tr-cabecera');

    let puesto = document.createElement("td");
    let textoPuesto = document.createTextNode("Puesto");
    puesto.appendChild(textoPuesto);
    puesto.classList.add('td-cabecera-puesto');
    cabecera.appendChild(puesto);

    let usuario = document.createElement("td");
    let textoUsuario = document.createTextNode("Usuario");
    usuario.appendChild(textoUsuario);
    usuario.classList.add('td-cabecera-usuario');
    cabecera.appendChild(usuario);

    let victorias = document.createElement("td");
    let textoVictorias = document.createTextNode("Victorias");
    victorias.appendChild(textoVictorias);
    victorias.classList.add('td-cabecera-victorias');
    cabecera.appendChild(victorias);

    tblBody.appendChild(cabecera);
    //Cuerpo
    let arrDatos = Object.keys(datos);
    for (let j=0; j<arrDatos.length; j++){
  
      let fila=document.createElement('tr');
      fila.classList.add('tr-fila');
  
      let puesto = document.createElement("td");
      let textoPuesto = document.createTextNode(j);
      puesto.appendChild(textoPuesto);
      if (j/j/2!=0){ puesto.classList.add('td-fila-puesto-black');}
      else {puesto.classList.add('td-fila-puesto-shadow');}
      
      fila.appendChild(puesto);
  
      let usuario = document.createElement("td");
      let textoUsuario = document.createTextNode(datos[j].nombre);
      usuario.appendChild(textoUsuario);
      if (j/2!=0){ puesto.classList.add('td-fila-usuario-black');}
      else {puesto.classList.add('td-fila-usuario-shadow');}
      fila.appendChild(usuario);
  
      let victorias = document.createElement("td");
      let textoVictorias = document.createTextNode(datos[j].victorias);
      victorias.appendChild(textoVictorias);
      if (j/j/2!=0){ puesto.classList.add('td-fila-victorias-black');}
      else {puesto.classList.add('td-fila-victorias-shadow');}
      fila.appendChild(victorias);

      console.log(fila);//****************************************************** */
      tblBody.appendChild(fila);  //Añade fila a l tblbody
    }

    tablaRanking.appendChild(tblBody); //Añade el tblbody a la tabla

  }


document.addEventListener("DOMContentLoaded", () => {
    //Estadísticas, se actualizará cada 1 segundos
    setInterval(ranking,1000);

});