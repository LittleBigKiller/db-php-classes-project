-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql.ct8.pl
-- Czas generowania: 10 Lis 2019, 22:40
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
(1, '<background=\"\"></background>', 0, 1),
(2, '<body bgcolor=\"\"></body>', 1, 1),
(3, '<bgcolor=\"\"></bgcolor>', 0, 1),
(4, '<body background=\"\"></body>', 0, 1),
(5, 'Reguła', 0, 2),
(6, 'Wyzwalacz', 0, 2),
(7, 'Procedura składowa', 0, 2),
(8, 'Funkcja zdefiniowana', 1, 2);

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
(1, 'Aby ustawić tło na stronie www należy użyć polecenia: ', 0, 0),
(2, 'Który z obiektów relacyjnej bazy danych, będący kodem języka SQL, może być wywoływany w zapytaniach modyfikujących kolumny danych widoczne jako tabela, bez względu na to czy jest tworzony programowo, czy dynamicznie?', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `results`
--

CREATE TABLE `results` (
  `rid` int(11) NOT NULL,
  `ans_correct` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `results`
--

INSERT INTO `results` (`rid`, `ans_correct`, `uid`) VALUES
(1, 6, 1),
(2, 9, 1);

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
(2, 'testtest0', 'aec87fd281326f94bf34b3d1f4809982', '', 1),
(3, 'testtest1', 'c23b2ed66eedb321c5bcfb5e3724b978', '', 0),
(4, 'testtest2', '3b46afa69314bf5a2f885a532cfab7c4', '', 1);

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
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `questions`
--
ALTER TABLE `questions`
  MODIFY `qid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `results`
--
ALTER TABLE `results`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
