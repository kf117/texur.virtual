function moverItem(id){
    var nuevo=$("#moto_"+id).html();
    nuevo=nuevo.replace("primary", "danger");
    nuevo=nuevo.replace("icon-arrow-right", "icon-trash");
    nuevo=nuevo.replace("moverItem", "quitarItem");
    nuevo='<div id="moto_'+id+'" name="moto_'+id+'" class="well" style="cursor:pointer;">'+nuevo+'</div>';
    //alert(nuevo);
    $("#moto_"+id).remove();
    $('#listado_select').append(nuevo);
    $('#cargando').show();
    $('#cargando').load("../moto/trasladar/agregarParaMover.php?id="+id);
    $('#cargando').hide();
}

function quitarItem(id){
    var nuevo=$("#moto_"+id).html();
    nuevo=nuevo.replace("danger", "primary");
    nuevo=nuevo.replace("icon-trash", "icon-arrow-right");
    nuevo=nuevo.replace("quitarItem", "moverItem");
    nuevo='<div id="moto_'+id+'" name="moto_'+id+'" class="well" style="cursor:pointer;">'+nuevo+'</div>';
    //alert(nuevo);
    $("#moto_"+id).remove();
    $('#listado_no_select').append(nuevo);
    $('#cargando_no').show();
    $('#cargando_no').load("../moto/trasladar/quitarParaMover.php?id="+id);
    $('#cargando_no').hide();
}
