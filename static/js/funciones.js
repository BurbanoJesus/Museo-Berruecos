    /**
 * Ajuste decimal de un número.
 *
 * @param {String}  tipo  El tipo de ajuste.
 * @param {Number}  valor El numero.
 * @param {Integer} exp   El exponente (el logaritmo 10 del ajuste base).
 * @returns {Number} El valor ajustado.
 */
function decimalAdjust(type, value, exp) {
    // Si el exp no está definido o es cero...
    if (typeof exp === 'undefined' || +exp === 0) {
        return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // Si el valor no es un número o el exp no es un entero...
    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
        return NaN;
    }
    // Shift
    value = value.toString().split('e');
    value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
}
// Decimal round
if (!Math.round10) {
    Math.round10 = function(value, exp) {
        return decimalAdjust('round', value, exp);
    };
}
// Decimal floor
if (!Math.floor10) {
    Math.floor10 = function(value, exp) {
        return decimalAdjust('floor', value, exp);
    };
}
// Decimal ceil
if (!Math.ceil10) {
    Math.ceil10 = function(value, exp) {
        return decimalAdjust('ceil', value, exp);
    };
}

// 
// FUNCIONES PARA LA VISTA INICIO
// 
//almacenar slider en una variable

// SLIDER
var slider = '';
var interval = '';
var sections = [];

function init_slider(){
    slider = $('#slider');
    sections = slider.find('section');
    sliderLength();
    if (sections.length == 1) {
        slider.closest('.contenedor_slider').find('#btn_prev').hide();
        slider.closest('.contenedor_slider').find('#btn_next').hide();
    }else{
        $('#slider .slider_section:last').insertBefore('#slider .slider_section:first');
        //mostrar la primera imagen con un margen de -100%
        slider.css('margin-left', '-'+100+'%');
    }
    // autoplay();
}

init_slider();

//mover ultima imagen al primer lugar
function sliderLength(){
    var slider_length = ($("#slider .slider_section").length*100);
    $("#slider").css('width',slider_length+'%');
}

function moverD() {
    slider.animate({
        marginLeft:'-'+200+'%'
    } ,700, function(){
        $('#slider .slider_section:first').insertAfter('#slider .slider_section:last');
        slider.css('margin-left', '-'+100+'%');
    });
}

function moverI() {
    slider.animate({
        marginLeft:0
    } ,700, function(){
        $('#slider .slider_section:last').insertBefore('#slider .slider_section:first');
        slider.css('margin-left', '-'+100+'%');
    });
}

function autoplay() {
    if (sections.length > 1) {
        interval = setInterval(function(){
            moverD();
        }, 3000);
    }
}

function destroy_slider(){
    if (interval !== ''){
        clearInterval(interval);
    }
}


$(document).on("click","#btn_next",function() {
    moverD();
    clearInterval(interval);
    autoplay();
});

$(document).on("click","#btn_prev",function() {
    moverI();
    clearInterval(interval);
    autoplay();
});



$(document).on("mouseenter mousedown",".slider", function(e){
    if (sections.length > 1) {
        clearInterval(interval);
    }
});

$(document).on("mouseleave",".slider", function(e){
    if (sections.length > 1) {
        clearInterval(interval);
        // autoplay();
    }
});

// ----
// ----
// MODAL, THEATER
$(window).resize(function() {
    // var width_window = document.body.scrollWidth;
    // var width_window = document.body.clientWidth;
    width_window = window.innerWidth;
    height_window = window.innerHeight;
    $(".modal").css({'width': width_window+'px'});
    $(".theater").css({'width': width_window+'px'});
});

var target = "";
var width_window = window.innerWidth;

function call_modal(target){
    var target = '#'+target;
    $(target).css("width",width_window+"px");
    $(target).fadeIn().css("display","inline-flex");
    $(target).find(".modal_main, .theater_main").show().css("display","block");
    // $('html').css('overflow','hidden');
    disableScrolling();
}

function call_theater(){
    $("#theater").css("width",width_window+"px");
    $("#theater").fadeIn().css("display","inline-flex");
    $("#theater").find(".theater_main").show().css("display","block");
    // $('html').css('overflow','hidden');
    if ($(".theater_content").height() > window.innerHeight) {
        $(".theater_content").css('padding-right','17px');
    }
    disableScrolling();
}

$(document).on("click",".modal .close, .modal .acept, .modal", function(e){ 
    e.stopPropagation();
    var target = '#'+$(this).closest('.modal').attr("id");
    $(target).fadeOut();
    $(target).find(".modal_main").fadeOut();
    $('html').css('overflow','auto');
    if(window.autoScroll){
      window.clearInterval(window.autoScroll);
      window.autoScroll = false;
    }
    enableScrolling();
});

$(document).on("click",".theater .close, .theater .acept, .theater", function(e){ 
    e.stopPropagation();
    var target = '#theater';
    $(target).fadeOut();
    $(target).find(".theater_main").fadeOut();
    $(target).find(".theater_content").children().remove();
    $('html').css('overflow','auto');
    if(window.autoScroll){
      window.clearInterval(window.autoScroll);
      window.autoScroll = false;
    }
    enableScrolling();
    destroy_slider();
});

$(document).on("click",".modal_main", function(e){ 
    e.stopPropagation();
});

$(document).on("click",".theater_main", function(e){ 
    e.stopPropagation();
});

$(document).on("click",".theater .indicador", function(e){ 
    e.stopPropagation();
});

function disableScrolling(){
    var x=window.scrollX;
    var y=window.scrollY;
    window.onscroll=function(){window.scrollTo(x, y);};
}

function enableScrolling(){
    window.onscroll=function(){};
}

$(document).on("click",".call_modal", function(){
    var target = "#"+$(this).attr("target");
    // console.log(target);
    call_modal(target);
});

//----
//----
//----

$(document).on("click",".call_theater", function(e){
    e.stopPropagation();
    var elemento = $(this);
    init_theater(elemento);
});

function init_theater(elemento){
    var target = "#theater";
    var source = elemento;
    var target_t = $(target).find(".theater_content");
    if (elemento.hasClass('multimedia')) {
        var data = elemento.closest('div.slider_multimedia').attr('id');
        var index = parseInt(elemento.attr('index'));
        var array = elemento.closest('div.slider_multimedia').find('div.file_multimedia').find('.imagen');
    }
    if (elemento.hasClass('simple')) {
        var data = elemento.closest('div.file_multimedia').attr('id');
        var index = parseInt(elemento.attr('index'));
        var array = elemento.closest('div.file_multimedia').find('.file');
        console.log(array);
    }
    if (elemento.hasClass('enlace')) {
        var data = elemento.attr("data_target");
        var array = $('#'+data).find('.file');
        source = array.eq(0);
        var index = parseInt(source.attr('index'));
    }

    source = source.prop('outerHTML');
    target_t.html(source);
    source = target_t.find('.file');
    source.prop('class','file');
    $(target).attr('data',data);
    // $(target).find('.indicador').html(index+'/'+array.length-1);
    var numero = index+1;
    var total = array.length;
    (total > 1) ? $(target).find('.indicador').html(numero+" / "+total) : true;
    check_index_theater(target,array,index);
    call_theater();
}


