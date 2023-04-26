fetch("../php/ingredientes.php") //Pedimos en la base de datos los ingredientes existentes
    .then((response) => response.json())
    .then((data) => {
        let ingre = data; //Guardamos los resultados de php
        let nombres = ingre.map((obj) => obj.nombre); //Sacamos el nombre de los resultados
        $("#autocomplete-custom-append").autocomplete({ lookup: nombres }); //Autocompletamos el campo
    })
    .catch((error) => console.error(error));
    
//console.log('funcionando');

//----------------Create-----------------
async function actionCreate()
{
    console.log('me diste un click');

    //Recuperamos los datos del formulario
    let nombre = document.getElementById('autocomplete-custom-append').value;
    let cantidad = document.getElementById('cantidad').value;
    let unidad_medida = document.getElementById('unidad_medida').value;
    const email = await obtenerCorreo();

    console.log(nombre);
    console.log(cantidad);
    console.log(unidad_medida);
    console.log(email);
    limpiarpagina();

    fetch('../php/crud_ingredientesex.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          nombre,
          cantidad,
          unidad_medida,
          email
        })
      })
      .then(res => res.json())
      .then(data => {
        console.log(data);
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
