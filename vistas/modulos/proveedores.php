<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar Proveedores
    </h1>

    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Proveedores</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregarProveedor">
          Agregar Proveedor
        </button>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-hover dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th style="text-align: center;">Nombre Apellido</th>
              <th style="text-align: center;">Celular</th>
              <th style="text-align: center;">Correo</th>
              <th style="text-align: center;">Rol</th>
              <th style="text-align: center;">Fecha última actualización</th>
              <th style="text-align: center;">Empresa</th>
              <th style="text-align: center;">Marca</th>
              <th style="text-align: center;">Comentarios</th>
              <th style="text-align: center;">Acciones</th>
            </tr>
          </thead>

          <tbody>
<?php
    // Obtener los proveedores a mostrar
    $proveedores = ControladorProveedores::ctrMostrarProveedores();

    // Verificar si $proveedores es un array u objeto
    if (is_array($proveedores) || is_object($proveedores)) {
        foreach ($proveedores as $key => $value) {
            echo '<tr>
                    <td>' . ($key + 1) . '</td>
                    <td class="text-uppercase">' . $value["nombre"] . '</td>
                    <td class="text-uppercase">' . $value["celular"] . '</td>
                    <td class="text-uppercase">' . $value["correo"] . '</td>
                    <td class="text-uppercase">' . $value["rol"] . '</td>
                    <td class="text-uppercase">' . $value["fecha"] . '</td>';

            // Mostrar nombre de la empresa y marca directamente desde la consulta JOIN
            echo '<td class="text-uppercase">' . ($value["empresa"] ?? "Error: Sin empresa") . '</td>';
            echo '<td class="text-uppercase">' . ($value["marca"] ?? "Error: Sin marca") . '</td>';

            echo '
                <td class="text-uppercase">' . $value["comentarios"] . '</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-warning btnEditarProveedor" idProveedor="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditarProveedor"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger btnEliminarProveedor" idProveedor="' . $value["id"] . '"><i class="fa fa-times"></i></button>
                    </div>
                </td>
            </tr>';
        }
    } else {
        echo "Error: " . $proveedores;
    }
?>
</tbody>

        </table>
      </div>
    </div>
  </section>
</div>


<!--=====================================
MODAL AGREGAR PROVEEDOR
======================================-->
<div id="modalAgregarProveedor" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#2B992B; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Proveedor</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
          <!-- ENTRADA PARA AGREGAR EL NOMBRE Y APELLIDO DEL PROVEEDOR-->
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-user"></i></span>
              <input type="text" class="form-control input-lg" name="agregarProveedor" id="agregarProveedor" placeholder="Ingrese Nombre y Apellido">
            </div>
          </div>

            <!-- ENTRADA PARA AGREGAR EL CELULAR-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control input-lg" name="agregarCelular" id="agregarCelular" placeholder="Ingrese Celular">
              </div>
            </div>
            <!-- ENTRADA PARA AGREGAR EL CORREO-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                <input type="text" class="form-control input-lg" name="agregarCorreo" id="agregarCorreo" placeholder="Ingrese Correo">
              </div>
            </div>
            <!-- ENTRADA PARA AGREGAR EL ROL-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                <input type="text" class="form-control input-lg" name="agregarRol" id="agregarRol" placeholder="Ingrese Rol">
              </div>
            </div>

            <!-- ENTRADA PARA EL NOMBRE DE LA EMPRESA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                <select class="form-control input-lg" name="agregarEmpresa" id="agregarEmpresa" required>
                  <option value="">Seleccionar Empresa</option>
                  <?php
                  // Obtener todas las empresas
                  $empresas = ControladorEmpresas::ctrMostrarEmpresasOrdenadasPorNombre();
                  
                  // Agregar aquí la variable que contiene el id de la empresa que quieres preseleccionar
                  $selected = (isset($empresaID) && $value["id"] == $empresaID) ? 'selected' : '';

                  //Se asegura $empresas sea un array
                  if (is_array($empresas) || is_object($empresas))
                  {
                    // Generar las opciones
                    foreach ($empresas as $key => $value) {
                      // Comprobar si el ID de la empresa coincide con el ID que se desea seleccionar
                      echo '<option value="' . $value["id"] . '" ' . $selected . '>' . strtoupper($value["empresa"]) . '</option>';
                    }
                  } else {
                    echo "Error: ". $empresas;
                  }
                  ?>
                </select>
              </div>
            </div>

            <!-- ENTRADA PARA EL NOMBRE DE LA MARCA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                <select class="form-control input-lg" name="agregarMarca" id="agregarMarca" required>
                  <option value="">Seleccionar Marca</option>
                  <?php
                  // Obtener todas las marcas
                  $marcas = ControladorMarcas::ctrMostrarMarcasOrdenadasPorNombre();
                  
                  // Agregar aquí la variable que contiene el id de la empresa que quieres preseleccionar
                  $selected = (isset($marcaID) && $value["id"] == $marcaID) ? 'selected' : '';

                  //Se asegura $marcas sea un array
                  if (is_array($marcas) || is_object($marcas))
                  {
                      // Generar las opciones
                    foreach ($marcas as $key => $value) {
                      // Comprobar si el ID de la marca coincide con el ID que se desea seleccionar
                      echo '<option value="' . $value["id"] . '" ' . $selected . '>' .strtoupper( $value["marca"]) . '</option>';
                    }
                  } else {
                      echo "Error: ". $marcas;
                    }
                  ?>
                </select>
              </div>
            </div>

            <!-- ENTRADA PARA AGREGAR EL COMENTARIO-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-commenting"></i></span>
                <input type="text" class="form-control input-lg" name="agregarComentarios" id="agregarComentarios" placeholder="Ingrese País o algún comentario adicional...">
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
              <button type="submit" class="btn btn-success">Guardar cambios</button>
            </div>

            <?php
              // Llamada al controlador para agregar el proveedor
              // Considera mover esta llamada fuera del formulario
              $agregarProveedor = new ControladorProveedores();
              $agregarProveedor->ctrCrearProveedor();
            ?>
          </div> <!-- Cierre de box-body -->
        </div> <!-- Cierre de modal-body -->
      </form>
    </div> <!-- Cierre de modal-content -->
  </div> <!-- Cierre de modal-dialog -->
