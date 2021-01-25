<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require_once MODELS.'juego_arrastrar.php';
session_start();
require_once LIBS.'verificar_general.php';

$estilos = ['estilos_juego_arrastrar.css','estilos_inicio.css','comp_modal.css'];
require_once VIEWS.'templates/head.php';

$obj_juego = new Juego_arrastrar();
$array = $obj_juego->listar_load();

$juegos = "active";
include VIEWS.'templates/header.php';

?>
<main>
    <div class="main">
        <div class="contenido" id="juego_arrastrar">
            <div class="informacion last">
                <h2 class="h2_informacion">Juego de colocar la respuesta</h2>
                <div class="tarjetas_juego_arrastrar">
                    <?php foreach ($array as $key => $row) { ?>
                      <div class="elemento">
                          <div class="j_espacios"></div>
                          <span class="enunciado"><?php echo $row->enunciado ?></span>
                      </div>
                    <?php } ?>
                </div>
                <h2 id="h2_respuestas">Arrastra la respuesta a su lugar correspondiente</h2>
                <div class="respuestas_juego_arrastrar">
                    <?php shuffle($array);
                    foreach ($array as $key => $row) { ?>
                    <div class="respuesta">
                        <div class="j_img" draggable="true">
                            <!-- <img src="<?php echo  IMG?>default/fondo_salud2.jpg" /> -->
                            <span class="respuesta"><?php echo $row->respuesta ?></span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <!-- <div class="check_juego_arrastrar"><i class="icon-filled-check"></i> Bien!!</div> -->
            <div id="modal_juego" class="modal modal_juego"></div>
            <div class="buttons_inline next">
              <button onclick="window.location = '<?php echo HOST?>lista_juegos'" class="button">Volver a Juegos</button>
              <button onclick="window.location = '<?php echo HOST?>juego_arrastrar'" class="button">Jugar de nuevo</button>
            </div>
        </div>
    </div>  
</main>
<script>
 


</script>
<?php
$scripts = ['juego_arrastrar.js','comp_modal.js']; 
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php'; 
?>
 

