<div class="content-wrapper">
  <section class="content-header">   
    <h1>
      Administrar usuarios
    </h1>
    <ol class="breadcrumb">    
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar usuarios</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregarUsuario">
          Agregar usuario
        </button>
      </div>

      <div class="box-body">
        <table class="table table-bordered table-hover dt-responsive tablas" width="100%">        
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th style="text-align: center;">Nombre</th>
              <th style="text-align: center;">Usuario</th>
              <th style="text-align: center;">Correo</th>
              <th style="text-align: center;">Perfil</th>
              <th style="text-align: center;">Estado</th>
              <th style="text-align: center;">Último login</th>
              <th>Acciones</th>
          </tr> 
          </thead>

          <tbody>
            <?php
              $item = null;
              $valor = null;
              $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
              //Controla que la respuesta de la BD sea un array.
              if (!is_array($usuarios))
                die('<br><div class="alert alert-danger">Problemas con la base de datos. Detalles: ' . htmlspecialchars($respuesta) . '</div>');

              foreach ($usuarios as $key => $value) {        
                echo ' <tr>
                          <td>'.($key+1).'</td>
                          <td>'.$value["nombre"].'</td>
                          <td>'.$value["usuario"].'</td>
                          <td>'.$value["correo"].'</td>
                          <td>'.$value["perfil"].'</td>';                         
                if($value["estado"] != 0){
                    echo '<td><button class="btn btn-success btn-xs btnActivar" idUsuario="'.$value["id"].'" estadoUsuario="0">Activado</button></td>';
                } else {
                    echo '<td><button class="btn btn-danger btn-xs btnActivar" idUsuario="'.$value["id"].'" estadoUsuario="1">Desactivado</button></td>';
                }
            
                echo '<td>'.$value["ultimo_login"].'</td>
                      <td>
                        <div class="btn-group"> 
                          <button class="btn btn-warning btnEditarUsuario" idUsuario="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-pencil"></i></button>
                          <button class="btn btn-danger btnEliminarUsuario" idUsuario="'.$value["id"].'" usuario="'.$value["usuario"].'"><i class="fa fa-times"></i></button>
                        </div>  
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
MODAL AGREGAR USUARIO
======================================-->
<div id="modalAgregarUsuario" class="modal fade" role="dialog"> 
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#2B992B; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar usuario</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">            
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoNombre" id="nuevoNombre" placeholder="Ingresar nombre" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL USUARIO -->
             <div class="form-group">             
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoUsuario" id="nuevoUsuario" placeholder="Ingresar usuario" id="nuevoUsuario" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL CORREO-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoCorreo" id="nuevoCorreo" placeholder="Ingrese Correo">
              </div>
            </div>
            <!-- ENTRADA PARA LA CONTRASEÑA -->
             <div class="form-group">             
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                <input type="password" class="form-control input-lg" name="nuevoPassword" id="nuevoPassword" placeholder="Ingresar contraseña" required>
              </div>
            </div>

            <!-- ENTRADA PARA SELECCIONAR SU PERFIL -->
            <div class="form-group">             
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span> 
                <select class="form-control input-lg" name="nuevoPerfil" id="nuevoPerfil">               
                  <option value="">Selecionar perfil</option>
                  <option value="SuperAdministrador">SuperAdministrador</option>
                  <option value="Administrador">Administrador</option>
                  <option value="Preventa">Preventa</option>
                  <option value="Venta">Venta</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-success">Guardar usuario</button>
        </div>

        <?php
          $crearUsuario = new ControladorUsuarios();
          $crearUsuario -> ctrCrearUsuario();
        ?>
      </form>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR USUARIO
======================================-->
<div id="modalEditarUsuario" class="modal fade" role="dialog"> 
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#2B992B; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar usuario</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->           
            <div class="form-group">
              <div class="input-group">            
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                <input type="text" class="form-control input-lg" name="editarNombre" id="editarNombre" value="" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL USUARIO -->
             <div class="form-group">             
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span> 
                <input type="text" class="form-control input-lg" name="editarUsuario" id="editarUsuario" value="" readonly>
              </div>
            </div>
            <!-- ENTRADA PARA EDITAR EL CORREO-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                <input type="text" class="form-control input-lg" name="editarCorreo" id="editarCorreo">
              </div>
            </div>
            <!-- ENTRADA PARA LA CONTRASEÑA -->
             <div class="form-group">
              <div class="input-group">             
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                <input type="password" class="form-control input-lg" name="editarPassword" id="editarPassword" placeholder="Escriba la nueva contraseña (sino, se mantiene la anterior)">
                <input type="hidden" name="passwordActual" id="passwordActual">
              </div>
            </div>

            <!-- ENTRADA PARA SELECCIONAR SU PERFIL -->
            <div class="form-group">             
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span> 
                <select class="form-control input-lg" name="editarPerfil">
                  <option value="" id="editarPerfil"></option>
                  <option value="SuperAdministrador">SuperAdministrador</option>
                  <option value="Administrador">Administrador</option>
                  <option value="Preventa">Preventa</option>
                  <option value="Venta">Venta</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-success">Modificar usuario</button>
        </div>
       <?php
          $editarUsuario = new ControladorUsuarios();
          $editarUsuario -> ctrEditarUsuario();

        ?> 
      </form>
    </div>
  </div>
</div>

<?php
  $borrarUsuario = new ControladorUsuarios();
  $borrarUsuario -> ctrBorrarUsuario();
?> 


