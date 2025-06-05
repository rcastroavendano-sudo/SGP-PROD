function soloNumerosDecimales(input) {
    // Permitir solo números y puntos
    input.value = input.value.replace(/[^0-9.]/g, '');
    
    // Validar que no haya más de un punto
    if ((input.value.match(/\./g) || []).length > 1) {
      input.value = input.value.substring(0, input.value.lastIndexOf('.'));
    }
  }
  
  /*=============================================
EDITAR COSTOS
=============================================*/
$(".tablas").on("click", ".btnEditarCosto", function() {

    var idCosto = $(this).attr("idCosto");

    var datos = new FormData();
    datos.append("idCosto", idCosto);

    $.ajax({
        url: "ajax/quotes-cloud-precios-venta.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        
        success: function(respuesta) {
             // Ahora puedes asignar los valores como normalmente
            $("#idCosto").val(respuesta["id"]);
            $("#editarItem").val(respuesta["item"]);
            $("#editarValor").val(respuesta["valor"]);
            $("#editarDescripcion").val(respuesta["descripcion"]);
       },

        error: function(xhr, status, error) {
            console.log("Error en precios-venta-cloud!!"); // Imprimir en consola cuando se haya iniciado la solicitud AJAX
        }
    });
});