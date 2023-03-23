fetch('../php/ingredientes.php')
  .then(response => response.json())
  .then(data => {
    let ingre = data;
    let nombres = ingre.map(obj => obj.nombre);
    
    //los acomodamos alfabeticamente
    let sortingredients = nombres.sort();
    //reference
    let input = document.getElementById("ingredient");
    //Execute function on keyup
    input.addEventListener("keyup", (e) => {
        //loop through above array
        //Initially remove all elements ( so if user erases a letter or adds new letter then clean previous outputs)
        removeElements();
        for (let i of sortingredients) {
        //convert input to lowercase and compare with each string
            if (
                i.toLowerCase().includes(input.value.toLowerCase()) &&
                input.value != ""
            ) {
                //create li element
                let listItem = document.createElement("li");
                //One common class name
                listItem.classList.add("list-items");
                listItem.style.cursor = "pointer";
                //Display matched part in bold
                let word = "<b>" + i.substr(0, input.value.length) + "</b>";
                word += i.substr(input.value.length);
                //display the value in array
                listItem.innerHTML = word;
                document.querySelector(".list").appendChild(listItem);
                addListClickEvent(listItem, i);
            }
        }
    });
    function addListClickEvent(item, value) {
      item.addEventListener('click', function() {
        input.value = value;
        removeElements();
      });
    }
    function removeElements() {
        //clear all the item
        let items = document.querySelectorAll(".list-items");
        items.forEach((item) => {
        item.remove();
        });
    }
  })
  .catch(error => console.error(error));
