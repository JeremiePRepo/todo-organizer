-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema todo.local
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema todo.local
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `todo.local` DEFAULT CHARACTER SET utf8 ;
USE `todo.local` ;

-- -----------------------------------------------------
-- Table `todo.local`.`task`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `todo.local`.`task` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `todo.local`.`ponderator`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `todo.local`.`ponderator` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `coefficient` INT(10) UNSIGNED NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `todo.local`.`pon_tas_link`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `todo.local`.`pon_tas_link` (
  `fk_ponderator` INT UNSIGNED NOT NULL,
  `fk_task` INT UNSIGNED NOT NULL,
  INDEX `link_to_pon_idx` (`fk_ponderator` ASC),
  INDEX `link_to_tas_idx` (`fk_task` ASC),
  CONSTRAINT `link_to_pon`
    FOREIGN KEY (`fk_ponderator`)
    REFERENCES `todo.local`.`ponderator` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `link_to_tas`
    FOREIGN KEY (`fk_task`)
    REFERENCES `todo.local`.`task` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
