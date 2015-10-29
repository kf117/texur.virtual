
function elegirFecha(id){
                    
                    NewCssCal(id,'','','','','','plus18');
                }


function buscadorOpenClose(){
    
    if(document.getElementById("buscadorLis").style.display=="none"){
        document.getElementById("buscadorLis").style.display="block";
        document.getElementById("iconoBus").setAttribute("class", "icon-eye-close");
    }
    else{
        document.getElementById("buscadorLis").style.display="none";
        document.getElementById("iconoBus").setAttribute("class", "icon-eye-open");
    }    
}


function seleccionar_ciudad(obj){
    $('#select_ciudades').load('/global/php/seleccion_ciudades.php?prov_id='+obj.value);
    
}

function seleccionar_modelo(obj){
    $('#select_modelos').load('/global/php/seleccion_modelos.php?marca_id='+obj.value);
    
}

function confirmDel(){
    
    if(confirm("Seguro que desea eliminar este registro?")) 
        return true;
    else return false;
}

function confirmDelCategoria(){
    if(confirm("Los productos que esten asignados a esta categor\u00CDa quedar\u00E1n sin asignaci\u00F3n ,seguro que desea eliminar este registro?")) 
        return true;
    else return false;
}

/////////////////////////MARCAS///////////////////////////////////////
function poderEditarMarca(id){
    $("#marca_"+id).val($('#marca_nombre_'+id).text());
    $(".marca_form").hide();
    $(".marca_nombre").show();
    $("#marca_nombre_"+id).hide();
    $("#marca_form_"+id).show();
    
}

function editarMarca(id){
    $('#marca_nombre_'+id).load('/marca/editarMarca.php?id='+id+'&marca='+encodeURI($("#marca_"+id).val()));
   
     $("#marca_form_"+id).hide();
     $("#marca_nombre_"+id).show();

}
/////////////////////////MARCAS///////////////////////////////////////
//
/////////////////////////COLORES///////////////////////////////////////
function poderEditarColor(id){
    $("#color_"+id).val($('#color_nombre_'+id).text());
    $(".color_form").hide();
    $(".color_nombre").show();
    $("#color_nombre_"+id).hide();
    $("#color_form_"+id).show();
    
}

function editarColor(id){
    $('#color_nombre_'+id).load('/color/editarColor.php?id='+id+'&color='+encodeURI($("#color_"+id).val()));
   
     $("#color_form_"+id).hide();
     $("#color_nombre_"+id).show();

}
/////////////////////////COLORES///////////////////////////////////////
//
/////////////////////////CLASIFICACION///////////////////////////////////////
function poderEditarClasificacion(id){
    $("#clasificacion_"+id).val($('#clasificacion_nombre_'+id).text());
    $(".clasificacion_form").hide();
    $(".clasificacion_nombre").show();
    $("#clasificacion_nombre_"+id).hide();
    $("#clasificacion_form_"+id).show();
    
}

function editarClasificacion(id){
    $('#clasificacion_nombre_'+id).load('/clasificacion/editarClasificacion.php?id='+id+'&clasificacion='+encodeURI($("#clasificacion_"+id).val()));
   
     $("#clasificacion_form_"+id).hide();
     $("#clasificacion_nombre_"+id).show();

}
/////////////////////////CLASIFICACION///////////////////////////////////////
///////////////////////////////CILINDRADA//////////////////////////////////////////////
function poderEditarCilindrada(id){
    $("#cilindrada_"+id).val($('#cilindrada_nombre_'+id).text());
    $(".cilindrada_form").hide();
    $(".cilindrada_nombre").show();
    $("#cilindrada_nombre_"+id).hide();
    $("#cilindrada_form_"+id).show();
    
}

function editarCilindrada(id){
    $('#cilindrada_nombre_'+id).load('/cilindrada/editarCilindrada.php?id='+id+'&cilindrada='+encodeURI($("#cilindrada_"+id).val()));
   
     $("#cilindrada_form_"+id).hide();
     $("#cilindrada_nombre_"+id).show();

}
///////////////////////////////CILINDRADA//////////////////////////////////////////////

