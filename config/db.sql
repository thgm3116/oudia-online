-- MySQL Script generated by MySQL Workbench
-- Sun Mar 11 21:58:42 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema oudia_viewer_online
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema oudia_viewer_online
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `oudia_viewer_online` DEFAULT CHARACTER SET utf8 ;
USE `oudia_viewer_online` ;

-- -----------------------------------------------------
-- Table `oudia_viewer_online`.`station`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oudia_viewer_online`.`station` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `type` VARCHAR(255) NOT NULL,
  `scale` VARCHAR(255) NOT NULL,
  `dia_file_id` INT NOT NULL,
  `status` TINYINT(1) NOT NULL,
  `created` DATETIME NOT NULL,
  `updated` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `oudia_viewer_online`.`train_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oudia_viewer_online`.`train_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `shortName` VARCHAR(255) NOT NULL,
  `timetableColor` VARCHAR(255) NOT NULL,
  `timetableFont` VARCHAR(255) NOT NULL,
  `idInFile` TINYINT(3) NOT NULL,
  `dia_file_id` INT NOT NULL,
  `status` TINYINT(1) NOT NULL,
  `created` DATETIME NOT NULL,
  `updated` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `oudia_viewer_online`.`dia_file`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oudia_viewer_online`.`dia_file` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `filename` VARCHAR(255) NOT NULL,
  `linename` VARCHAR(255) NOT NULL,
  `status` TINYINT(1) NOT NULL,
  `created` DATETIME NOT NULL,
  `updated` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `oudia_viewer_online`.`dia_group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oudia_viewer_online`.`dia_group` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dia_file_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `status` TINYINT(1) NOT NULL,
  `created` DATETIME NOT NULL,
  `updated` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `oudia_viewer_online`.`train`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oudia_viewer_online`.`train` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `identification_id` VARCHAR(255) NOT NULL,
  `train_type_id` INT NOT NULL,
  `distance` VARCHAR(6) NOT NULL,
  `bikou` VARCHAR(255) NOT NULL,
  `last_station_id` INT NOT NULL,
  `dia_group_id` INT NOT NULL,
  `status` TINYINT(1) NOT NULL,
  `created` DATETIME NOT NULL,
  `updated` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `oudia_viewer_online`.`dia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oudia_viewer_online`.`dia` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `station_id` INT NOT NULL,
  `train_id` INT NOT NULL,
  `departureTime` VARCHAR(4) NOT NULL,
  `arrivalTime` VARCHAR(4) NOT NULL,
  `type` TINYINT(2) NOT NULL,
  `isFirstDia` TINYINT(1) NOT NULL,
  `isLastDia` TINYINT(1) NOT NULL,
  `status` TINYINT(1) NOT NULL,
  `created` DATETIME NOT NULL,
  `updated` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
