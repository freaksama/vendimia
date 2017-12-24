


function agregar_empresa_favoritos(id,id_empresa,fav)
{
    var ruta_servicio  = api_url + '/empresa/agregar-fav'; 

    var data     = new FormData();
    
    data.append('id_empresa',id_empresa);   
    data.append('fav',fav); 
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            if(fav == 'N')
            {
                $("#"+id).data("fav","S");
                $("#"+id).html('<img src="img/star.png" class="w20" />');
            }
            else
            {
                $("#"+id).data("fav","N");
                $("#"+id).html('<img src="img/star-alt.png" class="w20" />');
            }   
        }

    });   
}

function busqueda_empresas_modal(id,consulta)
{
    var ruta_servicio  = api_url + '/buscarempresas/'+consulta; 
    
    $.ajax({
        url: ruta_servicio,        
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        var empresas = json['datos'];         

        if(empresas.length > 0)
        {
            var tbody = ''; 

            for(var i = 0;i < empresas.length; i++ )
            {
                tbody += '<tr>'; 
                tbody += '  <td><a class="lk-empresa" href="javascript:void(0)" data-id-empresa="' + empresas[i].id_empresa + '" data-nombre-empresa="'+empresas[i].nombre_empresa+'" >Seleccionar</a></td>'; 
                tbody += '  <td><b class="text-danger">'+empresas[i].nombre_empresa+'</b><br>'+empresas[i].descripcion+'</td>'; 
                tbody += '</tr>'; 
            }

            $("#"+id+" tbody").append(tbody);
        }

    });   
}

function busqueda_ciudad(id)
{
    var ruta_servicio  = api_url + '/buscarciudad/'+id; 
    
    $.ajax({
        url: ruta_servicio,        
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"GET"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        var ciudades = json;       
        console.log(ciudades)  ;

        $("#txt_ciudad").empty();

        if(ciudades.length > 0)
        {
            var tbody = ''; 

            for(var i = 0;i < ciudades.length; i++ )
            {
                tbody += '<option value="'+ciudades[i].id_ciudad+'">'+ciudades[i].nombre_ciudad + '</option>';                 
            }

            $("#txt_ciudad").append(tbody);
        }

    });   
}


function obtener_pendientes()
{
    var ruta_servicio  = api_url + '/pendientes'; 

    var data     = new FormData();
    
    data.append('token',token_web); 

    
    
    $.ajax({
        url: ruta_servicio,        
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 

        console.log(json); 

        if(json.length > 0)
        {
            var html =  '';
            $("#pendiente_vacio").hide();

            $("#tb_pendientes tr").empty();

            for(var i = 0;i < json.length; i++ )
            {                
                html += '<tr class="tr_pen">';
                html += '   <td class="w16"><input type="checkbox" class="ck-box-pen" data-id-pendiente="' + json[i].id_pendiente + '" name=""></td>';                        
                html += '   <td><span id="t_p_' + json[i].id_pendiente + '">' + json[i].descripcion + '</span></td>';
                html += '</tr>'; 
            }
            $("#tb_pendientes").append(html);
        }
        else
        {
            //$("#pendiente_vacio").show();
        }

    });   
}

function registrar_pendiente(descripcion)
{
    var ruta_servicio  = api_url + '/pendientes/registrar'; 

    var data     = new FormData();

    data.append('descripcion',descripcion); 
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            obtener_pendientes()
            /*var html =  '';
            html += '<tr>';
            html += '   <td class="w16"><input type="checkbox" class="ck-box-pen" data-id-pendiente="' + json.id_pendiente + '" name=""></td>';                        
            html += '   <td><span id="t_p_' + json.id_pendiente + '">' + descripcion + '</span></td>';
            html += '</tr>'; 

            //$("#tb_pendientes").append(html); 
            $("#tb_pendientes:first").append(html);
            */
            $("#txtdes").val('');
            $('#modal_nuevo_pendiente').modal('hide');
        }

    });   
}

function cambiar_status_pendiente(id_pendiente, status)
{
    var ruta_servicio  = api_url + '/pendientes/actualizar'; 

    ruta_servicio = ruta_servicio + '/' + id_pendiente; 

    var data     = new FormData();

    data.append('status',status); 
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            if(status == 'T')
            {
                $("#t_p_"+id_pendiente).attr('class','p_ok text-muted');
            }
            else
            {
                $("#t_p_"+id_pendiente).attr('class','');
            }
        }

    });   
}


