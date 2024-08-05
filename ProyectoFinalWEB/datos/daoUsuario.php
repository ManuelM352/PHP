<?php
//importa la clase conexión y el modelo para usarlos
require_once 'conexion.php';
require_once __DIR__ . '/../modelos/usuario.php';


class DAOUsuario
{

    private $conexion;

    /**
     * Permite obtener la conexión a la BD
     */
    private function conectar()
    {
        try {
            $this->conexion = Conexion::conectar();
        } catch (Exception $e) {
            die($e->getMessage()); /*Si la conexion no se establece se cortara el flujo enviando un mensaje con el error*/
        }
    }

    /**
     * Metodo que obtiene todos los usuarios de la base de datos y los
     * retorna como una lista de objetos  
     */
    public function obtenerTodos()
    {
        try {
            $this->conectar();
            $lista = array();
            $sentenciaSQL = $this->conexion->prepare("
                SELECT u.id, u.nombre, u.apellido1, u.apellido2, u.email, m.nombre_materia AS materia, u.tipo
                FROM usuarios u
                LEFT JOIN materia m ON u.materia_id = m.id
            ");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            foreach ($resultado as $fila) {
                $obj = new Usuario();
                $obj->id = $fila->id;
                $obj->nombre = $fila->nombre;
                $obj->apellido1 = $fila->apellido1;
                $obj->apellido2 = $fila->apellido2;
                $obj->email = $fila->email;
                $obj->materia_id = $fila->materia;
                $obj->tipo = $fila->tipo;
                $lista[] = $obj;
            }
            return $lista;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }


    /**
     * Metodo que obtiene un registro de la base de datos, retorna un objeto  
     */
    public function obtenerUno($id)
    {
        try {
            $this->conectar();

            //Almacenará el registro obtenido de la BD
            $obj = null;

            $sentenciaSQL = $this->conexion->prepare("SELECT id,nombre,apellido1,apellido2,email,materia_id,tipo,password FROM usuarios WHERE id=?");
            //Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([$id]);

            /*Obtiene los datos*/
            $fila = $sentenciaSQL->fetch(PDO::FETCH_OBJ);

            $obj = new Usuario();

            $obj->id = $fila->id;
            $obj->nombre = $fila->nombre;
            $obj->apellido1 = $fila->apellido1;
            $obj->apellido2 = $fila->apellido2;
            $obj->email = $fila->email;
            $obj->tipo = $fila->tipo;
            $obj->materia_id = $fila->materia_id;
            $obj->password = $fila->password;
            return $obj;
        } catch (Exception $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function autenticar($correo, $password)
    {
        try {

            $this->conectar();

            //Almacenará el registro obtenido de la BD
            $obj = null;

            $sentenciaSQL = $this->conexion->prepare("SELECT id,nombre,apellido1,apellido2,tipo FROM usuarios WHERE email=? AND password=sha2(?,224)");
            //Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute(array($correo, $password));

            /*Obtiene los datos*/
            $fila = $sentenciaSQL->fetch(PDO::FETCH_OBJ);
            if ($fila) {
                $obj = new Usuario();

                $obj->id = $fila->id;
                $obj->nombre = $fila->nombre;
                $obj->apellido1 = $fila->apellido1;
                $obj->apellido2 = $fila->apellido2;
                $obj->tipo = $fila->tipo;

                return $obj;
            }
            return null;
        } catch (Exception $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    /**
     * Elimina el usuario con el id indicado como parámetro
     */
    public function eliminar($id)
    {
        try {
            $this->conectar();

            // Verificar si el usuario a eliminar es el administrador
            $usuario = $this->obtenerUno($id);
            if ($usuario->email == 'admin@admin.com') {
                // No se puede eliminar al usuario administrador
                return false;
            }

            // Si no es el usuario administrador, proceder con la eliminación
            $sentenciaSQL = $this->conexion->prepare("DELETE FROM usuarios WHERE id = ?");
            $resultado = $sentenciaSQL->execute(array($id));
            return $resultado;
        } catch (PDOException $e) {
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

    /**
     * Función para editar al empleado de acuerdo al objeto recibido como parámetro
     */
    public function editar(Usuario $obj)
    {
        try {
            $sql = "UPDATE usuarios
                        SET
                        nombre = ?,
                        apellido1 = ?,
                        apellido2 = ?,
                        email = ?,  
                        materia_id = ?,                 
                        tipo = ?                  
                        WHERE id = ?";

            $this->conectar();

            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute(
                array(
                    $obj->nombre,
                    $obj->apellido1,
                    $obj->apellido2,
                    $obj->email,
                    $obj->materia_id,
                    $obj->tipo,
                    $obj->id
                )
            );
            return true;
        } catch (PDOException $e) {
            //Si quieres acceder expecíficamente al numero de error
            //se puede consultar la propiedad errorInfo
            return false;
        } finally {
            Conexion::desconectar();
        }
    }




    /**
     * Agrega un nuevo usuario de acuerdo al objeto recibido como parámetro
     */
    public function agregar(Usuario $obj)
    {
        $clave = 0;
        try {
            $sql = "INSERT INTO usuarios (nombre, apellido1, apellido2, email, materia_id, tipo, password) 
            VALUES (:nombre, :apellido1, :apellido2, :email, :materia_id, :tipo, SHA2(:password, 224))";

            $this->conectar();
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $obj->nombre);
            $stmt->bindParam(':apellido1', $obj->apellido1);
            $stmt->bindParam(':apellido2', $obj->apellido2);
            $stmt->bindParam(':email', $obj->email);
            $stmt->bindParam(':materia_id', $obj->materia_id);
            $stmt->bindParam(':tipo', $obj->tipo);
            $stmt->bindParam(':password', $obj->password);
            $stmt->execute();

            // Obtener el último ID insertado con autoincremento
            $clave = $this->conexion->lastInsertId();
            return $clave;
        } catch (Exception $e) {
            return $clave;
        } finally {
            Conexion::desconectar();
        }
    }
}
