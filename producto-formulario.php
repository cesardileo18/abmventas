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
include_once "entidades/producto.php";
include_once "entidades/tipoproducto.php";
$pg = "Edición de producto";

$producto = new Producto();
$producto->cargarFormulario($_REQUEST);

if($_POST){
  if(isset($_POST["btnGuardar"])){
      if(isset($_GET["id"]) && $_GET["id"] > 0){
            //Actualizo un cliente existente
            $producto->actualizar();
          
      } else {
          //Es nuevo
          $producto->insertar();
        
      }
  } else if(isset($_POST["btnBorrar"])){
      $producto->eliminar();
      header("location: producto-formulario.php");
  }
} 
if(isset($_GET["id"]) && $_GET["id"] > 0){
  $producto->obtenerPorId();
}

$tipoProducto = new Tipoproducto(); 
$array_tipoproductos = $tipoProducto->ObtenerTodos();

?>
<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Productos</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="estilos.css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
  

</head>

<?php include_once("nav.php"); ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Productos</h1>
          <div class="row">
                <div class="col-12 mb-3">
                    <a href="producto-formulario.php" class="btn btn-primary mr-2 mb-2 col-xs-12 col-sm-2 col-lg-1">Nuevo</a>
                    <button type="submit" class="btn btn-success mr-2 mb-2 col-xs-12 col-sm-2 col-lg-1" id="btnGuardar" name="btnGuardar">Guardar</button>
                    <button type="submit" class="btn btn-danger mb-2 col-xs-12 col-sm-2 col-lg-1" id="btnBorrar" name="btnBorrar">Borrar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required="" class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $producto-> nombre; ?>">
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="txtNombre">Tipo de producto:</label>
                    <select name="lstTipoProducto" id="lstTipoProducto" class="form-control">
                        <option value="" disabled selected >Seleccionar Productos</option>
                                  <?php foreach($array_tipoproductos as $tipo):?>
                                  <?php if ($producto->fk_idtipoproducto == $tipo->idtipoproducto):?>
                                  <option selected value="<?php echo $tipo->idtipoproducto; ?>"><?php echo $tipo->nombre; ?></option>
                                  <?php else: ?>
                                  <option value="<?php echo $tipo->idtipoproducto; ?>"><?php echo $tipo->nombre; ?></option>
                                  <?php endif; ?>
                                  <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <label for="txtCantidad">Cantidad:</label>
                    <input type="number" required="" class="form-control" name="txtCantidad" id="txtCantidad" value="<?php echo $producto->cantidad; ?>">
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="txtPrecio">Precio:</label>
                    <input type="text" class="form-control" name="txtPrecio" id="txtPrecio" value="<?php echo $producto->precio; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    <label for="txtCorreo">Descripción:</label>
                    <textarea type="text" name="txtDescripcion" id="txtDescripcion"><?php echo $producto->descripcion; ?></textarea>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      <script>
        ClassicEditor
            .create( document.querySelector( '#txtDescripcion' ) )
            .catch( error => {
            console.error( error );
            } );
        </script>
        <style>
        .ck.ck-editor {
            height: 600px;
        }
        </style>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
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

</body>

</html>