function obtener_contacto(consulta, letra)
{
    var ruta_servicio  = api_url + '/contactos'; 

    var data     = new FormData();

    data.append('consulta',consulta); 
    data.append('letra',letra); 
    
    data.append('token',token_web); 

    
    
    $.ajax({
        url: ruta_servicio,        
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var pendientes =  $.parseJSON(datos); 

        var json = pendientes['datos'];

        

        if(json.length > 0)
        {
            var html =  '';
            //$("#pendiente_vacio").hide();

            for(var i = 0;i < json.length; i++ )
            {   
                html += '<tr>';
                html += '    <td>';
                html += '        <img src="img/user2.png" />';
                html += '        <b>                          ';      
                html += '            <a href="#modal_detalles_contacto" class="ver_contacto" data-id-contacto="' + json[i].id_contacto + '" data-nombre="' + json[i].nombre_completo + '" data-empresa="' + json[i].empresa + '" data-celular="' + json[i].celular + '" data-correo="' + json[i].correo + '" data-domicilio="' + json[i].domicilio + '" data-detalles="' + json[i].detalles + '" role="button" data-toggle="modal" title="Editar contacto" >';
                html += '               ' + json[i].nombre_completo + ' ';
                html += '            </a>';
                html += '        </b>';
                html += '    </td>';
                html += '    <td>   ';                             
                html += '    <td>';
                if(json[i].celular != '')
                {
                    html += '<img src="img/phone-24.png" /> ' + json[i].celular + '<?';    
                }
                html += '    </td>';
                html += '    <td>';

                if(json[i].correo != '')
                {
                    html += '<img src="img/mail-24.png" /> ' + json[i].correo + '<?';    
                }
                html += '        ';
                html += '    </td>';
                html += '</tr>';
            }
            $("#table_contactos tr").empty(); 
            $("#table_contactos").append(html);
        }
        else
        {
            //$("#pendiente_vacio").show();
        }

    });   
}

function obtener_contacto_mini(consulta)
{
    var ruta_servicio  = api_url + '/contactos'; 

    var data     = new FormData();

    data.append('consulta',consulta); 
    data.append('letra',''); 
    
    data.append('token',token_web); 

    
    
    $.ajax({
        url: ruta_servicio,        
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var pendientes =  $.parseJSON(datos); 

        var json = pendientes['datos'];

        

        if(json.length > 0)
        {
            var html =  '';
            //$("#pendiente_vacio").hide();

            html += '<tr><th>Seleccionar</th><th>Nombre completo</th></tr>'; 

            for(var i = 0;i < json.length; i++ )
            {   
                html += '<tr>';
                html += '    <td style="width:50px;">';
                html += '        <a class="ck-paciente c" href="javascript:void(0)" data-id-paciente="' + json[i].id_contacto + '" data-nombre="' + json[i].nombre_completo + '" >Agregar</a>';
                html += '    </td>';
                html += '    <td><span >' + json[i].nombre_completo + '</span></td>';
                html += '</tr>';
            }
            $("#table_contactos tr").empty(); 
            $("#table_contactos").append(html);
        }
        else
        {
            //$("#pendiente_vacio").show();
        }

    });   
}

/*
function obtener_contacto_amway(consulta, letra)
{
    var ruta_servicio  = api_url + '/contactos'; 

    var data     = new FormData();

    data.append('consulta',consulta); 
    data.append('letra',letra); 
    
    data.append('token',token_web); 

    
    
    $.ajax({
        url: ruta_servicio,        
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var pendientes =  $.parseJSON(datos); 

        var json = pendientes['datos'];

        

        if(json.length > 0)
        {
            var html =  '';
            //$("#pendiente_vacio").hide();

            for(var i = 0;i < json.length; i++ )
            {   
                html += '<tr>';
                html += '    <td class="w300">';                
                //html += '        <div class="text-left">';
                html += '        <img src="img/user2.png" />';
                html += '        <b>                          ';      
                html += '            <a href="#modal_detalles_contacto" class="ver_contacto" data-id-contacto="' + json[i].id_contacto + '" data-nombre="' + json[i].nombre_completo + '" data-empresa="' + json[i].empresa + '" data-celular="' + json[i].celular + '" data-correo="' + json[i].correo + '" data-domicilio="' + json[i].domicilio + '" data-detalles="' + json[i].detalles + '" role="button" data-toggle="modal" title="Editar contacto" >';
                html += '               ' + json[i].nombre_completo + ' ';
                html += '            </a>';
                html += '        </b>';
                html += '    </td>';
                html += '    <td>';
                html += '        <div class="text-left">';
                html += '        <a href="javascript:void(0)" class="mgl5"><img src="img/check-black.png" /></a>';
                html += '        <a href="javascript:void(0)" class="mgl5"><img src="img/check-black.png" /></a>';
                html += '        <a href="javascript:void(0)" class="mgl5"><img src="img/check-black.png" /></a>';
                html += '        <a href="javascript:void(0)" class="mgl5"><img src="img/check-black.png" /></a>';
                html += '        <a href="javascript:void(0)" class="mgl5"><img src="img/check-black.png" /></a>';
                html += '        <a href="javascript:void(0)" class="mgl5"><img src="img/check-black.png" /></a>';
                html += '        <a href="javascript:void(0)" class="mgl5"><img src="img/check-black.png" /></a>';
                html += '        <a href="javascript:void(0)" class="mgl5"><img src="img/check-black.png" /></a>';
                html += '        </div></div>';
                html += '        <br>';   
                html += '    <div class="text-left">';
                if(json[i].celular != '')
                {
                    html += '<img src="img/phone-24.png" /> ' + json[i].celular + '';    
                }

                if(json[i].correo != '')
                {
                    html += '<img src="img/mail-24.png" /> ' + json[i].correo + '';    
                }                

                if(json[i].empresa != '')
                {
                    html += '<img src="img/maletin-24.png" class="w20" /> ' + json[i].empresa + '';    
                }
                html += '    </div>';
                html += '    </td>';
                html += '</tr>';
            }
            $("#table_contactos tr").empty(); 
            $("#table_contactos").append(html);
        }
        else
        {
            //$("#pendiente_vacio").show();
        }

    });   
}
*/



