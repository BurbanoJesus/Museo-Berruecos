<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Activar cuenta del Museo Arqueológico Berruecos</title>
        <style type="text/css">
            *{  padding: 0;
                margin: 0;
                -moz-webkit-box-sizing: border-box;
                -ms-webkit-box-sizing: border-box;
                -o-webkit-box-sizing: border-box;
                box-sizing: border-box;
            }

            div.body{
                background: #F2F4F6;
                width: 100%;
                height: 100%;
                font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
            }

            div.header{
                display: block;
                text-align: center;
                line-height: 75px;
                height: 75px;
            }

            div.content{
                display: block;
                flex-direction: column;
                justify-content: center;
                background: #FFFFFF;
                padding: 50px 5px;
                padding-top: 40px;
            }

            div.content div.main{
                display: block;
                background: #FFFFFF;
                width: 500px;
                margin: auto;
            }

            div.content h1{
                color: #262626;
                font-size: 19px;
                font-weight: bold;
                padding-bottom: 10px;
            }

            .preheader{
                display: none !important;
                font-size: 1px;
                line-height: 1px;
                max-height: 0;
                max-width: 0;
                mso-hide: all;
                opacity: 0;
                overflow: hidden;
                visibility: hidden;
            }

            .subject{
                color: #bbbfc3 !important;
                font-size: 17px;
                font-weight: bold;
                text-decoration: none;
                text-shadow: 0 1px 0 white;
            }

            .email-footer {
                width: 100% !important;

            }

            .p_main{
                box-sizing: border-box;
                color: #74787E;
                font-size: 16px;
                line-height: 1.5em;
                margin-top: 0;
                padding-bottom: 15px;
            }

            div.button{
                display: flex;
                justify-content: center;
                align-items: center;
            }

            div.button .button{
                display: inline-block;
                background: #22BC66;
                color: #FFF;
                text-decoration: none;
                font-size: 15px;
                padding: 10px 18px;
                border-radius: 3px;
                box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
                border: 2px solid #22bc66;
                margin: 20px auto;
                margin-bottom: 35px;
            }

            .sub{
                box-sizing: border-box;
                color: #74787E;
                font-size: 14px;
                line-height: 1.5em;
                margin-top: 0;

            }

            div.footer{
                display: block;
                text-align: center;
                padding: 30px 5px;
            }

            @media only screen and (max-width: 600px) {
                .email-body_inner {
                    width: 100% !important;

                }
            }

            
            @media only screen and (max-width: 500px) {
                div.button {
                    width: 100% !important;
                }

                div.button .button{
                    width: 90% !important;
                }
            }
      
        </style>
    </head>
    
    
    <body>
    <div class="body">
       <div class="header">
            <span class="preheader">Use este enlace para activar su cuenta. El enlace solo es válido por 24 horas.</span>
            <a href="{{host}}" class="subject">Museo Arqueológico Berruecos.</a>
        </div>
        <div class="content">
            <div class="main">
                <h1 align="left">Hola {{name}},</h1>
                <p class="p_main">Gracias por registrarse  al sitio web del Museo Arqueológico Berruecos, Para completar el registro de su cuenta es necesario que use el botón de abajo. <strong>Tenga en cuenta que este enlace de activación solo es válido durante las próximas 24 horas.</strong></p>
                <div class="button">
                    <a href="{{action_url_1}}" class="button" target="_blank">Activar Cuenta</a>
                </div>
                <p class="p_main"> Por razones de seguridad, esta solicitud se recibió de un dispositivo {{operating_system}} usando {{browser_name}}. Si no solicitó la creación de cuenta para el sitio web del Museo Arqueológico Berruecos, ignore este correo electrónico o póngase en contacto con el servicio de asistencia si tiene alguna pregunta.</p>
                <p class="p_main">Gracias,
                <br/>Equipo del Museo Arqueológico Berruecos</p>          
                <p class="sub">Si tiene problemas con el botón de arriba, copie y pegue la siguiente URL en su navegador web.</p>
                <p class="sub">{{action_url_2}}</p>
            </div>
        </div>
        <div class="footer">
            <p class="sub">© {{year}} Museo Arqueológico Berruecos. Todos los derechos reservados.</p>
        </div>
    </div>
  </body>
</html>