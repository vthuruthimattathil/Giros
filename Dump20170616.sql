CREATE DATABASE  IF NOT EXISTS `gestion16` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `gestion16`;
-- MySQL dump 10.13  Distrib 5.6.13, for osx10.6 (i386)
--
-- Host: giros.ltma.lu    Database: gestion16
-- ------------------------------------------------------
-- Server version	5.5.55-0+deb7u1-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `CBNC`
--

DROP TABLE IF EXISTS `CBNC`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CBNC` (
  `NOCBNC` int(11) NOT NULL,
  `CODE_BRANCHE` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BRANCHE` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NUMBER` decimal(4,2) DEFAULT NULL,
  `CLASSE` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`NOCBNC`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CHAMBRE`
--

DROP TABLE IF EXISTS `CHAMBRE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CHAMBRE` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `L1` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `L2` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `L3` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `L4` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CHOIX`
--

DROP TABLE IF EXISTS `CHOIX`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CHOIX` (
  `NOCHOIX` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `NODESIDERATA` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `NOCBNC` int(11) NOT NULL,
  `ORDRE` tinyint(4) DEFAULT NULL,
  `SALLE` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NB_BLOCS` tinyint(4) DEFAULT NULL,
  `DUREE` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`NOCHOIX`),
  KEY `FK_desiderata_idx` (`NODESIDERATA`),
  KEY `fk_CHOIX_CBNC1_idx` (`NOCBNC`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CLASSE`
--

DROP TABLE IF EXISTS `CLASSE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CLASSE` (
  `CODE` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `REGENT` char(15) COLLATE utf8_unicode_ci NOT NULL,
  `SITE` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`CODE`),
  KEY `FK_regent_idx` (`REGENT`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CLUSTER`
--

DROP TABLE IF EXISTS `CLUSTER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CLUSTER` (
  `NOCLUSTER` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `UNTIS` char(15) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`NOCLUSTER`),
  KEY `fk_CLUSTER_PROF1_idx` (`UNTIS`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CLUSTER_ELEVE`
--

DROP TABLE IF EXISTS `CLUSTER_ELEVE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CLUSTER_ELEVE` (
  `NOCLUSTER` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `IAM` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  KEY `fk_CLUSTER_ELEVE_CLUSTER1_idx` (`NOCLUSTER`),
  KEY `fk_CLUSTER_ELEVE_ELEVE1_idx` (`IAM`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `COMMANDE`
--

DROP TABLE IF EXISTS `COMMANDE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `COMMANDE` (
  `NOCOMMANDE` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `UNTIS` char(15) COLLATE utf8_unicode_ci NOT NULL,
  `NAME` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MIMETYPE` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DATE` datetime DEFAULT NULL,
  `DELAI` datetime DEFAULT NULL,
  `TYPE` int(11) DEFAULT NULL,
  `COULEUR` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `REMARQUE` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PAGES` int(11) DEFAULT NULL,
  `DONE` datetime DEFAULT NULL,
  `SOURCE` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`NOCOMMANDE`),
  KEY `FK_untis_idx` (`UNTIS`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `COMMANDE_ELEVE`
--

DROP TABLE IF EXISTS `COMMANDE_ELEVE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `COMMANDE_ELEVE` (
  `NOCOMMANDE` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `IAM` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`NOCOMMANDE`,`IAM`),
  KEY `fk_COMMANDE_has_ELEVE_ELEVE1_idx` (`IAM`),
  KEY `fk_COMMANDE_has_ELEVE_COMMANDE1_idx` (`NOCOMMANDE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DATESD`
--

DROP TABLE IF EXISTS `DATESD`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DATESD` (
  `NODATED` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `SURVEILLANT` char(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DATED` datetime DEFAULT NULL,
  `SALLE` char(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NOMBREMAX` smallint(1) DEFAULT '15',
  `COMMENT` char(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RESERVATION` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE` smallint(1) DEFAULT '0',
  PRIMARY KEY (`NODATED`),
  KEY `UNTIS_idx` (`SURVEILLANT`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DATESR`
--

DROP TABLE IF EXISTS `DATESR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DATESR` (
  `NODATER` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `SURVEILLANT` char(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DATER` datetime DEFAULT NULL,
  `SALLE` char(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NOMBREMAX` smallint(11) DEFAULT '15',
  `COMMENT` char(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RESERVATION` varchar(45) COLLATE utf8_unicode_ci DEFAULT '',
  `SITE` enum('L','D') COLLATE utf8_unicode_ci DEFAULT 'L',
  PRIMARY KEY (`NODATER`),
  KEY `UNTIS_idx` (`SURVEILLANT`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DECHARGE`
--

DROP TABLE IF EXISTS `DECHARGE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DECHARGE` (
  `NODECHARGE` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `NODESIDERATA` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DESIGNATION` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NOMBRE` tinyint(4) DEFAULT NULL,
  `DEPARTEMENT` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`NODECHARGE`),
  KEY `FK_desiderata_idx` (`NODESIDERATA`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DESIDERATA`
--

DROP TABLE IF EXISTS `DESIDERATA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DESIDERATA` (
  `NODESIDERATA` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `UNTIS` char(15) COLLATE utf8_unicode_ci NOT NULL,
  `DONNESPERS` enum('T','F') COLLATE utf8_unicode_ci DEFAULT NULL,
  `TELEPHONE` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `GSM` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DISPO1` date DEFAULT NULL,
  `DISPO2` date DEFAULT NULL,
  `SPECIALITES` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BRANCHES` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TACHE` decimal(4,2) DEFAULT NULL,
  `RECRUTEMENT` enum('T','F') COLLATE utf8_unicode_ci DEFAULT NULL,
  `CONGE` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CO_DUREE` tinyint(4) DEFAULT NULL,
  `REM_BRANCHES` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `REGENCE1` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `REGENCE2` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RATTRAPAGE` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SURVEILLANCE` tinyint(4) DEFAULT NULL,
  `FOMOS` enum('T','F') COLLATE utf8_unicode_ci DEFAULT NULL,
  `ETUDES` tinyint(4) DEFAULT NULL,
  `PARASCOLAIRE` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DETACHEMENT` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DE_NOMBRE` tinyint(4) DEFAULT NULL,
  `EMPLOI` enum('A','C') COLLATE utf8_unicode_ci DEFAULT NULL,
  `REM_SPECIALES` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NEIGE` enum('T','F') COLLATE utf8_unicode_ci DEFAULT NULL,
  `REMISE` date DEFAULT NULL,
  `PREP_SURV_CANTINE` enum('T','F','X') COLLATE utf8_unicode_ci DEFAULT NULL,
  `PREP_SITES` tinyint(4) DEFAULT NULL,
  `RIZ` enum('T','F') COLLATE utf8_unicode_ci DEFAULT NULL,
  `HUELMES` enum('T','F') COLLATE utf8_unicode_ci DEFAULT NULL,
  `MER` enum('T','F') COLLATE utf8_unicode_ci DEFAULT NULL,
  `PORTES` enum('T','F') COLLATE utf8_unicode_ci DEFAULT NULL,
  `ANGLA9PR` enum('T','F') COLLATE utf8_unicode_ci DEFAULT NULL,
  `PAUSE` enum('T','F') COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`NODESIDERATA`),
  KEY `FK_untis_idx` (`UNTIS`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DEVOIR`
--

DROP TABLE IF EXISTS `DEVOIR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DEVOIR` (
  `NODEVOIR` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `IAM` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `NODATED` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `UNTIS` char(15) COLLATE utf8_unicode_ci NOT NULL,
  `BRANCHE` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DATEC` datetime DEFAULT NULL,
  `DUREE` smallint(1) DEFAULT NULL,
  `DATEI` datetime DEFAULT NULL,
  `PRESENT` smallint(1) DEFAULT '0',
  PRIMARY KEY (`NODEVOIR`),
  KEY `FK_matricule_idx` (`IAM`),
  KEY `FK_untis_idx` (`UNTIS`),
  KEY `FK_nodated_idx` (`NODATED`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DOCUMENT`
--

DROP TABLE IF EXISTS `DOCUMENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DOCUMENT` (
  `NO` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `NOTYPE` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NOM` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`NO`),
  KEY `FK_notype_idx` (`NOTYPE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ELEVE`
--

DROP TABLE IF EXISTS `ELEVE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ELEVE` (
  `IAM` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `CODE` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NOME` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PRENOME` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CREDIT` decimal(5,2) DEFAULT NULL,
  `NOMT` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PRENOMT` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LIEN` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RUE` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CP` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LOCALITE` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CIVILITE` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SEXE` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IAM`),
  KEY `FK_classe_idx` (`CODE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ELEVE_BAK`
--

DROP TABLE IF EXISTS `ELEVE_BAK`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ELEVE_BAK` (
  `IAM` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `CODE` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NOME` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PRENOME` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CREDIT` decimal(5,2) DEFAULT NULL,
  `NOMT` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PRENOMT` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LIEN` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RUE` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CP` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LOCALITE` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CIVILITE` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SEXE` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IAM`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ENSEIGNER`
--

DROP TABLE IF EXISTS `ENSEIGNER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ENSEIGNER` (
  `NOENSEIGNER` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `UNTIS` char(15) COLLATE utf8_unicode_ci NOT NULL,
  `CODE` char(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`NOENSEIGNER`,`CODE`,`UNTIS`),
  KEY `FK_untis_idx` (`UNTIS`),
  KEY `FK_code_idx` (`CODE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LETTRE`
--

DROP TABLE IF EXISTS `LETTRE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LETTRE` (
  `NOLETTRE` int(11) NOT NULL AUTO_INCREMENT,
  `UNTIS` char(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IAM` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DATEI` datetime DEFAULT NULL,
  `DATA` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NOTYPE` int(11) DEFAULT NULL,
  PRIMARY KEY (`NOLETTRE`),
  KEY `fk_LETTER_PROF1_idx` (`UNTIS`),
  KEY `fk_LETTER_ELEVE1_idx` (`IAM`)
) ENGINE=MyISAM AUTO_INCREMENT=160219 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `MOTIFS`
--

DROP TABLE IF EXISTS `MOTIFS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MOTIFS` (
  `NOMOTIF` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`NOMOTIF`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PROF`
--

DROP TABLE IF EXISTS `PROF`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PROF` (
  `UNTIS` char(15) COLLATE utf8_unicode_ci NOT NULL,
  `NOM` char(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PRENOM` char(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SEXE` enum('M','F') COLLATE utf8_unicode_ci DEFAULT 'F',
  `NOCASE` char(32) COLLATE utf8_unicode_ci DEFAULT '0',
  `SERVICE` bigint(4) DEFAULT '0',
  `DOCUMENTS` bigint(4) DEFAULT '0',
  `COMPOSITIONS` bigint(4) DEFAULT '0',
  `RETENUES` bigint(4) DEFAULT '0',
  `LETTRE` bigint(4) DEFAULT '0',
  `DIVERS` bigint(4) DEFAULT NULL,
  `DESIDERATA` bigint(4) DEFAULT '0',
  `FOLLOWUP` bigint(4) DEFAULT '0',
  PRIMARY KEY (`UNTIS`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `REGISTRY`
--

DROP TABLE IF EXISTS `REGISTRY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `REGISTRY` (
  `NOKEY` int(11) NOT NULL AUTO_INCREMENT,
  `UNTIS` char(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `REGKEY` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `REGVALUE` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`NOKEY`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `RETENUE`
--

DROP TABLE IF EXISTS `RETENUE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RETENUE` (
  `NORETENUE` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `IAM` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `UNTIS` char(15) COLLATE utf8_unicode_ci NOT NULL,
  `NODATER` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `MOTIF` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAIL` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `REGENT` smallint(1) DEFAULT '0',
  `PRESENT` smallint(1) DEFAULT '-1',
  `DATEI` datetime DEFAULT NULL,
  `NOREPORT` mediumtext COLLATE utf8_unicode_ci,
  `SUIVI` smallint(1) DEFAULT '-1',
  `CO` enum('X','S','NS','M') COLLATE utf8_unicode_ci DEFAULT 'X',
  PRIMARY KEY (`NORETENUE`),
  KEY `FK_matricule_idx` (`IAM`),
  KEY `FK_untis_idx` (`UNTIS`),
  KEY `FK_nodater_idx` (`NODATER`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SUIVI_ELEVE`
--

DROP TABLE IF EXISTS `SUIVI_ELEVE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SUIVI_ELEVE` (
  `NOPORTFOLIO` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `IAM` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SCOLAIRE` int(11) DEFAULT NULL,
  `INSCRIPTIONS_NB` int(11) DEFAULT '0',
  `INSCRIPTIONS_REM` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RET_BAGARRE` int(11) DEFAULT '0',
  `RET_RETARDS` int(11) DEFAULT '0',
  `RET_ABS` int(11) DEFAULT '0',
  `RET_CONF` int(11) DEFAULT '0',
  `RET_COMPORTEMENT` int(11) DEFAULT '0',
  `RET_FRAUDE` int(11) DEFAULT '0',
  `RET_INSOLENCE` int(11) DEFAULT '0',
  `RET_TABAGISME` int(11) DEFAULT '0',
  `RET_REFUS_PUNITION` int(11) DEFAULT '0',
  `RET_MENSONGES` int(11) DEFAULT '0',
  `RET_INSULTES` int(11) DEFAULT '0',
  `RET_OUBLIS` int(11) DEFAULT '0',
  `RET_AUTRES` int(11) DEFAULT '0',
  `RET_REM` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CONSEIL_NB` int(11) DEFAULT '0',
  `CONSEIL_REM` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ABS_EXC` int(11) DEFAULT '0',
  `ABS_EXC_MED` int(11) DEFAULT '0',
  `ABS_NON_EXC` int(11) DEFAULT '0',
  `ABS_REM` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MOSAIK` int(11) DEFAULT NULL,
  `PIT_INSULTES` int(11) DEFAULT '0',
  `PIT_DISPUTES` int(11) DEFAULT '0',
  `PIT_REFUS_TRAVAIL` int(11) DEFAULT '0',
  `PIT_JET` int(11) DEFAULT '0',
  `PIT_COMPORTEMENT` int(11) DEFAULT '0',
  `PIT_AUTRE` int(11) DEFAULT '0',
  `PIT_REM` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ORIENTATION` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `REMARQUES` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ELEVE_IAM` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`NOPORTFOLIO`),
  KEY `fk_SUIVI_ELEVE_ELEVE1_idx` (`ELEVE_IAM`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SUIVI_ELEVE_STAGE`
--

DROP TABLE IF EXISTS `SUIVI_ELEVE_STAGE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SUIVI_ELEVE_STAGE` (
  `NOSUIVIELEVESTAGE` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `NOPORTFOLIO` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `ENTREPRISE` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAIL` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PERIODE` date DEFAULT NULL,
  PRIMARY KEY (`NOSUIVIELEVESTAGE`),
  KEY `fk_SUIVI_ELEVES_STAGE_SUIVI_ELEVES1_idx` (`NOPORTFOLIO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TDOCUMENT`
--

DROP TABLE IF EXISTS `TDOCUMENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TDOCUMENT` (
  `NOTYPE` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`NOTYPE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TRAVAUX`
--

DROP TABLE IF EXISTS `TRAVAUX`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TRAVAUX` (
  `NOTRAVAIL` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`NOTRAVAIL`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-16 13:38:23
