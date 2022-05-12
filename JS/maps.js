/*Señalizacion. Faro Trafalgar Balla Naval Trafalgar */
var map = new ol.Map({
layers: [new ol.layer.Tile({source: new ol.source.OSM()})],
target: 'map',
view: new ol.View({
projection: 'EPSG:4326',
center: [-6.03535,36.18306],
zoom: 15})});


document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("calcular_ruta").addEventListener('click', (e)=>{
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(function(position){
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                var cadenaRuta = latitude+","+longitude+";-6.03535,36.18306";
                ("#coordenadas").val(cadenaRuta);
               // $("#formulario_rutas").submit();
            });
        }
    });
});