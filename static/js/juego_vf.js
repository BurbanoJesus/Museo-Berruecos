// APRENDE
// INPUT FILE NO SE LE PUEDE HACER SET POR SEGURIDAD, PARA LEERLO Y MODIFICARLO ES NECESARIO GUARDARLO EN ARRAY INDEPENDIENTE,LUEGO ESTE ARRAY SE PUEDE ENVIAR A ARCHIVOS PHP.

var id_juego = $("#juego_vf").attr('data_id');
var datos = [];
var data_form = new FormData();
data_form.append('id_juego', id_juego);
// console.log(id_juego);
var cont = 0;

$.ajax({
	url: '/museo/core/controllers/inicio/c_juegos_vf_list.php',
	method: 'POST',
	data: data_form,
	contentType: false,
	processData: false,
	beforeSend: function() {
		// $("#divres").html("<img src='images/ajax-loader.gif'>");
	},
	success: function(datos){
		datos = JSON.parse(datos);
	    var resp_collection = datos.lista;
	    console.log(resp_collection);
	    var user_collection = new Array();
	    $(document).on('click','.juego_vf', function(e){
		    var elemento = $(this);
		    var section = elemento.closest('section');
		    var index = section.index();
		    var juego = elemento.closest('div.div_juego');
		    var array = juego.find('section');
		    var respuesta_user = '';
		    var respuesta_collect = '';
		    if (index >= 0) {
		        respuesta = (elemento.hasClass('verdadero')) ? 'v' : 'f';
		        user_collection.push(respuesta);
		    }
		     // -------------------------------------------------------
		    var str_check = '';
		    // console.log(index);
		    // console.log(resp_collection);
		    respuesta_collect = (resp_collection[index].respuesta == 'Falso') ? 'f':'v';
		    if (user_collection[index] == respuesta_collect){
		    	cont++;
		        str_check = '<i class="icon-filled-check"></i> Bien!!';
		       $(".check_respuesta").addClass('flex bien');
		       $(".check_respuesta").html(str_check);
		    }else{
		        str_check = '<i class="icon-filled-no-check"></i> Mal!!';
		        $(".check_respuesta").addClass('flex mal');
		        $(".check_respuesta").html(str_check);
		    }
		    // sleep(1000);
		    console.log(user_collection);
		    // -------------------------------------------------------
		    setTimeout(function(){
		        if (index < array.length -1) {
		            console.log('if');
		            array.eq(index).removeClass('flex');
		            array.eq(index).hide();
		            array.eq(index+1).addClass('flex');
		        }else{
		            array.eq(index).removeClass('flex');
		            array.eq(index).hide();
		            resultados = $("div.resultados_juego");
		            aciertos = resultados.find('p span');
		            aciertos.html('&nbsp'+cont+' / '+resp_collection.length);
		            resultados.addClass('flex');
		            if (cont == resp_collection.length){
			            var data_form = new FormData();
						data_form.append('id_juego', id_juego);
			            $.ajax({
			            	url: '/museo/core/controllers/inicio/c_juegos_vf_check.php',
			            	method: 'POST',
			            	data: data_form,
			            	contentType: false,
			            	processData: false,
			            	// dataType:  "json",
			            	beforeSend: function() {
			            		// $("#divres").html("<img src='images/ajax-loader.gif'>");
			            	},
			            	success: function(datos){
			            		// console.log(datos);
			            		datos = JSON.parse(datos);
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
		            }
		        }
		        $(".check_respuesta").removeClass('flex bien mal');
		    },1600);
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

// $.ajax({
// 	url: url,
// 	method: 'POST',
// 	data: data_form,
// 	contentType: false,
// 	 	processData: false,
// 	// dataType:  "json",
// 	beforeSend: function() {
// 		// $("#divres").html("<img src='images/ajax-loader.gif'>");
// 	},
// 	success: function(datos){
// 		// console.log(datos);
// 		datos = JSON.parse(datos);
// 	},
// 	error:function(xhr, status, error){
//       	if (xhr.responseText.indexOf('<html>') != -1) {
// 	        var str_inicio = xhr.responseText.indexOf('<p>');
// 	        var str_final = xhr.responseText.indexOf('</p>');
// 	        var str_error = xhr.responseText.substring(str_inicio+3,str_final);
// 	        console.log(str_error);
// 	    }else{
// 	        console.log(xhr.responseText);
// 	    }
//     }
// });

// $("div.div_juego section").hide();
