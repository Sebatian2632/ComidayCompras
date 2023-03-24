let ADDrecipe = document.getElementById("guardarreceta");
ADDrecipe.onclick = function(){
    let RDuration = document.getElementById("rduracion").value;
    let RPortion = document.getElementById("rporcion").value;
    let RTime = document.getElementById("rtiempo").value;
    let RType = document.getElementById("rtipo").value;
    let RImg = document.getElementById("rimg").value;
    //Seccionar las consultas e insert
        //iniciando con la tabla Receta
        

    //agregar valores a la tabla de listado de ingredientes con el icono para eliminar
    let explicacion = NStep + " " + Step + " " + Stepimg;  //Encadenamos para formar el texto a plasmar
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
    let txt = document.createTextNode(explicacion);    //Inicializamos un nodo con el texto a plasmar
    tdtext.appendChild(txt);                            //Agregamos el textro al TD
    tdRemove.appendChild(icon);                         //Agregamos el icono al TD
    tr.appendChild(tdRemove);                           //Agregamos el TD al TR
    tr.appendChild(tdtext);                             //Agregamos el TD al TR
    console.log(explicacion);
    const tbody=document.getElementById("procedimiento").querySelector("tbody").appendChild(tr);  //Agragamos al TBody ambos TR
}
//Para eliminar
function eliminarFila(){
    const tr = this.closest("tr");
    tr.remove();
    console.log("Se clico");
}
    