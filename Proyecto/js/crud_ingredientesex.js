
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
              Botones += '<button type="button" id="editarIngrediente" class="btn btn-primary" onclick="cambiarBotonAgregar('+JSONRespuesta.id+')"><i class="fa fa-pencil"></i></button>';
              Botones += '<button type="button" id="eliminarIngrediente" class="btn btn-danger data-toggle="modal" data-target="#modal_delete_ingrediente" onclick="actionDelete('+JSONRespuesta.id+')"><i class="fa fa-trash"></i></button>';
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
        tabla = $("#example").DataTable();
        tabla.clear().draw(); // Limpiar la tabla antes de agregar nuevos datos
        JSONRespuesta.entregas.forEach(ingredientes => {
          let Botones = '';
            Botones += '<button type="button" id="editarIngrediente" class="btn btn-primary" onclick="cambiarBotonAgregar('+ingredientes.idDisponibles+')"><i class="fa fa-pencil"></i></button>';
            Botones += '<button type="button" id="eliminarIngrediente" class="btn btn-danger"data-toggle="modal" data-target="#modal_delete_ingrediente" onclick="actionDelete('+ingredientes.idDisponibles+')"><i class="fa fa-trash"></i></button>';
          tabla.row.add([ingredientes.nombre_ingrediente, ingredientes.cantidad, ingredientes.unidad_medida, Botones]).draw().node().id = "renglon_" + ingredientes.idDisponibles;
        });
      }
    }
  });
}


//----------------DELATE-----------------
function actionDelete(id)
{
  idEliminar = id;
}

function confirmDelete(id)
{
  $.ajax({
    method:"POST",
    url: "../php/crud_ingredientesex.php",
    data: {
      id: idEliminar,
      accion: "delete"
    },
    success: function( respuesta ) {
      JSONRespuesta = JSON.parse(respuesta);
      if(JSONRespuesta.estado == 1)
      {
        let tabla = $("#example").DataTable();
        tabla.row("#renglon_"+idEliminar).remove().draw();
        alert("Ingrediente eliminado exitosamente.");
        $('#modal_delete_ingrediente').modal('hide'); // Cierra el modal
        readnumber();
      }
      else
      {
        alert("Error al eliminar el ingrediente, intentelo nuevamente");
      }
    }
  });
}

async function deleteAll()
{
  const email = await obtenerCorreo();
  $.ajax({
    method:"POST",
    url: "../php/crud_ingredientesex.php",
    data: {
      correo: email,
      accion: "delete_all"
    },
    success: function( respuesta ) {
      JSONRespuesta = JSON.parse(respuesta);
      if(JSONRespuesta.estado == 1)
      {
        alert("Ingredientes eliminados exitosamente.");
        $('#modal_delete_all').modal('hide'); // Cierra el modal
        let tabla = $("#example").DataTable();
        tabla.clear().draw();
        readnumber();
      }
      else
      {
        alert("Error al eliminar los ingredientes, intentelo nuevamente");
      }
    }
  });
}


//----------------UPDATE-----------------
function cambiarBotonAgregar(id) {
  var btnAgregarIn = document.getElementById("agregarin");

  if (btnAgregarIn.innerText === "Agregar") {
    let idingredientes = id;
    // Cambiar el texto y la función
    btnAgregarIn.innerText = "Actualizar";
    $.ajax({
      method:"POST",
      url: "../php/crud_ingredientesex.php",
      data: {
        id: idingredientes,
        accion:"read_id"
      },
      success: function( respuesta ) {
        JSONRespuesta = JSON.parse(respuesta);
        if(JSONRespuesta.estado==1){
          let nom_ingrediente = document.getElementById("autocomplete-custom-append");
          nom_ingrediente.value = JSONRespuesta.nombre_ingrediente;
          let cantidad = document.getElementById("cantidad");
          cantidad.value = JSONRespuesta.cantidad;
          let unidad = document.getElementById("unidad_medida");
          unidad.value = JSONRespuesta.unidad_medida;
        }else{
          alert("Registro no encontrado");
        }
      }
    });
    btnAgregarIn.onclick = function() {
      actionUpdate(idingredientes);
    };
  } else {
    // Restaurar el texto y la función originales
    btnAgregarIn.innerText = "Agregar";
    btnAgregarIn.onclick = actionCreate;
  }
}

async function actionUpdate(id) {
  let nom_ingrediente = document.getElementById("autocomplete-custom-append").value;
  let cantidad = document.getElementById("cantidad").value;
  let unidad = document.getElementById("unidad_medida").value;
  const email = await obtenerCorreo();
  console.log(id);
  console.log(nom_ingrediente);
  console.log(cantidad);
  console.log(unidad);
  $.ajax({
    method:"POST",
      url: "../php/crud_ingredientesex.php",
      data: {
        iding: id,
        nom: nom_ingrediente,
        cant: cantidad,
        unid: unidad,
        correo: email,
        accion:"update"
      },
      success: function( respuesta ) {
        JSONRespuesta = JSON.parse(respuesta);
        console.log(respuesta);
        if(JSONRespuesta.estado==1){
          let tabla = $("#example").DataTable();
          let Botones = '';
            Botones += '<button type="button" id="editarIngrediente" class="btn btn-primary" onclick="cambiarBotonAgregar('+id+')"><i class="fa fa-pencil"></i></button>';
            Botones += '<button type="button" id="eliminarIngrediente" class="btn btn-danger" data-toggle="modal" data-target="#modal_delete_ingrediente" onclick="actionDelete('+id+')"><i class="fa fa-trash"></i></button>';
          ////////////////////////////////////////////////
          var temp = tabla.row("#renglon_"+id).data();
          temp[0] = nom_ingrediente;
          temp[1] = cantidad;
          temp[2] = unidad;
          temp[3] = Botones;
          tabla.row("#renglon_"+id).data(temp).draw();
          /////////////////////////////////////////////////
          alert("Ingrediente actualizado correctamente");
          limpiarpagina();
          cambiarBotonAgregar();
        }else{
          alert("Error al actualizar el ingrediente, intentelo nuevamente");
      }
      }
  })
  fetch("../php/ingredientes.php") //Pedimos en la base de datos los ingredientes existentes
    .then((response) => response.json())
    .then((data) => {
        let ingre = data; //Guardamos los resultados de php
        let nombres = ingre.map((obj) => obj.nombre); //Sacamos el nombre de los resultados
        $("#autocomplete-custom-append").autocomplete({ lookup: nombres }); //Autocompletamos el campo
    })
    .catch((error) => console.error(error));
}



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

//Cerar el formulario
function Cerrar() {
  var btnAgregarIn = document.getElementById("agregarin");

  if (btnAgregarIn.innerText === "Actualizar") {
    btnAgregarIn.innerText = "Agregar";
    btnAgregarIn.onclick = actionCreate;
  }
  limpiarpagina();
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
