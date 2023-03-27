let ADDbutton = document.getElementById("guardarreceta"); //Variable global para el boton receta agregar
//Leemos cuando den clic en el boton de agregar receta
ADDbutton.onclick = function () {
    const RName = document.getElementById("nombrereceta").value;
    const ayuda = RName;
    const RDuration = document.getElementById("rduracion").value;
    const RPortion = document.getElementById("rporcion").value;
    const RTime = document.getElementById("rtiempo").value;
    const RType = document.getElementById("rtipo").value;
    const RImg = document.getElementById("rimg");
    console.log("Leer datos receta");
    Datarecipe(RName, RDuration, RPortion, RTime, RType, RImg);
    console.log("Receta a base de datos");
    Addrecipe(RName, RDuration, RPortion, RTime, RType, RImg);
    console.log("Revisar ingredientes existentes");
    Ingredientesendb();
    console.log("Obtener la id de la receta creada"); //Quitar
    console.log(ayuda);
    Obteneridreceta(ayuda); //Quitar
    console.log("Insertar los ingredientes que tiene la receta");
    Insertaringredientesenreceta();
    console.log("Insertar los pasos de la receta");
    Insertarpasosenreceta();
    console.log("Limpar campos de la receta");
    limpiarreceta();
};

//Funcion para obtener el correo de la session
function Obtenercorreo() {
    return fetch("../php/session.php")
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            const user = data.correo;
            return user;
        });
}

//Funcion para obtener los datos de la receta
function Datarecipe(RName, RDuration, RPortion, RTime, RType, RImg) {
    //Si alguno de los datos no es llenado alerta
    if (
        RName === "" ||
        RDuration === "" ||
        RPortion === "" ||
        RTime === "" ||
        RType === "" ||
        RImg.files.length === 0
    ) {
        alert("Por favor, complete todos los campos y seleccione una imagen.");
    }
    return [RName, RDuration, RPortion, RTime, RType, RImg];
}

function Addrecipe(RName, RDuration, RPortion, RTime, RType, RImg) {
    let imagen = RImg.files[0];
    let nombreimagen = imagen.name;
    Obtenercorreo().then((correo) => {
        console.log(correo)
        //Agregar la receta
        fetch("../php/insertarDB.php", {
            //Peticion php para guardar cosas en DB
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            //Sentencia para enviar la receta
            body:
                'sql=INSERT INTO recetas (nombre, duracion, tiempo_comida, tiempo_receta, porciones, imagen, usuarios_correo) VALUES ("' +
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
                nombreimagen +
                '", "' +
                correo +
                '")',
        })
            .then((response) => console.log()) //Mostrar en la consola que se añadio
            .catch((error) => console.error(error)); //Mostrar el error si es que hubo
    });
}

//Funcion para obtener los ingredientes de la tabla
function Ingredientesendb() {
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
        Enviaringrediente(ingrediente);
        for (let j = i + 1; j < texts.length; j++) {
            //Checamos que no se repita el ingrediente en toda la lista para evitar dobles en DB
            if (fila == texts[j]) {
                i++;
            }
        }
    }
}
//Funcion para leer los ingredientes de la BD y enviar si es que no esta
function Enviaringrediente(ingrediente) {
    fetch("../php/ingredientes.php") //Consulta a la DB por todos los ingredientes
        .then((response) => response.json()) //Obtenemos respuesta en JSON
        .then((data) => {
            //Guardar el contenido del JSON en data
            let ingre = data; //Pasar el contenido del data
            let nombres = ingre.map((obj) => obj.nombre); //Convertimos el contenido JSON de objeto => string, lista de ingredientes de la db
            if (!nombres.includes(ingrediente)) {
                console.log('Ingrediente no existe en la BD');
                fetch('../php/insertarDB.php', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                  },
                  body: 'sql=INSERT INTO ingredientes (nombre) VALUES ("' + ingrediente + '")',
                })
                  .then((response) => console.log(response))
                  .catch((error) => console.error(error));
              }
              
        })
        .catch((error) => console.error(error));
}
//Funcion para obtener el ID de la receta que creamos
async function Obteneridreceta(ayuda) {
    console.log(ayuda);
    try {
        const correo = await Obtenercorreo();
        const response = await fetch("../php/insertarDB.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body:
                'sql=SELECT idRecetas FROM recetas WHERE nombre="' +
                ayuda +
                '" AND Usuarios_correo="' +
                correo +
                '";',
        });
        const data = await response.json();
        console.log(data);
        return parseInt(data[0].idRecetas);
    } catch (error) {
        console.log(error);
    }
}