function registrar_contacto(nombre, empresa, tipo, celular, empresa, correo, domicilio, detalles)
{
    var ruta_servicio  = api_url + '/contacto/registrar'; 

    var data     = new FormData();

    data.append('nombre',nombre); 
    data.append('empresa',empresa); 
    data.append('tipo',tipo); 
    data.append('celular',celular); 
    data.append('empresa',empresa); 
    data.append('correo',correo); 
    data.append('domicilio',domicilio); 
    data.append('detalles',detalles); 

    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            obtener_contacto('','');             
            $("#txt_nombre").val('');
            $("#txt_empresa").val('');
            $("#txt_celular").val('');
            $("#txt_correo").val('');
            $("#txt_domicilio").val('');
            $("#txt_detalles").val('');


            $('#modal_nuevo_contacto').modal('hide');
        }

    });   
}

function actualizar_contacto(id_contacto, nombre, empresa, tipo ,celular, empresa, correo, domicilio, detalles)
{
    var ruta_servicio  = api_url + '/contacto/actualizar/' + id_contacto; 

    var data     = new FormData();

    data.append('nombre',nombre); 
    data.append('empresa',empresa); 
    data.append('tipo',tipo); 
    data.append('celular',celular); 
    data.append('empresa',empresa); 
    data.append('correo',correo); 
    data.append('domicilio',domicilio); 
    data.append('detalles',detalles); 

    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            obtener_contacto('','');             
            $("#txt_nombre_act").val('');
            $("#txt_empresa_act").val('');
            $("#txt_celular_act").val('');
            $("#txt_correo_act").val('');
            $("#txt_domicilio_act").val('');
            $("#txt_detalles_act").val('');

            $('#modal_editar_contacto').modal('hide');
        }

    });   
}

function eliminar_contacto(id_contacto)
{
    var ruta_servicio  = api_url + '/contacto/eliminar'; 

    var data     = new FormData();

    data.append('token',token_web); 
    data.append('id',id_contacto); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            obtener_contacto('','');             
            $('#modal_detalles_contacto').modal('hide');
        }

    });   
}

function registrar_contacto_amway(nombre, empresa, tipo, celular, empresa, correo, domicilio, detalles)
{
    var ruta_servicio  = api_url + '/amway/contacto/registrar'; 

    var data     = new FormData();

    data.append('nombre',nombre); 
    data.append('empresa',empresa); 
    data.append('tipo',tipo); 
    data.append('celular',celular); 
    data.append('empresa',empresa); 
    data.append('correo',correo); 
    data.append('domicilio',domicilio); 
    data.append('detalles',detalles); 

    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            obtener_contacto_amway('','');             
            $("#txt_nombre").val('');
            $("#txt_empresa").val('');
            $("#txt_celular").val('');
            $("#txt_correo").val('');
            $("#txt_domicilio").val('');
            $("#txt_detalles").val('');


            $('#modal_nuevo_contacto').modal('hide');
        }

    });   
}

function actualizar_contacto_amway(id_contacto, nombre, empresa, tipo ,celular, empresa, correo, domicilio, detalles)
{
    var ruta_servicio  = api_url + '/amway/contacto/actualizar/' + id_contacto; 

    var data     = new FormData();

    data.append('nombre',nombre); 
    data.append('empresa',empresa); 
    data.append('tipo',tipo); 
    data.append('celular',celular); 
    data.append('empresa',empresa); 
    data.append('correo',correo); 
    data.append('domicilio',domicilio); 
    data.append('detalles',detalles); 

    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            obtener_contacto_amway('','');             
            $("#txt_nombre_act").val('');
            $("#txt_empresa_act").val('');
            $("#txt_celular_act").val('');
            $("#txt_correo_act").val('');
            $("#txt_domicilio_act").val('');
            $("#txt_detalles_act").val('');

            $('#modal_editar_contacto').modal('hide');
        }

    });   
}

