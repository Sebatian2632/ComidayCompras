/*
La clase "Receta" tiene un constructor con valores predeterminados para sus propiedades: nombre, duración, porción, tiempo, tipo, img, correo electrónico e identificador. También tiene métodos getter y setter para cada propiedad.
La clase "Ingrediente" tiene un constructor con valores predeterminados para sus propiedades: nombre e identificador. También tiene métodos getter y setter para cada propiedad.
Ambas clases se exportan para que puedan ser utilizadas en otros módulos.

The "Receta" class has a constructor with default values for its properties: name, duration, portion, time, type, img, email, and id. It also has getter and setter methods for each property.
The "Ingrediente" class has a constructor with default values for its properties: name and id. It also has getter and setter methods for each property.
Both classes are exported so they can be used in other modules.
*/
export class Receta {
    constructor() {
        this.name = "";
        this.duration = "";
        this.portion = "";
        this.time = "";
        this.type = "";
        this.img = "";
        this.email = "";
        this.id = undefined;
    }

    getName() {
        return this.name;
    }
    setName(name) {
        this.name = name;
    }
    getDuration() {
        return this.duration;
    }
    setDuration(duration) {
        this.duration = duration;
    }
    getPortion() {
        return this.portion;
    }
    setPortion(portion) {
        this.portion = portion;
    }
    getTime() {
        return this.time;
    }
    setTime(time) {
        this.time = time;
    }
    getType() {
        return this.type;
    }
    setType(type) {
        this.type = type;
    }
    getImage() {
        return this.img;
    }
    setImage(image) {
        this.img = image;
    }
    getEmail() {
        return this.email;
    }
    setEmail(email) {
        this.email = email;
    }
    getId() {
        return this.id;
    }
    setId(recipeId) {
        this.id = recipeId;
    }
}

export class Ingrediente {
    constructor() {
        this.name = "";
        this.unit = "";
        this.quantity = "";
        this.id = undefined;
    }

    getName() {
        return this.name;
    }
    setName(name) {
        this.name = name;
    }
    getId() {
        return this.id;
    }
    setId(recipeId) {
        this.id = recipeId;
    }
    getUnit() {
        return this.unit;
    }
    setUnit(unit) {
        this.unit = unit;
    }
    getQuantity() {
        return this.quantity;
    }
    setQuantity(quantity) {
        this.quantity = quantity;
    }
}
