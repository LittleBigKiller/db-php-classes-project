-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql.ct8.pl
-- Czas generowania: 17 Lis 2019, 19:24
-- Wersja serwera: 5.7.26-29-log
-- Wersja PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `m10080_as-projekt`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `answers`
--

CREATE TABLE `answers` (
  `aid` int(11) NOT NULL,
  `contents` varchar(256) COLLATE utf8_polish_ci NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `qid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `answers`
--

INSERT INTO `answers` (`aid`, `contents`, `is_correct`, `qid`) VALUES
(1, '<background=\"\"></background>', 1, 1),
(2, '<body bgcolor=\"\"></body>', 0, 1),
(3, '<bgcolor=\"\"></bgcolor>', 0, 1),
(5, 'Reguła', 0, 2),
(6, 'Wyzwalacz', 0, 2),
(7, 'Procedura składowa', 0, 2),
(8, 'Funkcja zdefiniowana', 1, 2),
(9, 'TESTTESTTEST', 0, 0),
(10, 'TESTTESTTEST', 0, 0),
(11, 'TEST TEST TEST', 0, 0),
(15, 'TEST TEST TEST', 1, 11),
(16, 'TEST TEST TEST', 0, 11),
(17, 'YEETYEET', 0, 11),
(18, 'kek', 0, 11),
(19, 'Błędna 0', 0, 20),
(20, 'Błedna 1', 0, 20),
(21, 'Błedna 2', 0, 20),
(22, 'Poprawna', 1, 20),
(23, 'Błedna 0', 0, 12),
(24, 'Poprawna', 1, 12),
(25, 'Błedna 1', 0, 12),
(26, 'Błedna 2', 0, 12),
(27, 'Błedna 0', 0, 13),
(28, 'Błedna 1', 0, 13),
(29, 'Poprawna', 1, 13),
(30, 'Błedna 2', 0, 13),
(31, 'Poprawna', 1, 14),
(32, 'Błedna 0', 0, 14),
(33, 'Błedna 1', 0, 14),
(34, 'Błedna 2', 0, 14),
(35, 'Błedna 0', 0, 15),
(36, 'Błedna 1', 0, 15),
(37, 'Błedna 2', 0, 15),
(38, 'Poprawna', 1, 15),
(39, 'Błedna 0', 0, 16),
(40, 'Poprawna', 1, 16),
(41, 'Błedna 1', 0, 16),
(42, 'Błedna 2', 0, 16),
(43, 'Błedna 0', 0, 17),
(44, 'Błedna 1', 0, 17),
(45, 'Poprawna', 1, 17),
(46, 'Błedna 2', 0, 17),
(47, 'Błedna 0', 0, 18),
(48, 'Poprawna', 1, 18),
(49, 'Błedna 1', 0, 18),
(50, 'Błedna 2', 0, 18),
(51, 'Błedna 0', 0, 19),
(52, 'Błedna 1', 0, 19),
(53, 'Błedna 2', 0, 19),
(54, 'Poprawna', 1, 19),
(55, 'Błedna 0', 0, 21),
(56, 'Poprawna', 1, 21),
(57, 'Błedna 1', 0, 21),
(58, 'Błedna 2', 0, 21),
(59, 'Poprawna', 1, 22),
(60, 'Błędna 0', 0, 22),
(61, 'Błędna 1', 0, 22),
(62, 'Błędna 2', 0, 22),
(63, 'Błędna 0', 0, 23),
(64, 'Błędna 1', 0, 23),
(65, 'Błędna 2', 0, 23),
(66, 'Poprawna', 1, 23),
(67, 'Błędna 0', 0, 24),
(68, 'Błędna 1', 0, 24),
(69, 'Poprawna', 1, 24),
(70, 'Błędna 2', 0, 24),
(71, 'Błędna 0', 0, 26),
(72, 'Błędna 1', 0, 26),
(73, 'Błędna 2', 0, 26),
(74, 'Poprawna', 1, 26),
(75, 'Poprawna', 1, 25),
(76, 'Błędna 0', 0, 25),
(77, 'Błędna 1', 0, 25),
(78, 'Błędna 2', 0, 25);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `questions`
--

CREATE TABLE `questions` (
  `qid` int(11) NOT NULL,
  `contents` varchar(256) COLLATE utf8_polish_ci NOT NULL,
  `ans_correct` int(11) NOT NULL,
  `ans_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `questions`
--

INSERT INTO `questions` (`qid`, `contents`, `ans_correct`, `ans_total`) VALUES
(12, 'Pytanie 01', 2, 2),
(13, 'Pytanie 02', 1, 1),
(14, 'Pytanie 03', 2, 2),
(15, 'Pytanie 04', 0, 2),
(16, 'Pytanie 05', 2, 2),
(17, 'Pytanie 06', 0, 0),
(18, 'Pytanie 07', 1, 2),
(19, 'Pytanie 08', 0, 0),
(20, 'Pytanie 09', 0, 1),
(21, 'Pytanie 10', 1, 1),
(22, 'Pytanie 11', 2, 2),
(23, 'Pytanie 12', 1, 2),
(24, 'Pytanie 13', 0, 2),
(25, 'Pytanie 14', 0, 0),
(26, 'Pytanie 15', 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `results`
--

CREATE TABLE `results` (
  `rid` int(11) NOT NULL,
  `ans_correct` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `results`
--

INSERT INTO `results` (`rid`, `ans_correct`, `uid`, `timestamp`) VALUES
(1, 10, 20, 0),
(4, 5, 21, 1574014270),
(5, 8, 21, 1574014545);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `username` varchar(15) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_polish_ci NOT NULL,
  `salt` varchar(256) COLLATE utf8_polish_ci NOT NULL,
  `perm_level` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `salt`, `perm_level`) VALUES
(5, 'user01', 'b75705d7e35e7014521a46b532236ec3', '', 0),
(6, 'user02', '8bd108c8a01a892d129c52484ef97a0d', '', 0),
(7, 'user03', 'a7d39043afa25be5cc235d943b64917a', '', 0),
(8, 'user04', '9e3526e252e6d5914ec1bdaabc680436', '', 0),
(9, 'user05', 'fe510823ea9f953fbc758c714247a63b', '', 0),
(10, 'user06', '29a4b79bd438555382de11012a82136e', '', 0),
(11, 'user07', 'ac805b8ff22f71374ceac37684235925', '', 0),
(12, 'user08', 'e0141ba2f1770f9b6d40a497fbe4e25b', '', 0),
(13, 'user09', '29afa505abfb7edb3776b06e6d8e02e2', '', 0),
(14, 'user10', '990d67a9f94696b1abe2dccf06900322', '', 0),
(15, 'user11', '03aa1a0b0375b0461c1b8f35b234e67a', '', 0),
(16, 'user12', 'd781eaae8248db6ce1a7b82e58e60435', '', 0),
(17, 'user13', 'd09979d794a6ee60d836f884739f7196', '', 0),
(18, 'user14', 'd09979d794a6ee60d836f884739f7196', '', 0),
(19, 'user15', '726dedc0d6788b05f486730edcc0e871', '', 0),
(20, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', 1),
(21, 'user00', '0baf78e0dcadd5125fbb6ae50514b3e7', '', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`aid`);

--
-- Indeksy dla tabeli `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`qid`);

--
-- Indeksy dla tabeli `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`rid`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `answers`
--
ALTER TABLE `answers`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT dla tabeli `questions`
--
ALTER TABLE `questions`
  MODIFY `qid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT dla tabeli `results`
--
ALTER TABLE `results`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