function obtener_contacto_amway(consulta, letra)
{
    var ruta_servicio  = api_url + '/amway/contactos'; 

    var data     = new FormData();

    data.append('consulta',consulta); 
    data.append('letra',letra); 
    
    data.append('token',token_web); 

    
    
    $.ajax({
        url: ruta_servicio,        
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var pendientes =  $.parseJSON(datos); 

        var json = pendientes['datos'];

        

        if(json.length > 0)
        {
            var html =  '';
            //$("#pendiente_vacio").hide();

            $("#num_con").text('('+json.length+')');

            for(var i = 0;i < json.length; i++ )
            {   
                var a_img = Array() ; 
                a_img['N'] = 'img/check-black.png'; 
                a_img['S'] = 'img/check-green-32.png'; 

                var a_img_s = Array() ; 

                a_img_s['N'] = 'img/estrella-32.png'; 
                a_img_s['S'] = 'img/estrella-fav-32.png'; 

                var a_pasos = Array(); 
                a_pasos['1'] = 'Invitacion Inicial'; 
                a_pasos['2'] = 'Demostraci&oacute;n de productos'; 
                a_pasos['3'] = 'Explicar el Plan Amway'; 
                a_pasos['4'] = 'Invitarlo a la OP'; 
                a_pasos['5'] = 'Invitarlo a un Seminario'; 
                a_pasos['6'] = 'Entregar material de apoyo'; 
                a_pasos['7'] = 'Comprar productos'; 
                a_pasos['8'] = 'Firma de contrato'; 
                a_pasos['9'] = 'Completo'; 
                


                html += '<tr>';
                html += '    <td class="w300">';                
                //html += '        <div class="text-left">';
                html += '        <img src="img/user2.png" />';
                html += '        <b>                          ';      
                html += '            <a href="#modal_detalles_contacto" class="ver_contacto" data-id-contacto="' + json[i].id_contacto + '" data-nombre="' + json[i].nombre_completo + '" data-empresa="' + json[i].empresa + '" data-celular="' + json[i].celular + '" data-correo="' + json[i].correo + '" data-domicilio="' + json[i].domicilio + '" data-detalles="' + json[i].detalles + '" role="button" data-toggle="modal" title="Editar contacto" >';
                html += '               ' + json[i].nombre_completo + ' ';
                html += '            </a>';
                html += '        </b>';                
                html += '    </td>';
                html += '    <td>';
                //html += ' <div class="fr"><a href="javascript:void(0)" title="Opcion aun no disponible :V">Agendar cita <img src="img/calendar.png" class="w32" /></a></div>';
                html += '        <div class="text-left">';
                html += '          <a id="id_'+json[i].id_contacto+'_1" href="javascript:void(0)" class="ava_eta mgl5" data-id-contacto="' + json[i].id_contacto + '" data-id-paso="1" data-opcion="'+json[i].paso_1+'" ><img src="'+a_img[json[i].paso_1]+'" class="w32" title="'+a_pasos['1']+'" /></a>';
                html += '          <a id="id_'+json[i].id_contacto+'_2" href="javascript:void(0)" class="ava_eta mgl5" data-id-contacto="' + json[i].id_contacto + '" data-id-paso="2" data-opcion="'+json[i].paso_2+'" ><img src="'+a_img[json[i].paso_2]+'" class="w32" title="'+a_pasos['2']+'" /></a>';
                html += '          <a id="id_'+json[i].id_contacto+'_3" href="javascript:void(0)" class="ava_eta mgl5" data-id-contacto="' + json[i].id_contacto + '" data-id-paso="3" data-opcion="'+json[i].paso_3+'" ><img src="'+a_img[json[i].paso_3]+'" class="w32" title="'+a_pasos['3']+'" /></a>';
                html += '          <a id="id_'+json[i].id_contacto+'_4" href="javascript:void(0)" class="ava_eta mgl5" data-id-contacto="' + json[i].id_contacto + '" data-id-paso="4" data-opcion="'+json[i].paso_4+'" ><img src="'+a_img[json[i].paso_4]+'" class="w32" title="'+a_pasos['4']+'" /></a>';
                html += '          <a id="id_'+json[i].id_contacto+'_5" href="javascript:void(0)" class="ava_eta mgl5" data-id-contacto="' + json[i].id_contacto + '" data-id-paso="5" data-opcion="'+json[i].paso_5+'" ><img src="'+a_img[json[i].paso_5]+'" class="w32" title="'+a_pasos['5']+'" /></a>';
                html += '          <a id="id_'+json[i].id_contacto+'_6" href="javascript:void(0)" class="ava_eta mgl5" data-id-contacto="' + json[i].id_contacto + '" data-id-paso="6" data-opcion="'+json[i].paso_6+'" ><img src="'+a_img[json[i].paso_6]+'" class="w32" title="'+a_pasos['6']+'" /></a>';
                html += '          <a id="id_'+json[i].id_contacto+'_7" href="javascript:void(0)" class="ava_eta mgl5" data-id-contacto="' + json[i].id_contacto + '" data-id-paso="7" data-opcion="'+json[i].paso_7+'" ><img src="'+a_img[json[i].paso_7]+'" class="w32" title="'+a_pasos['7']+'" /></a>';
                html += '          <a id="id_'+json[i].id_contacto+'_8" href="javascript:void(0)" class="ava_eta mgl5" data-id-contacto="' + json[i].id_contacto + '" data-id-paso="8" data-opcion="'+json[i].paso_8+'" ><img src="'+a_img[json[i].paso_8]+'" class="w32" title="'+a_pasos['8']+'" /></a>';
                html += '          <a id="id_'+json[i].id_contacto+'_9" href="javascript:void(0)" class="ava_eta_com mgl5" data-id-contacto="' + json[i].id_contacto + '" data-id-paso="9" data-opcion="'+json[i].paso_9+'" ><img src="'+a_img_s[json[i].paso_9]+'" class="w28" title="'+a_pasos['9']+'" /></a>';
                html += '        </div></div>';
                html += '        <br>';   

                html += '    <div class="text-left">';
                if(json[i].celular != '')
                {
                    html += '<img src="img/phone-24.png" class="mgl5" /> ' + json[i].celular + '';    
                }

                if(json[i].correo != '')
                {
                    html += '<img src="img/mail-24.png"  class="mgl5" /> ' + json[i].correo + '';    
                }                

                if(json[i].empresa != '')
                {
                    html += '<img src="img/maletin-24.png" class="w20 mgl5" /> ' + json[i].empresa + '';    
                }

                //html += ' <!--div class="fr"><a href="javascript:void(0)">0 Comentarios <img src="img/comentarios-32.png" class="w20" /></a></div-->';
                html += '    </div>';
                html += '    </td>';
                html += '</tr>';
            }
            $("#table_contactos tr").empty(); 
            $("#table_contactos").append(html);
        }
        else
        {
            //$("#pendiente_vacio").show();
        }

    });   
}


