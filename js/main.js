function obtener_listado_clientes()
{
    var ruta_servicio  = api_url + '/listadoclientes'; 
    
    $.ajax({
        url: ruta_servicio,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        var clientes = json;

        if(clientes.length > 0)
        {
            var tbody = ''; 

            for(var i = 0;i < clientes.length; i++ )
            {
                tbody += '<tr>'; 
                tbody += '  <td>'+clientes[i].clave_cliente+'</td>'; 
                tbody += '  <td>'+clientes[i].nombre+' '+clientes[i].apellido_paterno+' '+clientes[i].apellido_materno+'<div class="fr"><a href="index.php?op=edi_cliente&id='+clientes[i].id_cliente+'"><img src="img/config3.png" class="w20" /></a></div></td>'; 
                tbody += '</tr>'; 
            }

            $("#t_clientes tbody").append(tbody);
        }

    });   
}

function obtener_siguiente_clave_cliente()
{
    var ruta_servicio  = api_url + '/siguienteClaveCliente'; 
    
    $.ajax({
        url: ruta_servicio,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        console.log(json); 

        if(json.clave_cliente != '')
        {
        	$("#txt_clave").text(json.clave_cliente); 
        }

    });   
}

function registrar_cliente(nombre,apellido_paterno,apellido_materno,rfc) 
{
    var ruta_servicio  = api_url + '/registrarcliente'; 

	var data     = new FormData();

    data.append('nombre',nombre); 
    data.append('apellido_paterno',apellido_paterno); 
    data.append('apellido_materno',apellido_materno); 
    data.append('rfc',rfc); 
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        console.log(json); 

        if(json.codigo==='000')
        {
        	alert('Bien hecho, el cliente se ha registrado correctamente'); 
        	window.location.href = 'index.php?op=clientes'; 
        }
        else
        {
        	alert('Ocurrio un error al registrar en la base de datos');
        }

    });   
}

function actualizar_cliente(id,nombre,apellido_paterno,apellido_materno,rfc) 
{
	var ruta_servicio  = api_url + '/actualizarcliente'; 

	var data     = new FormData();

	data.append('id',id); 
    data.append('nombre',nombre); 
    data.append('apellido_paterno',apellido_paterno); 
    data.append('apellido_materno',apellido_materno); 
    data.append('rfc',rfc); 
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        console.log(json); 

        if(json.codigo==='000')
        {
        	alert('Bien hecho, el cliente se ha actualizado correctamente'); 
        	window.location.href = 'index.php?op=clientes'; 
        }
        else
        {
        	alert('Ocurrio un error al registrar en la base de datos');
        }

    });   
}

function obtener_cliente(id)
{
    var ruta_servicio  = api_url + '/obtenercliente/'+id; 
    
    $.ajax({
        url: ruta_servicio,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos);        

        console.log(json); 

        if(json.clave_cliente != '')
        {
        	$("#txt_nombre").val(json.nombre); 
	        $("#txt_apellido_paterno").val(json.apellido_paterno); 
	        $("#txt_apellido_materno").val(json.apellido_materno); 
	        $("#txt_rfc").val(json.rfc); 
	        $("#txt_clave").text(json.clave_cliente); 
        }

    });   
}



function obtener_clientes_auto(consulta)
{
    var ruta_servicio  = api_url + '/buscarcliente'; 
    
    $.ajax({
        url: ruta_servicio,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos);        
        
        if(json[0].id != '')
        {
        	clientes_json = json;

        	$('#txt_nombre').autocomplete({
		        //serviceUrl: api_url + '/buscarcliente/',
		        lookup: clientes_json,
		        forceFixPosition:true,
		        autoSelectFirst: true,
		        
		        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
		            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
		            return re.test(suggestion.value);
		        },
		        onSelect: function(suggestion) {
		            $('#selction-ajax').html('<b>RFC : </b>' +suggestion.data);
		            $("#txt_cliente").val(suggestion.id);		            
		        },
		        onHint: function (hint) {
		            $('#txt_nombre-x').val(hint);
		        }, 
		        onInvalidateSelection: function() {
	            	$('#selction-ajax').html('');
	        	}
		      });
        }

    });   
}




/********************************************************************************************/

function obtener_listado_articulos()
{
    var ruta_servicio  = api_url + '/listadoarticulos'; 
    
    $.ajax({
        url: ruta_servicio,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        var articulos = json;

        if(articulos.length > 0)
        {
            var tbody = ''; 

            for(var i = 0;i < articulos.length; i++ )
            {
                tbody += '<tr>'; 
                tbody += '  <td>'+articulos[i].clave_articulo+'</td>'; 
                tbody += '  <td>'+articulos[i].descripcion+'<div class="fr"><a href="index.php?op=edi_articulo&id='+articulos[i].id_articulo+'" ><img src="img/config3.png" class="w20" /></a></div></td>'; 
                tbody += '</tr>'; 
            }

            $("#t_articulos tbody").append(tbody);
        }

    });   
}

