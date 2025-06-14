<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar Marcas Partner
    </h1>

    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>    
      <li class="active">Administrar marcas</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregarMarca">
          Agregar marca
        </button>
      </div>

      <div class="box-body">       
       <table class="table table-bordered table-hover dt-responsive tablas" width="100%">

        <thead>        
          <tr>
          <th style="width:10px">#</th>
          <th>Marca</th>
          <th>Acciones</th>
          </tr> 
        </thead>

        <tbody>
          <?php
            $item = null;
            $valor = null;

            $marcas = ControladorMarcas::ctrMostrarMarcas($item, $valor);
            //Se asegura $marcas sea un array
            if (is_array($marcas) || is_object($marcas))
            {
              foreach ($marcas as $key => $value) {
              echo ' <tr>
                <td>'.($key+1).'</td>
                <td class="text-uppercase">'.$value["marca"].'</td>
                <td>
                  <div class="btn-group">                        
                    <button class="btn btn-warning btnEditarMarca" idMarca="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarMarca"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-danger btnEliminarMarca" idMarca="'.$value["id"].'"><i class="fa fa-times"></i></button>
                  </div>  
                </td>
              </tr>';
              }
            } else {
              echo "Error: ". $marcas;
            }
          ?>
        </tbody>
       </table>
      </div>
    </div>
  </section>
</div>

<!--=====================================
MODAL AGREGAR MARCA
======================================-->
<div id="modalAgregarMarca" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#2B992B; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar marca</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-black-tie"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaMarca" id="nuevaMarca" placeholder="Ingresar marca" required>
              </div>
            </div> 
          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-success">Guardar marca</button>
        </div>

        <?php
          $crearMarca = new ControladorMarcas();
          $crearMarca -> ctrCrearMarca();
        ?>
      </form>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR MARCA
======================================-->
<div id="modalEditarMarca" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#2B992B; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Marca</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">             
                <span class="input-group-addon"><i class="fa fa-black-tie"></i></span> 
                <input type="text" class="form-control input-lg" name="editarMarca" id="editarMarca" required>
                <input type="hidden" name="idMarca" id="idMarca" required>
              </div>
            </div> 
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
          $editarMarca = new ControladorMarcas();
          $editarMarca -> ctrEditarMarca();
        ?> 
      </form>
    </div>
  </div>
</div>

<?php
  $borrarMarca = new ControladorMarcas();
  $borrarMarca -> ctrBorrarMarca();
?>


