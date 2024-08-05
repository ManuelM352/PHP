<?php
    $planSem = new PlanSemanal();

    function validateDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function es_lunes($fecha) {
        return (date('N', strtotime($fecha)) == 1); // 1 para Lunes
    }
    
    function es_viernes($fecha) {
        return (date('N', strtotime($fecha)) == 5); // 5 para Viernes
    }

    function misma_semana($fechaInicio, $fechaCierre) {
        return (date('W', strtotime($fechaInicio)) == date('W', strtotime($fechaCierre)));
    }

    $valLunes = $valMartes = $valMiercoles = $valJueves = $valViernes = $valFechaInicio = $valFechaFin =  $valMateria = "";

    if (count($_POST) == 1 && isset($_POST["id"]) && is_numeric($_POST["id"])) {
        $dao = new DAOPlanSemanal();
        $planSem = $dao->obtenerUno($_POST["id"]);
    } elseif (count($_POST) > 1) {
        $dao = new DAOPlanSemanal();
        $valLunes = $valMartes = $valMiercoles = $valJueves = $valViernes = $valFechaInicio = $valFechaFin = $valMateria = "is-invalid";
        $valido = true;

        if (isset($_POST["Lunes"]) && (strlen(trim($_POST["Lunes"])) > 3 && strlen(trim($_POST["Lunes"])) < 151)) {
            $valLunes = "is-valid";
        } else {
            $valido = false;
        }

        if (isset($_POST["Martes"]) && (strlen(trim($_POST["Martes"])) > 3 && strlen(trim($_POST["Martes"])) < 151)) {
            $valMartes = "is-valid";
        } else {
            $valido = false;
        }

        if (isset($_POST["Miercoles"]) && (strlen(trim($_POST["Miercoles"])) > 3 && strlen(trim($_POST["Miercoles"])) < 151)) {
            $valMiercoles = "is-valid";
        } else {
            $valido = false;
        }

        if (isset($_POST["Jueves"]) && (strlen(trim($_POST["Jueves"])) > 3 && strlen(trim($_POST["Jueves"])) < 151)) {
            $valJueves = "is-valid";
        } else {
            $valido = false;
        }

        if (isset($_POST["Viernes"]) && (strlen(trim($_POST["Viernes"])) > 3 && strlen(trim($_POST["Viernes"])) < 151)) {
            $valViernes = "is-valid";
        } else {
            $valido = false;
        }

        if(ISSET($_POST["fechaInicio"]) && validateDate($_POST["fechaInicio"]) && es_lunes($_POST["fechaInicio"]) && misma_semana($_POST["fechaInicio"],$_POST["fechaFin"])){
            $fInicio=DateTime::createFromFormat('Y-m-d', $_POST["fechaInicio"]);
            $h = new DateTime();
            $dif = $h->diff($fInicio)->y;
            $valFechaInicio="is-valid";
        }else{
            $valido=false;
        }

        if(ISSET($_POST["fechaFin"]) && validateDate($_POST["fechaFin"]) && es_viernes($_POST["fechaFin"]) && misma_semana($_POST["fechaInicio"],$_POST["fechaFin"])){
            $fLimite=DateTime::createFromFormat('Y-m-d', $_POST["fechaFin"]);
            $h = new DateTime();
            $dif = $h->diff($fLimite)->y;
            $valFechaFin="is-valid";
        }else{
            $valido=false;
        }

        

        if (isset($_POST["materia_id"]) && $_POST["materia_id"] !== '') {
            $valMateria = "is-valid";
        } else {
            $valMateria = "is-invalid";
            $valido = false;
        }

        $planSem->id = isset($_POST["Id"]) ? trim($_POST["Id"]) : 0;
        $planSem->lunes = isset($_POST["Lunes"]) ? trim($_POST["Lunes"]) : "";
        $planSem->martes = isset($_POST["Martes"]) ? trim($_POST["Martes"]) : "";
        $planSem->miercoles = isset($_POST["Miercoles"]) ? trim($_POST["Miercoles"]) : "";
        $planSem->jueves = isset($_POST["Jueves"]) ? $_POST["Jueves"] : "";
        $planSem->viernes = isset($_POST["Viernes"]) ? $_POST["Viernes"] : "";
        $planSem->materia_id = isset($_POST["materia_id"]) && $_POST["materia_id"] !== '' ? $_POST["materia_id"] : null;
        $planSem->fechaInicio=ISSET($_POST["fechaInicio"])?DateTime::createFromFormat('Y-m-d', $_POST["fechaInicio"]):new DateTime();
        $planSem->fechaFin=ISSET($_POST["fechaFin"])?DateTime::createFromFormat('Y-m-d', $_POST["fechaFin"]):new DateTime();

        $planSem->fechaInicio=ISSET($_POST["fechaInicio"])?DateTime::createFromFormat('Y-m-d', $_POST["fechaInicio"]):new DateTime();
        $planSem->fechaFin=ISSET($_POST["fechaFin"])?DateTime::createFromFormat('Y-m-d', $_POST["fechaFin"]):new DateTime();

        $planSem->id = $_POST['iden'];

        if ($valido) {
            $dao = new DAOPlanSemanal();
            if ($_POST['operation'] === 'edit') {
                $planSem->id = $_POST['iden'];
                if ($dao->editar($planSem) == false) {
                    $valFechaInicio = "is-invalid";
                    $valFechaFin = "is-invalid";
                    $_SESSION["msj"]="danger-Semana ya registrada";
                    //echo "Error al guardar";
                    if ($_POST['operation'] === 'edit') {
                        $_POST["id"] = $planSem->id;
                    }
                } else {
                    header("Location: tablaPlan.php");
                }
            } else {
                if($dao->obtenerUnoExistente($_POST["fechaInicio"],$_POST["materia_id"]) != null){
                    $_SESSION["msj"]="danger-Semana ya registrada para esta materia.";
                }else{
                    if ($dao->agregar($planSem) == 0) {
                        //var_dump($_POST);
                        $valFechaInicio = "is-invalid";
                        $valFechaFin = "is-invalid";
                        $_SESSION["msj"]="danger-Semana ya registrada";
                        //echo "Error al guardar";
                    } else {
                        header("Location: tablaPlan.php");
                    }
                }
            }
        } else {
            if ($_POST['operation'] === 'edit') {
                $_POST["id"] = $planSem->id;
            }
        }
    }
?>
