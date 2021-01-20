-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2018 at 04:46 PM
-- Server version: 5.6.15-log
-- PHP Version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `easyskul_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE IF NOT EXISTS `academic_years` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `ACADEMIC YEAR` varchar(234) NOT NULL,
  `TERM` varchar(234) NOT NULL,
  `STATUS` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `account_renewals`
--

CREATE TABLE IF NOT EXISTS `account_renewals` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(243) NOT NULL,
  `ADMIN ID` varchar(344) NOT NULL,
  `RENEWAL DATE` date NOT NULL,
  `OPERATION` varchar(342) NOT NULL,
  `UNIT PRICE` double NOT NULL,
  `QUANTITY` double NOT NULL,
  `AMOUNT` double NOT NULL,
  `DATE` date NOT NULL,
  `TIME` varchar(342) NOT NULL,
  `RECEIPT NUMBER` varchar(342) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `admitted_students`
--

CREATE TABLE IF NOT EXISTS `admitted_students` (
  `NO` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `ENTRY BY` varchar(234) NOT NULL,
  `ADMISSION NO / ID` varchar(3423) NOT NULL,
  `STUDENT LAST NAME` varchar(1234) NOT NULL,
  `STUDENT  FIRST NAME` varchar(1234) NOT NULL,
  `STD DATE OF BIRTH` date NOT NULL,
  `HOME TOWN` varchar(1344) NOT NULL,
  `NATIONALITY` varchar(1234) NOT NULL,
  `STD RELIGIOUS DENOMINATION` varchar(1234) NOT NULL,
  `FORMER SCHOOL` varchar(1234) NOT NULL,
  `DATE OF ADMISSION` date NOT NULL,
  `PRESENT CLASS` varchar(1344) NOT NULL,
  `PHOTO` varchar(344) NOT NULL,
  `GENDER` varchar(234) NOT NULL,
  `GUARDIAN NAME` varchar(234) NOT NULL,
  `GUARDIAN ADDRESS` text NOT NULL,
  `GUARDIAN OCCUPATION` varchar(2342) NOT NULL,
  `GUARDIAN TEL` varchar(234) NOT NULL,
  `GUARDIAN RD` varchar(234) NOT NULL,
  `GUARDIAN RELATIONSHIP STATUS` varchar(234) NOT NULL,
  `STUDENT DISABILITIES` varchar(234) NOT NULL,
  `ADMISSION FEE` double NOT NULL,
  `PAIDDATE` date NOT NULL,
  `ACADEMIC YEAR` varchar(10) NOT NULL,
  `YEAR OF ADMISSION` int(11) NOT NULL,
  PRIMARY KEY (`NO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `STUDENT ID` varchar(234) NOT NULL,
  `STUDENT NAME` varchar(234) NOT NULL,
  `CLASS` varchar(234) NOT NULL,
  `DATE` date NOT NULL,
  `TEACHER` varchar(234) NOT NULL,
  `ACADEMIC YEAR` varchar(234) NOT NULL,
  `TERM` varchar(234) NOT NULL,
  `STATUS` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE IF NOT EXISTS `bills` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(233) NOT NULL,
  `STUDENT ID` varchar(332) NOT NULL,
  `STUDENT NAME` varchar(234) NOT NULL,
  `CLASS` varchar(45) NOT NULL,
  `ITEM` varchar(123) NOT NULL,
  `PRICE` double NOT NULL,
  `QUANTITY` int(11) NOT NULL,
  `ACADEMIC YEAR` varchar(234) NOT NULL,
  `TERM` varchar(233) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(123) NOT NULL,
  `CLASS` varchar(123) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE IF NOT EXISTS `currencies` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `COUNTRY` varchar(234) NOT NULL,
  `CURRENCY` varchar(23) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cusers`
--

CREATE TABLE IF NOT EXISTS `cusers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(234) NOT NULL,
  `password` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cusers`
--

INSERT INTO `cusers` (`ID`, `user`, `password`) VALUES
(1, 'easyskulAdmin', 'e9c98d5d6658a9e306198143a75b3a88');

-- --------------------------------------------------------

--
-- Table structure for table `daily_feeding_fee`
--

CREATE TABLE IF NOT EXISTS `daily_feeding_fee` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(344) NOT NULL,
  `AMOUNT` double NOT NULL,
  `DATE` date NOT NULL,
  `DAYS` int(11) NOT NULL,
  `STUDENT ID` varchar(3243) NOT NULL,
  `STUDENT NAME` varchar(2342) NOT NULL,
  `CLASS` varchar(234) NOT NULL,
  `ACADEMIC YEAR` varchar(243) NOT NULL,
  `TERM` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `daily_fees_payments`
--

CREATE TABLE IF NOT EXISTS `daily_fees_payments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `ACADEMIC YEAR` varchar(234) NOT NULL,
  `TERM` varchar(234) NOT NULL,
  `STUDENT ID` varchar(34234) NOT NULL,
  `STUDENT NAME` varchar(234) NOT NULL,
  `CLASS` varchar(234) NOT NULL,
  `DATE` date NOT NULL,
  `TIME` varchar(234) NOT NULL,
  `AMOUNT PAID` double NOT NULL,
  `CREDIT` double NOT NULL,
  `DEBIT` double NOT NULL,
  `PAID BY` varchar(234) NOT NULL,
  `RECEIVED BY` varchar(234) NOT NULL,
  `RECEIPT NUMBER` varchar(234) NOT NULL,
  `GENERATED` varchar(23) NOT NULL,
  `BEIGN` varchar(243) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(2342) NOT NULL,
  `POSTED BY` varchar(234) NOT NULL,
  `DATE` date NOT NULL,
  `END DATE` date NOT NULL,
  `EVENT` varchar(234) NOT NULL,
  `COLOR` varchar(345) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `ITEM` varchar(234) NOT NULL,
  `UNIT PRICE` double NOT NULL,
  `QUANTITY` int(11) NOT NULL,
  `TOTAL AMOUNT` double NOT NULL,
  `DATE` date NOT NULL,
  `USER ID` varchar(34) NOT NULL,
  `STATUS` varchar(34) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `feeding_fee`
