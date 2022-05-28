<?php
// Se solicita la conexion a la bd
require_once "Conexion.php";

// Se revisa si ya hay un usuario logeado, en caso de que no, se le redirecciona a la pagina de bienvenida
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: Menu.php");
  exit;
}

// Se definen variables sin atributo
$username = $password = "";
$username_err = $password_err = "";

// Se procesa el formulario al apretar el boton
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Se revisa si el input usuario esta vacio
    if(empty(trim($_POST["usuario"]))){
        $username_err = "<p style='color: red;'>Por favor, ingrese su usuario.</p><br>";
    } else{
        $username = trim($_POST["usuario"]);
    }

    // Se revisa si el input contraseña esta vacio
    if(empty(trim($_POST["password"]))){
        $password_err = "<p  style='color: red;'>Por favor, ingrese su contraseña.</p><br>";
    } else{
        $password = trim($_POST["password"]);
    }

    // Se validan los inputs usuario y contraseña
    if(empty($username_err) && empty($password_err)){
        // Se hace una consulta a la base de datos y se guarda en $sql
        $sql = "SELECT id_cliente, usuario, password FROM clientes WHERE usuario = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Se unen las variables para los parametros
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Se configura el parametro
            $param_username = $username;

            // Se ejecuta la declaracion
            if(mysqli_stmt_execute($stmt)){
                // Resultado
                mysqli_stmt_store_result($stmt);

                // Si el usuario existe, se verifica la contraseña
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Se unen los resultados
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Si la contraseña es correcta, se inicia sesion
                            session_start();

                            // Se guardan los datos de sesion
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id_cliente"] = $id;
                            $_SESSION["usuario"] = $username;

                            // Se redirecciona a la pagina principal de cliente
                            header("location: index.php");
                        } else{
                            // Se muestra un mensaje si la contraseña es erronea
                            $password_err = "<p  style='color: red;'>La contraseña que has ingresado no es válida.</p><br>";
                        }
                    }
                } else{
                    // Se muestra un mensaje si el usuario no existe
                    $username_err = "<p  style='color: red;'>No existe cuenta registrada con ese nombre de usuario.<p><br>";
                }
            } else{
                echo "Error, por favor vuelve a intentarlo.";
            }
        }

        // Cierre de declaracion
        mysqli_stmt_close($stmt);
    }

    // Cierre de conexion a la bd
    mysqli_close($link);
}
?>

<!--Aqui va el HTML-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Iniciar sesion</title>
</head>

<body >
  <!--CABECERA-->
<header>
	<!--Menu de navegación-->
	<nav>
		<ul>
			<li><a href="menu.php">Inicio</a></li>
            <li><a href=".php">¿como comprar?</a></li>
            <li><a href="#">Ayuda</a></li>
		</ul>
	</nav>
</header>
<!--FIN CABECERA-->

    <div align="center">
        <h2 align="center">Iniciar Sesión</h2>
        <p align="center">Por favor, ingrese su usuario y contraseña para iniciar sesión.</p>

        <!--Formulario de incio de sesión-->
        <!--Se envian los datos de los inputs mediante el metodo POST-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <!--Revisa que el usuario no este vacio-->
            <div <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>>
                <label>Correo</label>
                <input type="text" name="usuario" placeholder="ingrese su correo" value="<?php echo $username; ?>" required>
                <span><?php echo $username_err; ?></span>
            </div>
          </br>
            <!--Revisa que la contraseña no este vacia-->
            <div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>>
                <label>Contraseña</label>
                <input type="password" placeholder="ingresar contraseña" name="password" required>
                <span><?php echo $password_err; ?></span>
            </div>
            </br>
            <div>
                <input class="actualizar" type="submit" value="Ingresar">
            </div>
            <p>¿No tienes una cuenta? <a href="RegistroCliente.php">Crear una cuenta</a>.</p>
        </form>
    </div>

<!--PIE DE PAGINA-->

<!--FIN PIE DE PAGINA-->
