
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- osoby
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `osoby`;


CREATE TABLE `osoby`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`nazwisko` VARCHAR(255)  NOT NULL,
	`imie` VARCHAR(255)  NOT NULL,
	`miejscowosc` INTEGER(11)  NOT NULL,
	`data_urodzenia` DATE  NOT NULL,
	`firma` INTEGER(11)  NOT NULL,
	`oddzial_firmy` INTEGER(11)  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	`updated_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `osoby_FI_1` (`miejscowosc`),
	CONSTRAINT `osoby_FK_1`
		FOREIGN KEY (`miejscowosc`)
		REFERENCES `miejscowosci` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `osoby_FI_2` (`firma`),
	CONSTRAINT `osoby_FK_2`
		FOREIGN KEY (`firma`)
		REFERENCES `firmy` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `osoby_FI_3` (`oddzial_firmy`),
	CONSTRAINT `osoby_FK_3`
		FOREIGN KEY (`oddzial_firmy`)
		REFERENCES `oddzialy_firmy` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- miejscowosci
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `miejscowosci`;


CREATE TABLE `miejscowosci`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`nazwa` VARCHAR(255)  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	`updated_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- firmy
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `firmy`;


CREATE TABLE `firmy`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`nazwa` VARCHAR(255)  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	`updated_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- oddzialy_firmy
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `oddzialy_firmy`;


CREATE TABLE `oddzialy_firmy`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`firma` INTEGER(11)  NOT NULL,
	`nazwa` VARCHAR(255)  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	`updated_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `oddzialy_firmy_FI_1` (`firma`),
	CONSTRAINT `oddzialy_firmy_FK_1`
		FOREIGN KEY (`firma`)
		REFERENCES `firmy` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Engine=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
