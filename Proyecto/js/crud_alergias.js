// -------------------- Alergias ---------------------

fetch("../php/ingredientes.php") //Pedimos en la base de datos los ingredientes existentes
.then((response) => response.json())
.then((data) => {
    let ingre = data; //Guardamos los resultados de php
    let nombres = ingre.map((obj) => obj.nombre); //Sacamos el nombre de los resultados
    $("#autocomplete-custom-append1").autocomplete({ lookup: nombres }); //Autocompletamos el campo
})
.catch((error) => console.error(error));

// Funciones de manejo de eventos
async function actionCreateAlergias() {
  let nombre = document.getElementById('autocomplete-custom-append1').value;
  if(nombre == "")
  {
    alert("Favor de poner el nombre de la alergia");
  }
  else
  {
    const email = await obtenerCorreo();
  $.ajax({
    method: "POST",
    url: "../php/crud_alergias.php",
    data: {
      nom: nombre,
      correo: email,
      accion: "create"
    },
    success: function(respuesta) {
      JSONRespuesta = JSON.parse(respuesta);
      console.log(respuesta);
      if (JSONRespuesta.estado == 1) {
        alert(JSONRespuesta.mensaje);
        let tabla = $("#example1").DataTable();
        let Botones = '';
        Botones += '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_delete_alergia" onclick="actionDeleteAlergia('+JSONRespuesta.id+')"><i class="fa fa-trash"></i></button>';
        tabla.row.add([nombre, Botones]).draw().node().id = "renglon_" + JSONRespuesta.id;
        $("#autocomplete-custom-append1").val("");
      } else {
        alert(JSONRespuesta.mensaje);
      }
    }
  });
  }
}

async function actionReadAlergia() {
  const email = await obtenerCorreo();
  $.ajax({
    method: "POST",
    url: "../php/crud_alergias.php",
    data: {
      correo: email,
      accion: "read"
    },
    success: function(respuesta) {
      console.log(respuesta);
      JSONRespuesta = JSON.parse(respuesta);
      if (JSONRespuesta.estado == 1) {
        let tabla = $("#example1").DataTable();
        tabla.clear().draw();
        JSONRespuesta.entregas.forEach(alergia => {
          let Botones = '';
          Botones += '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_delete_alergia" onclick="actionDeleteAlergia('+alergia.idalergia+')"><i class="fa fa-trash"></i></button>';
          tabla.row.add([alergia.nombre_ingrediente, Botones]).draw().node().id = "renglon_" + alergia.idalergia;
        });
      }
    }
  });
}

function actionDeleteAlergia(id) {
    idEliminarAlergia = id;
}

function confirmDeleteAlergia()
{
  $.ajax({
    method:"POST",
    url: "../php/crud_alergias.php",
    data: {
      id: idEliminarAlergia,
      accion: "delete"
    },
    success: function( respuesta ) {
      JSONRespuesta = JSON.parse(respuesta);
      if(JSONRespuesta.estado == 1)
      {
        let tabla = $("#example1").DataTable();
        tabla.row("#renglon_"+idEliminarAlergia).remove().draw();
        alert("Alergia eliminado exitosamente.");
        $('#modal_delete_alergia').modal('hide'); // Cierra el modal
        readnumber();
      }
      else
      {
        alert("Error al eliminar la alergia, intentelo nuevamente");
      }
    }
  });
}
  

async function deleteAllAlergia() {
  const email = await obtenerCorreo();
  $.ajax({
    method:"POST",
    url: "../php/crud_alergias.php",
    data: {
      correo: email,
      accion: "delete_all"
    },
    success: function( respuesta ) {
      JSONRespuesta = JSON.parse(respuesta);
      if(JSONRespuesta.estado == 1)
      {
        alert("Alergias eliminadas exitosamente.");
        $('#modal_delete_all_alergias').modal('hide'); // Cierra el modal
        let tabla = $("#example1").DataTable();
        tabla.clear().draw();
      }
      else
      {
        alert("Error al eliminar las alergias, intentelo nuevamente");
      }
    }
  });
}

async function obtenerCorreo() {
    const response = await fetch("../php/session.php");
    const data = await response.json();
    const user = data.correo;
    return user;
}


function Cerrar() {
// Función para cerrar el modal
$("#modal_alergias").modal("hide");
}