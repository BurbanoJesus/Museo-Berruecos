<div class="contenido_fecha">
	<div class="select dia" id="dia" data="">
	<div class="head_select">
		<span class="nombre_select">Dia</span>
		<i class="icon-arrow"></i>
	</div>
	<div class="opciones">
			<?php for ($i=0; $i <= 31; $i++) { ?>
			<div class="opcion"><span><?php echo $i?></span></div>
			<?php } ?>
	</div>
	</div>
	<div class="select mes" id="genero" data="">
		<div class="head_select">
			<span class="nombre_select">Mes</span>
			<i class="icon-arrow"></i>
		</div>
		<div class="opciones">
			<?php for ($i=0; $i <= 11; $i++) { ?>
			<div class="opcion"><i class="icon-filled-check"></i><span><?php echo $months[$i]?></span></div>
			<?php } ?>
		</div>
	</div>
	<div class="select year" id="genero" data="">
		<div class="head_select">
			<span class="nombre_select">Año</span>
			<i class="icon-arrow"></i>
		</div>
		<div class="opciones">
			<?php for ($i=1920; $i <= $year_actual; $i++) { ?>
			<div class="opcion"><span><?php echo $i?></span></div>
			<?php } ?>
		</div>
	</div>
	<!-- <input id="fecha_nac" type="date" placeholder="Ingresar Edad..." required="true" /> -->
</div>


<?php 
// $id_old = $array[0]->id_lugar;
$id_old = '';
foreach ($array as $key => $row) {
	$id_new = $row->id_lugar;
	$type = type_multimedia($row->url);
	if ($id_new != $id_old) {
?>
	<div id="multimedia_museo" class="img" style="display: none;">
<?php }else{ 
		if ($type == 'imagen') { 
		?>
			<img index="0" src="<?php echo $row_principal->foto_principal?>" target="theater" class="call_theater multimedia" />
		<?php } else { ?>
			<video index="0" target="theater" class="call_theater multimedia" controls>
				<source src="<?php echo $row_principal->foto_principal?>" type="video/mp4">Your browser does not support HTML5 video
			</video>
	</div>
	<?php }
		$id_old= $row->id_lugar;
	}
}
?>

<?php 
$url = 'https://api.misdatos.com.co/api/co/consultarNombres';
$data = array('documentType' => 'CC', 'documentNumber' => '1032440675');

// use key 'http' even if you send the request to https://...
$options = array(
    'https' => array(
        'header'  => "Authorization: XXXXXXXXXXXXXXXXXXXXXXXXXXX",
        'header'  => "Content-Type: application/x-www-form-urlencoded",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }

var_dump($result);
?>