//Funcion para insertar los ingredientes en receta_has_ingredientes
function Insertaringredientesenreceta() {
    Obteneridreceta().then((iddelareceta) => {
        const table = document.querySelector("#listaingredientes"); // Obtener la tabla
        const tds = table.querySelectorAll("td:not(.col-md-1)"); // Obtener todos los td que no tienen clase "col-md-1"
        const texts = Array.from(tds).map((td) => td.textContent); // Obtener la cadena de texto de cada td y guardarlos en un array
        for (let i = 0; i < texts.length; i++) {
            const ingredienteahora = texts[i];
            console.log("Ingredient:", ingredienteahora);
            const split = ingredienteahora.split(" ");
            const indiceDee = split.indexOf("de");
            const ingredientee = split.slice(indiceDee + 1).join(" ");
            let UnitMedida = split[1];
            let Quantity = split[0];
            let nombreingre = ingredientee;
            if (UnitMedida == "de") {
                const split2 = ingredienteahora.split(" ");
                console.log(
                    "Revisar lo siguiente en Insertaringredientesenreceta",
                    split2
                );
                UnitMedida = split2[3];
                Quantity = split2[0];
                nombreingre = ingredientee;
            }
            fetch("../php/insertarDB.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body:
                    'sql=SELECT idIngredientes FROM ingredientes WHERE nombre="' +
                    nombreingre +
                    '";',
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log("Ingredient ID:", data);
                    let idingredienteagregar = parseInt(data[0].idIngredientes);
                    fetch("../php/insertarDB.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        body:
                            'sql=INSERT INTO recetas_has_ingredientes (Recetas_idRecetas, Ingredientes_idIngredientes, cantidad, unidad_medida) VALUES ("' +
                            iddelareceta +
                            '", "' +
                            idingredienteagregar +
                            '", "' +
                            Quantity +
                            '", "' +
                            UnitMedida +
                            '")',
                    })
                        .then((response) =>
                            console.log("Ingredient added to recipe")
                        )
                        .catch((error) =>
                            console.error(
                                "Error adding ingredient to recipe:",
                                error
                            )
                        );
                })
                .catch((error) =>
                    console.error("Error getting ingredient ID:", error)
                );
        }
    });
}

//Funcion para insertar los pasos en la tabla
async function Insertarpasosenreceta() {
    try {
        const recetaid = await Obteneridreceta();
        const tablepro = document.querySelector("#procedimiento"); // Obtener la tabla
        const tdspro = tablepro.querySelectorAll("td:not(.col-md-1)"); // Obtener todos los td que no tienen clase "col-md-1"
        const textspro = Array.from(tdspro).map((td) => td.textContent); // Obtener la cadena de texto de cada td y guardarlos en un array
        for (let i = 0; i < textspro.length; i++) {
            const filaproce = textspro[i]; //Del array obtener la cadena de la posicion i
            const regex = /^Paso\s(\d+)\.\s(.+)\.$/;
            console.log(filaproce);
            if (regex.test(filaproce)) {
                console.log("Entro prim");
                const partes = filaproce.match(regex); //Comparar las cadenas para saber las partes
                const numeroPaso = partes[1];
                const descripcion = partes[2];
                await fetch("../php/insertarDB.php", {
                    //Peticion php para guardar cosas en DB
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body:
                        'sql=INSERT INTO pasos (nopaso, paso, Recetas_idRecetas) VALUES ("' +
                        numeroPaso +
                        '", "' +
                        descripcion +
                        '", "' +
                        recetaid +
                        '")',
                });
                console.log("Se añadió el paso:", filaproce);
            } else {
                console.log("entro aqui");
                const partes = filaproce.match(regex); //Comparar las cadenas para saber las partes
                const numeroPaso = partes[1];
                const descripcion = partes[2];
                const nombreArchivo = partes[3];
                await fetch("../php/insertarDB.php", {
                    //Peticion php para guardar cosas en DB
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body:
                        'sql=INSERT INTO pasos (idPasos, paso, imagen, Recetas_idRecetas) VALUES ("' +
                        numeroPaso +
                        '", "' +
                        descripcion +
                        '", "' +
                        nombreArchivo +
                        '", "' +
                        recetaid +
                        '")',
                });
                console.log("Se añadió el paso con imagen:", filaproce);
            }
        }
    } catch (error) {
        console.error(error);
    }
}

//Limpiar todos los campos de la receta
function limpiarreceta() {
    document.getElementById("nombrereceta").value = "";
    document.getElementById("rduracion").value = "";
    document.getElementById("rporcion").value = "";
    document.getElementById("rtiempo").value = "";
    document.getElementById("rtipo").value = "";
}
