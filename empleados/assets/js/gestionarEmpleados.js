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
                            '<td><a onclick="eliminarEmpleado('+empleados[i].id+')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>'+
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
function eliminarEmpleado(id){
    console.log('aqui elimina')
}