--

CREATE TABLE IF NOT EXISTS `feeding_fee` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(344) NOT NULL,
  `AMOUNT` double NOT NULL,
  `DATE` date NOT NULL,
  `DAYS LEFT` int(11) NOT NULL,
  `STUDENT ID` varchar(3243) NOT NULL,
  `STUDENT NAME` varchar(2342) NOT NULL,
  `ACADEMIC YEAR` varchar(243) NOT NULL,
  `TERM` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `grading_system`
--

CREATE TABLE IF NOT EXISTS `grading_system` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `CLASS MARK` double NOT NULL,
  `EXAM MARK` double NOT NULL,
  `PASS MARK` double NOT NULL,
  `PROBATION MARK` double NOT NULL,
  `A` double NOT NULL,
  `B` double NOT NULL,
  `C` double NOT NULL,
  `D` double NOT NULL,
  `E` double NOT NULL,
  `F` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE IF NOT EXISTS `histories` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `USER ID` varchar(234) NOT NULL,
  `OPERATION` varchar(234) NOT NULL,
  `DATE` date NOT NULL,
  `TIME` varchar(234) NOT NULL,
  `ACTION` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `library_books`
--

CREATE TABLE IF NOT EXISTS `library_books` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(244) NOT NULL,
  `BOOK NUMBER` varchar(234) NOT NULL,
  `BOOK NAME` varchar(234) NOT NULL,
  `SHELF NUMBER` varchar(243) NOT NULL,
  `PUBLISHER` varchar(234) NOT NULL,
  `CATEGORY` varchar(234) NOT NULL,
  `STATUS` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `library_books_status`
--

CREATE TABLE IF NOT EXISTS `library_books_status` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `BOOK NUMBER` varchar(234) NOT NULL,
  `SHELF NUMBER` varchar(234) NOT NULL,
  `STUDENT ID` varchar(234) NOT NULL,
  `STUDENT NAME` varchar(234) NOT NULL,
  `DATE GIVEN` date NOT NULL,
  `TIME GIVEN` varchar(234) NOT NULL,
  `DATE RETURNED` date NOT NULL,
  `TIME RETURNED` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `main admins`
--

