<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        form .row>div {
            margin: .5rem 0;
        }
    </style>
    <script>
        function toggleMateria() {
            var tipo = document.getElementById("cboTipo").value;
            var materiaContainer = document.getElementById("materia-container");

            if (tipo === "Usuario") {
                materiaContainer.style.display = "block";
            } else {
                materiaContainer.style.display = "none";
            }
        }

        function togglePasswordFields() {
            var operation = document.querySelector('input[name="operation"]').value;
            var passwordFields = document.querySelectorAll('.password-field');

            if (operation === 'edit') {
                passwordFields.forEach(function(field) {
                    field.style.display = 'none';
                });
            } else {
                passwordFields.forEach(function(field) {
                    field.style.display = 'block';
                });
            }
        }

        window.onload = function() {
            toggleMateria();
            togglePasswordFields();
            document.getElementById("cboTipo").addEventListener("change", toggleMateria);
        };
    </script>
</head>

<body style="background-color: lightgreen;">

    <?php
    session_start();

    if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != 1) {
        header("Location: ../index.html");
        exit();
    }

    require('menuUsuario.php');
    require_once('../../datos/daoUsuario.php');
    require_once('usuarioUtil.php');

    $accion = isset($_POST['id']) ? 'edit' : 'add';
    ?>

    <div class="container mt-3">
        <?php
        if (isset($_SESSION["msj"])) {
            $mensaje = explode("-", $_SESSION["msj"]);
        ?>
            <div id="mensajes" class="alert alert-<?= $mensaje[0] ?>">
                <?= $mensaje[1] ?>
            </div>
            <script>
                // Agrega un script para ocultar el mensaje después de 3 segundos
                setTimeout(function() {
                    document.getElementById('mensajes').style.display = 'none';
                }, 3000);
            </script>
        <?php
            unset($_SESSION["msj"]);
        }
        ?>
        <form action="" class="needs-validation" novalidate id="contenido" method="post" enctype="multipart/form-data">
            <input type="hidden" name="operation" value="<?php echo isset($_POST['id']) ? 'edit' : 'add'; ?>">
            <input type="hidden" name="iden" value="<?= $usuario->id ?>">

            <h1 id="titulo">Registrar usuarios</h1>
            <div class="row">
                <div class="col-4">
                    <label for="txtNombre" class="form-label">Nombre:</label>
                    <input type="text" id="txtNombre" name="Nombre" class="form-control <?= $valNombre ?>" placeholder="Nombre" required value="<?= $usuario->nombre ?>">
                    <div class="invalid-feedback">
                        <ul>
                            <li>El nombre es obligatorio</li>
                            <li>Debe contener solo caracteres alfabéticos</li>
                            <li>Debe tener entre 4 y 50</li>
                        </ul>
                    </div>
                </div>
                <div class="col-4">
                    <label for="txtApellido1" class="form-label">Primer apellido:</label>
                    <input type="text" id="txtApellido1" class="form-control <?= $valApe1 ?>" name="Apellido1" placeholder="Primer apellido" value="<?= $usuario->apellido1 ?>">
                    <div class="invalid-feedback">
                        <ul>
                            <li>El primer apellido es obligatorio</li>
                            <li>Debe contener solo caracteres alfabéticos</li>
                            <li>Debe tener entre 4 y 50</li>
                        </ul>
                    </div>
                </div>
                <div class="col-4">
                    <label for="txtApellido2" class="form-label">Segundo apellido:</label>
                    <input type="text" id="txtApellido2" class="form-control <?= $valApe2 ?>" name="Apellido2" placeholder="Segundo apellido" value="<?= $usuario->apellido2 ?>">
                    <div class="invalid-feedback">
                        <ul>
                            <li>Debe contener solo caracteres alfabéticos</li>
                            <li>Debe tener entre 4 y 50</li>
                        </ul>
                    </div>
                </div>
                <div class="col-6">
                    <label for="txtEmail" class="form-label">Correo:</label>
                    <input type="email" id="txtEmail" name="Email" class="form-control <?= $valEmail ?>" placeholder="Correo electrónico" required value="<?= $usuario->email ?>">
                    <div class="invalid-feedback">
                        <ul>
                            <li>El correo electrónico es obligatorio</li>
                            <li>El correo electrónico debe ser único</li>
                            <li>Debe tener un formato válido</li>
                        </ul>
                    </div>
                </div>

                <div id="materia-container" class="form-group col-6">
                    <label for="cbMateria" class="form-label">Materia:</label>
                    <select class="form-control <?= $valMateria ?>" name="materia_id" id="cbMateria">
                        <option value="">-- Seleccionar --</option>
                        <?php
                        require_once('../../datos/daoMateria.php');
                        $daoMateria = new DAOMateria();
                        if ($accion == 'add') {
                            $materias = $daoMateria->obtenerTodosDisponibles();
                        } else {
                            $usuarioId = $_POST['id'];
                            // Llama a las dos funciones para obtener las materias disponibles y las materias del usuario
                            $materiasDisponibles = $daoMateria->obtenerTodosDisponibles();
                            $materiasDelUsuario = $daoMateria->obtenerTodosEditar($usuarioId);

                            // Combina los resultados en una sola variable
                            $materias = array_merge($materiasDisponibles, $materiasDelUsuario);
                        }

                        if ($materias !== null) {
                            foreach ($materias as $materia) {
                                $selected = ($usuario->materia_id == $materia->id) ? 'selected' : '';
                                echo "<option value='" . $materia->id . "' $selected>" . $materia->nombre_materia . "</option>";
                            }
                        } else {
                            echo "<option value='' disabled>No se encontraron materias</option>";
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">
                        Debe seleccionar una materia
                    </div>
                </div>
                <div class="form-group col-6">
                    <label for="cboTipo" class="form-label">Tipo:</label>
                    <select class="form-control <?= $valTipo ?>" name="Tipo" id="cboTipo">
                        <option value="0">-- Seleccionar --</option>
                        <option value="Administrador" <?= ($usuario->tipo == "Administrador") ? "selected" : ""; ?>>Administrador</option>
                        <option value="Usuario" <?= ($usuario->tipo == "Usuario") ? "selected" : ""; ?>>Usuario</option>
                    </select>
                    <div class="invalid-feedback">
                        Debe de seleccionar un tipo de usuario
                    </div>
                </div>

                <div class="col-6 password-field">
                    <label for="txtContrasenia" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control <?= $valPassword ?>" id="Password" name="Password" placeholder="Contraseña" required>
                    <div class="invalid-feedback">
                        <ul>
                            <li>La contraseña es requerida</li>
                            <li>Debe tener entre 6 y 15 caracteres</li>
                        </ul>
                    </div>
                </div>
                <div class="col-6 password-field">
                    <label for="txtContrasenia2" class="form-label">Confirmar contraseña:</label>
                    <input type="password" class="form-control <?= $valPassword2 ?>" id="Password2" name="Password2" placeholder="Repetir Contraseña" required>
                    <div class="invalid-feedback">
                        <ul>
                            <li>Este campo es obligatorio</li>
                            <li>Las contraseñas no coinciden</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <button id="btnGuardar" class="btn btn-primary col-4 mx-2">Guardar</button>
                <button type="button" id="btnVolver" class="btn btn-secondary col-4 mx-2">Cancelar</button>
            </div>
        </form>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/usuario.js"></script>
</body>

</html>