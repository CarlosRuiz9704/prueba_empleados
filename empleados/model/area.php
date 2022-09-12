<?php
 require_once '../database/conexion.php';

class area
{
	private $pdo;

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

	public function ListarArea()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare('SELECT * FROM areas');
			$stm->execute();

			return json_encode($stm->fetchAll(PDO::FETCH_OBJ));
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

}

$roles = new area();

if (isset($_POST['listarArea'])) {
    echo $roles->ListarArea();
}