function obtener_articulos_auto(consulta)
{
    var ruta_servicio  = api_url + '/buscararticulo'; 
    
    $.ajax({
        url: ruta_servicio,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos);        
        
        if(json[0].id != '')
        {
        	articulos_json = json;

        	$('#txt_nombre_articulo').autocomplete({
		        //serviceUrl: api_url + '/buscarcliente/',
		        lookup: articulos_json,
		        forceFixPosition:true,
		        autoSelectFirst: true,
		        
		        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
		            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
		            return re.test(suggestion.value);
		        },
		        onSelect: function(suggestion) {
		            //$('#selction-ajax-2').html('<b>RFC : </b>' +suggestion.data);
		            $("#txt_articulo").val(suggestion.id);		            
		        },
		        onHint: function (hint) {
		            $('#txt_nombre-x').val(hint);
		        }, 
		        onInvalidateSelection: function() {
	            	//$('#selction-ajax-2').html('');
	        	}
		      });
        }

    });   
}


function obtener_siguiente_clave_articulo()
{
    var ruta_servicio  = api_url + '/siguienteClaveArticulo'; 
    
    $.ajax({
        url: ruta_servicio,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        console.log(json); 

        if(json.clave_articulo != '')
        {
        	$("#txt_clave").text(json.clave_articulo); 
        }

    });   
}


function registrar_articulo(des,modelo,precio,existencia)
{
	var ruta_servicio  = api_url + '/registrararticulo'; 

	var data     = new FormData();

    data.append('descripcion',des); 
    data.append('modelo',modelo); 
    data.append('precio',precio); 
    data.append('existencia',existencia); 
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        console.log(json); 

        if(json.codigo==='000')
        {
        	alert('Bien hecho, el articulo se ha registrado correctamente'); 
        	window.location.href = 'index.php?op=articulos'; 
        }
        else
        {
        	alert('Ocurrio un error al registrar en la base de datos');
        }

    });   
}


function obtener_articulo(id)
{
    var ruta_servicio  = api_url + '/obtenerarticulo/'+id; 
    
    $.ajax({
        url: ruta_servicio,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos);        

        console.log(json); 

        if(json.clave_articulo != '')
        {
        	$("#txt_des").val(json.descripcion); 
	        $("#txt_modelo").val(json.modelo); 
	        $("#txt_precio").val(json.precio); 
	        $("#txt_existencia").val(json.existencia); 
	        $("#txt_clave").text(json.clave_articulo); 
        }

    });   
}


function actualizar_articulo(id,des,modelo,precio,existencia)
{
	var ruta_servicio  = api_url + '/actualizararticulo'; 

	var data     = new FormData();

	data.append('id',id); 
    data.append('descripcion',des); 
    data.append('modelo',modelo); 
    data.append('precio',precio); 
    data.append('existencia',existencia); 
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        console.log(json); 

        if(json.codigo==='000')
        {
        	alert('Bien hecho, el articulo se ha actualizado correctamente'); 
        	window.location.href = 'index.php?op=articulos'; 
        }
        else
        {
        	alert('Ocurrio un error al registrar en la base de datos');
        }

    });   
}

/********************************************************************************************/

function obtener_configuracion()
{
    var ruta_servicio  = api_url + '/obtenerconfiguracion'; 
    
    $.ajax({
        url: ruta_servicio,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos);        

        console.log(json); 

        if(json.id != '')
        {
        	$("#txt_tasa").val(json.tasa_financiamiento ); 
	        $("#txt_enganche").val(json.enganche); 
	        $("#txt_plazo").val(json.plazo); 
        }

    });   
}

function actualizar_configuracion(tasa,enganche,plazo)
{
	var ruta_servicio  = api_url + '/actualizarconfiguracion'; 

	var data     = new FormData();
	
    data.append('tasa',tasa); 
    data.append('enganche',enganche); 
    data.append('plazo',plazo);     
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        console.log(json); 

        if(json.codigo==='000')
        {
        	alert('Bien hecho, la configuracion se ha actualizado correctamente'); 
        	window.location.href = 'index.php?op=configuracion'; 
        }
        else
        {
        	alert('Ocurrio un error al registrar en la base de datos');
        }

    });   
}


/********************************************************************************************/


