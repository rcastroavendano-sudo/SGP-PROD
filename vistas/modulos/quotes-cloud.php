
<div class="content-wrapper">
  <!-- Sección de encabezado de contenido -->
  <section class="content-header">
    <h1>
      Crear Quotes Cloud <!-- Título principal de la página -->
    </h1>
    <ol class="breadcrumb">
      <!-- Breadcrumb para navegación -->
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Crear quotes</li>
    </ol>
  </section> <!-- Fin de content-header -->

  <!-- Sección principal de contenido -->
  <section class="content">
    <div class="box">
      <form role="form" method="post" name="quoteForm" id="quoteForm">
        <!-- Formulario principal -->
        <div class="box-header with-border">
          <!-- Botón para generar quote -->
          <button type="submit" class="btn btn-warning" data-toggle="modal" onclick="generarQuote()">
            Generar Quote
          </button>
        </div> <!-- Fin de box-header -->

        <!-- Campos principales en una fila -->
        <div class="box-body">
          <div class="row">          
            <!-- Campo para Número de OP -->
            <div class="col-md-2">
              <label for="numero-op">N°OP</label>
              <input type="text" class="form-control" name="numero-op" id="numero-op" placeholder="Ingrese N°OP" required>
            </div> <!-- Fin de col-md-2 -->

            <!-- Campo para Nombre de OP -->
            <div class="col-md-2">
              <label for="nombre-op">Nombre OP</label>
              <input type="text" class="form-control" name="nombre-op" id="nombre-op" placeholder="Ingrese Nombre OP" required>
            </div> <!-- Fin de col-md-2 -->

            <!-- Campo para Cliente -->
            <div class="col-md-2">
              <label for="nombre-cliente">Cliente</label>
              <input type="text" class="form-control" name="nombre-cliente" id="nombre-cliente" placeholder="Ingrese Cliente" required>
            </div> <!-- Fin de col-md-2 -->

            <!-- ENTRADA PARA EL NOMBRE DEL VENDEDOR -->
             <div class="col-md-2">
                <?php
                  // Obtener todos los vendedores
                  $vendedores = ControladorQuotes::ctrMostrarVendedores();
                  //Controla que la respuesta de la BD sea un array.
                  if (!is_array($vendedores))
                    die('<br><div class="alert alert-danger">Problemas con la base de datos. Detalles: ' . htmlspecialchars($vendedores) . '</div>');
                ?>
                <label for="account-manager">Account Manager</label>
                  <select class="form-control" name="account-manager" id="account-manager" required>
                  <option value="" selected>¿Account Manager?</option>
                  <?php
                    foreach ($vendedores as $key => $value) {
                      echo '<option value="' .$value["usuario"] . '">' . strtoupper($value["nombre"]) . '</option>';
                    }
                 ?>
                </select>
              </div>

              <!-- Campo para U dedicada en Rack Site Bellet -->
              <div class="col-md-1">
                <label for="u-rack-bellet">U Rack Bellet</label>
                <input type="Number" class="form-control" name="u-rack-bellet" id="u-rack-bellet" oninput="soloValoresPositivos(this)" placeholder="Ej. U para switch">
              </div> <!-- Fin de col-md-1 -->

              <!-- Campo para U dedicada en Rack Site Bellet -->
               <div class="col-md-1">
                <label for="u-rack-liray">U Rack Liray</label>
                <input type="Number" class="form-control" name="u-rack-liray" id="u-rack-liray" oninput="soloValoresPositivos(this)" placeholder="Ej. U para switch">
              </div> <!-- Fin de col-md-1 -->

            <!-- Campo para Costo Total -->
            <div class="col-2">
              <label for="costo-total">Costo Mensual (USD)</label>
              <input type="Number" name="costo-total" id="costo-total" class="form-control" placeholder="0" readonly>
              <!-- Campo de solo lectura para mostrar el costo total -->
            </div> <!-- Fin de col-2 -->
          </div> <!-- Fin de row -->

            <!-- Tabla para detalles de VMs -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover dt-responsive" width="100%" id="tabla-dinamica">
                <thead>
                  <!-- Fila de títulos principales -->
                  <tr>
                    <th colspan="2" class="text-center"></th>
                    <th colspan="6" class="text-center green-title">Recursos de infraestructura</th>
                    <th colspan="4" class="text-center orange-title">Sistema operativo y BD</th>
                    <th colspan="5" class="text-center blue-title">Redes</th>
                    <th colspan="2" class="text-center"></th>
                  </tr>
                  <!-- Fila de subcolumnas -->
                  <tr>
                    <th class="col-line">#</th>
                    <th class="col-qty">Qty</th>
                    <th class="col-vm green-title">VM</th>
                    <th class="col-datacenter green-title">Datacenter</th>
                    <th class="col-vcpu green-title">vCPU</th>
                    <th class="col-vmem green-title">vMem (GB)</th>
                    <th class="col-vdisk green-title">vDisk (GB)</th>
                    <th class="col-bkp green-title">Respaldo</th>
                    <th class="col-so orange-title">SO</th>
                    <th class="col-cals orange-title">CALS</th>
                    <th class="col-bd orange-title">BD</th>
                    <th class="col-sal orange-title">SAL</th>
                    <th class="col-bwinetbp blue-title">Inet.Prim. Bellet</th>
                    <th class="col-bwinetbs blue-title">Inet.Sec. Bellet</th>
                    <th class="col-bwinetlp blue-title">Inet.Prim. Liray</th>
                    <th class="col-bwinetls blue-title">Inet.Sec. Liray</th>
                    <th class="col-ip blue-title">¿IP Pública?</th>
                    <th class="col-valor">Valor Mes (USD)</th>
                    <th class="col-acciones">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Espacio para agregar filas dinámicamente -->
                </tbody>
              </table>
            </div> <!-- Fin de table-responsive -->
          </div> <!-- Fin de box-body -->
          </form>
          <button type="button" class="btn btn-success" onclick="agregarFila()">Agregar Fila</button>
        </div> <!-- Fin de box-body -->
      </form>
    </div> <!-- Fin de box -->
  </section> <!-- Fin de content -->
</div> <!-- Fin de content-wrapper -->


