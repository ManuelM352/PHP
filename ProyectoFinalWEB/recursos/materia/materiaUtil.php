<?php

$materia = new Materia();

$valNombre_materia = $valCodigo_de_materia = $valDescripcion = $valCreditos = $valHorario = "";

if (count($_POST) == 1 && isset($_POST["id"]) && is_numeric($_POST["id"])) {
    // Obtener la información de la materia con ese id
    $dao = new DAOMateria();
    $materia = $dao->obtenerUno($_POST["id"]);
} elseif (count($_POST) > 1) {
    $valido = true;
    
    // Validación del nombre de la materia
    if (isset($_POST["nombre_materia"]) && 
    (strlen(trim($_POST["nombre_materia"])) > 3 && strlen(trim($_POST["nombre_materia"])) < 51) &&
    preg_match("/^[\p{L} .-]+$/u", $_POST["nombre_materia"])
    ) {
        $valNombre_materia = "is-valid";
    } else {
        $valido = false;
    }
 
    
    // Validación del código de la materia
    if (isset($_POST["codigo_de_materia"]) && 
        (strlen(trim($_POST["codigo_de_materia"])) > 3 && strlen(trim($_POST["codigo_de_materia"])) < 51) &&
        preg_match("/^[a-zA-Z0-9\s]+$/", $_POST["codigo_de_materia"])
    ) {
        $valCodigo_de_materia = "is-valid";
    } else {
        $valCodigo_de_materia = "is-invalid";
        $valido = false;
    }
    
    // Validación de la descripción de la materia
    if (isset($_POST["descripcion"]) && 
        (strlen(trim($_POST["descripcion"])) > 0 && strlen(trim($_POST["descripcion"])) < 256) &&
        preg_match("/^[\p{L} .-]+$/u", $_POST["descripcion"])
    ) {
        $valDescripcion = "is-valid";
    } else {
        $valDescripcion = "is-invalid";
        $valido = false;
    }
    
    // Validación de los créditos de la materia
    if (isset($_POST["creditos"]) && is_numeric($_POST["creditos"])) {
        $valCreditos = "is-valid";
    } else {
        $valCreditos = "is-invalid";
        $valido = false;
    }
    
    // Validación del horario de la materia
    if (isset($_POST["horario"]) && !empty($_POST["horario"])) {
        $valHorario = "is-valid";
    } else {
        $valHorario = "is-invalid";
        $valido = false;
    }

    $materia->id = isset($_POST["iden"]) ? $_POST["iden"] : 0;
    $materia->nombre_materia = isset($_POST["nombre_materia"]) ? trim($_POST["nombre_materia"]) : "";
    $materia->codigo_de_materia = isset($_POST["codigo_de_materia"]) ? trim($_POST["codigo_de_materia"]) : "";
    $materia->descripcion = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";
    $materia->creditos = isset($_POST["creditos"]) ? $_POST["creditos"] : "";
    $materia->horario = isset($_POST["horario"]) ? $_POST["horario"] : "";

    // Editar
    $materia->id = $_POST['iden'];
    
    if ($valido) {
        $dao = new DAOMateria();
        // Verificar operación a realizar
        if ($_POST['operation'] === 'edit') {
            // Editar
            $materia->id = $_POST['iden'];

            if ($dao->editar($materia) == false) {
                echo "Error al editar";
                if ($_POST['operation'] === 'edit') {
                    $_POST["id"] = $materia->id;
                }
            } else {
                header("Location: tablaMateria.php");
                exit();
            }
        } else {
            // Agregar
            if ($dao->agregar($materia) == 0) {
                echo "Error al guardar";
            } else {
                header("Location: tablaMateria.php");
                exit();
            }
        }
    } else {
        if ($_POST['operation'] === 'edit') {
            $_POST["id"] = $materia->id;
        }
    }
}
?>