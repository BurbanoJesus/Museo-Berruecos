// JavaScript Document
agregarEvento(window,'load',iniciar,false);
var array = [];
var datos = {};
function iniciar(){
	var letra='';
	errores=0;
	intentos=4;
	noIntentos=document.getElementById('noIntentos');
	for(var i=65;i <= 91;i++){
		if(i == 91){
			i = 209;
		} 
		var contenedorLetras=document.getElementById('contenedorLetras');
		var letra=letra+'<div class="botonLetra alinearHorizontal" id="letra'+String.fromCharCode(i)+'" data_id ="'+i+'" >'+String.fromCharCode(i)+'</div>';
		contenedorLetras.innerHTML=letra;
	}
	letras=document.getElementsByClassName('botonLetra');
	// console.log(letras);
	for(var i=0;i<letras.length;i++){
		agregarEvento(letras[i],'click',jugar,false);
	}

	$.ajax({
		url: '/museo/core/controllers/inicio/juegos/c_juegos_ahorcado_list.php',
		// method: 'POST',
		// data: data_form,
		// contentType: false,
		// processData: false,
		// dataType:  "json",
		beforeSend: function() {
			// $("#divres").html("<img src='images/ajax-loader.gif'>");
		},
		success: function(datos){
			datos = JSON.parse(datos);
			array = datos.lista;
			numeroAzar= Math.floor(Math.random()*array.length);
			// console.log(enunciados[numeroAzar]);
			document.getElementById('enunciado').innerHTML = array[numeroAzar].enunciado;
			palabraSecreta=document.getElementById('palabraSecreta');
			respuesta=[];
			palabra='';
			divClassLetra='<div class="letra">';
			console.log(array[numeroAzar].respuesta.charAt(2));
			for(var i=0; i < array[numeroAzar].respuesta.length; i++){
				if (array[numeroAzar].respuesta.charAt(i) == ' '){
					respuesta[i]=divClassLetra+' </div> ';
				}else{
					respuesta[i]=divClassLetra+'_</div> ';
				}
				palabra=palabra+respuesta[i];
			}
			// console.log(palabra);
			palabraSecreta.innerHTML=palabra;
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

	// datos = fetch('/museo/core/controllers/inicio/c_juegos_ahorcado_list.php',{})
	// .then(function(response) {
	//    if(response.ok) {
	//        return response.text();
	//        // var datos = JSON.parse(response.ok);
	//    } else {
	//        throw "Error en la llamada Ajax";
	//    }
	// })
	// .then(function(datos) {
	//     array = datos.lista;
	// 	numeroAzar= Math.floor(Math.random()*array.length);
	// 	// console.log(enunciados[numeroAzar]);
	// 	document.getElementById('enunciado').innerHTML = array[numeroAzar].enunciado;
	// 	palabraSecreta=document.getElementById('palabraSecreta');
	// 	respuesta=[];
	// 	palabra='';
	//     console.log(datos.lista[0].enunciado);
	// 	divClassLetra='<div class="letra">';
	// 	for(var i=0;i<array[numeroAzar].respuesta.length;i++){
	// 		respuesta[i]=divClassLetra+'_</div> ';
	// 		palabra=palabra+respuesta[i];
	// 		//contenedorPalabra.innerHTML=respuesta[i];
	// 	}
	// 	palabraSecreta.innerHTML=palabra;
	// })
	// .catch(function(err) {
	//    console.log(err);
	// });
}


function ganaste(){
	console.log(array[numeroAzar].id_juego);
	const data = new FormData();
	data.append('id_juego', array[numeroAzar].id_juego);
	datos = fetch('/museo/core/controllers/inicio/juegos/c_juegos_ahorcado_check.php', {
	   method: 'POST',
	   body: data
	})
	.then(function(response) {
	   if(response.ok) {
	       return response.text();
	       // var datos = JSON.parse(response.ok);
	   } else {
	       throw "Error en la llamada Ajax";
	   }
	})
	.then(function(datos) {
	    array = datos.error;
	    console.log(datos);
	    call_modal('modal_juego');
		    // setTimeout(function(){
		    // 	window.location.reload();
		    // },1200);
	})
	.catch(function(err) {
	   console.log(err);
	});
}

function jugar(e){
	if(e){
		id=e.target.id;
		// console.log(e.target);
		// console.log(letras[0]);
		e.target.classList.add("letra_disabled");
		removerEvento(e.target,'click',jugar);
	}else{
		if(window.event){
			id= window.event.srcElement.id;
			window.event.srcElement.classList.add("letra_disabled");
			removerEvento(window.event.srcElement,'click',jugar);
		}
	}
	var letraCorrecta=false;
	var palabra='';
	var letraPulsada= id.charAt(5);
	console.log(letraPulsada);
	for(var i=0;i<array[numeroAzar].respuesta.length;i++){
		if(array[numeroAzar].respuesta.toUpperCase().charAt(i)==letraPulsada){
			respuesta[i]=divClassLetra+letraPulsada+'</div>';	
			letraCorrecta=true;
		}
		palabra=palabra+respuesta[i];
		//contenedorPalabra.innerHTML=respuesta[i];
	}
	var imagen=document.getElementById('dibujo_ahorcado');
	palabraSecreta.innerHTML=palabra;
	if(letraCorrecta==false){
		colorLetra='';
		errores++;
		intentos=intentos-1;
		noIntentos.innerHTML= ' '+intentos;
		img=errores+1;
		imagen.src='/museo/static/img/juegos/dibujo_ahorcado_'+img+'.png';
		if(errores==4){
			document.querySelector('#modal_juego').innerHTML = '<div class="modal_main" style="width: 380px; height: 420px;">'+
	            '<div class="modal_content modal_confirmar">'+
	                '<div class="content_modal_juego perdiste">'+
	                    '<div class="img_main">'+
	                        '<img src="/museo/static/img/juegos/perdiste.png" />'+
	                    '</div>'+
	                    '<div class="main_jugar">'+
	                        '<img class="main_jugar" src="/museo/static/img/default/wrap_perdiste.png" alt="" />'+
	                        '<span class="sp_jugar">PERDISTE!!</span>'+
	                    '</div>'+
	                    '<a class="button" href="/museo/juego_ahorcado">Volver a jugar</a>'+
	                '</div>'+
	            '</div>'+
        	'</div>';
			call_modal('modal_juego');
		    // setTimeout(function(){
		    // 	window.location.reload();
		    // },1200);
			for(var i=0;i<letras.length;i++){	
				removerEvento(letras[i],'click',jugar);
			}
			palabra='';
			// for(var i=0;i<array[numeroAzar].respuesta.length;i++){
			// 	if(divClassLetra+array[numeroAzar].respuesta.toUpperCase().charAt(i)+'</div>'==respuesta[i]){
			// 		colorLetra='<div style="color:green;">'+respuesta[i]+'</div>';
			// 		respuesta[i]=colorLetra;	
			// 	}else{
			// 		respuesta[i]=divClassLetra+array[numeroAzar].respuesta.toUpperCase().charAt(i)+'</div>';
			// 	}
			// 	palabra=palabra+respuesta[i];
			// }
			// palabraSecreta.innerHTML=palabra;
		}
	}else{
		var palabraCompleta=true;
		for(var i=0;i<array[numeroAzar].respuesta.length;i++){
			if(respuesta[i]==divClassLetra+'_</div> '){
				palabraCompleta=false;
			}
		}
		if(palabraCompleta){
			for(var i=0;i<letras.length;i++){	
				removerEvento(letras[i],'click',jugar);
			}
			document.querySelector('#modal_juego').innerHTML = '<div class="modal_main" style="width: 380px; height: 420px;">'+
	            '<div class="modal_content modal_confirmar">'+
	                '<div class="content_modal_juego">'+
	                    '<div class="img_main">'+
	                        '<img src="/museo/static/img/juegos/ganaste.png" />'+
	                    '</div>'+
	                    '<div class="main_jugar">'+
	                        '<img class="main_jugar" src="/museo/static/img/default/wrap_ganaste.png" alt="" />'+
	                        '<span class="sp_jugar">GANASTE!!</span>'+
	                    '</div>'+
	                    '<a class="button" href="/museo/juego_ahorcado">Continuar</a>'+
	                '</div>'+
	            '</div>'+
        	'</div>';
        	ganaste();
		}
	}
}

function agregarEvento(elemento,evento,funcion,captura){
	if(window.addEventListener){
		elemento.addEventListener(evento,funcion,captura);
	}else if(window.attachEvent){
		elemento.attachEvent('on'+evento,captura);
	}else{
		alert('Error al agregar el evento');
	}
}

function removerEvento(elemento,evento,funcion){
	if(window.removeEventListener){
		elemento.removeEventListener(evento,funcion);
	}else if(window.detachEvent){
		elemento.detachEvent(evento,funcion);
	}else{
		alert('Error al remover el evento');
	}
}