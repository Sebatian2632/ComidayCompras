let ADDrecipe = document.getElementById("guardarreceta");
ADDrecipe.onclick = function () {
  let RDuration = document.getElementById("rduracion").value;
  let RPortion = document.getElementById("rporcion").value;
  let RTime = document.getElementById("rtiempo").value;
  let RType = document.getElementById("rtipo").value;
  let RImg = document.getElementById("rimg").value;
  //Seccionar las consultas e insert
		//revisamos ingredientes para insertar los que no existan
		const table = document.querySelector('#listaingredientes'); // Obtener la tabla
		const tds = table.querySelectorAll("td:not(.col-md-1)"); // Obtener todos los td que no tienen clase "col-md-1"
		const texts = Array.from(tds).map((td) => td.textContent); // Obtener la cadena de texto de cada td y guardarlos en un array
		
		//Iterar el array y separarlo
		for(let i=0; i < texts.length; i++){
			const fila = texts[i];
			const split = fila.split(' ')
			const indiceDe = split.indexOf("de");
			const ingrediente = split.slice(indiceDe + 1).join(" ");
			
			existe(ingrediente);
		}
		
		
  //iniciando con la tabla Receta
}

function existe(ingrediente){
	fetch('../php/ingredientes.php')
	.then(response => response.json())
	.then(data => {
			let ingre = data;
			let nombres = ingre.map(obj => obj.nombre);
			if(!nombres.includes(ingrediente)){
					fetch('../php/insertar_ingrediente.php', {
							method: 'POST',
							headers: {
									'Content-Type': 'application/x-www-form-urlencoded'
							},
							body: 'sql=INSERT INTO ingredientes (nombre) VALUES ("' + ingrediente + '")'
					})
					.then(response => console.log('Ingrediente insertado en la base de datos.'))
					.catch(error => console.error(error));
			}
	})
	.catch(error => console.error(error));
}