function limpiarBsqMotoChico(){
    //alert("asdsad");
    
    $('#nro_chasis').val('');
    $('#nro_motor').val('');
    $('#listMotos').submit();
}
function limpiarBsqMoto(){
    //alert("asdsad");
    $("#estado").val("0");
    $("#sucursal").val("0");
    $("#color").val("0");
    $("#proveedor").val("0");
    $("#modelo").val("0");
    $("#marca").val("0");
    
    
    $('#nro_chasis').val('');
    $('#nro_motor').val('');
    $('#listMotos').submit();
}
function limpiarBsqCliente(){
    //alert("asdsad");
    $("#tipo_cliente").val("0");
   
    
    
    $('#dni').val('');
    
    $('#listClientes').submit();
}


function limpiarBsqUsuario(){
    //alert("asdsad");
    $("#tipo_usuario").val("0");
   
    
    
    $('#nick').val('');
    
    $('#listClientes').submit();
}
////CLIENTES///
function mostrarCliTipo(id){
    $(".info_extra").hide();
    $("."+id).show();
}

function mostrarTabGraph(id){
    $(".graph_tab").removeClass("active");
    $(".graph_cont").hide();
    $("#container_"+id).show();
    $("#graph_"+id).addClass("active");
}

function agregarCliente(){
    
    window.open('/Venta/cliente/listado.php', 'Popup', 
    'height=600,width=900,scrollTo,resizable=1,scrollbars=1,location=0');
}

function agregarTarjetaRosa(){
    
    window.open('/Venta/tarjeta/form.php', 'Popup', 
    'height=400,width=950,scrollTo,resizable=1,scrollbars=1,location=0');
}

function agregarPago(){
    
    window.open('/Venta/pago/agregar.php', 'Popup', 
    'height=350,width=300,scrollTo,resizable=1,scrollbars=1,location=0');
}


/////////////////////////CHEQUES///////////////////////////////////////
function poderEditarCheque(id){
    
    $("#cheque_"+id).val($('#cheque_nombre_'+id).text());
    $(".cheque_form").hide();
    $(".cheque_nombre").show();
    $("#cheque_nombre_"+id).hide();
    $("#cheque_form_"+id).show();
  
}

function editarCheque(id){
    $('#cheque_nombre_'+id).load('/Venta/cheque/editarCheque.php?id='+id+'&cheque='+encodeURI($("#cheque_"+id).val()));
   
     $("#cheque_form_"+id).hide();
     $("#cheque_nombre_"+id).show();

}

function limpiarBsqCheques(){
    //alert("asdsad");
    $('#nro_cheque').val('');
   $('#chasis').val('');
    
    
    $('#dni').val('');
    
    $('#listCheques').submit();
}

function limpiarBsqVentas(){
    //alert("asdsad");
    $('#motor').val('');
   $('#chasis').val('');
    
    
    $('#dni').val('');
    
    $('#listVentas').submit();
}

function editarReclamo(n,acc,rep){
    //reclamo/editarReclamo.php?id={id_falla}&acc=17&rep={reparado}
    $("#res_ajax").load("/reclamo/editarReclamo.php?id="+n+"&acc="+acc+"&rep="+rep);
}

function verFallas(id){
    
    window.open('/moto/falla/listado.php?id='+id, 'Popup', 
    'height=600,width=500,scrollTo,resizable=1,scrollbars=1,location=0');
}

function retirarMoto(id){
    if(confirm("�Esta seguro que desea retirar la moto?")) { 
        $("#res_ajax_retirar").load("/Venta/retirarMoto.php?id="+id);
    }
}


function agregarDataExtra(){
    if(document.getElementById('data_extra').style.display=="none")
        $('#data_extra').show();
    else $('#data_extra').hide();
    
}

function limpiarBsqPatentamiento(){
    $("#estado").val("0");
    $('#cli_apellido').val('');
    $('#dni').val('');
    $('#patente').val('');
    $('#nro_chasis').val('');
    $('#nro_motor').val('');
    $('#listMotos').submit();
}

function imprimirVenta(id){
    window.open('/Venta/imprimir/imprimir.php?id='+id, 'Popup', 
    'height=550,width=700,scrollTo,resizable=1,scrollbars=1,location=0');
}



$('.side-nav .fa').mouseover(function() {
  $( this ).addClass( "fa-spin" );
});
$('.side-nav .fa').mouseout(function() {
  $( this ).removeClass( "fa-spin" );
});
