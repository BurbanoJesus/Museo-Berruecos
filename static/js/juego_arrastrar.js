var elementoArrastrado;

document.addEventListener("drag", function( event ) {
//console.log("drag")
}, false);

document.addEventListener("dragstart", function( event ) {
	// guarda información acerca del objeto arrastrado
	event.dataTransfer.setData('text/plain',null);
    // guarda una referéncia del elemento arrastrado
    elementoArrastrado = event.target;
	if (event.target.nodeName == 'IMG'){
	elementoArrastrado = event.target.parentElement;
	}
	// cambia la opacidad del elemento a medio transparente
	event.target.style.opacity = 1;
	// event.target.style.cursor = 'move';
}, false);


document.addEventListener("dragend", function( event ) {
  	// reestablece el valor de la opacidad
  	event.target.style.opacity = 1;
}, false);


document.addEventListener("dragover", function( event ) {
  	// previene el comportamiento por defecto del elemento arrastrado
 	event.preventDefault();
}, false);

document.addEventListener("dragenter", function( event ) {
  	// comprueba si el event.target es una zona de soltar  
  	if ( event.target.className == "j_espacios" ) {
    // y di lo és cambia el color de fondo
      	event.target.style.background = "purple";
 	}
}, false);

document.addEventListener("dragleave", function( event ) {
  	// comprueba si el event.target es una zona de soltar  
  	if ( event.target.className == "j_espacios"  ) {
    	// y si lo és, reestablece el valor inicial
      	event.target.style.background = "";
  	}
}, false);

document.addEventListener("drop", function( event ) {
  	// Si el elemento arrastrado es un link, este se abre en una nueve página.
  	// Para que esto no pase hay que utilizar: 
 	 event.preventDefault();
  	// comprueba si el event.target es una zona de soltar
  	if ( event.target.className == "j_espacios"  ) {
      	// reestablece el valor inicial para el background
      	event.target.style.background = "";
      	// elimina el elemento arrastrado del del elemento padre
      	elementoArrastrado.parentNode.removeChild( elementoArrastrado );
      	// y lo agrega al elemento de destino
      	elementoArrastrado.style.border = 'none';
      	event.target.appendChild( elementoArrastrado );

       	console.log(document.querySelectorAll('.respuestas_juego_arrastrar .j_img').length);
      	if (document.querySelectorAll('.respuestas_juego_arrastrar .j_img').length == 0){
            // console.log(document.querySelector('.respuestas_juego_arrastrar').previousElementSibling);
            var h2_respuestas =  document.querySelector('#h2_respuestas');
            h2_respuestas.parentElement.removeChild(h2_respuestas);
            document.querySelector('.respuestas_juego_arrastrar').innerHTML = '<div class="content_button next"><button id="confirmar_arrastrar" class="button bg_celeste">Comprobar</button></div>';
            document.getElementById('confirmar_arrastrar').addEventListener("click", function( event ){
				const array = document.querySelectorAll('.tarjetas_juego_arrastrar .elemento');
				let array_respuestas = [];
				array.forEach(function(value,index) {
					console.log(value.querySelector('span.respuesta').innerHTML);
					const respuesta = value.querySelector('span.respuesta').innerHTML;
					array_respuestas.push(respuesta);
					// console.log(value.closest('.main').innerHTML);
				 	     
				});
				console.log(array_respuestas);
				let datos_respuestas = JSON.stringify(array_respuestas);
				const data = new FormData();
				data.append('datos', datos_respuestas);
				console.log(data);

				fetch('/museo/core/controllers/inicio/juegos/c_juegos_arrastrar_check.php', {
				   method: 'POST',
				   body: data
				})
				.then(function(response) {
				   if(response.ok) {
				       return response.json();
				       // var datos = JSON.parse(response.ok);
				   } else {
				       throw "Error en la llamada Ajax";
				   }
				})
				.then(function(datos) {
				    console.log(datos);
				    if (datos.error === false){
					    document.querySelector('#modal_juego').innerHTML = '<div class="modal_main" style="width: 380px; height: 420px;">'+
				            '<div class="modal_content modal_confirmar">'+
				                '<div class="content_modal_juego">'+
				                    '<div class="img_main">'+
				                        '<img src="/museo/static/img/juegos/ganaste.png" />'+
				                    '</div>'+
				                    '<div class="main_jugar">'+
				                        '<img class="main_jugar" src="/museo/static/img/default/wrap_ganaste.png" alt="" />'+
				                        '<span class="sp_jugar">CORRECTO!!</span>'+
				                    '</div>'+
	                    			'<a class="button" href="/museo/juego_arrastrar">Volver a jugar</a>'+
				                '</div>'+
				            '</div>'+
			        	'</div>';
						call_modal('modal_juego');
					    // setTimeout(function(){
					    // 	window.location.reload();
					    // },1200);
					}
					else{
						document.querySelector('#modal_juego').innerHTML = '<div class="modal_main" style="width: 380px; height: 420px;">'+
			            '<div class="modal_content modal_confirmar">'+
			                '<div class="content_modal_juego perdiste">'+
			                    '<div class="img_main">'+
			                        '<img src="/museo/static/img/juegos/perdiste.png" />'+
			                    '</div>'+
			                    '<div class="main_jugar">'+
			                        '<img class="main_jugar" src="/museo/static/img/default/wrap_perdiste.png" alt="" />'+
			                        '<span class="sp_jugar">INCORRECTO!!</span>'+
			                    '</div>'+
			                    '<a class="button" href="/museo/juego_arrastrar">Volver a jugar</a>'+
			                '</div>'+
			            '</div>'+
		        	'</div>';
					call_modal('modal_juego');
				    // setTimeout(function(){
				    // 	window.location.reload();
				    // },1200);
					}
				})
				.catch(function(err) {
				   console.log(err);
				});
			});
		}
  	}
}, false);