$(document).on("click",".theater .btn_left,.theater .btn_right", function(e){
    e.stopPropagation();
    var theater = "#"+$(this).closest('.theater').attr("id");
    var target_t = $(this).closest('.theater').find(".theater_content");
    var data = $(this).closest('.theater').attr('data');
    var index = parseInt($(this).attr('index'));
    if ($('#'+data).hasClass('slider_multimedia')) {
        var array = $('#'+data).find('div.file_multimedia').find('.imagen');
        var elemento = array.eq(index);
        var source = elemento.find('.file');
    }
    else{
        var array = $('#'+data).find('.file');
        var elemento = array.eq(index);
        var source = elemento;
    }
    source = source.prop('outerHTML');
    target_t.html(source);
    source = target_t.find('.file');
    source.prop('class','');
    var numero = index+1;
    var total = array.length;
    $(theater).find('.indicador').html(numero+" / "+total);
    check_index_theater(theater,array,index);
});

function check_index_theater(theater,array,index){
    var btn_left = $(theater).find('.btn_left');
    var btn_right = $(theater).find('.btn_right');
    btn_left.show();
    btn_right.show();
    if (array.length == 1) {
        btn_left.attr('index',0).hide();
        btn_right.attr('index',0).hide();
    }
    else if (index == 0) {
        btn_left.attr('index',array.length-1);
        btn_right.attr('index',index+1);
    }
    else if(index == array.length-1){
        btn_left.attr('index',index-1);
        btn_right.attr('index',0);
    }
    else if(index > 0 && index < array.length-1){
        btn_left.attr('index',index-1);
        btn_right.attr('index',index+1);
    }
}


function type_multimedia(url){
    url = url.split('/');
    nombre = url.pop();
    nombre = nombre.split('.');
    extension = nombre.pop();
    extension = extension.trim();
    extension = extension.toLowerCase();
    // echo extension;
    if (extension == 'jpg' || extension == 'png' || extension == 'jpeg') {
        type = 'imagen';
    } else {
        type = 'video';
    }
    return type;
}
// 

// MENU ELEMENTO

$(document).on("click",".menu_elemento", function(e){
    e.stopPropagation();
    var menu = $(this);
    var me_opciones = menu.find('.me_opciones');
    var flag_open = true;
    // SABER SI TIENE LA CLASE OPEN
    if (me_opciones.hasClass('me_open')){
        flag_open = true;
    }else{
        flag_open = false;
    }
    //OCULTAR LOS DEMAS MENUS 
    $('.me_opciones').hide();
    $('.me_opciones').removeClass('me_open');
    
    //AGREGAR LA CLASE OPEN DEL ELEMENTO ACTUAL SI ES NECESARIO 
    if (flag_open){
        me_opciones.addClass('me_open');
    }
    //COMPROBAR
    if (me_opciones.hasClass('me_open')){
        me_opciones.hide();
        me_opciones.removeClass('me_open');
    }else{
        me_opciones.show();
        me_opciones.addClass('me_open');
    }
});
// 
$(document).on("click",".me_info_detalles", function(e){
    e.stopPropagation();
});
// 
$(document).on("click","form#form_lista_piezas .parent_me_elemento", function(e){
    e.stopPropagation();
    var id = $(this).attr('id_data');
    window.location = '/museo/detalles_pieza?id='+id;    
});
//
$(document).on("click","form#form_lista_piezas .me_editar", function(e){
    e.stopPropagation();
    var id = $(this).closest('.parent_me_elemento').attr('id_data');
    window.location = '/museo/editar_pieza?id='+id;
});

$(document).on("click",".me_eliminar", function(e){
    e.stopPropagation();
    console.log('str_inicio');
    var id = $(this).closest('.parent_me_elemento').attr('id_data');
    var url_data = $(this).closest('.parent_me_elemento').attr('url_data');
    var elemento = $(this).closest('.parent_me_elemento').prop('id');
    var modelo = $(this).closest('.parent_me_elemento').prop('model');
    var template_modal = '<div id="modal_eliminar" class="modal modal_eliminar">'+
            '<div class="modal_main" style="width: 500px; height: 200px;">'+
                '<i class="icon-cancelar-b close"></i>'+
                '<div class="modal_content modal_confirmar">'+
                    '<div>'+
                        '<span class="sp_confirmar"> ¿Esta seguro de eliminar el registro? </span>'+
                    '</div>'+
                    '<div class="content_button">'+
                        '<button class="button acept me_confirmar_eliminar" type="button" id_data="'+id+'" el_data="'+elemento+'" url_data="'+url_data+'" model="'+modelo+'">Si</button>'+
                        '<button class="button acept bg_cancel" type="button">Cancelar</button>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>';
    $("#div_mod_eliminar").html(template_modal);
    call_modal('modal_eliminar');
});

$(document).on("click",".me_confirmar_eliminar", function(e){
    e.stopPropagation();
    var id = $(this).attr('id_data');
    var id_elemento = $(this).attr('el_data');
    var url_data = $(this).attr('url_data');
    var modelo = $(this).attr('model');
    var elemento = $('#'+id_elemento);
    console.log(id_elemento);
    console.log(elemento);
    $.ajax({
        url: '/museo/core/controllers/inicio/'+url_data+'.php',
        method: 'POST',
        data: {id : id},
        // dataType:  "json",
        beforeSend: function() {
            // $("#divres").html("<img src='images/ajax-loader.gif'>");
        },
        success: function(datos){
            console.log(datos);
            datos = JSON.parse(datos);
            if (datos.error === false){
                elemento.remove();
            }else{
                var template = '<div class=""><div class="validate_msj ajax">Ha ocurrido un error</div></div>';
                $('.contenido').append(template);
            }
        },
        error:function(xhr, status, error){
              if (xhr.responseText.indexOf('<html>') != -1) {
                var str_inicio = xhr.responseText.indexOf('<p>');
                var str_final = xhr.responseText.indexOf('</p>');
                var str_error = xhr.responseText.substring(str_inicio+3,str_final);
                console.log(str_error);
            }else{
                console.log(xhr.responseText);
            }
        }
    });
});

//RESPONSIVE
$(document).on("click",".responsive_menu", function(e){
    $("div.menu").toggle();
});

$(document).on("click",".r_filtros", function(e){
   $("div.filtros").toggle();
});

