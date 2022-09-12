<?php
 require_once '../database/conexion.php';

class cliente
{
	private $pdo;
    
    public $id;
    public $nombre;
    public $email;
    public $sexo;  
    public $area_id;
    public $boletin;
    public $descripcion;
    public $roles;

	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = Database::StartUp();     
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Listar()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare('SELECT a.id,a.nombre, a.email, a.descripcion, 
                                        CASE
                                            WHEN a.sexo = "M" THEN "Masculino"
                                            WHEN a.sexo = "F" THEN "Femenino"
                                            ELSE "Otro"
                                        END des_sexo,
                                        CASE
                                            WHEN a.boletin = 1 THEN "Si"
                                            WHEN a.boletin = 0 THEN "No"
                                        END des_boletin, b.nombre desc_area
                                        FROM empleado a
                                        INNER JOIN areas b on b.id = a.area_id;');
			$stm->execute();

			return json_encode($stm->fetchAll(PDO::FETCH_OBJ));
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function getEmpleadoById($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM empleado WHERE id = ?");
			          

			$stm->execute(array($id));
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($id)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM empleado WHERE id = ?");			          
			$stm->execute(array($id));

			$stm = $this->pdo->prepare("DELETE FROM empleado_rol WHERE empleado_id = '".$id."'");			          
			$stm->execute(array($id));

			$empelado=$this->getEmpleadoById($id);

			if(!$empelado){
				return 1;
			}else{
				return 0;
			}
			
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar($data)
	{
		try 
		{
			$sql = "UPDATE empleado SET 
						nombre          = ?, 
						email        = ?,
                        sexo        = ?,
                        area_id        = ?,
                        boletin        = ?,
						descripcion        = ?
				    WHERE id = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                        $data->Nombre,                        
                        $data->Apellido,
                        $data->Correo,
                        $data->telefono, 
                        $data->id
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar($data)
	{
        $data = (object) $data;
		try 
		{
		$sql = "INSERT INTO empleado (nombre,email,sexo,area_id, boletin,descripcion) 
		        VALUES (?, ?, ?, ?, ?,?)";

		$this->pdo->prepare($sql)
		     ->execute(
				array(
                    $data->nombre, 
                    $data->email,
                    $data->sexo, 
                    $data->area, 
                    $data->boletin, 
                    $data->descripcion,
                )
			);
			$last_id = $this->pdo->lastInsertId();
			foreach ($data->roles as $key => $val){
				$insert_roles = "INSERT INTO empleado_rol (empleado_id,rol_id) 
		        VALUES (".$last_id.", ".$val.")";
				$this->pdo->prepare($insert_roles)->execute();
			}
			return true;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

    public function validate($datos){
        $data=array();
        parse_str($datos, $data);
        
        if(!array_key_exists("boletin", $data)){
            $data['boletin']=0;
        }

        if(empty($data['nombre']) || empty($data['email']) || empty($data['sexo']) || empty($data['area'])  || empty($data['descripcion']) || empty($data['roles'])){
            return false;
        }

        return $this->Registrar($data);
    }
}

$cliente = new cliente();

if (isset($_POST['listar'])) {
    echo $cliente->Listar();
}

if (isset($_POST['data'])) {
    echo $cliente->validate($_POST['data']);
}

if (isset($_POST['userId'])) {
    echo $cliente->Eliminar($_POST['userId']);
}