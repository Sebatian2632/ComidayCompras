-- MySQL Script generated by MySQL Workbench
-- Sun Mar 26 20:20:07 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema recetasDB
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `recetasDB` ;

-- -----------------------------------------------------
-- Schema recetasDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `recetasDB` DEFAULT CHARACTER SET utf8 ;
USE `recetasDB` ;

-- -----------------------------------------------------
-- Table `recetasDB`.`ingredientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasDB`.`ingredientes` ;

CREATE TABLE IF NOT EXISTS `recetasDB`.`ingredientes` (
  `idIngredientes` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idIngredientes`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `recetasDB`.`usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasDB`.`usuarios` ;

CREATE TABLE IF NOT EXISTS `recetasDB`.`usuarios` (
  `correo` VARCHAR(255) NOT NULL,
  `clave` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`correo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `recetasDB`.`recetas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasDB`.`recetas` ;

CREATE TABLE IF NOT EXISTS `recetasDB`.`recetas` (
  `idRecetas` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `duracion` VARCHAR(45) NOT NULL,
  `tiempo_comida` VARCHAR(45) NOT NULL,
  `tiempo_receta` VARCHAR(45) NOT NULL,
  `porciones` VARCHAR(45) NOT NULL,
  `imagen` VARCHAR(45) NULL,
  `Usuarios_correo` VARCHAR(255) NOT NULL,
  `caificacion` INT(11) NULL,
  PRIMARY KEY (`idRecetas`, `Usuarios_correo`),
  INDEX `fk_Recetas_Usuarios1_idx` (`Usuarios_correo` ASC),
  CONSTRAINT `fk_Recetas_Usuarios1`
    FOREIGN KEY (`Usuarios_correo`)
    REFERENCES `recetasDB`.`usuarios` (`correo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `recetasDB`.`pasos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasDB`.`pasos` ;

CREATE TABLE IF NOT EXISTS `recetasDB`.`pasos` (
  `idPasos` INT(11) NOT NULL AUTO_INCREMENT,
  `nopaso` VARCHAR(45) NOT NULL,
  `paso` TEXT NOT NULL,
  `imagen` VARCHAR(45) NULL,
  `Recetas_idRecetas` INT(11) NOT NULL,
  PRIMARY KEY (`idPasos`),
  INDEX `fk_Pasos_Recetas1_idx` (`Recetas_idRecetas` ASC),
  CONSTRAINT `fk_Pasos_Recetas1`
    FOREIGN KEY (`Recetas_idRecetas`)
    REFERENCES `recetasDB`.`recetas` (`idRecetas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `recetasDB`.`recetas_has_ingredientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recetasDB`.`recetas_has_ingredientes` ;

CREATE TABLE IF NOT EXISTS `recetasDB`.`recetas_has_ingredientes` (
  `Recetas_idRecetas` INT(11) NOT NULL,
  `Ingredientes_idIngredientes` INT(11) NOT NULL,
  `cantidad` FLOAT NOT NULL,
  `unidad_medida` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Recetas_idRecetas`, `Ingredientes_idIngredientes`),
  INDEX `fk_Recetas_has_Ingredientes_Ingredientes1_idx` (`Ingredientes_idIngredientes` ASC),
  INDEX `fk_Recetas_has_Ingredientes_Recetas1_idx` (`Recetas_idRecetas` ASC),
  CONSTRAINT `fk_Recetas_has_Ingredientes_Ingredientes1`
    FOREIGN KEY (`Ingredientes_idIngredientes`)
    REFERENCES `recetasDB`.`ingredientes` (`idIngredientes`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Recetas_has_Ingredientes_Recetas1`
    FOREIGN KEY (`Recetas_idRecetas`)
    REFERENCES `recetasDB`.`recetas` (`idRecetas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

