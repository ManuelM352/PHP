<?php
    $usuario = new Usuario();

    $valNombre = $valApe1 = $valApe2 = $valEmail = $valTipo = $valPassword = $valPassword2 = $valMateria = "";

    if (count($_POST) == 1 && isset($_POST["id"]) && is_numeric($_POST["id"])) {
        $dao = new DAOUsuario();
        $usuario = $dao->obtenerUno($_POST["id"]);
    } elseif (count($_POST) > 1) {
        $valNombre = $valApe1 = $valApe2 = $valEmail = $valTipo = $valPassword = $valPassword2 = "is-invalid";
        $valido = true;

        if (isset($_POST["Nombre"]) && (strlen(trim($_POST["Nombre"])) > 3 && strlen(trim($_POST["Nombre"])) < 51) && preg_match("/^[\p{L} .-]+$/u", $_POST["Nombre"])) {
            $valNombre = "is-valid";
        } else {
            $valido = false;
        }

        if (isset($_POST["Apellido1"]) && (strlen(trim($_POST["Apellido1"])) > 3 && strlen(trim($_POST["Apellido1"])) < 51) && preg_match("/^[\p{L} .-]+$/u", $_POST["Apellido1"])) {
            $valApe1 = "is-valid";
        } else {
            $valido = false;
        }

        if (isset($_POST["Apellido2"]) && (strlen(trim($_POST["Apellido2"])) == 0) || (strlen(trim($_POST["Apellido2"])) > 3 && strlen(trim($_POST["Apellido2"])) < 51) && preg_match("/^[\p{L} .-]+$/u", $_POST["Apellido2"])) {
            $valApe2 = "is-valid";
        } else {
            $valido = false;
        }

        if (isset($_POST["Email"]) && filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)) {
            $valEmail = "is-valid";
        } else {
            $valido = false;
        }

        if (isset($_POST["Password"]) && (strlen(trim($_POST["Password"])) >= 6 && strlen(trim($_POST["Password"])) < 16)) {
            $valPassword = "is-valid";
        } else {
            if (empty($_POST["Password"]) && $_POST['operation'] !== 'edit') {
                $valPassword = "is-invalid";
                $valido = false;
            } else {
                if ($_POST['operation'] === 'edit' && empty($_POST["Password"])) {
                    $valPassword = "is-valid";
                } else {
                    $valido = false;
                }
            }
        }

        if (isset($_POST["Password2"]) && (strlen(trim($_POST["Password2"])) >= 6 && strlen(trim($_POST["Password2"])) < 16) && $_POST["Password"] === $_POST["Password2"]) {
            $valPassword2 = "is-valid";
        } else {
            if (empty($_POST["Password2"]) && $_POST['operation'] !== 'edit') {
                $valPassword2 = "is-invalid";
                $valido = false;
            } else {
                if ($_POST['operation'] === 'edit' && empty($_POST["Password2"])) {
                    $valPassword2 = "is-valid";
                } else {
                    $valido = false;
                }
            }
        }

        if (isset($_POST["Tipo"]) && ($_POST["Tipo"] != 0)) {
            $valTipo = "is-valid";
        } else {
            $valido = false;
        }

        // if (isset($_POST["materia_id"]) && $_POST["materia_id"] !== '') {
        //     $valMateria = "is-valid";
        // } else {
        //     $valMateria = "is-invalid";
        //     $valido = false;
        // }

        $usuario->id = isset($_POST["Id"]) ? trim($_POST["Id"]) : 0;
        $usuario->nombre = isset($_POST["Nombre"]) ? trim($_POST["Nombre"]) : "";
        $usuario->apellido1 = isset($_POST["Apellido1"]) ? trim($_POST["Apellido1"]) : "";
        $usuario->apellido2 = isset($_POST["Apellido2"]) ? trim($_POST["Apellido2"]) : "";
        $usuario->email = isset($_POST["Email"]) ? $_POST["Email"] : "";
        $usuario->materia_id = isset($_POST["materia_id"]) && $_POST["materia_id"] !== '' ? $_POST["materia_id"] : null;
        $usuario->tipo = isset($_POST["Tipo"]) ? $_POST["Tipo"] : "";
        $usuario->password = isset($_POST["Password"]) ? $_POST["Password"] : "";

        $usuario->id = $_POST['iden'];

        if ($valido) {
            $dao = new DAOUsuario();
            if ($_POST['operation'] === 'edit') {
                $usuario->id = $_POST['iden'];
                if ($dao->editar($usuario) == false) {
                    $valEmail = "is-invalid";
                $_SESSION["msj"]="danger-Correo electronico en uso";
                $_POST["Email"]="";
                    if ($_POST['operation'] === 'edit') {
                        $_POST["id"] = $usuario->id;
                    }
                } else {
                    header("Location: tablaUsuario.php");
                }
            } else {
                if ($dao->agregar($usuario) == 0) {
                    //var_dump($_POST);
                    //echo "Error al guardar";
                    $valEmail = "is-invalid";
                    $_SESSION["msj"]="danger-Correo electronico en uso";
                } else {
                    header("Location: tablaUsuario.php");
                }
            }
        } else {
            if ($_POST['operation'] === 'edit') {
                $_POST["id"] = $usuario->id;
            }
        }
    }
?>
