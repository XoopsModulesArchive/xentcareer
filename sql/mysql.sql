# phpMyAdmin SQL Dump
# version 2.5.3
# http://www.phpmyadmin.net
#
# Serveur: localhost
# Généré le : Mardi 28 Septembre 2004 à 10:56
# Version du serveur: 4.0.15
# Version de PHP: 4.3.3
# 
# Base de données: `xoopsdev`
# 

# --------------------------------------------------------

#
# Structure de la table `xent_cr_cv`
#

CREATE TABLE `xent_cr_cv` (
    `ID`           INT(5)       NOT NULL AUTO_INCREMENT,
    `name`         VARCHAR(255) NOT NULL DEFAULT '',
    `family_name`  VARCHAR(255) NOT NULL DEFAULT '',
    `email`        VARCHAR(255) NOT NULL DEFAULT '',
    `address`      VARCHAR(255)          DEFAULT NULL,
    `city`         VARCHAR(255)          DEFAULT NULL,
    `province`     VARCHAR(255)          DEFAULT NULL,
    `country`      VARCHAR(255)          DEFAULT NULL,
    `zipcode`      VARCHAR(255)          DEFAULT NULL,
    `tel_home`     VARCHAR(255)          DEFAULT NULL,
    `tel_cell`     VARCHAR(255)          DEFAULT NULL,
    `tel_other`    VARCHAR(255)          DEFAULT NULL,
    `cv`           VARCHAR(255) NOT NULL DEFAULT '',
    `rec_letter`   VARCHAR(255)          DEFAULT NULL,
    `heard_odesia` VARCHAR(255)          DEFAULT NULL,
    `rec_name`     VARCHAR(255)          DEFAULT NULL,
    `rec_email`    VARCHAR(255)          DEFAULT NULL,
    `id_poste`     INT(5)       NOT NULL DEFAULT '0',
    KEY `ID` (`ID`)
)
    ENGINE = ISAM;

#
# Contenu de la table `xent_cr_cv`
#


# --------------------------------------------------------

#
# Structure de la table `xent_cr_job`
#

CREATE TABLE `xent_cr_job` (
    `id_job`       INT(5)  NOT NULL AUTO_INCREMENT,
    `id_titre`     INT(5)  NOT NULL DEFAULT '0',
    `id_typeposte` INT(5)  NOT NULL DEFAULT '0',
    `id_locations` INT(5)  NOT NULL DEFAULT '0',
    `posted_date`  INT(11) NOT NULL DEFAULT '0',
    `start_date`   INT(11) NOT NULL DEFAULT '0',
    `end_date`     INT(11) NOT NULL DEFAULT '0',
    `id_status`    INT(5)  NOT NULL DEFAULT '0',
    `description`  TEXT    NOT NULL,
    `exigence`     TEXT    NOT NULL,
    KEY `id_job` (`id_job`)
)
    ENGINE = ISAM;


#
# Contenu de la table `xent_cr_job`
#

# --------------------------------------------------------

#
# Structure de la table `xent_cr_reference`
#

CREATE TABLE `xent_cr_reference` (
    `id`            INT(5)       NOT NULL AUTO_INCREMENT,
    `reference_job` VARCHAR(255) NOT NULL DEFAULT '',
    KEY `id` (`id`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 6;

#
# Contenu de la table `xent_cr_reference`
#

INSERT INTO `xent_cr_reference`
VALUES (1, '------------------------');
INSERT INTO `xent_cr_reference`
VALUES (2, 'Monster');
INSERT INTO `xent_cr_reference`
VALUES (3, 'Jooboom');
INSERT INTO `xent_cr_reference`
VALUES (4, '[fr]Site web de l\'entreprise[/fr][en]Company website[/en]');
INSERT INTO `xent_cr_reference`
VALUES (5, '[fr]Recommandation d\'un employé[/fr][en]Employee recommandation[/en]');
INSERT INTO `xent_cr_reference`
VALUES (6, '[fr]Revues spécialisées[/fr][en]Specialized magazines[/en]');

# --------------------------------------------------------

#
# Structure de la table `xent_cr_status`
#

CREATE TABLE `xent_cr_status` (
    `id_status` INT(5)       NOT NULL AUTO_INCREMENT,
    `status`    VARCHAR(255) NOT NULL DEFAULT '',
    KEY `id_status` (`id_status`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 3;

#
# Contenu de la table `xent_cr_status`
#

INSERT INTO `xent_cr_status`
VALUES (1, 'Ouvert');
INSERT INTO `xent_cr_status`
VALUES (2, 'Fermé');
INSERT INTO `xent_cr_status`
VALUES (3, 'Occupé');

# --------------------------------------------------------