CREATE TABLE IF NOT EXISTS `main admins` (
  `NO` int(11) NOT NULL AUTO_INCREMENT,
  `ADMIN ID` varchar(234) NOT NULL,
  `ADMIN NAME` varchar(234) NOT NULL,
  `ADMIN EMAIL` varchar(234) NOT NULL,
  `ADMIN NUMBER` varchar(243) NOT NULL,
  `ADMIN PASSWORD` varchar(234) NOT NULL,
  `REGISTRATION STAGE` varchar(234) NOT NULL,
  `ADMIN PHOTO` varchar(234) NOT NULL,
  `REGISTRATION DATE` date NOT NULL,
  `LAST LOGIN DATE` date NOT NULL,
  `LAST LOGIN TIME` time NOT NULL,
  PRIMARY KEY (`NO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `marksheet`
--

CREATE TABLE IF NOT EXISTS `marksheet` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `CLASS` varchar(223) NOT NULL,
  `STUDENT ID` varchar(123) NOT NULL,
  `ACADEMIC YEAR` varchar(123) NOT NULL,
  `TERM` varchar(123) NOT NULL,
  `SUBJECT` varchar(234) NOT NULL,
  `MARKS` double NOT NULL,
  `MARKSHEET` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `noticeboard`
--

CREATE TABLE IF NOT EXISTS `noticeboard` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(2342) NOT NULL,
  `POSTED BY` varchar(234) NOT NULL,
  `INFO` text NOT NULL,
  `DATE PUBLISHED` date NOT NULL,
  `TIME` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_invoices`
--

CREATE TABLE IF NOT EXISTS `payment_invoices` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(324) NOT NULL,
  `USER ID` varchar(234) NOT NULL,
  `MOBILE MONEY NUMBER` varchar(244) NOT NULL,
  `INVOICE NUMBER` varchar(1109) NOT NULL,
  `DATE` date NOT NULL,
  `OPERATION` varchar(234) NOT NULL,
  `UNIT PRICE` double NOT NULL,
  `QUANTITY` int(11) NOT NULL,
  `STATUS` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `renewal_vouchers`
--

CREATE TABLE IF NOT EXISTS `renewal_vouchers` (
  `NO` int(11) NOT NULL AUTO_INCREMENT,
  `VOUCHER CODE` varchar(234) NOT NULL,
  `EXPIRY DATE` date NOT NULL,
  `USED` varchar(234) NOT NULL,
  PRIMARY KEY (`NO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `results_vouchers`
--

CREATE TABLE IF NOT EXISTS `results_vouchers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(234) NOT NULL,
  `USED` varchar(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `school_details`
--

CREATE TABLE IF NOT EXISTS `school_details` (
  `NO` int(11) NOT NULL AUTO_INCREMENT,
  `ADMIN EMAIL` varchar(234) NOT NULL,
  `SCHOOL NAME` varchar(234) NOT NULL,
  `SCHOOL NUMBERS` varchar(234) NOT NULL,
  `SCHOOL ADDRESS` varchar(234) NOT NULL,
  `SCHOOL MOTO` varchar(234) NOT NULL,
  `COUNTRY` varchar(234) NOT NULL,
  `CITY/TOWN` varchar(234) NOT NULL,
  `CREST` varchar(234) NOT NULL,
  `INITIALS` varchar(3) NOT NULL,
  `RENEWAL DATE` date NOT NULL,
  PRIMARY KEY (`NO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `school_entered_vouchers`
--

CREATE TABLE IF NOT EXISTS `school_entered_vouchers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(24) NOT NULL,
  `DATE RENEWED` date NOT NULL,
  `EXPIRY DATE` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `school_fees`
--

CREATE TABLE IF NOT EXISTS `school_fees` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `CLASS` varchar(234) NOT NULL,
  `AMOUNT` double NOT NULL,
  `STUDENT NAME` varchar(234) NOT NULL,
  `STUDENT ID` varchar(234) NOT NULL,
  `ACADEMIC YEAR` varchar(234) NOT NULL,
  `TERM` varchar(234) NOT NULL,
  `PAYMENT` double NOT NULL,
  `DEBIT` double NOT NULL,
  `CREDIT` double NOT NULL,
  `STATUS` varchar(34) NOT NULL,
  `FROM` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shelves`
--

CREATE TABLE IF NOT EXISTS `shelves` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `SHELF NUMBER` varchar(2344) NOT NULL,
  `BOOKS CATEGORIES` text NOT NULL,
  `TOTAL BOOKS` int(11) NOT NULL,
  `BOOKS GIVEN` int(11) NOT NULL,
  `BOOKS LEFT` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sms_cost`
--

CREATE TABLE IF NOT EXISTS `sms_cost` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UNIT PRICE` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sms_credit`
--

CREATE TABLE IF NOT EXISTS `sms_credit` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(244) NOT NULL,
  `SMS LEFT` int(11) NOT NULL,
  `SMS USED` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE IF NOT EXISTS `staffs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `STAFF NAME` varchar(234) NOT NULL,
  `POSITION` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `SUBJECT NAME` varchar(234) NOT NULL,
  `TEACHER` varchar(234) NOT NULL,
  `CLASS` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(255) NOT NULL,
  `TEACHER ID` varchar(255) NOT NULL,
  `FIRST NAME` varchar(150) NOT NULL,
  `LAST NAME` varchar(150) NOT NULL,
  `DATE OF BIRTH` date NOT NULL,
  `GENDER` varchar(10) NOT NULL,
  `AGE` int(20) NOT NULL,
  `CONTACT` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `ADDRESS` varchar(255) NOT NULL,
  `TEACHER CLASS` varchar(255) NOT NULL,
  `CITY` varchar(255) NOT NULL,
  `COUNTRY` varchar(255) NOT NULL,
  `REGISTERATION DATE` date NOT NULL,
  `JOB TYPE` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `terminal_reports`
--

CREATE TABLE IF NOT EXISTS `terminal_reports` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `CLASS` varchar(234) NOT NULL,
  `STUDENT ID` varchar(234) NOT NULL,
  `STUDENT NAME` varchar(234) NOT NULL,
  `ACADEMIC YEAR` varchar(234) NOT NULL,
  `TERM` varchar(234) NOT NULL,
  `SUBJECT` varchar(234) NOT NULL,
  `CLASS SCORE` double NOT NULL,
  `EXAM SCORE` double NOT NULL,
  `TOTAL SCORE` double NOT NULL,
  `POSITION` varchar(342) NOT NULL,
  `GRADE` varchar(3) NOT NULL,
  `REMARKS` varchar(342) NOT NULL,
  `TERM END` date NOT NULL,
  `TERM BEGINS` date NOT NULL,
  `PROMOTION` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `terminal_reports_av`
--

CREATE TABLE IF NOT EXISTS `terminal_reports_av` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(345) NOT NULL,
  `CLASS` varchar(345) NOT NULL,
  `STUDENT ID` varchar(345) NOT NULL,
  `STUDENT NAME` varchar(234) NOT NULL,
  `ACADEMIC YEAR` varchar(354) NOT NULL,
  `TERM` varchar(345) NOT NULL,
  `OVERALL POSITION` varchar(345) NOT NULL,
  `AVERAGE MARK` double NOT NULL,
  `PROMOTION STATUS` varchar(44) NOT NULL,
  `VIEWED` varchar(234) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `time_table`
--

CREATE TABLE IF NOT EXISTS `time_table` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ACADEMIC YEAR` varchar(231) NOT NULL,
  `TERM` varchar(112) NOT NULL,
  `SCHOOL` varchar(234) NOT NULL,
  `CLASS` varchar(112) NOT NULL,
  `FILE` varchar(342) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_2` (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transport_fee`
--

CREATE TABLE IF NOT EXISTS `transport_fee` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SCHOOL` varchar(234) NOT NULL,
  `AMOUNT` double NOT NULL,
  `DATE` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `NO` int(11) NOT NULL AUTO_INCREMENT,
  `USER ID` varchar(234) NOT NULL,
  `PASSWORD` varchar(2342) NOT NULL,
  `PASSWORD RECOVERY` varchar(255) NOT NULL,
  `SCHOOL` varchar(255) NOT NULL,
  `USER NAME` varchar(255) NOT NULL,
  `POSITION` varchar(255) NOT NULL,
  `CONTACT` varchar(255) NOT NULL,
  `GENDER` varchar(10) NOT NULL,
  `EMAIL` varchar(150) NOT NULL,
  `ADDRESS` varchar(255) NOT NULL,
  `USER IP` varchar(342) NOT NULL,
  `LOGIN DATE` date NOT NULL,
  `LOGIN TIME` time NOT NULL,
  `IP ADDRESS` varchar(234) NOT NULL,
  PRIMARY KEY (`NO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
