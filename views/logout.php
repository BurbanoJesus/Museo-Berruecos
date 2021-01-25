<?php
require_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
session_start();
$_SESSION["usuario"]= "";
session_destroy();
include VIEWS.'templates/head.php';
?>
<div class="logout">
	<h1>Información:</h1>
	<span>Sesion Finalizada</span>
	<a class="button" href="<?php HOST?>inicio">Ir al Inicio</a>
</div>

<?php include VIEWS.'templates/foot.php'; ?>