function registrar_avance_contacto_amway(id_contacto, id_paso, opcion, id_elemento)
{
    var ruta_servicio  = api_url + '/amway/registraravance'; 

    var data     = new FormData();

    data.append('id_contacto',id_contacto); 
    data.append('id_paso',id_paso); 
    data.append('opcion',opcion); 
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            var html            = ''; 
            var nueva_opcion    = ''; 

            if(opcion=='N')
            {
                html = '<img src="img/check-green-32.png" class="w32" />'; 
                nueva_opcion = 'S'; 
            }
            else
            {
                html = '<img src="img/check-black.png" class="w32" />'; 
                nueva_opcion = 'N'; 
            }


            $("#"+id_elemento).html(html); 
            $("#"+id_elemento).data("opcion",nueva_opcion); 
            
        }

    });  
}

function registrar_avance_contacto_completo_amway(id_contacto,opcion)
{
    var ruta_servicio  = api_url + '/amway/registraravance/completo'; 

    var data     = new FormData();

    data.append('id_contacto',id_contacto);     
    data.append('opcion',opcion); 
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            var html            = ''; 
            var html_s          = ''; 
            var nueva_opcion    = ''; 

            if(opcion=='N')
            {
                html = '<img src="img/check-green-32.png" class="w32" />'; 
                html_s = '<img src="img/estrella-fav-32.png" class="w28" />'; 
                nueva_opcion = 'S'; 
            }
            else
            {
                html = '<img src="img/check-black.png" class="w32" />'; 
                html_s = '<img src="img/estrella-32.png" class="w28" />' ; 
                nueva_opcion = 'N'; 
            }


            $("#id_"+id_contacto+"_1").html(html); 
            $("#id_"+id_contacto+"_2").html(html); 
            $("#id_"+id_contacto+"_3").html(html); 
            $("#id_"+id_contacto+"_4").html(html); 
            $("#id_"+id_contacto+"_5").html(html); 
            $("#id_"+id_contacto+"_6").html(html); 
            $("#id_"+id_contacto+"_7").html(html); 
            $("#id_"+id_contacto+"_8").html(html);             
            $("#id_"+id_contacto+"_9").html(html_s); 
            
            $("#id_"+id_contacto+"_1").data("opcion",nueva_opcion); 
            $("#id_"+id_contacto+"_2").data("opcion",nueva_opcion); 
            $("#id_"+id_contacto+"_3").data("opcion",nueva_opcion); 
            $("#id_"+id_contacto+"_4").data("opcion",nueva_opcion); 
            $("#id_"+id_contacto+"_5").data("opcion",nueva_opcion); 
            $("#id_"+id_contacto+"_6").data("opcion",nueva_opcion); 
            $("#id_"+id_contacto+"_7").data("opcion",nueva_opcion); 
            $("#id_"+id_contacto+"_8").data("opcion",nueva_opcion); 
            $("#id_"+id_contacto+"_9").data("opcion",nueva_opcion); 

            
        }

    });  
}

