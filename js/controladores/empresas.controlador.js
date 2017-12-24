 $(function(){
	$(".add-fav-empresa").click(function(){
		var id_empresa	= $(this).data("id-empresa"); 
		var fav 		= $(this).data("fav"); 
		var id 			= $(this).attr("id");
	    agregar_empresa_favoritos(id, id_empresa, fav);
	});
})