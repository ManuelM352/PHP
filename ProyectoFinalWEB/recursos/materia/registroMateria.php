<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar materia</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        form .row > div {
            margin: .5rem 0;
        }
    </style>
</head>
<body style="background-color: lightgreen;">
    
<?php
session_start();

if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != 1) {
    header("Location: ../index.html");
    exit(); 
} 

require('menuMateria.php');
require_once('../../datos/daoMateria.php');
require_once('materiaUtil.php');
?>

<div class="container mt-3">  
    <form action="" class="needs-validation" novalidate id="contenido" method="post" enctype="multipart/form-data">
        <!-- editar -->
        <input type="hidden" name="operation" value="<?php echo isset($_POST['id']) ? 'edit' : 'add'; ?>">
        <input type="hidden" name="iden" value="<?= $materia->id ?>">
        <h1 id="titulo">Registrar materia</h1>                    
        <div class="row">
            <div class="col-4">
                <label for="txtNombre" class="form-label">Nombre de la materia:</label>
                <input type="text" id="txtNombre" name="nombre_materia" class="form-control <?=$valNombre_materia?>"
                    placeholder="Nombre" required value="<?= $materia->nombre_materia ?>">
                <div class="invalid-feedback">
                    <ul>
                        <li>El nombre es obligatorio</li>
                        <li>Debe contener solo caracteres alfabéticos</li>
                        <li>Debe tener entre 2 y 50 caracteres</li>
                    </ul>
                </div>
            </div>
            <div class="col-4">
                <label for="txtCodigo" class="form-label">Código de materia:</label>
                <input type="text" id="txtCodigo" class="form-control <?=$valCodigo_de_materia?>" 
                name="codigo_de_materia" placeholder="Código de la materia"
                    value="<?= $materia->codigo_de_materia ?>">
                <div class="invalid-feedback">
                    <ul>
                        <li>El código de materia es obligatorio</li>
                        <li>Debe tener entre 2 y 50 caracteres</li>
                    </ul>
                </div>
            </div>
            <div class="col-4">
                <label for="txtDescripcion" class="form-label">Descripción:</label>
                <input type="text" id="txtDescripcion" class="form-control <?=$valDescripcion?>" 
                name="descripcion" placeholder="Descripción"
                    value="<?= $materia->descripcion ?>">
                <div class="invalid-feedback">
                    <ul>
                        <li>La descripción es obligatoria</li>
                        <li>Debe tener entre 2 y 256 caracteres</li>
                    </ul>
                </div>
            </div>
            <div class="col-4">
                <label for="txtCreditos" class="form-label">Créditos:</label>
                <input type="text" id="txtCreditos" class="form-control <?=$valCreditos?>" name="creditos" placeholder="Créditos"
                    value="<?= $materia->creditos ?>">
                <div class="invalid-feedback">
                    <ul>
                        <li>Los créditos son obligatorios</li>
                        <li>Debe ser un valor numérico</li>
                    </ul>
                </div>
            </div>
            <div class="col-4">
                <label for="txtHorario" class="form-label">Horario:</label>
                <input type="text" id="txtHorario" class="form-control <?=$valHorario?>" name="horario" placeholder="Horario"
                    value="<?= $materia->horario ?>">
                <div class="invalid-feedback">
                    <ul>
                        <li>El horario es obligatorio</li>
                        <li>Debe tener entre 2 y 50 caracteres</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">                            
            <button id="btnGuardar" class="btn btn-primary col-4 mx-2">Guardar</button>
            <button type="button" onclick="window.location.href='tablaMateria.php'" id="btnVolver" class="btn btn-secondary col-4 mx-2">Cancelar</button>
        </div>
    </form>
</div>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/materia.js"></script>
</body>
</html>