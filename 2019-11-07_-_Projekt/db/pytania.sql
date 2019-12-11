-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql.ct8.pl
-- Czas generowania: 04 Gru 2019, 12:13
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
(78, 'Błędna 2', 0, 25),
(79, 'FIX TABLE', 0, 27),
(80, 'CHECK TABLE', 0, 27),
(82, 'RESOLVE TABLE', 0, 27),
(83, 'strtoupper(\"ala ma psa\");', 1, 28),
(84, 'strtolower(\"ala ma psa\");', 0, 28),
(85, 'ucfirst(\"ala ma psa\");', 0, 28),
(86, 'strstr(\"ala ma psa\");', 0, 28),
(87, 'n-elementów tablicy', 0, 29),
(88, 'co drugiego elementu tablicy', 1, 29),
(89, 'sumy wszystkich elementów tablicy', 0, 29),
(90, 'sumy tych elementów tablicy, których wartości są nieparzyste', 0, 29),
(91, 'Scroll', 0, 30),
(92, 'Fixed', 1, 30),
(93, 'Local', 0, 30),
(94, 'Inherit', 0, 30),
(95, 'sort()', 0, 31),
(96, 'rsort()', 0, 31),
(97, 'asort()', 0, 31),
(98, 'ksort()', 1, 31),
(99, 'SELECT * FROM ksiazki WHERE cena < 50;', 0, 32),
(100, 'SELECT tytul FROM ksiazki WHERE cena < 50;', 1, 32),
(101, 'SELECT tytul FROM ksiazki WHERE cena > \'50 zł\';', 0, 32),
(102, 'SELECT ksiazki FROM tytul WHERE cena < \'50 zł\';', 0, 32),
(103, '<css>', 0, 33),
(104, '<link>', 1, 33),
(105, '<style>', 0, 33),
(106, '<meta>', 0, 33),
(107, 'kluczy PRIMARY KEY i FOREIGN KEY', 0, 34),
(108, 'klucza FOREIGN KEY z wartością NOT NULL', 0, 34),
(109, 'klucza obcego z wartością NOT NULL i UNIQUE', 0, 34),
(110, 'klucza PRIMARY KEY z wartością NOT NULL i UNIQUE', 1, 34),
(111, 'znacznik <div>', 0, 35),
(112, 'znaczniki <frame> i <table>', 0, 35),
(113, 'znacznik <p> z formatowaniem', 0, 35),
(114, 'znaczniki <h1>, <h2> oraz <p>', 1, 35),
(115, 'zmienna--;', 0, 36),
(116, 'zmienna+=1;', 1, 36),
(117, 'zmienna=zmienna+10;', 0, 36),
(118, 'zmienna===zmienna+1;', 0, 36),
(119, 'SQL DML (ang. Data Manipulation Language)', 0, 37),
(120, 'SQL DDL (ang. Data Definition Language)', 0, 37),
(121, 'SQL DCL (ang. Data Control Language)', 0, 37),
(122, 'SQL DQL (ang. Data Query Language)', 1, 37),
(123, 'SELECT szkola FROM klasa=klasa+1 WHERE klasa >=1 AND klasa <=5;', 0, 38),
(124, 'SELECT nazwisko, imie FROM klasa=klasa+1 WHERE klasa>1 OR klasa <5;', 0, 38),
(125, 'UPDATE szkola SET klasa=klasa+1 WHERE klasa>=1 AND klasa <=5;', 1, 38),
(126, 'UPDATE nazwisko, imie SET klasa=klasa+1 WHERE klasa>1 OR klasa<5;', 0, 38),
(127, 'ADD TABLE', 0, 39),
(128, 'ALTER TABLE', 0, 39),
(129, 'INSERT TABLE', 0, 39),
(130, 'CREATE TABLE', 1, 39),
(131, 'if', 0, 40),
(132, 'next', 0, 40),
(133, 'switch', 0, 40),
(134, 'foreach', 1, 40),
(135, 'DHCP', 0, 41),
(136, 'FTP', 1, 41),
(137, 'POP3', 0, 41),
(138, 'DNS', 0, 41),
(139, 'line-spacing', 0, 42),
(140, 'white-space', 0, 42),
(141, 'word-spacing', 1, 42),
(142, 'letter-space', 0, 42),
(143, 'Joomla', 0, 43),
(144, 'Apache', 1, 43),
(145, 'Mambo', 0, 43),
(146, 'WordPress', 0, 43),
(147, 'mysqldump -u root -p baza > kopia.sql', 0, 44),
(148, 'mysqldump -u root -p baza < kopia.sql', 0, 44),
(149, 'mysql -u root -p baza < kopia.sql', 1, 44),
(150, 'mysql -u root -p baza > kopia.sql', 0, 44),
(151, '</ br>', 0, 45),
(152, '<br />', 1, 45),
(153, '</br/>', 0, 45),
(154, '<br> </br>', 0, 45),
(155, 'JPG', 0, 46),
(156, 'PNG', 1, 46),
(157, 'NEF', 0, 46),
(158, 'BMP', 0, 46),
(159, '<ins> ... </ins>', 0, 47),
(160, '<pre> ... </pre>', 1, 47),
(161, '<code> ... </code>', 0, 47),
(162, '<blockquote> ... </blockquote>', 0, 47),
(163, '<meta keywords=\"psy, koty, gryzonie\">', 0, 48),
(164, '<meta name=\"keywords\" =\"psy, koty, gryzonie\">', 0, 48),
(165, '<meta name=\"keywords\" content=\"psy, koty, gryzonie\">', 1, 48),
(166, '<meta name=\"description\" content=\"psy, koty, gryzonie\">', 0, 48),
(167, 'var i=3/2;', 0, 49),
(168, 'var i=Number(3/2);', 0, 49),
(169, 'var i=parseInt(3/2);', 1, 49),
(170, 'var i=parseFloat(3/2);', 0, 49),
(171, 'Specyfikacja wymagań, analiza wymagań klienta, tworzenie, wdrażanie,testy', 0, 50),
(172, 'Analiza wymagań klienta, specyfikacja wymagań tworzenie, testy, wdrażanie', 1, 50),
(173, 'Tworzenie, analiza wymagań klienta, specyfikacja wymagań, wdrażanie, testy', 0, 50),
(174, 'Analiza wymagań klienta, specyfikacja wymagań, tworzenie, wdrażanie, testy', 0, 50),
(175, 'wyciszenia', 0, 51),
(176, 'normalizacji', 1, 51),
(177, 'podbicia basów', 0, 51),
(178, 'usuwania szumów', 0, 51),
(179, 'w tabeli artykuly obniża wartość każdego pola cena o 30% dla wszystkich artykułów', 0, 52),
(180, 'w tabeli artykuly obniża wartość każdego pola cena dla którego pole kod jest równe 2', 1, 52),
(181, 'wprowadzenie w tabeli artykuly nowych pól cena i kod', 0, 52),
(182, 'wprowadzenie w tabeli artykuly pola o nazwie cena ze znacznikiem kod', 0, 52),
(183, 'SELECT', 1, 53),
(184, 'UPDATE', 0, 53),
(185, 'INSERT INTO', 0, 53),
(186, 'CHECK TABLE', 0, 53),
(187, 'EXPORT DATABASE', 0, 54),
(188, 'BACKUP DATABASE', 0, 54),
(189, 'RESTORE DATABASE', 1, 54),
(190, 'UNBACKUP DATABASE', 0, 54),
(191, 'a1', 1, 55),
(192, 'a2', 0, 55),
(193, 'a1', 0, 56),
(194, 'a2', 0, 56),
(195, 'a3', 0, 56),
(196, 'a4', 0, 56),
(197, 'a1', 0, 57),
(198, 'REPAIR TABLE', 1, 27),
(199, 'asd', 1, 58),
(200, 'sdfsfd', 0, 58),
(201, 'dfg', 0, 58),
(202, 'dfgdfg', 0, 58),
(203, 'testtest', 1, 59),
(204, 'testtest', 0, 59),
(205, 'tsettsesetset', 0, 59),
(206, 'asdasdads', 0, 59),
(207, 'test', 0, 60),
(208, 'test', 0, 60),
(209, 'test', 1, 60),
(210, 'test', 0, 60);

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
(27, 'Aby naprawić uszkodzoną tabelę w MySQL, należy wydać polecenie', 10, 13),
(28, 'W celu zmodyfikowania tekstu \"ala ma psa\" na \"ALA MA PSA\" należy użyć funkcji PHP', 8, 11),
(30, 'Który z atrybutów background-attachment w języku CSS należy wybrać, aby tło strony było nieruchome względem okna przeglądarki?', 10, 13),
(31, 'Która z wymienionych funkcji sortowania wykorzystywana w języku PHP sortuje tablicę asocjacyjną według indeksów', 7, 14),
(32, 'Dana jest tabela ksiazki z polami: tytul, autor (typu tekstowego), cena (typu liczbowego). Aby kwerenda SELECT zwróciła tylko tytuły, dla których cena jest mniejsza od 50zł, należy zapisać:', 10, 14),
(33, 'Dołączenie zewnętrznego arkusza stylów do kodu HTML jest realizowane przy użyciu znacznika', 8, 10),
(34, 'Do poprawnego i spójnego działania bazy danych niezbędne jest umieszczenie w każdej tabeli', 8, 14),
(35, 'Aby poprawnie zdefiniować hierarchiczną strukturę tekstu witryny internetowej, należy zastosować', 6, 10),
(36, 'W języku JavaScript wynik działania instrukcji zmienna++; będzie taki sam jak instrukcji', 14, 18),
(37, 'Jak nazywa się podzbiór strukturalnego języka zapytań, związany z formułowaniem zapytań do bazy danych za pomocą polecenia SELECT?', 8, 14),
(38, 'Baza danych 6-letniej szkoły podstawowej zawiera tabelę szkola z polami: imie, nazwisko, klasa. Wszyscy uczniowie klas 1-5 zdali do następnej klasy. Aby zwiększyć wartość w polu klasa o 1 należy użyć polecenia', 6, 10),
(39, 'W języku SQL, aby stworzyć tabelę, należy zastosować polecenie', 7, 13),
(40, 'Dla każdej iteracji pętli wartość bieżącego elementu tablicy jest przypisywana do zmiennej, a wskaźnik tablicy jest przesuwany o jeden, aż do ostatniego elementu tablicy. Zdanie to jest prawdziwe dla instrukcji', 11, 15),
(41, 'Za pomocą którego protokołu należy wysłać pliki na serwer WWW?', 7, 10),
(42, 'W języku CSS, aby zdefiniować niestandardowe odstępy między wyrazami, stosuje się właściwość', 13, 15),
(43, 'Które oprogramowanie NIE JEST systemem zarządzania treścią (CMS)?', 9, 12),
(44, 'Które polecenie wydane z konsoli systemowej dokona przywrócenia bazy danych?', 11, 15),
(45, 'Prawidłowy, zgodny ze standardem języka XHTML, zapis samozamykającego się znacznika odpowiadającego za łamanie linii ma postać', 11, 13),
(46, 'Który z wymienionych formatów plików graficznych obsługuje przezroczystość?', 16, 17),
(47, 'Przy użyciu jakiego znacznika HTML otrzymamy tekst napisany czcionką o stałej szerokości znaku, który uwzględnia dodatkowe spacje, tabulacje i znaki końca linii?', 12, 15),
(48, 'W języku HTML aby zdefiniować słowa kluczowe strony, należy użyć zapisu', 6, 13),
(49, 'W języku JavaScript zdefiniowana zmienna i, która ma przechowywać wynik dzielenia wynoszący 1, to', 9, 12),
(50, 'Wskaż prawidłową kolejność tworzenia aplikacji', 9, 16),
(51, 'Aby dopasować dźwięk do danego poziomu głośności, należy użyć efektu', 10, 13),
(52, 'Polecenie SQL o treści: UPDATE artykuly SET cena = cena * 0.7 WHERE kod = 2; oznacza', 8, 11),
(53, 'W bazie danych sklepu spożywczego pod koniec dnia jest tworzony raport wyświetlający te produkty wraz z ich dostawcami, dla których stan magazynowy jest mniejszy niż 10 sztuk. Do zdefiniowania tego raportu posłużono się kwerendą', 11, 17),
(54, 'Aby przywrócić bazę danych z kopii bezpieczeństwa na serwerze MSSQL, należy posłużyć się poleceniem', 12, 13),
(55, 'Za mało odpowiedzi', 0, 0),
(56, 'Brak dobrej odpowiedzi', 0, 0),
(57, 'Za mało odpowiedzi i brak prawidłowej', 0, 0);

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
(6, 9, 5, 1574035398),
(7, 9, 5, 1574035898),
(8, 8, 6, 1574115451),
(9, 9, 6, 1574115739),
(10, 10, 7, 1574115905),
(11, 4, 7, 1574116002),
(12, 6, 8, 1574116047),
(13, 9, 8, 1574116074),
(14, 10, 9, 1574116117),
(15, 10, 9, 1574116164),
(16, 1, 10, 1574116242),
(17, 2, 10, 1574116259),
(18, 10, 11, 1574116285),
(19, 10, 11, 1574116316),
(20, 1, 12, 1574116387),
(21, 9, 12, 1574116402),
(22, 6, 13, 1574116429),
(23, 10, 13, 1574116459),
(24, 10, 14, 1574116499),
(25, 10, 14, 1574116524),
(26, 7, 15, 1574116557),
(27, 4, 15, 1574116572),
(28, 9, 16, 1574116612),
(29, 10, 16, 1574116631),
(30, 10, 16, 1574116684),
(31, 10, 17, 1574116723),
(32, 2, 17, 1574116758),
(33, 6, 18, 1574116829),
(34, 10, 18, 1574116847),
(35, 10, 19, 1574116882),
(36, 9, 19, 1574116903),
(37, 0, 25, 1574899754),
(38, 1, 29, 1575163242),
(39, 1, 29, 1575165388),
(40, 3, 29, 1575328029),
(41, 6, 29, 1575330021),
(42, 0, 30, 1575333534),
(43, 0, 30, 1575333548),
(44, 0, 30, 1575333554),
(48, 4, 33, 1575445213);

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
(5, 'user01', 'dXNlcjAx', '', 0),
(6, 'user02', 'dXNlcjAy', '', 0),
(7, 'user03', 'dXNlcjAz', '', 0),
(8, 'user04', 'dXNlcjA0', '', 0),
(9, 'user05', 'dXNlcjA1', '', 0),
(10, 'user06', 'dXNlcjA2', '', 0),
(11, 'user07', 'dXNlcjA3', '', 0),
(12, 'user08', 'dXNlcjA4', '', 0),
(13, 'user09', 'dXNlcjA5', '', 0),
(14, 'user10', 'dXNlcjEw', '', 0),
(15, 'user11', 'dXNlcjEx', '', 0),
(16, 'user12', 'dXNlcjEy', '', 0),
(17, 'user13', 'dXNlcjEz', '', 0),
(18, 'user14', 'dXNlcjE0', '', 0),
(19, 'user15', 'dXNlcjE1', '', 0),
(20, 'admin', 'YWRtaW4=', '', 1);

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
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT dla tabeli `questions`
--
ALTER TABLE `questions`
  MODIFY `qid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT dla tabeli `results`
--
ALTER TABLE `results`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