function eliminar_contacto_amway(id_contacto)
{
    var ruta_servicio  = api_url + '/contacto/eliminar'; 

    var data     = new FormData();

    data.append('token',token_web); 
    data.append('id',id_contacto); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            obtener_contacto_amway('','');             
            $('#modal_detalles_contacto').modal('hide');
        }

    });   
}

function activar_modulo_usuario(id_modulo, id_elemento)
{
    var ruta_servicio  = api_url + '/modulo/usuario/activar'; 
    var data     = new FormData();

    data.append('id_modulo',id_modulo);     
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        var html            = '';             
        
        if(json.codigo == '000')
        {
            html = '<img src="img/check-32.png" class="w32" /> <span class="text-success">Listo</span>'; 
            $("#"+id_elemento).html(html); 
            alert("Es necesario que salga del sistema y vuelva a ingresar para ver los cambios");
        }
        else
        {
            alert("Ocurrio un error al activar"); 
        }

    });     
}


function obtener_periodos_citas(fecha)
{  
    var ruta_servicio  = api_url + '/periodos/disponibles/citas'; 
    var data     = new FormData();

    data.append('fecha',fecha);     
    data.append('token',token_web); 

    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        var html            = '';    

        
        var link =  '';

        console.log(json);
                        
        $("#periodos_detalle").empty();

        
        
        var div = '<div >' ; 

        div += ''; 


       /* var div_usu = '<table class="table">'; 
        div_usu += '<tr><td style="text-align:center;"><img src="' + json[i]['avatar'] + '"  style="width:32px;" /></td>'; 
        div_usu += '    <td>' + json[i]['nombre'] + ' ' + json[i]['apellidos'] + '</td><tr>';
        div_usu += '</table>';*/

       // div += div_usu;


        var periodos = json;

        var tabla = '<table class="table table-striped table-bordered table-hover table-condensed">';

        for(var j = 0 ; j < periodos.length ; j++)
        {
            var td = '';

            if(periodos[j].cita != '1')
            {
                td += '<tr class="success">';
                td += '  <td>Horario ' + periodos[j].periodo + '</td>';
                if(perm_citas_publicas == 'N')
                {
                    td += '  <td><span class="text-danger">ocupado</span></td>';
                }
                else
                {
                    td += '  <td><a href="javascript:void(0)" class="text-success new_cit" data-id-periodo="' + periodos[j].id_periodo + '" data-fecha="' + fecha + '" data-nombre-periodo="' + periodos[j].periodo + '" data-id-usuario="1" data-avatar="" data-nombre="Diego" >Disponible</a></td>';
                }
                
                td += '</tr>';
            }
            else
            {
                td += '<tr class="danger">';
                td += '  <td>Horario ' + periodos[j].periodo + '</td>';
                td += '  <td><span class="text-danger">Ocupado</span></td>';
                td += '</tr>';
            }

            tabla += td;
        }
        tabla += '</table>';

        div += tabla; 

        //div += '</div></div>';

        div += '</div>';

        $("#periodos_detalle").append(div);
            
        
        $("#citas_proximas").hide(); 
        $("#cargar_info").hide();
        $("#periodos").fadeIn();

    });  
}   


function eliminar_cita(id_cita)
{
    var ruta_servicio  = api_url + '/citas/eliminar'; 

    var data     = new FormData();

    data.append('token',token_web); 
    data.append('id',id_cita); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            window.location.href="index.php?sub=amw&op=cit";
        }

    });   
}

/******************************************************************************************************************************************************
*
* RED DENTAL
*
********************************************************************************************************************************************************/
function registrar_contacto_reddental(nombre, empresa, tipo, celular, empresa, correo, domicilio, detalles)
{
    var ruta_servicio  = api_url + '/reddental/contacto/registrar'; 

    var data     = new FormData();

    data.append('nombre',nombre); 
    data.append('empresa',empresa); 
    data.append('tipo',tipo); 
    data.append('celular',celular); 
    data.append('empresa',empresa); 
    data.append('correo',correo); 
    data.append('domicilio',domicilio); 
    data.append('detalles',detalles); 

    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            obtener_contacto_reddental('','');             
            $("#txt_nombre").val('');
            $("#txt_empresa").val('');
            $("#txt_celular").val('');
            $("#txt_correo").val('');
            $("#txt_domicilio").val('');
            $("#txt_detalles").val('');


            $('#modal_nuevo_contacto').modal('hide');
        }

    });   
}

