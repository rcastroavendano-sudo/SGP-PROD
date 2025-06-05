<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Precios Venta Cloud
    </h1>

    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Precios Venta Cloud</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
      </div>
      <div class="box-body">
        <table class="table table-bordered table-hover dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th style="text-align: center;">Item</th>
              <th style="text-align: center;">Valor Venta (USD)</th>
              <th style="text-align: center;">Descripción</th>
              <th style="text-align: center;">Fecha última actualización</th>
              <th style="text-align: center;">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $item = null;
              $valor = null;

              // Obtener los costos del datacenter
              $costos = ControladorQuotes::ctrMostrarCostos($item, $valor);
              if (!is_array($costos))
                die('<br><div class="alert alert-danger">Problemas con la base de datos. Detalles: ' . htmlspecialchars($costos) . '</div>');

              foreach ($costos as $key => $value) {
                echo ' <tr>
                  <td>' . ($key + 1) . '</td>
                  <td class="text-uppercase">'.$value["item"].'</td>
                  <td class="text-uppercase">USD '.$value["valor"].'</td>
                  <td class="text-uppercase">'.$value["descripcion"].'</td>
                  <td class="text-uppercase">'.$value["fecha"].'</td>
                  <td>
                  <center>
                    <div class="btn-group">                        
                      <button class="btn btn-warning btnEditarCosto" idCosto="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarPrecioVenta"><i class="fa fa-pencil"></i></button>
                    </div>
                  </center>  
                  </td>
                </tr>';
                }
            ?>
          </tbody>

        </table>
      </div>
    </div>
  </section>
</div>


<!--=====================================
MODAL EDITAR PRECIO VENTA
======================================-->
<div id="modalEditarPrecioVenta" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#2B992B; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Precio de Venta</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL ITEM -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="text" class="form-control input-lg" name="editarItem" id="editarItem" readonly>
                <input type="hidden" name="idCosto" id="idCosto" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL VALOR -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                <input type="text" class="form-control input-lg" name="editarValor" id="editarValor" oninput="soloNumerosDecimales(this)">
              </div>
            </div>
            <!-- ENTRADA PARA LA DESCRIPCION -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-commenting-o"></i></span>
                <input type="text" class="form-control input-lg" name="editarDescripcion" id="editarDescripcion">
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
              $editarCosto = new ControladorQuotes();
              $editarCosto -> ctrEditarCosto();
            ?> 
          </div> <!-- Cierre de box-body -->
        </div> <!-- Cierre de modal-body -->
      </form>
    </div> <!-- Cierre de modal-content -->
  </div> <!-- Cierre de modal-dialog -->
</div> <!-- Cierre de modalEditarProveedor -->