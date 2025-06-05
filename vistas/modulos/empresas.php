<!-- Contenido del archivo HTML/PHP con correcciones -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar Empresas Partner
    </h1>

    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar empresas</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregarEmpresa">
          Agregar empresa
        </button>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-hover dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Empresa</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $item = null;
            $valor = null;

            // Obtener las empresas a mostrar
            $empresas = ControladorEmpresas::ctrMostrarEmpresas($item, $valor);

            //Se asegura $empresas sea un array
            if (is_array($empresas) || is_object($empresas))
            {
              foreach ($empresas as $key => $value) {
                echo '<tr>
                  <td>' . ($key + 1) . '</td>
                  <td class="text-uppercase">' . $value["empresa"] . '</td>              

                  <td>
                  <div class="btn-group">
                  <button class="btn btn-warning btnEditarEmpresa" idEmpresa="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditarEmpresa"><i class="fa fa-pencil"></i></button>
                  <button class="btn btn-danger btnEliminarEmpresa" idEmpresa="' . $value["id"] . '"><i class="fa fa-times"></i></button>
                  </div>
                  </td>
                </tr>';
              }
            } else {
              echo "Error: ". $empresas;
            }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<!-- Modal Agregar Empresa -->
<div id="modalAgregarEmpresa" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <div class="modal-header" style="background:#2B992B; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar empresa</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                <input type="text" class="form-control input-lg" name="nuevaEmpresa" id="nuevaEmpresa" placeholder="Ingresar empresa" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-success">Guardar empresa</button>
        </div>
        <?php
          $crearEmpresa = new ControladorEmpresas();
          $crearEmpresa->ctrCrearEmpresa();
        ?>
      </form>
    </div>
  </div>
</div>

<!-- Modal Editar Empresa -->
<div id="modalEditarEmpresa" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <div class="modal-header" style="background:#2B992B; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Empresa</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                <input type="text" class="form-control input-lg" name="editarEmpresa" id="editarEmpresa" required>
                <input type="hidden" name="idEmpresa" id="idEmpresa" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-success">Guardar cambios</button>
        </div>
        <?php
        $editarEmpresa = new ControladorEmpresas();
        $editarEmpresa->ctrEditarEmpresa();
        ?>
      </form>
    </div>
  </div>
</div>

<?php
$borrarEmpresa = new ControladorEmpresas();
$borrarEmpresa->ctrBorrarEmpresa();
?>
