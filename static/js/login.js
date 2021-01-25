//Iniciar sesion
$(document).on('submit','#login',function(event){
  event.preventDefault();
  var url = $("#login").prop('action');

  $.ajax({
    url: url,
    type: 'POST',
    dataType: 'json',
    data: $('#login').serialize(),
    beforeSend:function(){
      // $('.botonlg').val('Validando1');
    },
    success:function(respuesta){
      console.log(respuesta);
      if(respuesta.error == false){
          var url = $('span.sp_url_redirect').attr('data');
          if(url === ''){
              url = '/museo/inicio';
          }
          window.location.href = url;
        }
      else {
        console.log('error');
        $('.error_login').html('Usuario o contraseña no encontrados').fadeIn('normal');
        // $('div.login form button').css('margin-top','10px');
        // setTimeout(function(){
        //   $('.error').slideUp('slow');
        // },3000);
        // $('.botonlg').val('Iniciar Sesion'); 
      }
    },
    error:function(xhr, status, error){
      if (xhr.responseText.indexOf('<html>') != -1) {
        var str_inicio = xhr.responseText.indexOf('<p>');
        var str_final = xhr.responseText.indexOf('</p>');
        var str_error = xhr.responseText.substring(str_inicio+3,str_final);
        console.log(str_error);
      }else{
        // console.log(xhr.responseText);
        // console.log(status);
        // console.log(error);
      }
    }
  });
});

