<?php
//importa la clase conexión y el modelo para usarlos
require_once 'conexion.php'; 
require_once __DIR__ . '/../modelos/planSemanal.php';


class DAOPlanSemanal
{
    
	private $conexion; 
    
    /**
     * Permite obtener la conexión a la BD
     */
    private function conectar(){
        try{
			$this->conexion = Conexion::conectar(); 
		}
		catch(Exception $e)
		{
			die($e->getMessage()); /*Si la conexion no se establece se cortara el flujo enviando un mensaje con el error*/
		}
    }
    
   /**
    * Metodo que obtiene todos los usuarios de la base de datos y los
    * retorna como una lista de objetos  
    */
    public function obtenerTodos($id)
    {
        try
        {
            $this->conectar();
            $lista = array();
            $sentenciaSQL = $this->conexion->prepare("
            SELECT ps.id, ps.lunes, ps.martes, ps.miercoles, ps.jueves, ps.viernes, ps.fechaInicio, ps.fechaFin,
             ps.materia_id, m.nombre_materia AS nombre_materia FROM plansemanal ps 
             LEFT JOIN materia m ON ps.materia_id = m.id LEFT JOIN usuarios u ON u.materia_id = m.id WHERE u.id = :id");
            $sentenciaSQL->bindParam(':id', $id, PDO::PARAM_INT);
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            foreach ($resultado as $fila)
            {
                $obj = new PlanSemanal();
                $obj->id = $fila->id;
                $obj->lunes = $fila->lunes;
                $obj->martes = $fila->martes;
                $obj->miercoles = $fila->miercoles;
                $obj->jueves = $fila->jueves;
                $obj->viernes = $fila->viernes;
                $obj->fechaInicio = $fila->fechaInicio;
                $obj->fechaFin = $fila->fechaFin;
                $obj->materia_id = $fila->materia_id;
                $obj->nombre_materia = $fila->nombre_materia; // Nuevo campo para el nombre de la materia
                $lista[] = $obj;
            }
            return $lista;
        }
        catch(PDOException $e){
            return null;
        }
        finally{
            Conexion::desconectar();
        }
    }
    



    
    
	/**
     * Metodo que obtiene un registro de la base de datos, retorna un objeto  
     */
    public function obtenerUno($id)
	{
		try
		{ 
            $this->conectar();
            
            //Almacenará el registro obtenido de la BD
			$obj = null; 
            
			$sentenciaSQL = $this->conexion->prepare("SELECT id,lunes,martes,miercoles,jueves,viernes,fechaInicio,fechaFin,materia_id FROM plansemanal WHERE id=?"); 
			//Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([$id]);
            
            /*Obtiene los datos*/
			$fila=$sentenciaSQL->fetch(PDO::FETCH_OBJ);

            if($fila){
                $obj = new PlanSemanal();
                
                $obj->id = $fila->id;
	            $obj->lunes = $fila->lunes;
                $obj->martes = $fila->martes;
	            $obj->miercoles = $fila->miercoles;
                $obj->jueves = $fila->jueves;
	            $obj->viernes = $fila->viernes;
                $obj->fechaInicio = DateTime::createFromFormat('Y-m-d',$fila->fechaInicio);
                $obj->fechaFin = DateTime::createFromFormat('Y-m-d',$fila->fechaFin);
                $obj->materia_id = $fila->materia_id;
                return $obj;
            }
            return null;         
		}
		catch(Exception $e){
            return null;
		}finally{
            Conexion::desconectar();
        }
	}

    public function obtenerUnoExistente($fechaInicio, $materia_id)
	{
		try
		{ 
            $this->conectar();
            
            //Almacenará el registro obtenido de la BD
			$obj = null; 
            
			$sentenciaSQL = $this->conexion->prepare("SELECT id,lunes,martes,miercoles,jueves,viernes,fechaInicio,fechaFin,materia_id FROM plansemanal WHERE fechaInicio=? AND materia_id=?"); 
			//Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([$fechaInicio,$materia_id]);
            
            /*Obtiene los datos*/
			$fila=$sentenciaSQL->fetch(PDO::FETCH_OBJ);

            if($fila){
                $obj = new PlanSemanal();
                
                $obj->id = $fila->id;
	            $obj->lunes = $fila->lunes;
                $obj->martes = $fila->martes;
	            $obj->miercoles = $fila->miercoles;
                $obj->jueves = $fila->jueves;
	            $obj->viernes = $fila->viernes;
                $obj->fechaInicio = DateTime::createFromFormat('Y-m-d',$fila->fechaInicio);
                $obj->fechaFin = DateTime::createFromFormat('Y-m-d',$fila->fechaFin);
                $obj->materia_id = $fila->materia_id;
                return $obj;
            }
            return null;         
		}
		catch(Exception $e){
            return null;
		}finally{
            Conexion::desconectar();
        }
	}

    
    public function eliminar($id)
    {
        try 
        {
            $this->conectar();
            
            $materia = $this->obtenerUno($id);
            $sentenciaSQL = $this->conexion->prepare("DELETE FROM plansemanal WHERE id = ?");                      
            $resultado = $sentenciaSQL->execute(array($id));
            return $resultado;
        } catch (PDOException $e) 
        {
            return false;    
        } finally {
            Conexion::desconectar();
        }
    }

	/**
     * Función para editar al empleado de acuerdo al objeto recibido como parámetro
     */
	public function editar(PlanSemanal $obj)
	{
		try 
        {
        
                $sql = "UPDATE plansemanal
                        SET
                        lunes = ?,
                        martes = ?,
                        miercoles = ?,
                        jueves = ?,                   
                        viernes = ?,
                        fechaInicio = ?, 
                        fechaFin = ?,
                        materia_id = ?  
                        WHERE id = ?";
                
                $this->conectar();
                
                $sentenciaSQL = $this->conexion->prepare($sql);
                $sentenciaSQL->execute(
                    array(
                        $obj->lunes,
                        $obj->martes,
                        $obj->miercoles,              
                        $obj->jueves,                      
                        $obj->viernes,
                        $obj->fechaInicio->format('Y-m-d'),
                        $obj->fechaFin->format('Y-m-d'),
                        $obj->materia_id,
                        $obj->id
                    )
                );
                return true;
    
		} catch (PDOException $e){
			//Si quieres acceder expecíficamente al numero de error
			//se puede consultar la propiedad errorInfo
			return false;
		}finally{
            Conexion::desconectar();
        }
	}

	

	
	/**
     * Agrega uns nueva materia de acuerdo al objeto recibido como parámetro
     */
    public function agregar(PlanSemanal $obj)
	{
        $clave=0;
		try 
		{
            $sql = "INSERT INTO 
            planSemanal
                (lunes,
                martes,
                miercoles,
                jueves,
                viernes,
                fechaInicio,
                fechaFin,
                materia_id)
                VALUES
                (:lunes,                
                :martes,
                :miercoles,
                :jueves,                
                :viernes,
                :fechaInicio,
                :fechaFin,
                :materia_id);";
                
            $this->conectar();
            $this->conexion->prepare($sql)
                 ->execute(array(
                    ':lunes'=>$obj->lunes,
                    ':martes'=>$obj->martes,
                    ':miercoles'=>$obj->miercoles,
                    ':jueves'=>$obj->jueves,
                    ':viernes'=>$obj->viernes,
                 ':fechaInicio'=>$obj->fechaInicio->format('Y-m-d'),
                 ':fechaFin'=>$obj->fechaFin->format('Y-m-d'),
                 ':materia_id'=>$obj->materia_id,
                 ));
                 
            //SABER EL ULTIMO ID INSERTADO CON AUTOINCREMENT
            $clave=$this->conexion->lastInsertId();
            return $clave;
		} catch (Exception $e){
			return $clave;
		}finally{
            
            /*En caso de que se necesite manejar transacciones, 
			no deberá desconectarse mientras la transacción deba 
			persistir*/
            
            Conexion::desconectar();
        }
	}
}