function actualizar_contacto_redental(id_contacto, nombre, empresa, tipo ,celular, empresa, correo, domicilio, detalles)
{
    var ruta_servicio  = api_url + '/reddental/contacto/actualizar/' + id_contacto; 

    var data     = new FormData();

    data.append('nombre',nombre); 
    data.append('empresa',empresa); 
    data.append('tipo',tipo); 
    data.append('celular',celular); 
    data.append('empresa',empresa); 
    data.append('correo',correo); 
    data.append('domicilio',domicilio); 
    data.append('detalles',detalles); 

    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            obtener_contacto_reddental('','');             
            $("#txt_nombre_act").val('');
            $("#txt_empresa_act").val('');
            $("#txt_celular_act").val('');
            $("#txt_correo_act").val('');
            $("#txt_domicilio_act").val('');
            $("#txt_detalles_act").val('');

            $('#modal_editar_contacto').modal('hide');
        }

    });   
}

function actualizar_contacto_redental_mini(id_contacto, nombre, empresa, tipo ,celular, empresa, correo, domicilio, detalles)
{
    var ruta_servicio  = api_url + '/reddental/contacto/actualizar/' + id_contacto; 

    var data     = new FormData();

    data.append('nombre',nombre); 
    data.append('empresa',empresa); 
    data.append('tipo',tipo); 
    data.append('celular',celular); 
    data.append('empresa',empresa); 
    data.append('correo',correo); 
    data.append('domicilio',domicilio); 
    data.append('detalles',detalles); 

    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            $("#ms_ok").fadeIn(); 
            setTimeout(function(){ $("#ms_ok").fadeOut(); }, 3000);

        }

    });   
}

function obtener_contacto_reddental(consulta, letra)
{
    var ruta_servicio  = api_url + '/reddental/contactos'; 

    var data     = new FormData();

    data.append('consulta',consulta); 
    data.append('letra',letra); 
    
    data.append('token',token_web); 

    
    
    $.ajax({
        url: ruta_servicio,        
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var pendientes =  $.parseJSON(datos); 

        var json = pendientes['datos'];

        

        if(json.length > 0)
        {
            var html =  '';
            //$("#pendiente_vacio").hide();

            $("#num_con").text('('+json.length+')');

            for(var i = 0;i < json.length; i++ )
            {   

                html += '<tr>';
                html += '    <td class="w300">';                
                //html += '        <div class="text-left">';
                html += '        <img src="img/user2.png" />';
                html += '        <b>                          ';      
                html += '            <a href="#modal_detalles_contacto" class="ver_contacto" data-id-contacto="' + json[i].id_contacto + '" data-nombre="' + json[i].nombre_completo + '" data-empresa="' + json[i].empresa + '" data-celular="' + json[i].celular + '" data-correo="' + json[i].correo + '" data-domicilio="' + json[i].domicilio + '" data-detalles="' + json[i].detalles + '" role="button" data-toggle="modal" title="Editar contacto" >';
                html += '               ' + json[i].nombre_completo + ' ';
                html += '            </a>';
                html += '        </b>';                
                html += '    </td>';
                html += '    <td>';             
                html += '        ';   

                html += '    <div class="text-left">';
                if(json[i].celular != '')
                {
                    html += '<img src="img/phone-24.png" class="mgl5" /> ' + json[i].celular + '';    
                }

                if(json[i].correo != '')
                {
                    html += '<img src="img/mail-24.png"  class="mgl5" /> ' + json[i].correo + '';    
                }                

                if(json[i].empresa != '')
                {
                    html += '<img src="img/maletin-24.png" class="w20 mgl5" /> ' + json[i].empresa + '';    
                }

                html += ' <div class="fr"><a href="index.php?sub=rdd&op=p_det&id='+ json[i].id_contacto +'"><img src="img/historial-32.png" />Historial</a> | <a href="index.php?sub=rdd&op=new_c&id='+json[i].id_contacto+'">Nueva consulta <img src="img/new.png" class="w20" /></a></div>';
                html += '    </div>';
                html += '    </td>';
                html += '</tr>';
            }
            $("#table_contactos tr").empty(); 
            $("#table_contactos").append(html);
        }
        else
        {
            //$("#pendiente_vacio").show();
        }

    });   
}

function eliminar_contacto_reddental(id_contacto)
{
    var ruta_servicio  = api_url + '/contacto/eliminar'; 

    var data     = new FormData();

    data.append('token',token_web); 
    data.append('id',id_contacto); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            obtener_contacto_amway('','');             
            $('#modal_detalles_contacto').modal('hide');
        }

    });   
}

function eliminar_contacto_reddental_mini(id_contacto)
{
    var ruta_servicio  = api_url + '/contacto/eliminar'; 

    var data     = new FormData();

    data.append('token',token_web); 
    data.append('id',id_contacto); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            window.location.href="index.php?sub=rdd&op=pac";
        }

    });   
}


