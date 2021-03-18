<?php

//Iniciamos la session
session_start();

if(!isset($_SESSION["nombre"])){
    header("location:login.php");
}

if($_POST){
    if(isset($_POST["btnCerrar"])){ /* Analizamos si es la accion del boton cerrar */
        session_destroy();
        header("location:login.php");
    }
}

include_once "config.php";
include_once "entidades/venta.php";
include_once "entidades/cliente.php";
include_once "entidades/producto.php";
$pg = "Nueva venta";

$venta = new Venta();
$venta->cargarFormulario($_REQUEST);
if($_POST){
    if(isset($_POST["btnGuardar"])){
        if(isset($_GET["id"]) && $_GET["id"] > 0){
              //Actualizo un cliente existente
              $venta->actualizar();
        } else {
            //Es nuevo
            $venta->insertar();
        }
    } else if(isset($_POST["btnBorrar"])){
        $venta->eliminar();
        header("location: venta-formulario.php");
    }

    if(isset($_GET["id"]) && $_GET["id"] > 0){
      $venta->obtenerPorId();
  }
}
if(isset($_GET["do"]) && $_GET["do"] == "buscarProducto" && $_GET["id"] && $_GET["id"] > 0) {
    $idproducto = $_GET["id"];
    $producto = new Producto();
    $producto->idproducto = $idproducto; 
    $producto->obtenerPorId();
    echo json_decode($producto->precio);
    exit;

    } elseif (isset($_GET["id"]) && $_GET["id"] > 0){
      $venta->obtenerPorId();
    }
    
$cliente = new Cliente(); 
$array_clientes = $cliente->ObtenerTodos();

$producto = new Producto();
$array_productos = $producto->obtenerTodos();

?>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Edición de venta</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>

</head>

<?php include_once("nav.php"); ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <form action="" method="POST">
          <h1 class="h3 mb-4 text-gray-800">Venta</h1>
            <div class="row">
                <div class="col-12 mb-3">
                    <a href="ventas.php" class="btn btn-primary mr-2 mb-2 col-xs-12 col-sm-2 col-lg-1">Listado</a>
                    <a href="venta-formulario.php" class="btn btn-primary mr-2 mb-2 col-xs-12 col-sm-2 col-lg-1">Nuevo</a>
                    <button type="submit" class="btn btn-success mr-2 mb-2 col-xs-12 col-sm-2 col-lg-1" id="btnGuardar" name="btnGuardar">Guardar</button>
                    <button type="submit" class="btn btn-danger mb-2 col-xs-12 col-sm-2 col-lg-1" id="btnBorrar" name="btnBorrar">Borrar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <label for="txtFecha">Fecha:</label>
                    <input type="date" required="" class="form-control" name="txtFecha" id="txtFecha" value="<?php echo date_format(date_create($venta->fecha), "d-m-Y"); ?>">
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="txtFecha">Hora:</label>
                    <input type="time" required="" class="form-control" name="txtHora" id="txtHora" value="<?php echo $venta->hora;?>">
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="lstCliente">Venta:</label>
                    <select required="" class="form-control" name="lstCliente" id="lstCliente">
                    <option value="" disabled selected >Seleccionar</option>
                    <?php foreach($array_clientes as $cliente):?>
                            <?php if ($venta->fk_idcliente == $cliente->idcliente):?>
                            <option selected value="<?php echo $cliente->idcliente; ?>"><?php echo $cliente->nombre; ?></option>
                            <?php else: ?>
                            <option value="<?php echo $cliente->idcliente; ?>"><?php echo $cliente->nombre; ?></option>
                            <?php endif; ?>
                            <?php endforeach; ?>    
                    </select>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="lstProducto">Producto:</label>
                    <select required="" class="form-control" name="lstProducto" id="lstProducto" onchange="fBuscarPrecio();">
                    <option value="" disabled selected >Seleccionar</option>
                    <?php foreach($array_productos as $producto):?>
                                  <?php if ($venta->fk_idproducto == $producto->idproducto):?>
                                  <option selected value="<?php echo $producto->idproducto; ?>"><?php echo $producto->nombre; ?></option>
                                  <?php else: ?>
                                  <option value="<?php echo $producto->idproducto; ?>"><?php echo $producto->nombre; ?></option>
                                  <?php endif; ?>
                                  <?php endforeach; ?>
                                                                        </select>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="txtCantidad">Cantidad:</label>
                    <input type="text" required="" class="form-control" name="txtCantidad" id="txtCantidad" onchange="fCalcularTotal();" value="<?php echo $venta->cantidad; ?>">
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="txtPrecioUni">Precio unitario:</label>
                    <input type="text" class="form-control" name="txtPrecioUni" id="txtPrecioUni" onchange="fCalcularTotal();" value="<?php echo $venta->preciounitario;?>">
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="txtTotal">Total:</label>
                    <input type="text" class="form-control" name="txtTotal" id="txtTotal" onchange="fCalcularTotal();" value="<?php echo $venta->total;?>">
                </div>
            </div>
        </div>
     </form>
        <!-- /.container-fluid -->

  <script> 

function fBuscarPrecio(){
            var idproducto = $("#lstProducto option:selected").val();
            $.ajax({
                type: "GET",
                url: "venta-formulario.php?do=buscarProducto",
                data: { id:idproducto },
                async: true,
                dataType: "json",
                success: function (respuesta) {
                    $("#txtPrecioUni").val(respuesta);
                }
            });

        }

        function fCalcularTotal(){
            var precio = $('#txtPrecioUni').val();
            var cantidad = $('#txtCantidad').val();
            var resultado = precio * cantidad;
                  $("#txtTotal").val(resultado);
            
        }

  </script>
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Desea salir del sistema?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Hacer clic en "Cerrar sesión" si deseas finalizar tu sesión actual.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" name="btnCerrar">Cerrar sesión</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>
</body>

</html>
