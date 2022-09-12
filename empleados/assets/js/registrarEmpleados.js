$(document).ready(function(){
    listarRoles();
   // selectOnlyCheck();
    listarArea();
    
});


function listarRoles(){
    $.ajax({
        url: "../model/roles.php", 
        type:'post',
        data: {listar:true},
        success: function(result){
        let roles=JSON.parse(result);
            if(roles.length>0){
                    for(let i=0; i<roles.length;i++){
                        $('#roles').
                        append(
                        '<input class="form-check-input roles-check" name="roles" type="checkbox" value="'+roles[i].id+'" id="'+roles[i].id+'">'+
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
        url: "../model/area.php", 
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

function selectOnlyCheck(){
    $(document).on('click', '.roles-check', function() {      
        $('.roles-check').not(this).prop('checked', false);      
    });
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
        saveEmpleado($("#registrar_empleados").serialize())
     }else{
        Swal.fire({
            title: 'Error!',
            text: 'Hay datos mal ingresados, Por favor verificar la informacion registrada en el formulario',
            icon: 'error',
          })
     }
}

function saveEmpleado(data){
    $.ajax({
        url: "../model/empleado.php", 
        type:'post',
        data: {data:data},
        success: function(result){
      }});
}