//
//
//

$(window).on("load", function() {

    $('i.icon-filled-lupa[type=submit],a[type=submit],button[type=submit]').attr('disabled',false);
    // 
    // FUNCIONES PARA LA VISTA MUNICIPIO
    // 


    // ----
    // ----
    // MODAL, THEATER
    // $(window).resize(function() {
    //     // var width_window = document.body.scrollWidth;
    //     // var width_window = document.body.clientWidth;
    //     width_window = window.innerWidth;
    //     $(".modal").css({'width': width_window+'px'});
    //     $(".theater").css({'width': width_window+'px'});
    // });

    // var target = "";
    // var width_window = window.innerWidth;

    // function call_modal(target){
    //     $(target).css("width",width_window+"px");
    //     $(target).fadeIn().css("display","inline-flex");
    //     $(target).find(".modal_main, .theater_main").show().css("display","block");
    //     // $('html').css('overflow','hidden');
    //     disableScrolling();
    // }

    // function call_theater(){
    //     $("#theater").css("width",width_window+"px");
    //     $("#theater").fadeIn().css("display","inline-flex");
    //     $("#theater").find(".theater_main").show().css("display","block");
    //     // $('html').css('overflow','hidden');
    //     disableScrolling();
    // }

    // $(document).on("click",".modal .close, .modal .acept, .modal", function(e){ 
    //     e.stopPropagation();
    //     var target = '#'+$(this).closest('.modal').attr("id");
    //     console.log(target);
    //     $(target).fadeOut();
    //     $(target).find(".modal_main").fadeOut();
    //     $('html').css('overflow','auto');
    //     if(window.autoScroll){
    //       window.clearInterval(window.autoScroll);
    //       window.autoScroll = false;
    //     }
    //     enableScrolling();
    // });

    // $(document).on("click",".theater .close, .theater .acept, .theater", function(e){ 
    //     e.stopPropagation();
    //     var target = '#'+$(this).closest('.theater').attr("id");
    //     $(target).fadeOut();
    //     $(target).find(".theater_main").fadeOut();
    //     $(target).find(".theater_content").children().remove();
    //     $('html').css('overflow','auto');
    //     if(window.autoScroll){
    //       window.clearInterval(window.autoScroll);
    //       window.autoScroll = false;
    //     }
    //     enableScrolling();
    // });

    // $(document).on("click",".modal_main", function(e){ 
    //     e.stopPropagation();
    // });

    // $(document).on("click",".theater_main", function(e){ 
    //     e.stopPropagation();
    // });

    // $(document).on("click",".theater .indicador", function(e){ 
    //     e.stopPropagation();
    // });

    // function disableScrolling(){
    //     var x=window.scrollX;
    //     var y=window.scrollY;
    //     window.onscroll=function(){window.scrollTo(x, y);};
    // }

    // function enableScrolling(){
    //     window.onscroll=function(){};
    // }

    // $(document).on("click",".call_modal", function(){
    //     var target = "#"+$(this).attr("target");
    //     // console.log(target);
    //     call_modal(target);
    // });

    // //----
    // //----
    // //----

    // $(document).on("click",".call_theater", function(e){
    //     e.stopPropagation();
    //     var elemento = $(this);
    //     init_theater(elemento);
    // });

    // function init_theater(elemento){
    //     var target = "#theater";
    //     var source = elemento;
    //     var target_t = $(target).find(".theater_content");
    //     if (elemento.hasClass('multimedia')) {
    //         var data = elemento.closest('div.slider_multimedia').attr('id');
    //         var index = parseInt(elemento.attr('index'));
    //         var array = elemento.closest('div.slider_multimedia').find('div.file_multimedia').find('.imagen');
    //     }
    //     if (elemento.hasClass('simple')) {
    //         var data = elemento.closest('div.file_multimedia').attr('id');
    //         var index = parseInt(elemento.attr('index'));
    //         var array = elemento.closest('div.file_multimedia').find('img,video');
    //         console.log(array);
    //     }
    //     if (elemento.hasClass('enlace')) {
    //         var data = elemento.attr("data_target");
    //         var array = $('#'+data).find('img,video');
    //         source = array.eq(0);
    //         var index = parseInt(source.attr('index'));
    //     }

    //     if (elemento.hasClass('ajax_slider_theater')) {
    //         var data = elemento.attr("target");

    //         var array = [];
    //         var source = '';
    //         var index = 0;
    //     }
    //     // source = source.prop('outerHTML');
    //     target_t.html(source);
    //     source = target_t.find('img,video');
    //     source.prop('class','');
    //     $(target).attr('data',data);
    //     // $(target).find('.indicador').html(index+'/'+array.length-1);
    //     var numero = index+1;
    //     var total = array.length;
    //     (total > 1) ? $(target).find('.indicador').html(numero+" / "+total) : true;
    //     check_index_theater(target,array,index);
    //     call_theater();
    // }


    // $(document).on("click",".theater .btn_left,.theater .btn_right", function(e){
    //     e.stopPropagation();
    //     var theater = "#"+$(this).closest('.theater').attr("id");
    //     var target_t = $(this).closest('.theater').find(".theater_content");
    //     var data = $(this).closest('.theater').attr('data');
    //     var index = parseInt($(this).attr('index'));
    //     if ($('#'+data).hasClass('slider_multimedia')) {
    //         var array = $('#'+data).find('div.file_multimedia').find('.imagen');
    //         var elemento = array.eq(index);
    //         var source = elemento.find('img,video');
    //     }
    //     else{
    //         var array = $('#'+data).find('img,video');
    //         var elemento = array.eq(index);
    //         var source = elemento;
    //     }
    //     source = source.prop('outerHTML');
    //     console.log(array);
    //     target_t.html(source);
    //     source = target_t.find('img,video');
    //     source.prop('class','');
    //     var numero = index+1;
    //     var total = array.length;
    //     $(theater).find('.indicador').html(numero+" / "+total);
    //     check_index_theater(theater,array,index);
    // });

    // function check_index_theater(theater,array,index){
    //     var btn_left = $(theater).find('.btn_left');
    //     var btn_right = $(theater).find('.btn_right');
    //     btn_left.show();
    //     btn_right.show();
    //     if (array.length == 1) {
    //         btn_left.attr('index',0).hide();
    //         btn_right.attr('index',0).hide();;
    //     }
    //     else if (index == 0) {
    //         btn_left.attr('index',array.length-1);
    //         btn_right.attr('index',index+1);
    //     }
    //     else if(index == array.length-1){
    //         btn_left.attr('index',index-1);
    //         btn_right.attr('index',0);
    //     }
    //     else if(index > 0 && index < array.length-1){
    //         btn_left.attr('index',index-1);
    //         btn_right.attr('index',index+1);
    //     }
    // }





     // $(document).on("play","#video", function(){
     //    console.log('video');
     // });
    // $("video").on('play', function(e){
    //     console.log('this');
    // });
    

    // SLIDER MULTIMEDIA
    $(document).on("click",".slider_multimedia .imagen", function(){
        var elemento = $(this);
        var array= $(this).parent().children();
        var source = $(this).find('.file');
        // console.log(source);
        var index = parseInt($(this).attr("index"));
        var target = $(this).closest(".slider_multimedia").find('.current_mult');
        var slider_multimedia = $(this).closest('.slider_multimedia');
        console.log(source);
        source = source.prop('outerHTML');
        target.html(source);
        source = target.find('.file');
        source.attr('index',index);
        source.prop('class','call_theater multimedia file');
        source.attr('target','theater');

        array.removeClass('active');
        elemento.addClass('active');
        console.log(index);
        var btn_left = slider_multimedia.find('.btn_left');
        var btn_right = slider_multimedia.find('.btn_right');
        if (index == 0) {
            btn_left.attr('index',array.length-1);
            btn_right.attr('index',index+1);
        }
        else if(index == array.length-1){
            btn_left.attr('index',index-1);
            btn_right.attr('index',0);
        }
        else if(index > 0 && index < array.length-1){
            btn_left.attr('index',index-1);
            btn_right.attr('index',index+1);
        }
    });

    $(document).on("click",".slider_multimedia .img_main .btn_left, .slider_multimedia .img_main .btn_right", function(e){
        e.stopPropagation();
        var index = parseInt($(this).attr("index"));
        var array= $(this).closest('.slider_multimedia').find('div.file_multimedia').find('.imagen');
        var elemento = array.eq(index);
        var source = elemento.find('.file');
        var target = $(this).closest(".img_main").find('.current_mult');
        var slider_multimedia = $(this).closest('div.slider_multimedia');
        var slider_num_imgs = slider_multimedia.attr('numero_imgs');
        source = source.prop('outerHTML');
        console.log(source);
        console.log(index);
        target.html(source);
        target.attr('index',index);
        source = target.find('.file');
        source.attr('index',index);
        source.prop('class','call_theater multimedia file');
        source.attr('target','theater');

        console.log(index);
        var btn_left = slider_multimedia.find('.btn_left');
        var btn_right = slider_multimedia.find('.btn_right');
        if (index == 0) {
            btn_left.attr('index',array.length-1);
            btn_right.attr('index',index+1);
        }
        else if(index == array.length-1){
            btn_left.attr('index',index-1);
            btn_right.attr('index',0);
        }
        else if(index > 0 && index < array.length-1){
            btn_left.attr('index',index-1);
            btn_right.attr('index',index+1);
        }


        if (index <= slider_num_imgs) {
            array.removeClass('active');
            elemento.addClass('active');
        }else{
            array.eq(slider_num_imgs).addClass('active');
        }
    });


    // TIPO DE VISTA
    $(document).on("click",".vista .vista_lista", function(){
        if ($("div#contenido").hasClass('contenido_g')) {
            $("div.contenido_g").removeClass('contenido_g');
            $("div.busqueda_g").removeClass('busqueda_g');
            $("div.productos_g").removeClass('productos_g').addClass('productos');
            $("div.info_producto_g").removeClass('info_producto_g').addClass('info_producto');
            $(".vista_grid").removeClass('active');
            $(this).addClass('active');
        }
    });

     $(document).on("click",".vista .vista_grid", function(){
        if ($("div#contenido").hasClass('contenido')) {
            $("div.contenido").addClass('contenido_g');
            $("div.busqueda").addClass('busqueda_g');
            $("div.productos").removeClass('productos').addClass('productos_g');
            $("div.info_producto").removeClass('info_producto').addClass('info_producto_g');
            $(".vista_lista").removeClass('active');
            $(this).addClass('active');
        }
    });
    // 

    

    // FILTROS
    // 
    // CHECK
    $(document).on("click",".check .elemento", function(){
        var elemento = $(this);
        var data_elemento = $(this).find('span').html();
        var check = $(this).closest('.check');
        var data_check = $(this).closest('.check').attr('data');
        if (data_elemento != data_check) {
            check.find(".elemento").css({'color':'var(--gris)'});
            elemento.css({'color':'var(--verde_check)'});
            check.attr('data',data_elemento);
            console.log(check);
            check.find('input[type="hidden"]').val(data_elemento);
        }else{
            elemento.css({'color':'var(--gris)'});
            check.attr('data','');
            console.log('sadio');
            check.find('input[type="hidden"]').val('');
        }
    });

    function checked(check){
        $(".check .elemento").each(function(index,value){
            var check = $(this).closest('.check');
            var elemento = $(this);
            var data_elemento = $(this).find('span').html();
            if (elemento.attr('checked') == 'checked'){
                check.find(".elemento").css({'color':'var(--gris)'});
                elemento.css({'color':'var(--verde_check)'});
                check.attr('data',data_elemento);
                check.find('input[type="hidden"]').val(data_elemento);
            }
        });
    }
    checked();

    function checked_elem(check){
        check.find('.elemento').each(function(index,value){
            var check = $(this).closest('.check');
            var elemento = $(this);
            var data_elemento = $(this).find('span').html();
            if (elemento.attr('checked') == 'checked'){
                check.find(".elemento").css({'color':'var(--gris)'});
                elemento.css({'color':'var(--verde_check)'});
                check.attr('data',data_elemento);
                check.find('input[type="hidden"]').val(data_elemento);
            }
        });
    }

    function data_check(){
        $(".check").each(function(index,value){
            var check = $(this);
            var data = $(this).attr('data');
            var array = $(this).find('.elemento span');
            if (data.length > 0) {
                array.each(function(index,value){
                    if(value.innerHTML == data){
                        console.log(value);
                        console.log(data);
                        array.eq(index).closest('.elemento').attr('checked','');
                        checked_elem(check);
                    }
                });
            }
        });
    }
    data_check();
    // 

    var target_actual = {};
    // SELECT
    $(document).on("mousedown",".select .head_select", function(){
        target_actual = $(this).parent();
        var elemento = $(this);
        var target = elemento.parent().find('.opciones');
        console.log(target);
        if (target.hasClass('slider_down')) {
            target.hide();
            target.removeClass('slider_down');
        }else{
            target.show();
            target.addClass('slider_down');
        }
    });

    $(document).on("click",".select .opciones .opcion", function(){
        var elemento = $(this);
        var data_elemento = $(this).find('span').html();
        var select = $(this).closest('.select');
        var data_select = $(this).closest('.select').attr('data');
        if (data_elemento != data_select) {
            select.attr('data',data_elemento);
            select.find('.head_select').find('.nombre_select').html(data_elemento);
            select.find('input[type="hidden"]').val(data_elemento);
            console.log(select.find('input[type="hidden"]'));
            if (elemento.hasClass('default')){
                select.find('input[type="hidden"]').val('');
            }
        }
        $(this).parent().hide();
    });

    function validar_select(flag_validar){
        var array_select = [];
        $(".select").each(function(index,value){
            if (!$(this).attr('data')) {
                console.log('this');
                $(this).find('.head_select').css({'border-color':'#D93025'});
                $(this).find('.head_select i').css({'color':'#D93025'});
                array_select.push(false);
            }
            else{
                $(this).find('.head_select').css({'border-color':'var(--gris)'});
                $(this).find('.head_select i').css({'color':'var(--gris)'});
                array_select.push(true);
            }
        });
        array_select.forEach(function(value,index){
            if (value == false) {
                flag_validar = false;
            }
        });
        return flag_validar;
    }
    
    function data_select(){
        $(".select").each(function(index,value){
            var select = $(this);
            var data = select.attr('data');
            if (data.length > 0){
                select.find('.head_select').find('.nombre_select').html(data);
                select.find('input[type="hidden"]').val(data);
            }
        });
    }

    data_select();
    
    function selected(){
        $(".select .opciones .opcion").each(function(index,value){
            var select = $(this).closest('.select');
            var elemento = $(this);
            if (elemento.attr('selected') == 'selected'){
                var data = elemento.find('span').html();
                select.attr('data',data);
                select.find('.head_select').find('.nombre_select').html(data);
                select.find('input[type="hidden"]').val(data);
            }
        });
    }

    selected();


    // 

     // OCULTAR LOS OBJETOS AL HACER CLICK AFUERA DE ELLOS

    $(document).on('mousedown', function(e) 
    {
        var select = $(".select, .select .head_select,.select i,.select span");
        var menu_elemento = $(".menu_elemento");
        var select_op = $(".select .opciones");
        target = $(e.target);
        // console.log(select.is(target));
        // console.log(select.has(target).length);
        // console.log(target[0]);

        // if the target of the click isn't the container nor a descendant of the container
        if (!select.is(target) && select.has(target).length === 0){
            console.log(target);
            select_op.hide().removeClass('slider_down');
        }

        if (!menu_elemento.is(target.closest('.menu_elemento'))){
            console.log(target);
            menu_elemento.find('.me_opciones').removeClass('me_open').hide();
        }
      
    });
    // 

    // ACCORDION

    // $('.accordion_contenido').hide();
    $(document).on("click",".accordion_elemento .nombre_elemento", function(e){
        var elemento = $(this);
        var target = elemento.next();


        // accordionItemHeader = this;
        // accordionItemHeader.classList.toggle("active");
        // const accordionItemBody = accordionItemHeader.nextElementSibling;
        // if(accordionItemHeader.classList.contains("active")) {
        //   accordionItemBody.style.maxHeight = accordionItemBody.scrollHeight + "px";
        // }
        // else {
        //   accordionItemBody.style.maxHeight = 0;
        // }

        console.log(target.prop('scrollHeight'));
        var scroll_height = target.prop('scrollHeight');

        elemento.toggleClass('open');
        if (elemento.hasClass('open')) {
            elemento.find('.arrow_accordion').css({'transform': 'translateY(-50%) rotate(270deg)'});
            target.css('max-height',scroll_height+'px');
        } 
        else {
            elemento.find('.arrow_accordion').css({'transform': 'translateY(-50%) rotate(90deg)'});
            target.css({'max-height':'0px'});
        }
        // console.log(this);
    });
    // 

   

    //TEXTAREA
    function setTextareaHeight(textareas) {
        textareas.each(function () {
            var textarea = $(this);
            var extraHeight = 0;
            extraHeight = parseInt(textarea.css('padding-top')) + parseInt(textarea.css('padding-bottom')), // to set total height - padding size
                h = textarea[0].scrollHeight - extraHeight;
     
            if ( !textarea.hasClass('autoHeightDone') ) {
                textarea.addClass('autoHeightDone');
                // init height
                textarea.height('auto').height(h);

                textarea.bind('keyup', function() {
                    textarea.removeAttr('style'); // no funciona el height auto
                    h = textarea.get(0).scrollHeight - extraHeight;
                    textarea.height(h+'px'); // set new height
                });
            }else{
                console.log('po');
                textarea.height('auto').height(h);
                textarea.removeAttr('style'); // no funciona el height auto
                h = textarea.get(0).scrollHeight - extraHeight;
                textarea.height(h+'px');
            }
        })
    }
    setTextareaHeight($('textarea'));
    //




    // LOGIN
    $("form .input_login input").each(function(index,value){
        if ($(this).val().length > 0) {
            console.log($(this).length);
            $(this).next().addClass('input_fijo');
        }
    });
  

     $("form .input_login input").on('focusout', function(){
        if ($(this).val().length > 0) {

            $(this).next().addClass('input_fijo');
        } else {
            $(this).next().removeClass('input_fijo');
        }
    });


    $(document).on("click","i.pass", function(e){
        var icon = $(this);
        var input = $(this).closest('.input_login, .contenido_input').find('input');
        if (icon.hasClass('icon-lineal-visible')) {
            $(this).removeClass('icon-lineal-visible').addClass('icon-lineal-no-visible');
            input.attr('type','text').focus();

        } else {
            $(this).removeClass('icon-lineal-no-visible').addClass('icon-lineal-visible');
            input.attr('type','password').focus();
        }
    });

    //

    // VISTA LISTA ARTICULOS


    //



    // REGISTRAR PIEZA
    // INPUT FILE NO SE LE PUEDE HACER SET POR SEGURIDAD, PARA LEERLO Y MODIFICARLO ES NECESARIO GUARDARLO EN ARRAY INDEPENDIENTE,LUEGO ESTE ARRAY SE PUEDE ENVIAR A ARCHIVOS PHP.
    var filecollection = new Array();
    $(document).on('change','.input_preview', function(e){
        var elemento = $(this);
        var files = e.target.files;
        var agregar_mult = $('#loading_inf_1');
        $.each(files, function(i,file){
           
            filecollection.push(file);
           
            var reader = new FileReader();

            var type = file.type.split("/");
            type = type[0];
            var name = file.name;

            console.log(file);

            $('#loading_inf_1').css({'display':'inline-flex'});

            if (type == 'image') {
                reader.readAsDataURL(file);
                reader.onload = function(e){
                    var template ='<div class="div_img"><img id="img_1" class="img_pdf" src="'+e.target.result+'" alt="" /><i class="icon-filled-no-check quitar_img"></i></div>';
                    agregar_mult.before(template);
                    if (elemento.hasClass('input_jcrop')){
                        cargar_jcrop();
                    }
                }
            }else{
                var template ='<div class="div_img"><div class="video_preview"><div class="play_logo"></div><p class="video_name">Video: '+name+'</p></div><i class="icon-filled-no-check quitar_img"></i></div>';
                    agregar_mult.before(template);
                    console.log(agregar_mult);
            }
            
            $('#loading_inf_1').css({'display':'none'});

            // reader.onprogress = function(e) {
            //     // if(e.lengthComputable) {
            //     //     var percentLoaded = Math.round( (
            //     //     e.loaded * 100) / e.total );
            //     // }
            //     // // console.log("total: " + progressEvent.total + ", loaded: "
            //     // //   + progressEvent.loaded + "(" + percentLoaded + "%)");
            //     // console.log('1');
            // }
       });
    });

    $(document).on('click','.div_img .quitar_img', function(e){
        var index = $(".div_img .quitar_img").index($(this));
        var input = $(this).closest('.contenido_img').find('input');
        console.log(input);
        if (input.hasClass('input_file_one')){
            input.closest('.agregar_mult').show();
            input.val('');
        }
        $('.agregar_mult input.input_mult').eq(index).remove();
        $(this).closest('.div_img').remove();
    });

    // 
    var cont_input_mult = 2;
    $(document).on("change", ".input_mult", function(event){
        // console.log('this');
        var template = '<input class="input_mult input_preview" id="input_file_'+cont_input_mult+'" name="images[]" type="file" multiple /><label class="label_icon icon-filled-add-multimedia" for="input_file_'+cont_input_mult+'"></label><div class="content_button"><label class="button" for="input_file_'+cont_input_mult+'">Agregar</label></div>';
        $(this).parent().children().hide();
        $('.agregar_mult').append(template);
        cont_input_mult++;
    });


    $(document).on("change", ".input_file_one", function(event){
        $(this).parent().hide();
    });


    //
    // REGISTRAR JUEGO

    var cont_preguntas = 2;

    $(document).on("click", "#add_pregunta", function(event){
        var template = '<div class="input s100"><h3>Pregunta '+cont_preguntas+'.</h3><div class="contenido_input"><textarea class="input input_text" name="pregunta_'+cont_preguntas+'" id="" placeholder="Ingresar Descripción..."></textarea></div></div><div class="input s100"><h3>Respuesta '+cont_preguntas+'.</h3><div class="select" id="categoria" data=""><div class="head_select"><span class="nombre_select">Seleccione respuesta</span><i class="icon-arrow"></i></div><div class="opciones"><div class="opcion"><i class="icon-filled-check"></i><span>Verdadero</span></div><div class="opcion"><i class="icon-filled-check"></i><span>Falso</span></div></div><input type="hidden" name="respuesta_'+cont_preguntas+'" value="" required /></div></div><div class="input s100"><h3>Agregar Imagen.</h3><div class="contenido_input"><div id="contenido_img" class="contenido_img"><div class="agregar_mult"><input class="input_preview input_file_one" id="input_file_'+cont_preguntas+'" name="image_'+cont_preguntas+'" type="file" accept="image/*" required /><label class="label_icon icon-filled-add-multimedia" for="input_file_'+cont_preguntas+'"></label><div class="div_button"><label class="button" for="input_file_'+cont_preguntas+'">Agregar</label></div></div></div></div></div>';
        $('.contenido_preguntas').append(template);
        cont_preguntas++;
        $('#remove_pregunta').removeClass('disable');
    });

    $(document).on("click", "#remove_pregunta", function(event){
        var array = $('.contenido_preguntas').children();
        var length = array.length;
        if (length >= 6){
            array[length-1].remove();
            array[length-2].remove();
            array[length-3].remove();
            cont_preguntas--;
            if (length == 6){
               $(this).addClass('disable');
            }
        }
    });
    // 

    // FECHAS
    var months = new Array('Enero','Febrero','Marzo','Abril','Mayo',
    'Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth();
    var month_b = date.getMonth() + 1;
    var yy = date.getFullYear();
    var hour = date.getHours();
    var min = date.getMinutes();
    var seconds = date.getSeconds();
    var options = {hour: 'numeric', minute: 'numeric', hour12: true };
    var hous_mod = date.toLocaleString('es-CO', options);
    var month_mod = months[month];
    
    var hora_i = format_input_time(hour,min);
    var fecha_i = format_input_date(day,month_b,yy);
    // $("#fecha_a").val(fecha_i);
    $("input[name='fecha']").val(fecha_i+' '+hora_i);

    var fecha_ult_act = to_fecha_str(fecha_i);
    $("span.ult_act").html(fecha_ult_act);

    function format_input_date(day,month,yy){
        month = (month < 10 ? "0" : "") + month;
        day = (day < 10 ? "0" : "") + day;
        return yy+'-'+month+'-'+day;
    }

    function format_input_time(hour,min,seconds = '00'){
        hour = (hour < 10 ? "0" : "") + hour;
        min = (min < 10 ? "0" : "") + min;
        return hour+':'+min+':'+seconds;
    }

    function to_fecha_str(fecha){
        fecha = fecha.substring(0,10);
        fecha = fecha.split('-');
        yy = fecha[0];
        month = fecha[1];
        day = parseInt(fecha[2]);
        fecha = day+' de '+months[month-1]+' de '+yy;
        return fecha;
    }

    function dif_fecha(fecha_1,fecha_2){
        // Agregar hora por default en caso de recibir fecha sin la hora
        fecha_1 = (fecha_1.search(" ") == -1) ? fecha_1 +=" 00:00:00" : fecha_1;
        fecha_2 = (fecha_2.search(" ") == -1) ? fecha_2 +=" 00:00:00" : fecha_2;
        // Guardar en aux las fechas para cambiar el orden segun cual sea la fecha mayor
        var aux_fecha_1 = fecha_1;
        var aux_fecha_2 = fecha_2;
        // Crear objeto fecha para las dos fechas
        var fecha_1 = new Date(fecha_1);
        var fecha_2 = new Date(fecha_2);
        // Crear variables de las fechas en milisegundos
        var fecha_1_time = fecha_1.getTime();
        var fecha_2_time = fecha_2.getTime();

        // Verificar cual fecha es mayor y establecer fecha inicial(1) y fecha final(2)
        if (fecha_1_time < fecha_2_time) {
            var str_fecha_1 = aux_fecha_1;
            var str_fecha_2 = aux_fecha_2;
            diferencia = fecha_2_time - fecha_1_time;
        }
        else{
            var str_fecha_1 = aux_fecha_2;
            var str_fecha_2 = aux_fecha_1;
            diferencia = fecha_1_time - fecha_2_time;
        }

        // extraer el año, mes y dia de cada fecha
        var values_1 = str_fecha_1.split(" ")[0].split("-");
        var yy_1 = values_1[0];
        var mm_1 = values_1[1];
        var dd_1 = values_1[2];
        //
        var values_2 = str_fecha_2.split(" ")[0].split("-");
        var yy_2 = values_2[0];
        var mm_2 = values_2[1];
        var dd_2 = values_2[2];

        year_inicio = parseInt(yy_1);
        year_final = parseInt(yy_2);
        mes_inicio = parseInt(mm_1);
        mes_final = parseInt(mm_2); 
        dia_inicio = parseInt(dd_1);
        dia_final = parseInt(dd_2);

        // 
        segundos = diferencia/1000;

        if (segundos >= 60) {
            minutos = segundos/60;
            minutos = Math.floor10(minutos);
            segundos = segundos%60;
        } else {
            minutos = 0;
        }
        console.log(minutos);
        console.log(segundos);

        if (minutos >= 60) {
            horas = minutos/60;
            horas = Math.floor10(horas);
            minutos = minutos%60;
        } else {
            horas = 0;
        }
        console.log(minutos);

        if (horas >= 24) {
            dias = horas/24;
            dias = Math.floor10(dias);
            horas = horas%24;
        } else {
            dias = 0;
        }


        var years_evaluados = [];
        var dias_bisiestos = 0;
        var aux_year_inicio = year_inicio;
        var aux_year_final = year_final;

        console.log('dias: '+dias);

        for (var year_i = year_inicio; year_i <= year_final; year_i ++){
            if (((year_i % 4 == 0) && (year_i % 100 != 0 )) || (year_i % 400 == 0)){
                 switch(true){
                    case aux_year_inicio == aux_year_final:
                        if (mes_inicio <= 2){
                            if ((mes_inicio == 2 && dia_inicio <=29 && mes_final >= 3) || (mes_inicio == 1 && dia_inicio <=31 && mes_final >= 3)) {
                                dias_bisiestos++;
                            }
                        }
                        break;

                    case aux_year_inicio == year_i:
                        if (mes_inicio <= 2 && dia_inicio <= 31){
                            dias_bisiestos++;
                            // console.log('bi <');
                        }
                        break;

                    case aux_year_final == year_i:
                        if (mes_final >= 3){
                                dias_bisiestos++;
                                // console.log('bi <');
                        }
                        break;

                    default:
                        dias_bisiestos++;
                        // console.log('bi otro');
                        break;
                }
            }
        }
        (dias >= 28 ) ? dias -= dias_bisiestos: true;
        // console.log(dias);
        console.log('dias bi: '+dias_bisiestos);

        var dias_cada_mes = [0,31,28,31,30,31,30,31,31,30,31,30,31];
        var meses = 0;
        var aux_mes_inicio = mes_inicio;
        var aux_mes_final = mes_final;

        if (dias >= 365) {
            years = dias/365;
            years = Math.floor10(years);
            dias = dias%365;
        } else {
            years = 0;
        }
        // 06 - 04
        switch(true){
            case mes_inicio > mes_final:
                for (mes_inicio; mes_inicio <= 12; mes_inicio++) {
                    if (dias >= dias_cada_mes[mes_inicio]) {
                        dias -= dias_cada_mes[mes_inicio];
                        meses++;
                        console.log(dias);
                    }
                }
                for (i = 1; i <= mes_final; i++) {
                   if (dias >= dias_cada_mes[i]) {
                        dias -= dias_cada_mes[i];
                        meses++;
                        console.log(dias);
                    }
                }
                break;

            case mes_inicio < mes_final:
                for (mes_inicio; mes_inicio <= mes_final; mes_inicio++) {
                    if (dias >= dias_cada_mes[mes_inicio]) {
                        dias -= dias_cada_mes[mes_inicio];
                        meses++;
                    }
                }
                break;

            case mes_inicio == mes_final && dias >= 334:
                for (mes_inicio; mes_inicio <= 12; mes_inicio++) {
                    if (dias >= dias_cada_mes[mes_inicio]) {
                        dias -= dias_cada_mes[mes_inicio];
                        meses++;
                    }
                }
                for (i = 1; i < mes_final; i++) {
                   if (dias >= dias_cada_mes[i]) {
                        dias -= dias_cada_mes[i];
                        meses++;
                    }
                    console.log(dias);
                }
                break;

        }
        console.log('meses :'+meses);

        if (meses >= 12) {
            years ++;
            meses = 0;
        }

        var dif_fecha = {
            "años" : years,
            "meses" : meses,
            "dias" : dias,
            "horas" : horas,
            "minutos" : minutos,
            "segundos" : segundos,
        }

        // return years+' Años y '+meses+' Meses y '+dias+' Dias y '+horas+' Horas y '+minutos;
        return dif_fecha;
    }
    //

    $(document).on("change","form input[name='fecha_nac']", function(e){
        var fecha_nac = $(this).val();
        // var fecha_nac = "2020-04-27 00:00:00";
        // var fecha_actual = "2020-12-20 04:32:00";
        var edad = dif_fecha(fecha_nac,fecha_i+' '+hora_i);
        $("input[name='edad']").val(edad['años']);
        console.log(edad);
    });
    // 
    function sleep(ms) {
        var start = Date.now(),
            now = start;
        while (now - start < ms) {
          now = Date.now();
        }
    }
    //
    // FUNCION PARA AL PRESIONAR ENTER EVITAR HACER SUBMIT
    // $("form").keypress(function(e) {
    //     if (e.which == 13) {
    //         return false;
    //     }
    // });
    // 

     

    // VALIDAR
    // $(document).on("submit","form#registrar_pieza", function(e){
    //     var flag_validar = true;
    //     flag_validar = validar_select();
    //     flag_validar = validar_texto(flag_validar);
    //     // 
    //     if (flag_validar == false) {
    //         console.log('this falso');
    //         return false;
    //     }
    //     // e.preventDefault();
    // });

    // $(document).on("submit","form#registrar_usuario", function(e){
    //     var flag_validar = true;
    //     flag_validar = validar_texto(flag_validar);
    //     flag_validar = validar_nombres(flag_validar);
    //     flag_validar = validar_correo(flag_validar);
    //     flag_validar = validar_usuario(flag_validar);
    //     flag_validar = validar_pass_iguales(flag_validar);
    //     // 
    //     if (flag_validar == false) {
    //         console.log('this falso');
    //         return false;
    //     }
    //     // e.preventDefault();
    // });
    // $(document).on("submit","form#registrar_juego_vf", function(e){
    //     var flag_validar = true;
    //     flag_validar = validar_select();
    //     flag_validar = validar_texto(flag_validar);
    //     // 
    //     if (flag_validar == false) {
    //         console.log('this falso');
    //         return false;
    //     }
    //     // e.preventDefault();
    // });
    // //
    // const reg_ip = /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
    // const reg_tag_html = /^<([a-z]+)([^<]+)*(?:>(.*)<\/\1>|\s+\/>)$/;
    // const reg_url = /^(http|https|ftp)+\:+\/\/+(www\.|)+[a-z0-9\-\.]+([a-z\.]|)+\.[a-z]{2,4}$/;
    // const reg_correo = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    // const reg_nombres = /^[a-zA-Z ]{5,80}$/;
    // const reg_user = /^[a-zA-Z0-9\_\-]{3,16}$/;
    // const reg_pass = /^[a-zA-Z0-9\-\.\_\@]{4,18}$/;
    // const reg_numeros = /^[0-9]{7,10}$/;
    // const reg_decimales = /^[+]?([0-9]+(?:[\.][0-9]*)?|\.[0-9]+)$/;
    // // 

    // function validar_texto(flag_validar){
    //     var array_texto = [];
    //     $("input.input_text, textarea.input_text").each(function(index,value){
    //         var elemento = $(this);
    //         var input = elemento.closest('div.input');
    //         if (elemento.val().length <= 4) {
    //             elemento.css({'border-color':'#D93025'});
    //             array_texto.push(false);
    //             msj_error = input.find('span.input_msj_error');
    //             if (msj_error.length == 0){
    //                 input.append('<span class="input_msj_error">Minimo de caracteres: 4, Usa solo letras</span>');
    //             }
    //         }else{
    //             elemento.css({'border-color':'var(--gris)'});
    //             array_texto.push(true);
    //             input.find('span.input_msj_error').remove();
    //         }
    //     });
    //     array_texto.forEach(function(value,index){
    //         if (value == false) {
    //             flag_validar = false;
    //         }
    //     });
    //     return flag_validar;
    // }

    // function validar_nombres(flag_validar){
    //     var array_nombres = [];
    //     $("input.input_nombres").each(function(index,value){
    //         var elemento = $(this);
    //         var input = elemento.closest('div.input');
    //         var str_elemento = elemento.val();
    //         str_elemento = str_elemento.trim();
    //         if (!reg_nombres.test(str_elemento)){
    //             elemento.css({'border-color':'#D93025'});
    //             array_nombres.push(false);
    //             msj_error = input.find('span.input_msj_error');
    //             if (msj_error.length == 0){
    //                 input.append('<span class="input_msj_error">No se admiten numeros ni caracteres especiales, Minimo de caracteres: 5.</span>');
    //             }
    //         }else{
    //             elemento.css({'border-color':'var(--gris)'});
    //             array_nombres.push(true);
    //             input.find('span.input_msj_error').remove();
    //         }
    //     });
    //     array_nombres.forEach(function(value,index){
    //         if (value == false) {
    //             flag_validar = false;
    //         }
    //     });
    //     return flag_validar;
    // }

    // function validar_usuario(flag_validar){
    //     var array_usuario = [];
    //     $("input.input_usuario").each(function(index,value){
    //         var elemento = $(this);
    //         var input = elemento.closest('div.input');
    //         var str_elemento = elemento.val();
    //         str_elemento = str_elemento.trim();
    //         if (!reg_user.test(str_elemento)) {
    //             elemento.css({'border-color':'#D93025'});
    //             array_usuario.push(false);
    //             msj_error = input.find('span.input_msj_error');
    //             if (msj_error.length == 0){
    //                 input.append('<span class="input_msj_error">Minimo de caracteres: 5. Usa solo letra, numeros o los signos: _-.</span>');
    //             }
    //         }else{
    //             elemento.css({'border-color':'var(--gris)'});
    //             array_usuario.push(true);
    //             input.find('span.input_msj_error').remove();
    //         }
    //     });
    //     array_usuario.forEach(function(value,index){
    //         if (value == false) {
    //             flag_validar = false;
    //         }
    //     });
    //     return flag_validar;
    // }

    // function validar_correo(flag_validar){
    //     var array_correo = [];
    //     $("input.input_correo").each(function(index,value){
    //         var elemento = $(this);
    //         var input = elemento.closest('div.input');
    //         var str_elemento = elemento.val();
    //         str_elemento = str_elemento.trim();
    //         if (!reg_correo.test(str_elemento)) {
    //             elemento.css({'border-color':'#D93025'});
    //             array_correo.push(false);
    //             msj_error = input.find('span.input_msj_error');
    //             if (msj_error.length == 0){
    //                 input.append('<span class="input_msj_error">Correo no valido, Ejemplo de correo: example@mail.com</span>');
    //             }
    //         }else{
    //             elemento.css({'border-color':'var(--gris)'});
    //             array_correo.push(true);
    //             input.find('span.input_msj_error').remove();
    //         }
    //     });
    //     array_correo.forEach(function(value,index){
    //         if (value == false) {
    //             flag_validar = false;
    //         }
    //     });
    //     return flag_validar;
    // }

    // function validar_pass_iguales(flag_validarflag_validar){
    //     var elemento_1 = $("input.pass_equal").eq(0);
    //     var elemento_2 = $("input.pass_equal").eq(1);
    //     var str_elemento_1 = elemento_1.val();
    //     var str_elemento_2 = elemento_2.val();
    //     var input = elemento_1.closest('div.input');
    //     // console.log(str_elemento_1);
    //     // console.log(str_elemento_2);
    //     if (str_elemento_1.length < 5 || !reg_pass.test(str_elemento_1)) {
    //         flag_validar = false;
    //         elemento_1.css({'border-color':'#D93025'});
    //         elemento_2.css({'border-color':'#D93025'});
    //         msj_error = input.find('span.input_msj_error');
    //         if (msj_error.length == 0){
    //             input.append('<span class="input_msj_error">Minimo de caracteres: 6. Usa solo letras, numeros o signos de puntuacion comunes</span>');
    //         }
    //     }else if (str_elemento_1 != str_elemento_2) {
    //         flag_validar = false;
    //         elemento_1.css({'border-color':'#D93025'});
    //         elemento_2.css({'border-color':'#D93025'});
    //         msj_error = input.find('span.input_msj_error');
    //         if (msj_error.length == 0){
    //             input.append('<span class="input_msj_error">Las contraseñas no coinciden</span>');
    //         }else{
    //             msj_error.html('Las contraseñas no coinciden');
    //         }
    //     }else{
    //         elemento_1.css({'border-color':'var(--gris)'});
    //         elemento_2.css({'border-color':'var(--gris)'});
    //         flag_validar = true;
    //         input.find('span.input_msj_error').remove();
    //     }
    //     return flag_validar;
    // }

    // validar_pass_iguales();


    // 
// Fin window onload
});