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
    }

    initMap();
    // map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
    var marcador = [];
    var flag_marcador = false;
   
    var array_lugares = [];
    var datos = {};

    $.ajax({
        url: '/museo/core/controllers/inicio/c_visita_list.php',
        // method: 'POST',
        // data: data_form,
        // contentType: false,
        // processData: false,
        // dataType:  "json",
        beforeSend: function() {
            // $("#divres").html("<img src='images/ajax-loader.gif'>");
        },
        success: function(datos){
            console.log(datos);
            datos = JSON.parse(datos);
            array_lugares = datos.lista;
            array_lugares.forEach(function(value,index) {
                latitud = array_lugares[index].latitud;
                longitud = array_lugares[index].longitud;
                var lat_lon = new google.maps.LatLng(parseFloat(latitud),parseFloat(longitud));
                marcador[index] = new google.maps.Marker({
                position: lat_lon,
                title: array_lugares.lugar
                });
                marcador[index].setMap(map);
                map.setCenter(lat_lon);
                map.setZoom(10);
                flag_marcador = true;
                var infoWindow = new google.maps.InfoWindow; 
                infoWindow.setContent('<button class="maps_link" target="theater" id="'+array_lugares[index].id_lugar+'">'+array_lugares[index].titulo+'</button>'); 
                infoWindow.open(map, marcador[index]);
                // marcador[index].showInfoWindow();
                google.maps.event.addListener(marcador[index], "click", function(e){
                    // Throw an error to stop the close
                     infoWindow.open(map, marcador[index]);
                });
            });
        },
        error:function(xhr, status, error){
              if (xhr.responseText.indexOf('<html>') != -1) {
                var str_inicio = xhr.responseText.indexOf('<p>');
                var str_final = xhr.responseText.indexOf('</p>');
                var str_error = xhr.responseText.substring(str_inicio+3,str_final);
                console.log(str_error);
            }else{
                console.log(xhr.responseText);
            }
        }
    });

    $(document).on("click",".maps_link", function(e){
        var id_lugar = $(this).attr('id');
        $.ajax({
            url: '/museo/core/controllers/inicio/c_visita_find.php',
            method: 'POST',
            data: {id_lugar: id_lugar},
            beforeSend: function() {
                // $("#divres").html("<img src='images/ajax-loader.gif'>");
            },
            success: function(datos){
                var datos = JSON.parse(datos);
                var array = datos.row;
                var template = '<div class="contenido_theater_slider">'+
                        '<div class="base_slider">'+
                            '<div id="contenedor_slider" class="contenedor_slider">'+
                                '<div id="slider" class="slider">';
                array.forEach(function(value,index) {
                    template += '<section class="slider_section">';
                    type = type_multimedia(value.url);
                    if (type == 'imagen') { 
                        template += '<div class="img"><img class="file" index="'+index+'" src="'+value.url+'" /></div>'
                    } else {

                        template += '<div class="img"><video class="file" index="'+index+'" src="'+value.url+'" type="video/mp4" controls></video></div>';
                    } 
                    template += '</section>';
                });

                template += '</div>';
                template += '<div id="btn_prev" class="btn_prev"><i class="icon-arrow-c"></i></div>';
                template += '<div id="btn_next" class="btn_next"><i class="icon-arrow-c"></i></div>';
                template += '</div></div>';
                
                template += '<div class="descripcion">'+array[0].descripcion+'</div></div>';
                // console.log(template);
                var target_t = $("#theater").find(".theater_content");
                var btn_left = $("#theater").find('.btn_left');
                var btn_right = $("#theater").find('.btn_right');

                btn_left.attr('index',0).hide();
                btn_right.attr('index',0).hide();

                target_t.html(template);
                call_theater();
                init_slider();
            },
            error:function(xhr, status, error){
                  if (xhr.responseText.indexOf('<html>') != -1) {
                    var str_inicio = xhr.responseText.indexOf('<p>');
                    var str_final = xhr.responseText.indexOf('</p>');
                    var str_error = xhr.responseText.substring(str_inicio+3,str_final);
                    console.log(str_error);
                }else{
                    console.log(xhr.responseText);
                }
            }
        });
    });

    $('.btn_geolo').on("click", function(e) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                pos = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude
                };
            // map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
            map.setCenter(new google.maps.LatLng(pos.lat, pos.lng));
            map.setZoom(14);
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