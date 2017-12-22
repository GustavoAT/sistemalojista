-- -----------------------------------------------------
-- Table `pos_servicetype`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pos_servicetype` ;

CREATE TABLE IF NOT EXISTS `pos_servicetype` (
  `servicetype_id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `service_cost` DOUBLE NULL,
  `comment` VARCHAR(100) NULL,
  PRIMARY KEY (`servicetype_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pos_service`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pos_service` ;

CREATE TABLE IF NOT EXISTS `pos_service` (
  `service_id` INT(10) NOT NULL,
  `servicetype_id` INT(10) NOT NULL,
  `person_id` INT(10) NULL,
  `start_time` TIMESTAMP NULL,
  `finish_time` TIMESTAMP NULL,
  `discount` DOUBLE NULL,
  PRIMARY KEY (`service_id`),
  INDEX `fk_service_servicetype1_idx` (`servicetype_id` ASC),
  INDEX `fk_service_customer_idx` (`person_id` ASC),
  CONSTRAINT `fk_service_servicetypr1`
    FOREIGN KEY (`servicetype_id`)
    REFERENCES `pos_servicetype` (`servicetype_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_service_customer`
    FOREIGN KEY (`person_id`)
    REFERENCES `pos_customers` (`person_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


- -----------------------------------------------------
-- Table `pos_doservice`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pos_doservice` ;

CREATE TABLE IF NOT EXISTS `pos_doservice` (
  `sevice_id` INT NOT NULL,
  `person_id` INT NOT NULL,
  PRIMARY KEY (`sevice_id`, `person_id`),
  INDEX `fk_doservice_service_idx` (`sevice_id` ASC),
  INDEX `fk_doservice_employee_id_idx` (`person_id` ASC),
  CONSTRAINT `fk_doservice_service_id`
    FOREIGN KEY (`sevice_id`)
    REFERENCES `pos_service` (`service_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_doservice_employee_id`
    FOREIGN KEY (`person_id`)
    REFERENCES `pos_employees` (`person_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pos_service_items`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pos_service_items` ;

CREATE TABLE IF NOT EXISTS `pos_service_items` (
  `service_id` INT(10) NOT NULL,
  `item_id` INT(10) NOT NULL,
  PRIMARY KEY (`service_id`, `item_id`),
  INDEX `fk_service_items_serviceidx` (`service_id` ASC),
  INDEX `fk_service_items_itemid_idx` (`item_id` ASC),
  CONSTRAINT `fk_service_items_serviceid`
    FOREIGN KEY (`service_id`)
    REFERENCES `pos_service` (`service_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_service_items_itemid`
    FOREIGN KEY (`item_id`)
    REFERENCES `pos_items` (`item_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


INSERT INTO `pos_modules` VALUES ('module_service','module_service_desc',15,'service'),('module_servicetype','module_servicetype_desc',95,'servicetype');
INSERT INTO `pos_permissions` VALUES ('service',1),('service',2);







