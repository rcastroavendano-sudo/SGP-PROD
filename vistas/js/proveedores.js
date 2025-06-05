/*=============================================
EDITAR PROVEEDORES
ES LLAMADO DESDE EL BOTON DE EDITAR btnEditarProveedor
DESDE EL ACHIVO PROVEEDORES.PHP
LO PRIMERO QUE SE HACE ES LLENAR EL MODAL
=============================================*/
$(".tablas").on("click", ".btnEditarProveedor", function() {
    var idProveedor = $(this).attr("idProveedor");

    var datos = new FormData();
    datos.append("idProveedor", idProveedor);

    $.ajax({
        url: "ajax/proveedores.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            $("#idProveedor").val(respuesta["proveedor_id"]);
            $("#editarProveedor").val(respuesta["nombre"]);
            $("#editarCelular").val(respuesta["celular"]);
            $("#editarCorreo").val(respuesta["correo"]);
            $("#editarRol").val(respuesta["rol"]);
            $("#editarComentarios").val(respuesta["comentarios"]);

            // Asignar el ID de la empresa
            if (respuesta["empresa_id"]) {
                $("#editarEmpresa").val(respuesta["empresa_id"]);
            } else {
                $("#editarEmpresa").val('');
            }
            
            if (respuesta["marca_empresa"]) {
                $("#editarMarca").val(respuesta["marca_id"]); // Asegúrate de que el ID se esté retornando correctamente
            } else {
                $("#editarMarca").val(''); 
            }
            
        }
    });
});



/*=============================================
ELIMINAR PROVEEDOR
=============================================*/
$(".tablas").on("click", ".btnEliminarProveedor", function() { // Asegúrate de que el nombre sea correcto
    var idProveedor = $(this).attr("idProveedor");
    swal({
        title: '¿Está seguro de borrar el proveedor?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar proveedor!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=proveedores&idProveedor=" + idProveedor;
        }
    });
});
