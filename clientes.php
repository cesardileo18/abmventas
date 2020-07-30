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
include_once "entidades/cliente.php";
include_once "entidades/domicilio.php";
$pg = "Listado de clientes";

$cliente = new Cliente();
$aClientes = $cliente->obtenerTodos();

?>
<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Listado de clientes</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="estilos.css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  

</head>

<?php include_once("nav.php"); ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Listado de clientes</h1>
          <div class="row">
                <div class="col-12 mb-3">
                    <a href="cliente-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                </div>
            </div>
          <table class="table table-hover border">
            <tr>
                <th>CUIT</th>
                <th>Nombre</th>
                <th>Fecha Nac.</th>
                <th>Teléfono</th>
                <th>Correo</th>
                
                <th>Acciones</th>
            </tr>
            <?php foreach ($aClientes as $cliente): ?>
        
              <tr>
                  <td><a href="cliente-formulario.php?id=<?php echo $cliente->idcliente; ?>"><?php echo $cliente->cuit; ?></a></td>
                  <td><?php echo $cliente->nombre; ?></td>
                  <td><?php echo $cliente->fecha_nac; ?></td>
                  <td><?php echo $cliente->telefono; ?></td>
                  <td><?php echo $cliente->correo; ?></td>
                  <td style= "width: 110px">
                  <a href="cliente-formulario.php?id=<?php echo $cliente->idcliente; ?>"><i class="fas fa-search"></i></a></td>
              </tr>
            <?php endforeach; ?>
          </table>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

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
