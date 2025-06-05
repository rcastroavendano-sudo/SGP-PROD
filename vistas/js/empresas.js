/*=============================================
EDITAR EMPRESAS
=============================================*/
$(".tablas").on("click", ".btnEditarEmpresa", function(){

	var idEmpresa = $(this).attr("idEmpresa");

	var datos = new FormData();
	datos.append("idEmpresa", idEmpresa);

	$.ajax({
		url: "ajax/empresas.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){
     		$("#editarEmpresa").val(respuesta["empresa"]);
     		$("#idEmpresa").val(respuesta["id"]);
     	}
	})
})

/*=============================================
ELIMINAR EMPRESA
=============================================*/
$(".tablas").on("click", ".btnEliminarEmpresa", function(){
	 var idEmpresa = $(this).attr("idEmpresa");
	 swal({
	 	title: '¿Está seguro de borrar la empresa?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: 'Si, borrar empresa!'
	 }).then(function(result){

	if(result.value){
		window.location = "index.php?ruta=empresas&idEmpresa="+idEmpresa;
	}
	 })
})