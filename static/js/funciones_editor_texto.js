$(window).on("load", function() {
	$('#editor_texto').summernote({
	  toolbar: [
	    // [groupName, [list of button]]
	    ['style', ['style']],
	    ['style', ['bold', 'italic', 'underline', 'clear']],
	    ['font', ['strikethrough', 'superscript', 'subscript']],
	    ['fontsize', ['fontsize']],
	    ['color', ['color']],
	    ['para', ['ul', 'ol', 'paragraph']],
	    ['view', [ 'codeview']],
	  ]
	});

});