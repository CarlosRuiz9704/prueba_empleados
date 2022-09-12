<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/js/gestionarEmpleados.js"></script>
</head>

<body>
    <div class="container mt-3">       
        <h1 class="title_page">Lista de empleados</h1> 
        <a class="btn btn-primary" style="float:right" href="view/registrar_empleado.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Crear</a>
        <table class="table" id="list-empleados">
            <thead>
                <tr>
                    <th><i class="fa fa-user" aria-hidden="true"></i> Nombre</th>
                    <th><i class="fa fa-at" aria-hidden="true"></i> Email</th>
                    <th><i class="fa fa-intersex"></i> Sexo</th>
                    <th><i class="fa fa-briefcase" aria-hidden="true"></i> Area</th>
                    <th><i class="fa fa-envelope" aria-hidden="true"></i> Boletin</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
        </table>
    </div>
</body>
</html>