<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
session_start();
require_once LIBS.'verificar_general.php';

$estilos = ['estilos_juego_ahorcado.css','estilos_inicio.css','comp_modal.css'];
require_once VIEWS.'templates/head.php';

$juegos = "active";
include VIEWS.'templates/header.php';

?>
<main>
    <div class="main">
        <div class="contenido" id="juego_ahorcado">
            <div class="informacion last">
                <h2 class="h2_informacion">Juego Ahorcado</h2>
                <span id="enunciado" class="descripcion_juego_ahorcado">Cargando...</span>
                <div class="img">
                    <img id="dibujo_ahorcado" src="<?php echo IMG?>juegos/dibujo_ahorcado_1.png">
                </div>
                <div class="contenedorPalabra" id="contenedorPalabra">
                    <div class="div_intentos">
                        <span class="contenedorNoIntentos">Intentos restantes:</span>
                        <span id='noIntentos'> 4</span>
                    </div>
                    <div id="palabraSecreta" class="palabraSecreta centrarDiv"></div>
                </div>
                <div id="contenedorLetras" class="contenedorLetras" ></div>
            </div>
            <div class="buttons_inline next">
              <button onclick="window.location = '<?php echo HOST?>lista_juegos'" class="button">Volver a Juegos</button>
              <button onclick="window.location = '<?php echo HOST?>juego_ahorcado'" class="button">Jugar de nuevo</button>
            </div>
        </div>
        <div id="modal_juego" class="modal modal_juego"></div>
        <!-- <div class="modal_main" style="width: 380px; height: 420px;">
            <div class="modal_content modal_confirmar">
                <div class="content_modal_juego">
                    <div class="img_main">
                        <img src="<?php echo IMG?>juegos/ganaste.png" />
                    </div>
                    <div class="main_jugar">
                        <img class="main_jugar" src="<?php echo IMG?>default/wrap_ganaste.png" alt="" />
                        <span class="sp_jugar">GANASTE!!</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal_main" style="width: 380px; height: 420px;">
            <div class="modal_content modal_confirmar">
                <div class="content_modal_juego perdiste">
                    <div class="img_main">
                        <img src="<?php echo IMG?>juegos/perdiste.png" />
                    </div>
                    <div class="main_jugar">
                        <img class="main_jugar" src="<?php echo IMG?>default/wrap_perdiste.png" alt="" />
                        <span class="sp_jugar">PERDISTE!!</span>
                    </div>
                </div>
            </div>
        </div> -->
    </div>  
</main>
<?php 
$scripts = ['juego_ahorcado.js','comp_modal.js'];
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php'; 
?>