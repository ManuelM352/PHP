<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        
        form .row > div{
            margin: .5rem 0;
        }
    </style>
</head>
<body style="background-color: lightgreen;">
    
<?php
    session_start();

    if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != 2) {
        header("Location: ../index.html");
        exit(); 
    } 

      require('menuPlan.php');
      require_once('../../datos/daoPlanSemanal.php');
      require_once('planUtil.php');

      $accion = isset($_POST['id']) ? 'edit' : 'add';
    ?>
    <div class="container mt-3">   

    <?php
          if(ISSET($_SESSION["msj"])){
            $mensaje=explode("-",$_SESSION["msj"]);
          ?>
          <div id="mensajes" class="alert alert-<?=$mensaje[0]?>">
              <?=$mensaje[1]?>
          </div>
          <script>
            // Agrega un script para ocultar el mensaje después de 3 segundos
            setTimeout(function(){
                document.getElementById('mensajes').style.display = 'none';
            }, 3000);
        </script>
          <?php
            UNSET($_SESSION["msj"]);
          }
    ?>

    <form action="" class="needs-validation" novalidate id="contenido" method="post" enctype="multipart/form-data">
       <!-- editar -->
        <input type="hidden" name="operation" value="<?php echo isset($_POST['id']) ? 'edit' : 'add'; ?>">
        <input type="hidden" name="iden" value="<?= $planSem->id ?>">
        <input type="hidden" name="userid" value="<?= isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : '' ?>">

        <label value = <?$tanque?>></label>

        <h1 id="titulo">Registrar Plan Semanal</h1>                    
            <div class="row">
                <div class="col-4">
                    <label for="txtLunes" class="form-label">Actividades del Lunes:</label>
                    <input type="text" id="txtLunes" name="Lunes" class="form-control <?=$valLunes?>"
                    placeholder="Lunes" required value="<?= $planSem->lunes ?>">
                    <div class="invalid-feedback">
                        <ul>
                            <li>El campo es obligatorio</li>
                            <li>Entre 3 y 150 caracteres</li>
                        </ul>
                    </div>
                </div>
                <div class="col-4">
                    <label for="txtMartes" class="form-label">Actividades del Martes:</label>
                    <input type="text" id="txtMartes" class="form-control <?=$valMartes?>" 
                    name="Martes" placeholder="Martes" value="<?= $planSem->martes ?>">
                    <div class="invalid-feedback">
                        <ul>
                            <li>El campo es obligatorio</li> 
                            <li>Entre 3 y 150 caracteres</li>   
                        </ul>
                    </div>
                </div>
                <div class="col-4">
                    <label for="txtMiercoles" class="form-label">Actividades del Miercoles:</label>
                    <input type="text" id="txtMiercoles" class="form-control <?=$valMiercoles?>" name="Miercoles" placeholder=Miercoles
                    value="<?= $planSem->miercoles ?>">
                    <div class="invalid-feedback">
                        <ul>
                            <li>El campo es obligatorio</li> 
                            <li>Entre 3 y 150 caracteres</li>
                        </ul>
                    </div>
                </div>

                <div class="col-6">
                    <label for="txtJueves" class="form-label">Actividades del Jueves:</label>
                    <input type="text" id="txtJueves"  name="Jueves" class="form-control <?=$valJueves?>"
                    placeholder="Jueves" required value="<?= $planSem->jueves ?>">
                    <div class="invalid-feedback">
                        <ul>
                            <li>El campo es obligatorio</li>
                            <li>Entre 3 y 150 caracteres</li> 
                        </ul>
                    </div>
                </div>

                <div class="col-6">
                    <label for="txtViernes" class="form-label">Actividades del Viernes:</label>
                    <input type="text" id="txtViernes"  name="Viernes" class="form-control <?=$valViernes?>"
                    placeholder="Viernes" required value="<?= $planSem->viernes ?>">
                    <div class="invalid-feedback">
                        <ul>
                            <li>El campo es obligatorio</li> 
                           <li>Entre 3 y 150 caracteres</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-6">
                    <label for="txtFechaInicio" class="form-label">Fecha de Inicio: </label>
                    <input type="date" id="txtFechaInicio" name="fechaInicio" class="form-control <?=$valFechaInicio?>" placeholder="Fecha de inicio" required >
                    <div id="validationServer01Feedback" class="invalid-feedback">
                        <ul>
                        <li>Fecha de inicio debe ser Lunes de la misma semana</li>
                        </ul>                 
                    </div>
                </div>
        
                <div class="col-6">
                    <label for="txtFechaCier" class="form-label">Fecha de Cierre: </label>
                    <input type="date" id="txtFechaCier" name="fechaFin" class="form-control <?=$valFechaFin?>" placeholder="Fecha de cierre" required >
                    <div id="validationServer01Feedback" class="invalid-feedback">
                        <ul>
                        <li>Fecha de cierre debe ser Viernes de la misma semana</li>
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
                    $planSemId = $_SESSION['usuario'];
                    $materias = $daoMateria->obtenerTodosPorUsuario($planSemId);

                    if ($materias !== null) {
                        foreach ($materias as $materia) {
                            $selected = ($planSem->materia_id == $materia->id) ? 'selected' : '';
                            echo "<option value='".$materia->id."' $selected>".$materia->nombre_materia."</option>";
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

            </div>
            <div class="row justify-content-center">                            
                <button id="btnGuardar" class="btn btn-primary col-4 mx-2">Guardar</button>
                <button type="button" id="btnVolver" class="btn btn-secondary col-4 mx-2">Cancelar</button>
            </div>

        </form>
    </div>
    <script src="../dt/jQuery-3.7.0/jquery-3.7.0.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/planRegistro.js"></script>
</body>
</html>