</div> <!-- Cierre de modalAgregarProveedor -->



<!--=====================================
MODAL EDITAR PROVEEDOR
======================================-->
<div id="modalEditarProveedor" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#2B992B; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Proveedor</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EDITAR EL NOMBRE Y APELLIDO DEL PROVEEDOR-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" name="editarProveedor" id="editarProveedor">
                <input type="hidden" name="idProveedor" id="idProveedor">
              </div>
            </div>
            <!-- ENTRADA PARA EDITAR EL CELULAR-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control input-lg" name="editarCelular" id="editarCelular">
              </div>
            </div>
            <!-- ENTRADA PARA EDITAR EL CORREO-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                <input type="text" class="form-control input-lg" name="editarCorreo" id="editarCorreo">
              </div>
            </div>
            <!-- ENTRADA PARA EDITAR EL ROL-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                <input type="text" class="form-control input-lg" name="editarRol" id="editarRol">
              </div>
            </div>

            <!-- ENTRADA PARA EL NOMBRE DE LA EMPRESA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                <select class="form-control input-lg" name="editarEmpresa" id="editarEmpresa" required>
                  <option value="">Seleccionar Empresa</option>
                  <?php
                  // Obtener todas las empresas
                  $empresas = ControladorEmpresas::ctrMostrarEmpresasOrdenadasPorNombre();
                  
                  // Variable que contiene el id de la empresa que quieres preseleccionar
                  $empresaID = isset($respuesta["empresa_id"]) ? $respuesta["empresa_id"] : null; // Este valor se asignará dinámicamente

                  //Se asegura $empresas sea un array
                  if (is_array($empresas) || is_object($empresas))
                  {
                      // Generar las opciones
                      foreach ($empresas as $key => $value) {
                      // Comprobar si el ID de la empresa coincide con el ID que se desea seleccionar
                      $selected = (isset($empresaID) && $value["id"] == $empresaID) ? 'selected' : '';
                      echo '<option value="' . $value["id"] . '" ' . $selected . '>' . $value["empresa"] . '</option>';
                    }
                  } else {
                    echo "Error: ". $empresas;
				          }
                  ?>
                </select>
              </div>
            </div>

            <!-- ENTRADA PARA EL NOMBRE DE LA MARCA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                <select class="form-control input-lg" name="editarMarca" id="editarMarca" required>
                  <option value="">Seleccionar Marca</option>
                  <?php
                  // Obtener todas las marcas
                  $marcas = ControladorMarcas::ctrMostrarMarcasOrdenadasPorNombre();
                  
                  // Agregar aquí la variable que contiene el id de la empresa que quieres preseleccionar
                  $marcaID = isset($respuesta["marca_id"]) ? $respuesta["marca_id"] : null; // Este valor se asignará dinámicamente
                  
                  //Se asegura $marcas sea un array
                  if (is_array($marcas) || is_object($marcas))
                  {
                      // Generar las opciones
                    foreach ($marcas as $key => $value) {
                      // Comprobar si el ID de la marca coincide con el ID que se desea seleccionar
                      $selected = (isset($marcaID) && $value["id"] == $marcaID) ? 'selected' : '';
                      echo '<option value="' . $value["id"] . '" ' . $selected . '>' . $value["marca"] . '</option>';  // Asume que el nombre de la marca está en 'nombre_marca'
                    }
                  } else {
                    echo "Error: ". $marcas;
				          }

                  ?>
                </select>
              </div>
            </div>

            <!-- ENTRADA PARA EDITAR EL COMENTARIO-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-commenting"></i></span>
                <input type="text" class="form-control input-lg" name="editarComentarios" id="editarComentarios">
              </div>
            </div>

            <!--=====================================
            PIE DEL MODAL
            ======================================-->
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
              <button type="submit" class="btn btn-success">Guardar cambios</button>
            </div>

            <?php
              $editarProveedor = new ControladorProveedores();
              $editarProveedor->ctrEditarProveedor();
            ?>
          </div> <!-- Cierre de box-body -->
        </div> <!-- Cierre de modal-body -->
      </form>
    </div> <!-- Cierre de modal-content -->
  </div> <!-- Cierre de modal-dialog -->
</div> <!-- Cierre de modalEditarProveedor -->


<?php
  // Llamada al controlador para eliminar el proveedor
  $borrarProveedor = new ControladorProveedores();
  $borrarProveedor->ctrBorrarProveedor();
?> 
