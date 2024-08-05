<?php
//importa la clase conexión y el modelo para usarlos
require_once 'conexion.php'; 
require_once __DIR__ . '/../modelos/materia.php';


class DAOMateria
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
	public function obtenerTodos()
	{
		try
		{
            $this->conectar();      
   
			$lista = array();
            /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
			$sentenciaSQL = $this->conexion->prepare("SELECT id,nombre_materia,codigo_de_materia,descripcion,creditos,horario FROM Materia");
			
            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
			$sentenciaSQL->execute();

            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);

			foreach($resultado as $fila)
			{
				$obj = new Materia();
                $obj->id = $fila->id;
	            $obj->nombre_materia = $fila->nombre_materia;
                $obj->codigo_de_materia = $fila->codigo_de_materia;
	            $obj->descripcion = $fila->descripcion;
                $obj->creditos = $fila->creditos;
	            $obj->horario = $fila->horario;
                $lista[] = $obj;
			}
            
			return $lista;
		}
		catch(PDOException $e){
			return null;
		}finally{
            Conexion::desconectar();
        }
	}

    public function obtenerTodosUnique($id)
    {
        try
        {
            $this->conectar();
            $lista = array();
            $sentenciaSQL = $this->conexion->prepare("
                SELECT m.id, m.nombre_materia, m.codigo_de_materia, m.descripcion, m.creditos, m.horario
                FROM Materia m
                INNER JOIN usuarios u ON m.id = u.materia_id
                WHERE u.id = :usuario_id
            ");
            $sentenciaSQL->bindParam(':usuario_id', $id, PDO::PARAM_INT);
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            foreach ($resultado as $fila)
            {
                $obj = new Materia();
                $obj->id = $fila->id;
                $obj->nombre_materia = $fila->nombre_materia;
                $obj->codigo_de_materia = $fila->codigo_de_materia;
                $obj->descripcion = $fila->descripcion;
                $obj->creditos = $fila->creditos;
                $obj->horario = $fila->horario;
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
    


public function obtenerTodosPorUsuario($id)
{
    try
    {
        $this->conectar();
        $lista = array();
        $sentenciaSQL = $this->conexion->prepare("
            SELECT m.id, m.nombre_materia, m.codigo_de_materia, m.descripcion, m.creditos, m.horario
            FROM materia m
            INNER JOIN usuarios u ON m.id = u.materia_id
            WHERE u.id = ?
        ");
        $sentenciaSQL->execute([$id]);
        $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
        foreach ($resultado as $fila)
        {
            $obj = new Materia();
            $obj->id = $fila->id;
            $obj->nombre_materia = $fila->nombre_materia;
            $obj->codigo_de_materia = $fila->codigo_de_materia;
            $obj->descripcion = $fila->descripcion;
            $obj->creditos = $fila->creditos;
            $obj->horario = $fila->horario;
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

public function obtenerTodosDisponibles()
{
    try
    {
        $this->conectar();
        $lista = array();
        $sentenciaSQL = $this->conexion->prepare("
            SELECT id, nombre_materia, codigo_de_materia, descripcion, creditos, horario
            FROM Materia
            WHERE id NOT IN (SELECT DISTINCT materia_id FROM usuarios WHERE materia_id IS NOT NULL)
        ");
        $sentenciaSQL->execute();
        $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
        foreach ($resultado as $fila)
        {
            $obj = new Materia();
            $obj->id = $fila->id;
            $obj->nombre_materia = $fila->nombre_materia;
            $obj->codigo_de_materia = $fila->codigo_de_materia;
            $obj->descripcion = $fila->descripcion;
            $obj->creditos = $fila->creditos;
            $obj->horario = $fila->horario;
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

public function obtenerTodosEditar($id)
{
    try
    {
        $this->conectar();
        $lista = array();
        $sentenciaSQL = $this->conexion->prepare("
            SELECT m.id, m.nombre_materia, m.codigo_de_materia, m.descripcion, m.creditos, m.horario
            FROM Materia m
            INNER JOIN usuarios u ON m.id = u.materia_id
            WHERE u.id = :usuario_id
        ");
        $sentenciaSQL->bindParam(':usuario_id', $id, PDO::PARAM_INT);
        $sentenciaSQL->execute();
        $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
        foreach ($resultado as $fila)
        {
            $obj = new Materia();
            $obj->id = $fila->id;
            $obj->nombre_materia = $fila->nombre_materia;
            $obj->codigo_de_materia = $fila->codigo_de_materia;
            $obj->descripcion = $fila->descripcion;
            $obj->creditos = $fila->creditos;
            $obj->horario = $fila->horario;
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
            
			$sentenciaSQL = $this->conexion->prepare("SELECT id,nombre_materia,codigo_de_materia,descripcion,creditos,horario FROM Materia WHERE id=?"); 
			//Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([$id]);
            
            /*Obtiene los datos*/
			$fila=$sentenciaSQL->fetch(PDO::FETCH_OBJ);

            if($fila){
                $obj = new Materia();
                
                $obj->id = $fila->id;
                $obj->nombre_materia = $fila->nombre_materia;
                $obj->codigo_de_materia = $fila->codigo_de_materia;
                $obj->descripcion = $fila->descripcion;
                $obj->creditos = $fila->creditos;
                $obj->horario = $fila->horario;
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
            $sentenciaSQL = $this->conexion->prepare("DELETE FROM materia WHERE id = ?");                      
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
	public function editar(Materia $obj)
	{
		try 
        {
        
                $sql = "UPDATE materia
                        SET
                        nombre_materia = ?,
                        codigo_de_materia = ?,
                        descripcion = ?,
                        creditos = ?,                   
                        horario = ? 
                        WHERE id = ?";
                
                $this->conectar();
                
                $sentenciaSQL = $this->conexion->prepare($sql);
                $sentenciaSQL->execute(
                    array(
                        $obj->nombre_materia,
                        $obj->codigo_de_materia,
                        $obj->descripcion,              
                        $obj->creditos,                      
                        $obj->horario,
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
    public function agregar(Materia $obj)
	{
        $clave=0;
		try 
		{
            $sql = "INSERT INTO 
            materia
                (nombre_materia,
                codigo_de_materia,
                descripcion,
                creditos,
                horario)
                VALUES
                (:nombre_materia,                
                :codigo_de_materia,
                :descripcion,
                :creditos,                
                :horario);";
                
            $this->conectar();
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre_materia', $obj->nombre_materia);            
            $stmt->bindParam(':codigo_de_materia', $obj->codigo_de_materia);
            $stmt->bindParam(':descripcion', $obj->descripcion);
            $stmt->bindParam(':creditos', $obj->creditos);
            $stmt->bindParam(':horario', $obj->horario);      
            $stmt->execute();
                 
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