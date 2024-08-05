<?php
require_once('../datos/DAOUsuario.php');

//Verificar que llegan datos
if (isset($_POST["correo"]) && isset($_POST["password"])) {
    //Conectarme y buscar 
    $dao = new DAOUsuario();
    $usuario = $dao->autenticar($_POST["correo"], $_POST["password"]);

    // Después de autenticar
    if ($usuario) {
        session_start();
        $_SESSION["usuario"] = $usuario->id;
        $_SESSION["nombre"] = $usuario->nombre . " " . $usuario->apellido1;
        // Asignar valores numéricos a los tipos de usuario
        switch ($usuario->tipo) {
            case "Administrador":
                $_SESSION["tipo"] = 1;
                header("Location: usuarios/tablaUsuario.php");
                exit;
            case "Usuario":
                $_SESSION["tipo"] = 2;
                header("Location: planSemanal/tablaPlan.php");
                break;
            default:
                $_SESSION["tipo"] = 0; // Valor predeterminado para otros tipos
        }

        return;
    }
}
header("Location: index.html");
