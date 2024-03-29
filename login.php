<?php
//Iniciamos la session
session_start();

//En el dia de mañana la clave encriptada vendrá de una base de datos
$claveEncriptada = password_hash("", PASSWORD_DEFAULT);

if ($_POST) {
  //Comprobamos que el usuario sea admin y la clave sea admin123
  $usuario = trim($_POST["txtUsuario"]); //trim elimina espacios de los laterales
  $clave = trim($_POST["txtClave"]);

  //Si es correcto creamos una variable de session llamada nombre y tenga el valor "Ana Valle"
  if ($usuario == "" &&  password_verify($clave, $claveEncriptada)) {
    $_SESSION["nombre"] = "";

    //Redireccionamos a la home
    header("location:index.php");
  } else {
    //Si no es correcto la clave o el usuario mostrar en pantalla "Usuario o clave incorrecto"
    $msg = "Usuario o clave incorrecto";
  }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">


  <title>Inicio de sesión</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">


  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body id="login" class="bg-gradient-info">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Bienvenidos</h1>
                  </div>
                  <form action="" method="POST" class="user">
                    <?php if (isset($msg)) : ?>
                      <div class="alert alert-danger" role="alert">
                        <?php echo $msg; ?>
                      </div>
                    <?php endif; ?>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="txtUsuario" name="txtUsuario" aria-describedby="emailHelp" placeholder="Usuario" value="">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="txtClave" name="txtClave" placeholder="Clave" value="">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Rcuerdame</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Entrar
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.php">Olvidaste la clave?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.php">Crear una cuenta!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
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