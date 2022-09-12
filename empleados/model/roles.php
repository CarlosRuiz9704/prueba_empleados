<?php
 require_once '../database/conexion.php';

class roles
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

	public function Listar()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare('SELECT * FROM roles');
			$stm->execute();

			return json_encode($stm->fetchAll(PDO::FETCH_OBJ));
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

}

$roles = new roles();

if (isset($_POST['listar'])) {
    echo $roles->Listar();
}