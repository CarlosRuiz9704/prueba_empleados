$(document).ready(function(){
    listarEmpleados();
    listarRoles();
    listarArea();
});


function listarEmpleados(){
    $.ajax({
        url: "model/empleado.php", 
        type:'post',
        data: {listar:true},
        success: function(result){
        let empleados=JSON.parse(result);
            if(empleados.length>0){
                $("#list-empleados tbody").remove();
                $('#list-empleados').append('<tbody>');
                    for(let i=0; i<empleados.length;i++){
                        $('#list-empleados').
                        append(
                        '<tr>'+
                            '<td>'+empleados[i].nombre+'</td>'+
                            '<td>' +empleados[i].email+ '</td>'+
                            '<td>' + empleados[i].des_sexo + '</td>'+
                            '<td>' + empleados[i].desc_area + '</td>'+
                            '<td>' + empleados[i].des_boletin + '</td>'+
                            '<td><a onclick="editarEmpleado('+empleados[i].id+')" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>'+
                            '<td><a onclick="confirmDelete('+empleados[i].id+')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>'+
                        '</tr>');
                    }
                $('#list-empleados').append('</tbody>');
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: 'No hay empleados para listar',
                    icon: 'error',
                  })
            }
      }});
}

function editarEmpleado(id){
    $.ajax({
        url: "model/empleado.php", 
        type:'post',
        async: false,
        data: {userIdEdit:id},
        success: function(result){
            data=JSON.parse(result);
            console.log(data);
            $("#nombre").val(data.nombre)
            $("#correo").val(data.email)
            $("#id_user").val(data.id)
            $("#descripcion").val(data.descripcion)
            if(data.boletin==1) {
                $("#boletin").prop('checked', true);
            }else{
                $("#boletin").prop('checked', false);
            }
            if(data.sexo=="M"){
               $("#masculino").prop('checked', true)
            }else if(data.sexo=="F"){
                $("#femenino").prop('checked', true)
            }

            $("#area option").each(function(){
                var thisOptionValue=$(this).val();

                if (data.area_id==thisOptionValue){
                    $(this).prop('selected',true)
                }
            });
            getRolesByUser(id);
      }});
}

function getRolesByUser(id){
    $.ajax({
        url: "model/area.php", 
        type:'post',
        data: {userId:id},
        success: function(result){
            roles=JSON.parse(result);
            $('.roles-check').prop('checked', false); 

            $(".roles-check").each(function(){
                let value=$(this).val();
                console.log(value)
                let rol_check = roles.filter(valor => valor.rol_id == value);
                    if(rol_check.length > 0){
                        $("#"+rol_check[0].rol_id).prop('checked',true)
                    }   
            });
      }});
}
function confirmDelete(id){
    Swal.fire({
        title: 'Desea eliminar el empleado?',
        text: "una vez confirmada esta acción no se podra revertir",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar'
      }).then((result) => {
        if (result.isConfirmed) {
            eliminarEmpleado(id)
        }
      })
}
function eliminarEmpleado(id){
    $.ajax({
        url: "model/empleado.php", 
        type:'post',
        data: {userId:id},
        success: function(result){
        if(result==1){
            Swal.fire({
                icon: 'success',
                title: 'Exito!!',
                text: 'Empleado eliminado exitosamente'
              })
              listarEmpleados();
        }else{
            Swal.fire({
                title: 'Error!',
                text: 'Problemas al eliminar el empleado',
                icon: 'error',
              })
        }
      }});
}

function listarRoles(){
    $.ajax({
        url: "model/roles.php", 
        type:'post',
        data: {listar:true},
        success: function(result){
        let roles=JSON.parse(result);
            if(roles.length>0){
                    for(let i=0; i<roles.length;i++){
                        $('#roles').
                        append(
                        '<input class="form-check-input roles-check" name="roles[]" type="checkbox" value="'+roles[i].id+'" id="'+roles[i].id+'">'+
                        '<label class="form-check-label" for="'+roles[i].id+'">'+roles[i].nombre+'</label></br>'
                        );
                    }
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: 'No hay roles para listar',
                    icon: 'error',
                  })
            }
      }});
}

function listarArea(){
    $.ajax({
        url: "model/area.php", 
        type:'post',
        data: {listarArea:true},
        success: function(result){
        let areas=JSON.parse(result);
            if(areas.length>0){
                    for(let i=0; i<areas.length;i++){
                        $('#area').
                        append(
                        '<option value="'+areas[i].id+'">'+areas[i].nombre+'</option>'
                        );
                    }
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: 'No hay areas para listar',
                    icon: 'error',
                  })
            }
      }});
}


function validarFrom(){
    let flag=true;
    let expresion= /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    if($("#nombre").val()<=0){
        flag=false;
        $("#nombre").focus();
    }else if(!$("#correo").val().match(expresion)){
        flag=false;
        $("#correo").focus();
        
    }else if($("#area").val().length<=0){
        flag=false;
        $("#area").focus();
    }else if($("#descripcion").val().length<=0){
        flag=false;
        $("#descripcion").focus();
    }else if ($('.roles-check:checked').length==0){       
        flag=false;
        $('.roles-check').focus()
     }

     if(flag){
        upEmpleado($("#registrar_empleados").serialize())
     }else{
        Swal.fire({
            title: 'Error!',
            text: 'Hay datos mal ingresados, Por favor verificar la informacion registrada en el formulario',
            icon: 'error',
          })
     }
}


function upEmpleado(data){
    $.ajax({
        url: "model/empleado.php", 
        type:'post',
        data: {dataUpdate:data},
        success: function(result){
            if(result==1){
                Swal.fire({
                    icon: 'success',
                    title: 'Exito!!',
                    text: 'Registro actualizado correctamente'
                  })
                listarEmpleados();
                $('#myModal').modal('hide');
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: 'Ocurrio un problema al realizar la actualizacion',
                    icon: 'error',
                  })
            }
      }});
}