function registrar_servicio(servicio, des, precio)
{
    var ruta_servicio  = api_url + '/reddental/servicio/registrar'; 

    var data     = new FormData();

    data.append('servicio',servicio); 
    data.append('des',des); 
    data.append('precio',precio); 
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            location.href = 'index.php?sub=rdd&op=ser'
        }

    });   
}

function actualizar_servicio(id_servicio, servicio, des, precio)
{
    var ruta_servicio  = api_url + '/reddental/servicio/actualizar'; 

    var data     = new FormData();
    data.append('id_servicio',id_servicio); 

    data.append('servicio',servicio); 
    data.append('des',des); 
    data.append('precio',precio); 
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            location.href = 'index.php?sub=rdd&op=ser'
        }

    });   
}

function eliminar_servicio(id_servicio)
{
    var ruta_servicio  = api_url + '/reddental/servicio/eliminar'; 

    var data     = new FormData();
    data.append('id_servicio',id_servicio); 
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {
            location.href = 'index.php?sub=rdd&op=ser'
        }

    });   
}



function registrar_ingreso(modulo, json, ret)
{
    var ruta_servicio  = api_url + '/ingresos/registrar'; 

    var data     = new FormData();

    data.append('modulo',modulo); 
    data.append('json',json); 
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {   
            if(ret=='')
            {
                location.href = 'index.php?sub=ing&op=det'
            }
            else
            {
                location.href = 'index.php?sub=ing&op=list'
            }
            
        }

    });   
}

function actualizar_ingreso(id,modulo,concepto,cantidad, ingreso,iva,total,modulo,ret)
{
    var ruta_servicio  = api_url + '/ingresos/actualizar'; 

    var data     = new FormData();

    data.append('id',id); 
    data.append('modulo',modulo); 
    data.append('concepto',concepto); 
    data.append('cantidad',cantidad); 
    data.append('ingreso',ingreso); 
    data.append('iva',iva); 
    data.append('total',total);     
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {   
            location.href = 'index.php?sub=ing&op=list'            
        }

    });   
}

function eliminar_ingreso(id)
{
    var ruta_servicio  = api_url + '/ingresos/eliminar'; 

    var data     = new FormData();

    data.append('id',id);     
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {   
            location.href = 'index.php?sub=ing&op=list'            
        }

    });   
}

function registrar_consulta_reddental(id_modulo,id_contacto,j_medicamentos, j_servicios, j_ingresos) 
{
    var ruta_servicio  = api_url + '/reddental/consulta/registrar'; 

    var data     = new FormData();

    data.append('id_modulo',id_modulo);
    data.append('id_contacto',id_contacto);
    data.append('j_servicios',j_servicios);     
    data.append('j_medicamentos',j_medicamentos);     
    data.append('j_ingresos',j_ingresos);     

    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {   
            location.href = 'index.php?sub=rdd&op=det_c&id='+ json.id_consulta;            
        }

    });  
}



function eliminar_consulta(id)
{
    var ruta_servicio  = api_url + '/reddental/consulta/eliminar'; 

    var data     = new FormData();

    data.append('id_consulta',id);     
    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {   
            location.href = 'index.php?sub=rdd&op=con';      
        }

    });   
}


function registrar_medicamento_clinica(nombre, descripcion, cantidad)
{
    var ruta_servicio  = api_url + '/reddental/medicamentos/registrar'; 

    var data     = new FormData();

    data.append('txtnombre',nombre);
    data.append('txtdes',descripcion);
    data.append('cantidad',cantidad);         

    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {   
            $('#modal_medicamentos').modal('hide');
            AgregarMedicamento(json.id_medicamento,nombre,descripcion,cantidad,'');
        }

    });  
}

function enviar_mensaje_empresa(nombre,correo,mensaje,empresa)
{
    var ruta_servicio  = api_url + '/empresa/mensaje/registrar'; 

    var data     = new FormData();

    data.append('nombre',nombre);
    data.append('correo',correo);
    data.append('mensaje',mensaje);         
    data.append('empresa',empresa);      

    data.append('token',token_web); 
    
    $.ajax({
        url: ruta_servicio,
        data: data,
        async:true,
        contentType:false,                 //Debe estar en false para que pase el objeto sin procesar        
        processData:false,                 //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,                        //Para que el formulario no guarde cache
        type:"POST"
    }).done(function(datos){

        var json =  $.parseJSON(datos); 
        
        if(json.codigo == '000')
        {   
            //$('#modal_medicamentos').modal('hide');
            //AgregarMedicamento(json.id_medicamento,nombre,descripcion,cantidad,'');
            $("#form_contacto").hide();
            $("#dmse").fadeIn(); 
        }

    });  
} 