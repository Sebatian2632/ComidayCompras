-- MySQL Script generated by MySQL Workbench
-- Fri May 26 08:58:49 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema recetasdb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `recetasdb` ;

-- -----------------------------------------------------
-- Schema recetasdb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `recetasdb` DEFAULT CHARACTER SET utf8 ;
USE `recetasdb` ;

-- -----------------------------------------------------
-- Table `recetasdb`.`planeacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasdb`.`planeacion` ;

CREATE TABLE IF NOT EXISTS `recetasdb`.`planeacion` (
  `idplaneacion` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idplaneacion`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `recetasdb`.`grupo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasdb`.`grupo` ;

CREATE TABLE IF NOT EXISTS `recetasdb`.`grupo` (
  `idgrupo` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `clave` VARCHAR(45) NOT NULL,
  `planeacion_idplaneacion` INT NOT NULL,
  PRIMARY KEY (`idgrupo`),
  INDEX `fk_grupo_planeacion1_idx` (`planeacion_idplaneacion` ASC) ,
  CONSTRAINT `fk_grupo_planeacion1`
    FOREIGN KEY (`planeacion_idplaneacion`)
    REFERENCES `recetasdb`.`planeacion` (`idplaneacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `recetasdb`.`ingredientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasdb`.`ingredientes` ;

CREATE TABLE IF NOT EXISTS `recetasdb`.`ingredientes` (
  `idIngredientes` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idIngredientes`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `recetasdb`.`usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasdb`.`usuarios` ;

CREATE TABLE IF NOT EXISTS `recetasdb`.`usuarios` (
  `correo` VARCHAR(255) NOT NULL,
  `clave` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `planeacion_idplaneacion` INT NOT NULL,
  PRIMARY KEY (`correo`),
  INDEX `fk_usuarios_planeacion1_idx` (`planeacion_idplaneacion` ASC),
  CONSTRAINT `fk_usuarios_planeacion1`
    FOREIGN KEY (`planeacion_idplaneacion`)
    REFERENCES `recetasdb`.`planeacion` (`idplaneacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `recetasdb`.`recetas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasdb`.`recetas` ;

CREATE TABLE IF NOT EXISTS `recetasdb`.`recetas` (
  `idRecetas` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `duracion` VARCHAR(45) NOT NULL,
  `tiempo_comida` VARCHAR(45) NOT NULL,
  `tiempo_receta` VARCHAR(45) NOT NULL,
  `porciones` VARCHAR(45) NOT NULL,
  `Usuarios_correo` VARCHAR(255) NOT NULL,
  `calificacion` INT NULL DEFAULT NULL,
  `imagen` LONGBLOB NOT NULL,
  PRIMARY KEY (`idRecetas`, `Usuarios_correo`),
  INDEX `fk_Recetas_Usuarios1_idx` (`Usuarios_correo` ASC) ,
  CONSTRAINT `fk_Recetas_Usuarios1`
    FOREIGN KEY (`Usuarios_correo`)
    REFERENCES `recetasdb`.`usuarios` (`correo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `recetasdb`.`pasos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasdb`.`pasos` ;

CREATE TABLE IF NOT EXISTS `recetasdb`.`pasos` (
  `idPasos` INT NOT NULL AUTO_INCREMENT,
  `nopaso` VARCHAR(45) NOT NULL,
  `paso` TEXT NOT NULL,
  `imagen` LONGBLOB NULL DEFAULT NULL,
  `Recetas_idRecetas` INT NOT NULL,
  PRIMARY KEY (`idPasos`),
  INDEX `fk_Pasos_Recetas1_idx` (`Recetas_idRecetas` ASC),
  CONSTRAINT `fk_Pasos_Recetas1`
    FOREIGN KEY (`Recetas_idRecetas`)
    REFERENCES `recetasdb`.`recetas` (`idRecetas`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `recetasdb`.`recetas_has_ingredientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasdb`.`recetas_has_ingredientes` ;

CREATE TABLE IF NOT EXISTS `recetasdb`.`recetas_has_ingredientes` (
  `Recetas_idRecetas` INT NOT NULL,
  `Ingredientes_idIngredientes` INT NOT NULL,
  `cantidad` FLOAT NOT NULL,
  `unidad_medida` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Recetas_idRecetas`, `Ingredientes_idIngredientes`),
  INDEX `fk_Recetas_has_Ingredientes_Ingredientes1_idx` (`Ingredientes_idIngredientes` ASC),
  INDEX `fk_Recetas_has_Ingredientes_Recetas1_idx` (`Recetas_idRecetas` ASC),
  CONSTRAINT `fk_Recetas_has_Ingredientes_Ingredientes1`
    FOREIGN KEY (`Ingredientes_idIngredientes`)
    REFERENCES `recetasdb`.`ingredientes` (`idIngredientes`),
  CONSTRAINT `fk_Recetas_has_Ingredientes_Recetas1`
    FOREIGN KEY (`Recetas_idRecetas`)
    REFERENCES `recetasdb`.`recetas` (`idRecetas`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `recetasdb`.`usuario_has_grupo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasdb`.`usuario_has_grupo` ;

CREATE TABLE IF NOT EXISTS `recetasdb`.`usuario_has_grupo` (
  `id_grupo` INT NOT NULL AUTO_INCREMENT,
  `correo_usuario` VARCHAR(45) NOT NULL,
  `rol` VARCHAR(45) NOT NULL,
  INDEX `usuario_correo_idx` (`correo_usuario` ASC),
  INDEX `grupo_id_idx` (`id_grupo` ASC),
  CONSTRAINT `grupo_id`
    FOREIGN KEY (`id_grupo`)
    REFERENCES `recetasdb`.`grupo` (`idgrupo`),
  CONSTRAINT `usuario_correo`
    FOREIGN KEY (`correo_usuario`)
    REFERENCES `recetasdb`.`usuarios` (`correo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `recetasdb`.`usuario_has_ingredientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasdb`.`usuario_has_ingredientes` ;

CREATE TABLE IF NOT EXISTS `recetasdb`.`usuario_has_ingredientes` (
  `idDisponibles` INT NOT NULL AUTO_INCREMENT,
  `usuario_correo` VARCHAR(45) NOT NULL,
  `ingrediente_id` INT NOT NULL,
  `cantidad` INT NOT NULL,
  `unidad_medida` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idDisponibles`),
  INDEX `correo_idx` (`usuario_correo` ASC),
  INDEX `fk_usuario_has_ingredientes_1_idx` (`ingrediente_id` ASC) ,
  CONSTRAINT `ingredientesID`
    FOREIGN KEY (`ingrediente_id`)
    REFERENCES `recetasdb`.`ingredientes` (`idIngredientes`),
  CONSTRAINT `usuariocorreo`
    FOREIGN KEY (`usuario_correo`)
    REFERENCES `recetasdb`.`usuarios` (`correo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `recetasdb`.`recetas_has_planeacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasdb`.`recetas_has_planeacion` ;

CREATE TABLE IF NOT EXISTS `recetasdb`.`recetas_has_planeacion` (
  `recetas_idRecetas` INT NOT NULL,
  `recetas_Usuarios_correo` VARCHAR(255) NOT NULL,
  `planeacion_idplaneacion` INT NOT NULL,
  `no_porciones` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`recetas_idRecetas`, `recetas_Usuarios_correo`, `planeacion_idplaneacion`),
  INDEX `fk_recetas_has_planeacion_planeacion1_idx` (`planeacion_idplaneacion` ASC) ,
  INDEX `fk_recetas_has_planeacion_recetas1_idx` (`recetas_idRecetas` ASC, `recetas_Usuarios_correo` ASC),
  CONSTRAINT `fk_recetas_has_planeacion_recetas1`
    FOREIGN KEY (`recetas_idRecetas` , `recetas_Usuarios_correo`)
    REFERENCES `recetasdb`.`recetas` (`idRecetas` , `Usuarios_correo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_recetas_has_planeacion_planeacion1`
    FOREIGN KEY (`planeacion_idplaneacion`)
    REFERENCES `recetasdb`.`planeacion` (`idplaneacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;

-- Crear la tabla "alergias"
CREATE TABLE IF NOT EXISTS `recetasdb`.`alergias` (
  `idalergia` INT NOT NULL AUTO_INCREMENT,
  `alergico` BOOLEAN NOT NULL,
  `usuarios_correo` VARCHAR(255) NOT NULL,
  `ingredientes_idIngredientes` INT NOT NULL,
  PRIMARY KEY (`idalergia`),
  INDEX `fk_alergias_usuarios1_idx` (`usuarios_correo` ASC),
  INDEX `fk_alergias_ingredientes1_idx` (`ingredientes_idIngredientes` ASC),
  CONSTRAINT `fk_alergias_usuarios1`
    FOREIGN KEY (`usuarios_correo`)
    REFERENCES `recetasdb`.`usuarios` (`correo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alergias_ingredientes1`
    FOREIGN KEY (`ingredientes_idIngredientes`)
    REFERENCES `recetasdb`.`ingredientes` (`idIngredientes`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
