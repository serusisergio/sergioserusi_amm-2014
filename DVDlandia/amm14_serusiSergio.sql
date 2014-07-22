-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Lug 22, 2014 alle 12:03
-- Versione del server: 5.5.37
-- Versione PHP: 5.4.6-1ubuntu1.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `amm14_serusiSergio`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `casediscografiche`
--

CREATE TABLE IF NOT EXISTS `casediscografiche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomecasadiscografica` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `casediscografiche`
--

INSERT INTO `casediscografiche` (`id`, `nomecasadiscografica`) VALUES
(1, 'Universal'),
(2, 'Sony');

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomecategoria` varchar(45) DEFAULT NULL,
  `idcasadiscografica` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `casediscografiche_fk` (`idcasadiscografica`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`id`, `nomecategoria`, `idcasadiscografica`) VALUES
(1, 'Horror', 1),
(2, 'Drammatico', 1),
(3, 'Romantico', 2),
(4, 'XXX', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `clienti`
--

CREATE TABLE IF NOT EXISTS `clienti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) DEFAULT NULL,
  `cognome` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `via` varchar(128) DEFAULT NULL,
  `numero_civico` int(128) DEFAULT NULL,
  `citta` varchar(128) DEFAULT NULL,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `clienti`
--

INSERT INTO `clienti` (`id`, `nome`, `cognome`, `email`, `via`, `numero_civico`, `citta`, `username`, `password`) VALUES
(1, 'davide', 'spano', 'spano@unica.it', 'dante', 29, 'cagliari', 'cliente', 'spano');

-- --------------------------------------------------------

--
-- Struttura della tabella `dvdi`
--

CREATE TABLE IF NOT EXISTS `dvdi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcategoria` int(11) DEFAULT NULL,
  `anno` int(11) NOT NULL,
  `titolo` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_fk` (`idcategoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dump dei dati per la tabella `dvdi`
--

INSERT INTO `dvdi` (`id`, `idcategoria`, `anno`, `titolo`) VALUES
(1, 1, 2008, 'rembo'),
(2, 1, 2009, 'play'),
(3, 2, 2004, 'just'),
(4, 3, 1999, 'rambo'),
(5, 4, 1993, 'Biancaneve'),
(6, 1, 2003, 'screem '),
(7, 3, 2008, 'remember me');

-- --------------------------------------------------------

--
-- Struttura della tabella `gestori`
--

CREATE TABLE IF NOT EXISTS `gestori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) DEFAULT NULL,
  `cognome` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `via` varchar(128) DEFAULT NULL,
  `numero_civico` int(128) DEFAULT NULL,
  `citta` varchar(128) DEFAULT NULL,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `gestori`
--

INSERT INTO `gestori` (`id`, `nome`, `cognome`, `email`, `via`, `numero_civico`, `citta`, `username`, `password`) VALUES
(1, 'sergio', 'serusi', 'serusisergio@hotmail.com', 'nuoro', 31, 'simaxis', 'gestore', 'sergio');

-- --------------------------------------------------------

--
-- Struttura della tabella `noleggi`
--

CREATE TABLE IF NOT EXISTS `noleggi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idfilm` int(11) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `datainizio` date DEFAULT NULL,
  `datafine` date DEFAULT NULL,
  `costo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `film_fk` (`idfilm`),
  KEY `cliente_fk` (`idcliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `noleggi`
--

INSERT INTO `noleggi` (`id`, `idfilm`, `idcliente`, `datainizio`, `datafine`, `costo`) VALUES
(1, 2, 1, '2014-07-20', '2014-07-30', 3);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `categorie`
--
ALTER TABLE `categorie`
  ADD CONSTRAINT `casediscografiche_fk` FOREIGN KEY (`idcasadiscografica`) REFERENCES `casediscografiche` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `noleggi`
--
ALTER TABLE `noleggi`
  ADD CONSTRAINT `cliente_fk` FOREIGN KEY (`idcliente`) REFERENCES `clienti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `film_fk` FOREIGN KEY (`idfilm`) REFERENCES `dvdi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
