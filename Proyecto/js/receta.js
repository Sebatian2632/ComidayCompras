let ADDrecipe = document.getElementById("guardarreceta");
ADDrecipe.onclick = function () {
    var recetaid; //Variable para el id de la receta
    let usuario = correo;
    let RName = document.getElementById("nombrereceta").value;
    let RDuration = document.getElementById("rduracion").value;
    let RPortion = document.getElementById("rporcion").value;
    let RTime = document.getElementById("rtiempo").value;
    let RType = document.getElementById("rtipo").value;
    let RImg = document.getElementById("rimg").value;

    //Agregar la receta
    fetch("../php/insertarDB.php", {
        //Peticion php para guardar cosas en DB
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        //Sentencia para enviar el nuevo ingrediente
        body:
            'sql=INSERT INTO recetas (nombre, duracion, tiempo_comida, tiempo_receta, porciones, imagen, usuario_correo) VALUES ("' +
            RName +
            '", "' +
            RDuration +
            '", "' +
            RTime +
            '", "' +
            RType +
            '", "' +
            RPortion +
            '", "' +
            RImg +
            '", "' +
            usuario +
            '")',
    })
        .then((response) =>
            console.log("Receta insertada en la base de datos.")
        ) //Mostrar en la consola que se añadio
        .catch((error) => console.error(error)); //Mostrar el error si es que hubo
    //Retomar el ID de la receta creada
    fetch("../php/insertarDB.php", {
        //Peticion php para guardar cosas en DB
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        //Sentencia para enviar el nuevo ingrediente
        body:
            'sql=SELECT idRecetas FROM recetas WHERE nombre="' +
            RName +
            '" AND Usuarios_correo="' +
            usuario +
            '";',
    })
        .then((response) => response.json())
        .then((data) => {
            recetaid = data.map((obj) => obj.idRecetas);
        })
        .catch((error) => console.error(error)); //Mostrar el error si es que hubo
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
        existe(ingrediente); //Checar si existe el ingrediente
        for (let j = i + 1; j < texts.length; j++) {
            //Checamos que no se repita el ingrediente en toda la lista para evitar dobles en DB
            if (fila == texts[j]) {
                i++;
            }
        }
    }
    //Procedimiento
    const tablepro = document.querySelector("#procedimiento"); // Obtener la tabla
    const tdspro = tablepro.querySelectorAll("td:not(.col-md-1)"); // Obtener todos los td que no tienen clase "col-md-1"
    const textspro = Array.from(tds).map((td) => tdspro.textContent); // Obtener la cadena de texto de cada td y guardarlos en un array
    for (let i = 0; i < texts.length; i++) {
        const fila = texts[i]; //Del array obtener la cadena de la posicion i
        fetch("../php/insertarDB.php", {
            //Peticion php para guardar cosas en DB
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            //Sentencia para enviar el nuevo ingrediente ('paso_1', 'ruta_imagen_paso_1', 'idRecetas'), ('paso_2', 'ruta_imagen_paso_2', 'idRecetas'), ...;

            body:
                'sql=INSERT INTO pasos (paso, imagen, Recetas_idRecetas) VALUES ("' +
                RName +
                '", "' +
                RDuration +
                '", "' +
                RTime +
                '", "' +
                RType +
                '", "' +
                RPortion +
                '", "' +
                RImg +
                '", "' +
                usuario +
                '")',
        })
            .then((response) =>
                console.log("Paso insertado en la base de datos.")
            ) //Mostrar en la consola que se añadio
            .catch((error) => console.error(error)); //Mostrar el error si es que hubo
    }
};

function existe(ingrediente) {
    fetch("../php/ingredientes.php") //Consulta a la DB por todos los ingredientes
        .then((response) => response.json()) //Obtenemos respuesta en JSON
        .then((data) => {
            //Guardar el contenido del JSON en data
            let ingre = data; //Pasar el contenido del data
            let nombres = ingre.map((obj) => obj.nombre); //Convertimos el contenido JSON de objeto => string, lista de ingredientes de la db
            if (!nombres.includes(ingrediente)) {
                //si no esta en la lista de ingredientes
                fetch("../php/insertarDB.php", {
                    //Peticion php para guardar nuevo ingrediente
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body:
                        'sql=INSERT INTO ingredientes (nombre) VALUES ("' +
                        ingrediente +
                        '")', //Sentencia para enviar el nuevo ingrediente
                })
                    .then((response) =>
                        console.log(
                            "Ingrediente insertado en la base de datos."
                        )
                    ) //Mostrar en la consola que se añadio
                    .catch((error) => console.error(error)); //Mostrar el error si es que hubo
            }
        })
        .catch((error) => console.error(error));
}
