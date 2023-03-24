fetch('../php/ingredientes.php')
  .then(response => response.json())
  .then(data => {
    let ingre = data;
    let nombres = ingre.map(obj => obj.nombre);
    $("#autocomplete-custom-append").autocomplete({lookup:nombres})
  })
  .catch(error => console.error(error));


    let Addingre = document.getElementById("agregarin");
    Addingre.onclick = function(){
      let NIName = document.getElementById("autocomplete-custom-append").value;
      let NIQuantity = document.getElementById("cantidad").value;
      let NIUnit = document.getElementById("unidad_medida").value;
      //agregar valores a la tabla de listado de ingredientes con el icono para eliminar
      let ulingredient = NIQuantity + " " + NIUnit + " de "  + NIName;  //Encadenamos para formar el texto a plasmar
      const tr=document.createElement("tr");              //Creamos el TR
      const tdRemove=document.createElement("td");        //Creamos el TD
      tdRemove.className = "col-md-1 col-sm-1";           //Damos clase al TD
      const icon = document.createElement('i');           //Creamos el i
      icon.classList.add('fa', 'fa-times-circle-o');      //Damos clase al i
      icon.style.color = 'rgb(255, 0, 89)';               //Asignamos color al i
      icon.style.textAlign = 'right';                     //Asignamos posicion al i
      icon.onclick=eliminarFila;                          //Asignamos evento o funcion al clickar
      const tdtext=document.createElement("td");          //Creamos el TD de texto
      tdtext.className = "col-md-11 col-sm-11";           //Damos clase al TD de texto
      let txt = document.createTextNode(ulingredient);    //Inicializamos un nodo con el texto a plasmar
      tdtext.appendChild(txt);                            //Agregamos el textro al TD
      tdRemove.appendChild(icon);                         //Agregamos el icono al TD
      tr.appendChild(tdRemove);                           //Agregamos el TD al TR
      tr.appendChild(tdtext);                             //Agregamos el TD al TR
      const tbody=document.getElementById("listaingredientes").querySelector("tbody").appendChild(tr);  //Agragamos al TBody ambos TR
    }
    //Para eliminar
    function eliminarFila(){
      const tr = this.closest("tr");
      tr.remove();
      console.log("Se clico");
      
    }


    /*
function agregarreceta(){
  let RecipeName = document.getElementById("nombrereceta").value;
  let Ingredient = document.getElementById("autocomplete-custom-append").value;
  let IQuantity = document.getElementById("cantidad").value;
  let IUnit = document.getElementById("unidad_medida").value;
  let NStep = document.getElementById("nombrereceta").value;
  let Stepimg = document.getElementById("nombrereceta").value;
  let Step = document.getElementById("nombrereceta").value;
  let RDuration = document.getElementById("nombrereceta").value;
  let RPortion = document.getElementById("nombrereceta").value;
  let RTime = document.getElementById("nombrereceta").value;
  let RType = document.getElementById("nombrereceta").value;
  let RImg = document.getElementById("nombrereceta").value;
}*/