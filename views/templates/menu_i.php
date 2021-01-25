<div class="menu">
	<nav>
		<a class="<?php echo $inicio?>" href="<?php echo HOST?>inicio">INCIO</a>
		<a class="<?php echo $actualidad?>" href="<?php echo HOST?>actualidad">Actualidad</a>
		<a class="<?php echo $visita?>" href="<?php echo HOST?>visita">Visita</a>
		<a class="<?php echo $aprende?>" href="<?php echo HOST?>aprende">Aprende</a>
		<a class="<?php echo $museo?>" href="<?php echo HOST?>lista_piezas">Museo</a>
		<?php if ($tipo_usuario == 'administrador') { ?>
			<a class="<?php echo $registro?>" href="<?php echo HOST?>registrar_pieza">Registro</a>
		<?php } ?>
		<?php if (!isset($_SESSION['usuario'])){?>
			<a class="<?php echo $cuenta?>" href="<?php echo HOST?>registrar_usuario">Crear Cuenta</a>
		<?php }
		$url_sesion = (isset($_SESSION['usuario'])) ? HOST."logout": HOST."login";
		$estado_sesion = (isset($_SESSION['usuario'])) ? "Cerrar sesión": "Iniciar sesión";
		?>
		<a class="responsive_movil_on" href="<?php echo $url_sesion?>"><?php echo $estado_sesion ?></a>
	</nav>
</div>