function actionCreate(idReceta) {
    var no_porciones = document.getElementById("no_porciones_planeacion").value;
    var idReceta = idReceta;
    //alert("El valor es: " + no_porciones + " con id receta: " + idReceta);

    var datos = {
        no_porciones: no_porciones,
        idReceta: idReceta
      };

    $.ajax({
        url: "../php/recuperarPorciones.php", // Ruta al script PHP
        type: "POST", // Método de envío de datos
        data: datos, // Datos a enviar
        success: function(response) {
          // Manejar la respuesta del servidor aquí
          console.log(response);
        }
      });
}
