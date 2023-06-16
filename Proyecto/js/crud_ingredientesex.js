fetch("../php/ingredientes.php") //Pedimos en la base de datos los ingredientes existentes
    .then((response) => response.json())
    .then((data) => {
        let ingre = data; //Guardamos los resultados de php
        let nombres = ingre.map((obj) => obj.nombre); //Sacamos el nombre de los resultados
        $("#autocomplete-custom-append").autocomplete({ lookup: nombres }); //Autocompletamos el campo
    })
    .catch((error) => console.error(error));
    

//----------------CREATE-----------------
async function actionCreate()
{
    //Recuperamos los datos del formulario
    let nombre = document.getElementById('autocomplete-custom-append').value;
    let cantidad = document.getElementById('cantidad').value;
    if(cantidad === '0')
    {
      console.log('me diste un click');
      alert("Favor de poner un número positivo en la cantidad")
    }
    else
    {
      let unidad_medida = document.getElementById('unidad_medida').value;
      const email = await obtenerCorreo();

    if(nombre === '' || cantidad === '' || unidad_medida === '')
    {
      alert("Por favor llene todos los campos");
    }
    else
    {
      limpiarpagina();

      $.ajax({
        method:"POST",
        url: "../php/crud_ingredientesex.php",
        data: {
          nom: nombre,
          cant: cantidad,
          unid: unidad_medida,
          correo: email,
          accion: "create"
        },
        success: function( respuesta ) {
          JSONRespuesta = JSON.parse(respuesta);
          console.log(respuesta);
          if(JSONRespuesta.estado==1){
            alert(JSONRespuesta.mensaje);
            tabla = $("#example").DataTable();
            let Botones = '';
              Botones += '<button type="button" id="editarIngrediente" class="btn btn-primary"><i class="fa fa-pencil"></i></button>';
              Botones += '<button type="button" id="eliminarIngrediente" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
            tabla.row.add([nombre, cantidad, unidad_medida, Botones]).draw().node().id = "renglon_" + JSONRespuesta.id;
            readnumber()
          }else{
            alert(JSONRespuesta.mensaje);
          }
        }
      });
      }
    }     
}

//----------------READ-----------------
async function actionRead() {
  const email = await obtenerCorreo();
  $.ajax({
    method:"POST",
    url: "../php/crud_ingredientesex.php",
    data: {
      correo: email,
      accion: "read"
    },
    success: function( respuesta ) {
      JSONRespuesta = JSON.parse(respuesta);
      if(JSONRespuesta.estado==1){
        console.log(respuesta);
        //alert(JSONRespuesta.mensaje);
        tabla = $("#example").DataTable();
        JSONRespuesta.entregas.forEach(ingredientes => {
          let Botones = '';
            Botones += '<button type="button" id="editarIngrediente" class="btn btn-primary"><i class="fa fa-pencil"></i></button>';
            Botones += '<button type="button" id="eliminarIngrediente" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
          tabla.row.add([ingredientes.nombre_ingrediente, ingredientes.cantidad, ingredientes.unidad_medida, Botones]).draw().node().id = "renglon_" + ingredientes.idDisponibles;
        });
      }
    }
  });
}


//----------------DELATE-----------------



//----------------UPDATE-----------------



//----------------READ NUMBER-----------------
async function readnumber()
{
  let email = await obtenerCorreo();
  $.ajax({
    method:"POST",
    url: "../php/crud_ingredientesex.php",
    data: {
      correo: email,
      accion: "read_number"
    },
    success: function( respuesta ) {
      JSONRespuesta = JSON.parse(respuesta);
      if(JSONRespuesta.estado == 1)
      {
        let numeroregistros = JSONRespuesta.numero_registros;
        document.getElementById("numero_ingredientes").textContent = numeroregistros;
      }
      else
      {
        alert('Error al obtener los ingredientes existentes');
      }
    }
  }); 
}

//Limpiar las variables del formulario
function limpiarpagina()
{
    document.getElementById("autocomplete-custom-append").value = "";
    document.getElementById("cantidad").value = "";
    document.getElementById("unidad_medida").value = "";
}

//Leemos el correo de la sesion
async function obtenerCorreo() {
    const response = await fetch("../php/session.php");
    const data = await response.json();
    const user = data.correo;
    return user;
}
