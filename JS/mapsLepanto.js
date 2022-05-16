mapboxgl.accessToken = 'pk.eyJ1IjoicHJveWVjdG9oZiIsImEiOiJjbDM5M2lyMXEwMHdyM2NwY3J4eGkyZmhkIn0.VtJRmEdgdkSDTCA7aafy3A';
var map = new mapboxgl.Map({
container: 'map',
style: 'mapbox://styles/mapbox/streets-v11',
center: [20.9674,38.5428],
zoom: 10
});
// Add zoom and rotation controls to the map.
map.addControl(new mapboxgl.NavigationControl());
// Add router
map.addControl(new MapboxDirections({accessToken: mapboxgl.accessToken}), 'top-left');
var marker = new mapboxgl.Marker().setLngLat([20.9674,38.5428]).addTo(map); // marcador 1

