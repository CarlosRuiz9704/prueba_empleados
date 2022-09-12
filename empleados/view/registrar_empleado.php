

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
    <script src="../assets/js/registrarEmpleados.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Registrar Empleado</h2>
        <div class="alert alert-info">
             Los campos con asteriscos (*) son obligatorios.
        </div>
        <form id="registrar_empleados">
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Nombre completo *</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nombre" name="nombre">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Correo Electronico *</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="correo" name="email">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Sexo *</label>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sexo" value="M" id="masculino"
                            checked>
                        <label class="form-check-label" for="masculino">
                            Masculino
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sexo" value="F" id="femenino">
                        <label class="form-check-label" for="flexRadioDefault2">
                            Femenino
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="area" class="col-sm-2 col-form-label">Area *</label>
                <div class="col-sm-10">
                    <select class="form-control" name="area" id="area">
                        <option value="">Seleccione una area</option>
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Descripción *</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="3" id="descripcion" name="descripcion"></textarea>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="boletin" id="boletin">
                        <label class="form-check-label" for="flexCheckChecked">
                            Deseo recibir boletín informativo
                        </label>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Roles *</label>
                <div class="col-sm-10" >
                    <div class="form-check" id="roles">
                
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="validarFrom()">Guardar</button>
        </form>
    </div>



</body>

</html>