function obtener_listado_ventas()
{
    var ruta_servicio  = api_url + '/listadoventas'; 
    
    $.ajax({
        url: ruta_servicio,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        var ventas = json;

        if(ventas.length > 0)
        {
            var tbody = ''; 

            for(var i = 0;i < ventas.length; i++ )
            {
                tbody += '<tr>'; 
                tbody += '  <td>'+ventas[i].folio_venta+'</td>'; 
                tbody += '  <td>'+ventas[i].clave_cliente+'</td>'; 
                tbody += '  <td>'+ventas[i].nombre+' '+ventas[i].apellido_paterno +' '+ ventas[i].apellido_materno+'</td>'; 
                tbody += '  <td>'+formatMoney(ventas[i].total)+'</td>'; 
                tbody += '  <td>'+ventas[i].fecha+'</td>';                 
                tbody += '</tr>'; 
            }

            $("#t_ventas tbody").append(tbody);
        }

    });   
}


function obtener_siguiente_clave_venta()
{
    var ruta_servicio  = api_url + '/siguienteClaveVenta'; 
    
    $.ajax({
        url: ruta_servicio,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        console.log(json); 

        if(json.clave_venta != '')
        {
        	$("#txt_clave").text(json.clave_venta); 
        }

    });   
}


function agregar_articulo_venta(id)
{
	var ruta_servicio  = api_url + '/calcularprecioarticulo/'+id; 
    
    $.ajax({
        url: ruta_servicio,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos);        

        console.log(json); 

        if(json.clave_articulo != '')
        {
        	if(json.existencia > 0)
        	{
        		lista_articulos.push(json); 

        		pintar_articulo(json);
        		calcular_importe_total();	
        	}
        	else
        	{
        		alert('El artículo seleccionado no cuenta con existencia, favor de verificar'); 
        	}
        	
        }

    });   
}

function calcular_enganche(importe)
{
	var ruta_servicio  = api_url + '/calcularenganche/'+importe; 
    
    $.ajax({
        url: ruta_servicio,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos);        

        if(json.total != '')
        {
        	$("#enganche").text(formatMoney(json.enganche)); 
        	$("#bonificacion_enganche").text(formatMoney(json.bonificacion)); 
        	$("#total").text(formatMoney(json.total)); 
        	total = json.total; 
        }
        else
        {
        	$("#enganche").text('0.00'); 
        	$("#bonificacion_enganche").text('0.00'); 
        	$("#total").text('0.00'); 	
        }

    }); 
}

function calcular_abonos(importe_total)
{
	var ruta_servicio  = api_url + '/calculoabonomeses/'+importe_total; 
    
    $.ajax({
        url: ruta_servicio,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"GET"
    }).done(function(datos){

        var abonos =  $.parseJSON(datos);

        if(abonos.length > 0)
        {	
        	var html = ''; 

        	for(var i = 0;i < abonos.length; i++ )
            {
                html += '<tr>'; 
                html += '  <td>'+abonos[i].descripcion+'</td>'; 
                html += '  <td>'+formatMoney(abonos[i].cantidad_abono)+'</td>'; 
                html += '  <td>'+abonos[i].total_pagar_des+'</td>'; 
                html += '  <td>'+formatMoney(abonos[i].ahorro)+'</td>';                 
                html += '  <td><input type="radio" name="plazos" value="'+abonos[i].plazos+'" /></td>';
                html += '</tr>'; 
            }

            $("#t_abonos tbody").append(html);
        }

    }); 	
}

function guardar_venta(cliente,articulos,plazos,total,articulos_json)
{
	var ruta_servicio  = api_url + '/registrarventa'; 

	var data     = new FormData();
	
    data.append('cliente',cliente); 
    data.append('articulos',articulos); 
    data.append('plazos',plazos);     
    data.append('total',total);     
    data.append('articulos_json',articulos_json);     

    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,
        processData:false,
        cache:false,
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        console.log(json); 

        if(json.codigo==='000')
        {
        	alert('Bien Hecho, Tu venta ha sido registrada correctamente'); 
        	window.location.href = 'index.php?op=ventas'; 
        }
        else
        {
        	alert('Ocurrio un error al registrar en la base de datos');
        }

    });   
}


/************************************/

function formatMoney(num) {
	num = parseFloat(num);
    var p = num.toFixed(2).split(".");
    return "$" + p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num=="-" ? acc : num + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
}

function soloNumeros(e){

	console.log(e.key); 

	if(	e.key=='F5' 		|| 
		e.key=='.' 			|| 
		e.key=='tab' 		||
		e.key=='Backspace' 	||
		e.key=='ArrowLeft' 	||
		e.key=='ArrowRight' ||
		e.key=='Delete'
		){
		return true; 
	}

	var key = window.Event ? e.which : e.keyCode
	

	return (key >= 48 && key <= 57)

}
      