fetch('../php/ingredientes.php')
  .then(response => response.json())
  .then(data => {
    let ingre = data;
    let nombres = ingre.map(obj => obj.nombre);
      $("#autocomplete-custom-append").autocomplete({lookup:nombres})
    
  })
  .catch(error => console.error(error));


