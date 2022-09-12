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

	public function getEmpleadoById($id,$flag)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM empleado WHERE id = ?");
			          

			$stm->execute(array($id));
			if($flag==1){
				return $stm->fetch(PDO::FETCH_OBJ);
			}else{
				return json_encode($stm->fetch(PDO::FETCH_OBJ), JSON_INVALID_UTF8_SUBSTITUTE);
			}
			
			
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

			$empelado=$this->getEmpleadoById($id,1);

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
		$data = (object) $data;
		$ok=true;
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
						$data->nombre, 
						$data->email,
						$data->sexo, 
						$data->area, 
						$data->boletin, 
						$data->descripcion,
						$data->id_user,
					)
				);
				$delete = "DELETE FROM empleado_rol WHERE empleado_id = '".$data->id_user."'";
				$this->pdo->prepare($delete)->execute();

				foreach ($data->roles as $key => $val){
					$insert_roles = "INSERT INTO empleado_rol (empleado_id,rol_id) 
					VALUES (".$data->id_user.", ".$val.")";
					$this->pdo->prepare($insert_roles)->execute();
				}

				return 1;
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

    public function validate($datos,$flag){
        $data=array();
        parse_str($datos, $data);
        if(!array_key_exists("boletin", $data)){
            $data['boletin']=0;
        }

        if(empty($data['nombre']) || empty($data['email']) || empty($data['sexo']) || empty($data['area'])  || empty($data['descripcion']) || empty($data['roles'])){
            return false;
        }

		if($flag == 1){
			return $this->Registrar($data);
		}else{
			return $this->Actualizar($data);
		}
        
    }
}

$cliente = new cliente();

if (isset($_POST['listar'])) {
    echo $cliente->Listar();
}

if (isset($_POST['data'])) {
    echo $cliente->validate($_POST['data'],1);
}

if (isset($_POST['userId'])) {
    echo $cliente->Eliminar($_POST['userId']);
}

if (isset($_POST['userIdEdit'])) {
    echo($cliente->getEmpleadoById($_POST['userIdEdit'],2)); 
}

if (isset($_POST['dataUpdate'])) {
    echo ($cliente->validate($_POST['dataUpdate'],2)); 
}