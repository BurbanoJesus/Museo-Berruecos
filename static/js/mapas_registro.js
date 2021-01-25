$(document).ready(function () {

    function initMap(){
        map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: 1.4717949084251858,
                lng: -77.5808529606071
            },
            zoom: 9,
            mapTypeId: 'hybrid'

        });

        var input = document.getElementById('search_maps');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];

        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          /*
           * Para fines de minimizar las adecuaciones debido a que es este una demostración de adaptación mínima de código, se reemplaza forEach por some.
           */ 
          // places.forEach(function(place) {
          places.some(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
            // some interrumpe su ejecución en cuanto devuelve un valor verdadero (true)
            return true;
          });
          map.fitBounds(bounds);
        });
    }

    initMap();
    // map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
    var marcador;
    var flag_marcador = false;
   

        // var lat_lng_fam = $('#ubi_familia').val();

    if ($("input[name='latitud']").length > 0){
        latitud = $("input[name='latitud']").val();
        longitud = $("input[name='longitud']").val();
        console.log(latitud);
        console.log(longitud);
        if(latitud != 0){
            var lat_lon = new google.maps.LatLng(parseFloat(latitud),parseFloat(longitud));
            marcador = new google.maps.Marker({
            position: lat_lon,
            title: 'Ubicacion de la Familia'
            });
            marcador.setMap(map);
            map.setCenter(lat_lon);
            map.setZoom(14);
            flag_marcador = true;
            console.log('gasolina');
        }
    }

    //Creacion de evento click al mapa
    google.maps.event.addListener(map, 'click', function (evt) {
        if (flag_marcador === true) {
            marcador.setMap(null);
        }
        console.log(evt.latLng.lat());
        $('.div_lat_lng').find('input.lat').val(evt.latLng.lat());
        $('.div_lat_lng').find('input.lng').val(evt.latLng.lng());
        // console.debug($('#lat_lng').val();
        var lat_lon = new google.maps.LatLng(evt.latLng.lat(), evt.latLng.lng());
        marcador = new google.maps.Marker({
            position: lat_lon,
            title: 'Ubicacion de la Familia',
            // animation: google.maps.Animation.DROP
        });
        window.setTimeout(function(){map.panTo(new google.maps.LatLng(evt.latLng.lat(), evt.latLng.lng()))}, 0);
        marcador.setMap(map);
        flag_marcador = true;
    });

    var infoWindow = new google.maps.InfoWindow; 
    $('.btn_geolo').on("click", function(e) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
       if (flag_marcador === true) {
            console.log('this');
            marcador.setMap(null);
        }
        // map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
        $('.div_lat_lng').find('input.lat').val(pos.lat);
        $('.div_lat_lng').find('input.lng').val(pos.lng);
        map.setCenter(new google.maps.LatLng(pos.lat, pos.lng));
        map.setZoom(14);
        var lat_lon = new google.maps.LatLng(pos.lat, pos.lng);
        marcador = new google.maps.Marker({
        position: lat_lon,
        title: 'Ubicacion de la Familia'
        });
        marcador.setMap(map);
        flag_marcador = true;

       }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } 
        else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      
        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                                  'Error: The Geolocation service failed.' :
                                  'Error: Your browser doesn\'t support geolocation.');
        }
    });

    $('.geo_ubicacion').one("click", function(e) {
        // map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
        if (flag_marcador == false) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    pos = {
                      lat: position.coords.latitude,
                      lng: position.coords.longitude
                    };
                if (flag_marcador === true) {
                    console.log('this');
                    marcador.setMap(null);
                }
                $('.div_lat_lng').find('input.lat').val(pos.lat);
                $('.div_lat_lng').find('input.lng').val(pos.lng);
                map.setCenter(new google.maps.LatLng(pos.lat, pos.lng));
                map.setZoom(14);
                var lat_lon = new google.maps.LatLng(pos.lat, pos.lng);
                marcador = new google.maps.Marker({
                position: lat_lon,
                title: 'Ubicacion de la Familia'
                });
                marcador.setMap(map);
                flag_marcador = true;

               }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                  });
                } 
                else {
                  // Browser doesn't support Geolocation
                  handleLocationError(false, infoWindow, map.getCenter());
                }
              
                function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                    infoWindow.setPosition(pos);
                    infoWindow.setContent(browserHasGeolocation ?
                                          'Error: The Geolocation service failed.' :
                                          'Error: Your browser doesn\'t support geolocation.');
                }
            }
        });


});

// Try HTML5 geolocation.
// if (navigator.geolocation) {
//   navigator.geolocation.getCurrentPosition(function(position) {
//       pos = {
//       lat: position.coords.latitude,
//       lng: position.coords.longitude
//     };

//     // marker = new google.maps.Marker({
//     // position: pos,
//     // draggable: false,
//     // animation: google.maps.Animation.DROP,
//     // map: map
//     // });
//     // map.setCenter(pos);

//     // document.getElementById("pos").value = marker.getPosition().lat()+","+ marker.getPosition().lng();

//    }, function() {
//         handleLocationError(true, infoWindow, map.getCenter());
//       });
//     } 
//     else {
//       // Browser doesn't support Geolocation
//       handleLocationError(false, infoWindow, map.getCenter());
//     }
  
//   function handleLocationError(browserHasGeolocation, infoWindow, pos) {
//     infoWindow.setPosition(pos);
//     infoWindow.setContent(browserHasGeolocation ?
//                           'Error: The Geolocation service failed.' :
//                           'Error: Your browser doesn\'t support geolocation.');
//   }

// if(navigator.onLine) {
//     // el navegador está conectado a la red
// } else {
//     // el navegador NO está conectado a la red
// }