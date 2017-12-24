<?
    ##########################################################################################################
    #    
    #                        R U T A S  D E L M O D U L O 
    #
    ##########################################################################################################     


    /*********************************************************************************************************
    * 
    *        B L O Q U E       C L I E N T E S
    *
    **********************************************************************************************************/



    Base::router('get','/listadoclientes', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ListadoClientes($parametros);
    });

    Base::router('post','/registrarcliente', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->RegistrarCliente($parametros);
    });

    Base::router('post','/actualizarcliente', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ActualizarCliente($parametros);
    });    

    Base::router('get','/siguienteClaveCliente', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ObtenerSiguienteClaveCliente();
    });

    Base::router('get','/obtenercliente/:id', function($id) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['id_cliente'] = $id; 
        $resultado = $c_sistema->ObtenerClienteId($parametros);
    });


    Base::router('get','/buscarcliente', function() use ($c_sistema,&$parametros,&$resultado){                  
        $resultado = $c_sistema->BuscarCliente();
    });


    

    /*********************************************************************************************************
    * 
    *        B L O Q U E       A R T I C U L O S
    *
    **********************************************************************************************************/

    Base::router('get','/listadoarticulos', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ListadoArticulos();
    });

    Base::router('get','/buscararticulo', function() use ($c_sistema,&$parametros,&$resultado){
        $resultado = $c_sistema->BuscarArticulo();
    });

    Base::router('get','/siguienteClaveArticulo', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ObtenerSiguienteClaveArticulo();
    });

    Base::router('post','/registrararticulo', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->RegistrarArticulo($parametros);
    });

    Base::router('get','/obtenerarticulo/:id', function($id) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['id_articulo'] = $id; 
        $resultado = $c_sistema->ObtenerArticuloId($parametros);
    });

    Base::router('post','/actualizararticulo', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ActualizarArticulo($parametros);
    });   

    /*********************************************************************************************************
    * 
    *        B L O Q U E       A R T I C U L O S
    *
    **********************************************************************************************************/

    Base::router('get','/obtenerconfiguracion', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ObtenerConfiguracion();
    });

    Base::router('post','/actualizarconfiguracion', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ActualizarConfiguracion($parametros);
    }); 

    /*********************************************************************************************************
    * 
    *        B L O Q U E       V E N T A S
    *
    **********************************************************************************************************/

    Base::router('get','/listadoventas', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ListadoVentas();
    });

    Base::router('get','/siguienteClaveVenta', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ObtenerSiguienteClaveVenta  ();
    });

    Base::router('get','/calcularprecioarticulo/:id', function($id) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['id_articulo'] = $id; 
        $resultado = $c_sistema->CalcularPrecioArticuloId($parametros);
    });

    Base::router('get','/calcularenganche/:importe', function($importe) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['importe'] = $importe; 
        $resultado = $c_sistema->CalcularEnganche($parametros);
    });

    Base::router('get','/calculoabonomeses/:importe', function($importe) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['importe'] = $importe; 
        $resultado = $c_sistema->CalculoAbonoMeses($parametros);
    });

    Base::router('post','/registrarventa', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->RegistrarVenta($parametros);
    }); 

    


    

    


    

    




    

    


    
    

    

    

    


    


    


    

    











    Base::router('post','/empresa/agregar-fav', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->AgregarEmpresaFavoritos($parametros);
    });

    Base::router('get','/buscarempresas/:consulta', function($consulta) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['consulta'] = $consulta;
        $resultado = $c_sistema->ObtenerEmpresasGeneral($parametros);
    });

    Base::router('post','/empresa/mensaje/registrar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->RegistrarMensajeEmpresa($parametros);
    });

    Base::router('get','/buscarciudad/:id', function($id) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['id_estado'] = $id;        
        $resultado = $c_sistema->ObtenerCiudades($parametros);
    });
    

    /************************************************************************************************************
    * 
    *  PENDIENTES 
    *
    *************************************************************************************************************/

    Base::router('post','/pendientes', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->listadoPendientes($parametros);
    });

    Base::router('post','/pendientes/registrar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->registrarPendienteAjax($parametros);
    });

    Base::router('post','/pendientes/actualizar/:id', function($id) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['id'] = $id;
        $resultado = $c_sistema->actualizarPendienteAjax($parametros);
    });


    /************************************************************************************************************
    * 
    *  Contactos 
    *
    *************************************************************************************************************/


    Base::router('post','/contactos', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ListadoContactos($parametros);
    });

    Base::router('post','/contacto/registrar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->RegistrarContacto($parametros);
    });

    Base::router('post','/contacto/actualizar/:id', function($id) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['id'] = $id;
        $resultado = $c_sistema->ActualizarContacto($parametros);
    });

    Base::router('post','/contacto/eliminar', function() use ($c_sistema,&$parametros,&$resultado){          
        $resultado = $c_sistema->EliminarContacto($parametros);
    });



    /************************************************************************************************************
    * 
    *  A M W A Y 
    *
    *************************************************************************************************************/

    Base::router('post','/amway/contacto/registrar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->RegistrarContactoAmway($parametros);
    });

    Base::router('post','/amway/contacto/actualizar/:id', function($id) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['id'] = $id;
        $resultado = $c_sistema->ActualizarContacto($parametros);
    });


    Base::router('post','/amway/contactos', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ListadoContactosAmway($parametros);
    });
    
    Base::router('post','/amway/registraravance', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->RegistrarAvanceEtapaContacto($parametros);
    });

    Base::router('post','/amway/registraravance/completo', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->RegistrarAvanceEtapaContactoCompleto($parametros);
    });

    Base::router('post','/amway/contacto/eliminar', function() use ($c_sistema,&$parametros,&$resultado){          
        $resultado = $c_sistema->EliminarContacto($parametros);
    });


    /************************************************************************************************************
    * 
    * C I T A S 
    *
    *************************************************************************************************************/

    Base::router('post','/periodos/disponibles/citas', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->obtenerPeriodosDisponibles($parametros);
    });


    /************************************************************************************************************
    * 
    *  R E D  D E N T A L 
    *
    *************************************************************************************************************/

    Base::router('post','/reddental/contacto/registrar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->RegistrarContactoRedDental($parametros);
    });

    Base::router('post','/reddental/contacto/actualizar/:id', function($id) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['id'] = $id;
        $resultado = $c_sistema->ActualizarContacto($parametros);
    });

    Base::router('post','/reddental/contactos', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ListadoPacientesRedDental($parametros);
    });        

    Base::router('post','/reddental/contacto/eliminar', function() use ($c_sistema,&$parametros,&$resultado){          
        $resultado = $c_sistema->EliminarContacto($parametros);
    });

    Base::router('post','/reddental/servicio/registrar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->registrarServicioClinica($parametros);
    });

    Base::router('post','/reddental/servicio/actualizar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->actualizarServicioClinica($parametros);
    });

    Base::router('post','/reddental/servicio/eliminar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->eliminarServicioClinica($parametros);
    });

    Base::router('post','/reddental/consulta/registrar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->RegistrarConsulta($parametros);
    });

    Base::router('post','/reddental/consulta/actualizar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ActualizarConsulta($parametros);
    });

    Base::router('post','/reddental/consulta/eliminar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->EliminarConsulta($parametros);
    });


    /************************************************************************************************************
    * 
    *  I N G R E S O S
    *
    *************************************************************************************************************/

    Base::router('post','/ingresos/registrar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->RegistrarIngreso($parametros);
    });

    Base::router('post','/ingresos/actualizar', function() use ($c_sistema,&$parametros,&$resultado){          
        $resultado = $c_sistema->ActualizarIngreso($parametros);
    });

    Base::router('post','/ingresos/eliminar', function() use ($c_sistema,&$parametros,&$resultado){          
        $resultado = $c_sistema->EliminarIngreso($parametros);
    });

    /***********************************************************************************************************
    *
    * M E D I C A M E N T O S    
    *
    ***********************************************************************************************************/

    Base::router('post','/reddental/medicamentos/registrar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->registrarMedicamentoClinica($parametros);
    });

    Base::router('post','/reddental/medicamentos/listado', function() use ($c_sistema,&$parametros,&$resultado){          
        $resultado = $c_sistema->ListadoMedicamentos($parametros);
    });

    

    /************************************************************************************************************
    *
    * C O M E N T A R I O S   C O N T A C T O S
    *    
    *************************************************************************************************************/


    Base::router('get','/amway/contactos/cometarios/:id', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ObtenerComentariosContacto($parametros);
    });

    Base::router('post','/amway/contacto/registra/comentario', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->RegistrarComentarioContacto($parametros);
    });

    Base::router('put','/amway/contacto/actualizar/comentario/:id', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ActualizarComentarioContacto($parametros);
    });

    Base::router('put','/amway/contacto/eliminar/comentario/:id', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->ActualizarComentarioContacto($parametros);
    });


     /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    *
    * C I T A S 
    *    
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    Base::router('post','/citas/eliminar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->EliminarCita($parametros);
    });

     /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    *
    * A c t i v a r   M O d u l o s 
    *    
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


    Base::router('post','/modulo/usuario/activar', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->RegistrarUsuarioModulo($parametros);
    });













    



    
    



    /************************************************************************************************************
    * 
    *  CHAT EN LINEA 
    *
    *************************************************************************************************************/    

    Base::router('get','/obtener_conversacion_anterior/:id_usuario_r/:id_usuario/:page', function($id_usuario_r,$id_usuario,$page) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['id_usuario_r'] = $id_usuario_r;
        $parametros['id_usuario'] = $id_usuario;
        $parametros['page'] = $page;
        $resultado = $c_sistema->cargarConversacionAnteriorUsuario($parametros);
    });

    Base::router('get','/marcar_mensaje_visto/:id_usuario/:id_inbox', function($id_usuario,$id_inbox) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['id_usuario'] = $id_usuario;
        $parametros['id_inbox'] = $id_inbox;
        $resultado = $c_sistema->marcarVistoInbox($parametros);
    });

    Base::router('get','/cargar_inbox_usuario/:id_usuario_r/:id_inbox_max', function($id_usuario_r,$id_inbox_max) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['id_usuario_r'] = $id_usuario_r;        
        $parametros['id_inbox_max'] = $id_inbox_max;        
        $resultado = $c_sistema->listadoInboxSinLeer($parametros);
    });

    Base::router('get','/eliminar_inbox/:id_inbox', function($id_inbox) use ($c_sistema,&$parametros,&$resultado){  
        $parametros['id_inbox'] = $id_inbox;        
        $resultado = $c_sistema->eliminarInbox($parametros);
    });

    Base::router('get','/marcar_inbox_visto/:id_inbox', function($id_inbox) use ($c_sistema,&$parametros,&$resultado){          
        $parametros['id_inbox'] = $id_inbox;
        $resultado = $c_sistema->marcarVistoInbox($parametros);
    });

    Base::router('post','/new_inbox', function() use ($c_sistema,&$parametros,&$resultado){  
        $resultado = $c_sistema->registrarInbox($parametros,$files);
    });
 
    
    
    ##########################################################################################################
    #
    #   I N F O R M A C I O N - G E N E R A L 
    #
    ##########################################################################################################

    Base::router('get','/info', function(){        
        include('info.php');
    });
?>