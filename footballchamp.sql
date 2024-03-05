-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 05, 2024 lúc 09:10 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `footballchamp`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detailteam`
--

CREATE TABLE `detailteam` (
  `id` int(11) NOT NULL,
  `name_team` varchar(255) DEFAULT NULL,
  `url_image` varchar(255) DEFAULT NULL,
  `quantity_soccer` int(11) DEFAULT NULL,
  `name_soccer` varchar(255) DEFAULT NULL,
  `birth_soccer` date DEFAULT NULL,
  `category_soccer` int(11) DEFAULT NULL,
  `home_court` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `listteam`
--

CREATE TABLE `listteam` (
  `season_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `day_sigin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `result`
--

CREATE TABLE `result` (
  `id` int(11) NOT NULL,
  `season_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `win` int(11) DEFAULT NULL,
  `lose` int(11) DEFAULT NULL,
  `draw` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `season_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `team_id_1` int(11) DEFAULT NULL,
  `team_id_2` int(11) DEFAULT NULL,
  `team1_score` int(11) DEFAULT NULL,
  `team2_score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bẫy `schedule`
--
DELIMITER $$
CREATE TRIGGER `insert_schedule` BEFORE INSERT ON `schedule` FOR EACH ROW SET NEW.team1_score = null, NEW.team2_score = null
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_schedule_result` AFTER UPDATE ON `schedule` FOR EACH ROW UPDATE result
SET win = (SELECT COUNT(*)
           FROM schedule
           WHERE (team1_score > team2_score AND team_id_1 = NEW.team_id_1) OR 
                 (team2_score > team1_score AND team_id_2 = NEW.team_id_1)),
    lose = (SELECT COUNT(*)
            FROM schedule
            WHERE (team1_score < team2_score AND team_id_1 = NEW.team_id_1) OR 
                  (team2_score < team1_score AND team_id_2 = NEW.team_id_1)),
    draw = (SELECT COUNT(*)
            FROM schedule
            WHERE (team1_score = team2_score AND team_id_1 = NEW.team_id_1) OR 
                  (team2_score = team1_score AND team_id_2 = NEW.team_id_1)),
                  total=win*3+draw
WHERE team_id = NEW.team_id_1
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_schedule_result2` AFTER UPDATE ON `schedule` FOR EACH ROW UPDATE result
SET win = (SELECT COUNT(*)
           FROM schedule
           WHERE (team1_score > team2_score AND team_id_1 = NEW.team_id_2) OR 
                 (team2_score > team1_score AND team_id_2 = NEW.team_id_2)),
    lose = (SELECT COUNT(*)
            FROM schedule
            WHERE (team1_score < team2_score AND team_id_1 = NEW.team_id_2) OR 
                  (team2_score < team1_score AND team_id_2 = NEW.team_id_2)),
    draw = (SELECT COUNT(*)
            FROM schedule
            WHERE (team1_score = team2_score AND team_id_1 = NEW.team_id_2) OR 
                  (team2_score = team1_score AND team_id_2 = NEW.team_id_2)),
     total = win*3+draw
WHERE team_id = NEW.team_id_2
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `season`
--

CREATE TABLE `season` (
  `id` int(11) NOT NULL,
  `name_season` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `quantity_team` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `season`
--

INSERT INTO `season` (`id`, `name_season`, `start_date`, `end_date`, `quantity_team`) VALUES
(2, NULL, '2032-02-20', '1970-01-01', NULL),
(3, NULL, '1970-01-01', '1970-01-01', NULL),
(4, NULL, '1970-01-01', '1970-01-01', NULL),
(5, NULL, '2032-02-20', '1970-01-01', NULL),
(6, '2024', '2032-02-20', '1970-01-01', 11),
(7, 'tann', '2032-02-20', '1970-01-01', 11);

--
-- Bẫy `season`
--
DELIMITER $$
CREATE TRIGGER `Delete_season_listteam` AFTER DELETE ON `season` FOR EACH ROW DELETE FROM listteam WHERE season_id = OLD.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Delete_season_result` AFTER DELETE ON `season` FOR EACH ROW DELETE FROM result WHERE season_id = OLD.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Delete_season_schedule` AFTER DELETE ON `season` FOR EACH ROW DELETE FROM schedule WHERE season_id = OLD.id
$$
DELIMITER ;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `detailteam`
--
ALTER TABLE `detailteam`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `season`
--
ALTER TABLE `season`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `detailteam`
--
ALTER TABLE `detailteam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `result`
--
ALTER TABLE `result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `season`
--
ALTER TABLE `season`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
