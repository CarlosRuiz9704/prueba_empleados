$(document).ready(function(){
    listarEmpleados();
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
                            '<td><a onclick="editarEmpleado('+empleados[i].id+')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>'+
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
 console.log('aqui edita')
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