/*Documentacion del codigo
El siguiente codigo se desarrolla con nomenclatura camelCase, que se usa para variables, funciones y propiedades
    CamelCase se refiere a escribir palabras juntas sin espacios y cada palabra después de la primera comienza con una letra mayúscula, por ejemplo: miVariableDeEjemplo.
*/
import { Receta } from "./recetaclass.js"; //Clase receta para guardar datos
let addButton = document.getElementById("guardarreceta"); //Variable global para el boton receta agregar
const receta = new Receta(); //Variable global para la instancia de la clase Receta

//Cuando se presione el boton guardar receta al final de la pagina
addButton.onclick = function () {
    leerDatosReceta();
};
//Lectura de los datos ingresados en la receta para saber si estan completos o vacios para guardarlos en la clase posteriormente
async function leerDatosReceta() {
    //Se instancian e inicializan los datos
    const rName = document.getElementById("nombrereceta").value;
    const rDuration = document.getElementById("rduracion").value;
    const rPortion = document.getElementById("rporcion").value;
    const rTime = document.getElementById("rtiempo").value;
    const rType = document.getElementById("rtipo").value;
    const rImg = document.getElementById("rimg");
    const email = await obtenerCorreo();
    //Comprobamos si estan completos
    if (
        rName == "" ||
        rDuration == "" ||
        rPortion == "" ||
        rTime == "" ||
        rType == "" ||
        rImg.files.length === 0
    ) {
        //No estan completos
        alert("Por favor, complete todos los campos y seleccione una imagen.");
        return;
    }
    //Creamos la receta para guardar los datos
    receta.setName(rName);
    receta.setDuration(rDuration);
    receta.setPortion(rPortion);
    receta.setTime(rTime);
    receta.setType(rType);
    receta.setImage(rImg);
    receta.setEmail(email);
    imprimirDatosReceta(); //Debug
    await addRecipe();
    await DbIngredients();

    esperar(3000);
}

//Comprobar los datos de la receta, es con fines de debugin
function imprimirDatosReceta() {
    console.log("Aqui inicia la receta");
    console.log("Nombre de la receta: ", receta.getName());
    console.log("Duracion de la receta: ", receta.getDuration());
    console.log("Porcion de la receta: ", receta.getPortion());
    console.log("Tiempo de la receta: ", receta.getTime());
    console.log("Tipo de la receta: ", receta.getType());
    console.log("Imagen de la receta: ", receta.getImage());
    console.log("Mail de la receta: ", receta.getEmail());
    console.log("Id de la receta: ", receta.getId());
    console.log("Aqui termina la receta");
}

//Leemos el correo de la sesion
async function obtenerCorreo() {
    const response = await fetch("../php/session.php");
    const data = await response.json();
    const user = data.correo;
    return user;
}
//------------------------Receta datos y acciones----------------------------
//Ingresamos la receta a la base de datos
async function addRecipe() {
    let rName = receta.getName();
    let rDuration = receta.getDuration();
    let rTime = receta.getTime();
    let rType = receta.getType();
    let rPortion = receta.getPortion();
    let rimg = receta.getImage();
    let correo = receta.getEmail();
    fetch("../php/insertarDB.php", {
        //Peticion php para guardar cosas en DB
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        //Sentencia para enviar la receta
        body:
            'sql=INSERT INTO recetas (nombre, duracion, tiempo_comida, tiempo_receta, porciones, imagen, usuarios_correo) VALUES ("' +
            rName +
            '", "' +
            rDuration +
            '", "' +
            rTime +
            '", "' +
            rType +
            '", "' +
            rPortion +
            '", "' +
            rimg +
            '", "' +
            correo +
            '")',
    })
        .then((response) => console.log("Se añadio la receta")) //Mostrar en la consola que se añadio
        .catch((error) => console.error(error)); //Mostrar el error si es que hubo
    let idReceta = await obtenerIdReceta();
    console.log(idReceta); //Dubug
    receta.setId(idReceta);
}
//Obtener el id de la receta
async function obtenerIdReceta() {
    let rName = receta.getName();
    let rDuration = receta.getDuration();
    let rTime = receta.getTime();
    let rType = receta.getType();
    let correo = receta.getEmail();

    return new Promise((resolve, reject) => {
        fetch("../php/insertarDB.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body:
                'sql=SELECT idRecetas FROM recetas WHERE nombre="' +
                rName +
                '" AND duracion="' +
                rDuration +
                '" AND tiempo_comida="' +
                rTime +
                '" AND tiempo_receta="' +
                rType +
                '" AND Usuarios_correo="' +
                correo +
                '";',
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                resolve(parseInt(data[0].idRecetas));
            })
            .catch((error) => reject(error));
    });
}
//--------------------Ingredientes datos y acciones --------------------------
//Funcion para obtener los ingredientes de la tabla
async function DbIngredients() {
    //revisamos ingredientes para insertar los que no existan
    const table = document.querySelector("#listaingredientes"); // Obtener la tabla
    const tds = table.querySelectorAll("td:not(.col-md-1)"); // Obtener todos los td que no tienen clase "col-md-1"
    const texts = Array.from(tds).map((td) => td.textContent); // Obtener la cadena de texto de cada td y guardarlos en un array
    //Iterar el array y separarlo
    for (let i = 0; i < texts.length; i++) {
        const fila = texts[i]; //Del array obtener la cadena de la posicion i
        const split = fila.split(" "); //Partimos la cadena donde existan ' '
        const indiceDe = split.indexOf("de"); //Obtenemos la posicion del "de"
        const ingrediente = split.slice(indiceDe + 1).join(" "); //De la posicion del primer "de" se obtiene la cadena de despues
        await sendIngredient(ingrediente);
        for (let j = i + 1; j < texts.length; j++) {
            //Checamos que no se repita el ingrediente en toda la lista para evitar dobles en DB
            if (fila == texts[j]) {
                i++;
            }
        }
    }
}

//Funcion para leer los ingredientes de la BD y enviar si es que no esta
async function sendIngredient(ingrediente) {
    return fetch("../php/ingredientes.php") //Consulta a la DB por todos los ingredientes
        .then((response) => response.json()) //Obtenemos respuesta en JSON
        .then((data) => {
            //Guardar el contenido del JSON en data
            let ingre = data; //Pasar el contenido del data
            let nombres = ingre.map((obj) => obj.nombre); //Convertimos el contenido JSON de objeto => string, lista de ingredientes de la db
            if (!nombres.includes(ingrediente)) {
                console.log("Ingrediente no existe en la BD");
                fetch("../php/insertarDB.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body:
                        'sql=INSERT INTO ingredientes (nombre) VALUES ("' +
                        ingrediente +
                        '")',
                })
                    .then((response) => console.log(response))
                    .catch((error) => console.error(error));
            }
        })
        .catch((error) => console.error(error));
}

//Esperar en ms para evitar problemas al retomar datos de la db, es una aberracion de programacion pero creo que funcionaxd
function esperar(ms) {
    return new Promise((resolve) => setTimeout(resolve, ms));
}
