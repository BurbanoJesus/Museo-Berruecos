<header>
	<div class="header">
		<div class="top_login">
			<div class="actualizacion">
				<div class="div_ult_act responsive_movil_off">
					<span>Ultima actualizacion:</span>
					<span class="ult_act"></span>
				</div>
				<div class="redes">
					<i onclick="window.open('https://www.facebook.com/alcaldiadearboleda.berruecos','_blank')" class="icon-lineal-facebook"></i>
					<i class="icon-lineal-whatsapp"></i>
					<i class="icon-lineal-youtube"></i>
				</div>
			</div>
			<div class="sesion">
				<?php if(!isset($_SESSION['usuario'])){ ?>
				<a href="<?php echo HOST.'login'?>" class="login responsive_movil_off"><i class="icon-filled-user "></i>INICIAR SESIÓN</a>
				<?php } ?>
				<div class="init_perfil">
					<?php 
					$tipo_usuario = '';
					// var_dump($_SESSION['usuario']->usuario);
					if (isset($_SESSION['usuario'])){ 
						$usuario = $_SESSION['usuario']->usuario;
						$tipo_usuario = $_SESSION['usuario']->tipo_usuario;
						$img_preview= $_SESSION['usuario']->img_preview;
						if($tipo_usuario === 'administrador'){
							$str_nombre = $_SESSION['usuario']->tipo_usuario;
						}else{
							$str_nombre = $_SESSION['usuario']->nombres;
							$str_nombre = explode(' ',$str_nombre)[0];
						}
					?>
						<div class="menu_elemento usuario">
							<div class="info_sesion me_icon">
								<span class="main_sp"><?php echo ucfirst($str_nombre) ?></span>
								<div class="img_usuario">
									<img class="file_usuario" src="<?php echo $img_preview ?>" alt="" />
								</div>
							</div>
							<div class="me_opciones">
								<div class="me_info_detalles">
									<img src="<?php echo $img_preview ?>" alt="" />
									<span><?php echo ucfirst($str_nombre) ?></span>
									<span class="sub"><?php echo $_SESSION['usuario']->correo ?></span>
								</div>
								<?php if ($tipo_usuario != 'general'){ ?>
								<!-- <span class="me_opcion me_panel" onclick="window.location = '<?php echo HOST?>panel?id=lkuy'"><i class="icon-filled-set"></i>Panel PIC</span> -->
								<?php } ?>
								<span class="me_opcion me_ver_perfil"  onclick="window.location = '<?php echo HOST?>ver_perfil?id=<?php echo $usuario?>'"><i class="icon-filled-user"></i>Ver Perfil</span>
								<span class="me_opcion me_cerrar_sesion"  onclick="window.location = '<?php echo HOST?>logout'"><i class="icon-filled-power"></i>Cerrar Sesion</span>
							</div>
						</div>
					<?php }else{ ?>
						<!-- <i class="icon-perfil-login"></i> -->
						<!-- <div class="crear_cuenta">
							<a href="<?php echo $hostviews?>inicio/registrar_usuario" class="crear_cuenta">Crear Cuenta</a>
						</div> -->
					<?php } ?>
				</div>
			</div>
			<div class="main_titulo">
				<img class="img_top_login" src="<?php echo IMG?>logo.png" alt="logo" />
				<span>Museo Arqueológico Berrruecos</span>
			</div>
			<div class="responsive_menu responsive_movil_on">
				<i class="icon-filled-menu-b"></i>
			</div>
		</div>
		<?php include VIEWS.'templates/menu_i.php'; ?>
	</div>
</header>