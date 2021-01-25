$(function(){
	$('#s1').Jcrop({
		onChange: showCoords,
		onSelect: showCoords,
		aspectRatio: 1,
		setSelect : [0, 0, 200, 180],
	});
});

function cargar_jcrop(){
	$('#img_1').Jcrop({
		onChange: showCoords,
		onSelect: showCoords,
		aspectRatio: 1,
		setSelect : [0, 0, 250, 250],
	});
}

function showCoords(c)
{
	$('input[name="x"]').val(c.x);
	$('input[name="y"]').val(c.y);
	$('input[name="w"]').val(c.w);
	$('input[name="h"]').val(c.h);
};
