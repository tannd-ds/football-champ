-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 16, 2024 lúc 04:30 AM
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
-- Cấu trúc bảng cho bảng `detailschedule`
--

CREATE TABLE `detailschedule` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `soccer_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `category_goal` int(11) NOT NULL,
  `time_goal` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bẫy `detailschedule`
--
DELIMITER $$
CREATE TRIGGER `delete_detailschedule_schedule` BEFORE DELETE ON `detailschedule` FOR EACH ROW UPDATE schedule 
    SET 
    	team1_score = team1_score - 1
    WHERE 
        team_id_1 = OLD.team_id
        AND id = OLD.schedule_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_detailschedule_schedule_2` BEFORE DELETE ON `detailschedule` FOR EACH ROW UPDATE schedule 
    SET 
    	team2_score = team2_score - 1
    WHERE 
        team_id_2 = OLD.team_id
        AND id = OLD.schedule_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_detailschedule_soccer` AFTER DELETE ON `detailschedule` FOR EACH ROW UPDATE soccer
SET total_goal	= (SELECT COUNT(*)FROM detailschedule WHERE soccer_id=OLD.soccer_id)
WHERE id = OLD.soccer_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_detailschedule_schedule` AFTER INSERT ON `detailschedule` FOR EACH ROW UPDATE schedule 
    SET 
        team1_score = team1_score + 1
    WHERE 
        team_id_1 = NEW.team_id
        AND id = NEW.schedule_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_detailschedule_schedule_2` AFTER INSERT ON `detailschedule` FOR EACH ROW UPDATE schedule 
    SET 
        team2_score = team2_score + 1
    WHERE 
        team_id_2 = NEW.team_id
        AND id = NEW.schedule_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_detailschedule_soccer` AFTER INSERT ON `detailschedule` FOR EACH ROW UPDATE soccer
SET total_goal	= (SELECT COUNT(*)FROM detailschedule WHERE soccer_id=NEW.soccer_id)
WHERE id = NEW.soccer_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_detailschedule_schedule` AFTER UPDATE ON `detailschedule` FOR EACH ROW UPDATE schedule 
    SET 
    	team1_score = team1_score - 1,
        team2_score = team2_score + 1
    WHERE 
        team_id_2 = NEW.team_id
        AND id = NEW.schedule_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_detailschedule_schedule_2` AFTER UPDATE ON `detailschedule` FOR EACH ROW UPDATE schedule 
    SET 
    	team1_score = team1_score + 1,
        team2_score = team2_score - 1
    WHERE 
        team_id_1 = NEW.team_id
        AND id = NEW.schedule_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_detailschedule_soccer` AFTER UPDATE ON `detailschedule` FOR EACH ROW UPDATE soccer
SET total_goal	= (SELECT COUNT(*)FROM detailschedule WHERE soccer_id=NEW.soccer_id)
WHERE id = NEW.soccer_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_detailschedule_soccer_2` AFTER UPDATE ON `detailschedule` FOR EACH ROW UPDATE soccer
SET total_goal	= (SELECT COUNT(*)FROM detailschedule WHERE soccer_id=OLD.soccer_id)
WHERE id = OLD.soccer_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detailteam`
--

CREATE TABLE `detailteam` (
  `id` int(11) NOT NULL,
  `name_team` varchar(255) NOT NULL,
  `url_image` varchar(255) DEFAULT NULL,
  `quantity_soccer` int(11) DEFAULT NULL,
  `established_date` date NOT NULL,
  `home_court` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bẫy `detailteam`
--
DELIMITER $$
CREATE TRIGGER `delete_detailteam_detailschedule` BEFORE DELETE ON `detailteam` FOR EACH ROW DELETE FROM detailschedule WHERE
team_id= old.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_detailteam_listteam` AFTER DELETE ON `detailteam` FOR EACH ROW DELETE FROM listteam
WHERE listteam.team_id = OLD.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_detailteam_user` AFTER DELETE ON `detailteam` FOR EACH ROW UPDATE user
SET team_id = null
WHERE team_id = OLD.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `listteam`
--

CREATE TABLE `listteam` (
  `id` int(11) NOT NULL,
  `season_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `date_signin` date DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bẫy `listteam`
--
DELIMITER $$
CREATE TRIGGER `delete_listteam_result` AFTER DELETE ON `listteam` FOR EACH ROW DELETE FROM result where team_id=old.team_id and season_id=old.season_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_listteam_schedule` AFTER DELETE ON `listteam` FOR EACH ROW DELETE FROM schedule
where (team_id_1 = old.team_id OR team_id_2= old.team_id) AND season_id=old.season_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_listteam_result` AFTER INSERT ON `listteam` FOR EACH ROW IF NEW.status = 1 THEN
        INSERT INTO `result` (`id`, `season_id`, `team_id`, `win`, `lose`, `draw`, `total`) 
        VALUES (NULL, NEW.season_id, NEW.team_id, 0, 0, 0, 0);
    END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_listteam_result` AFTER UPDATE ON `listteam` FOR EACH ROW IF NEW.status = 1 THEN
        INSERT INTO `result` (`id`, `season_id`, `team_id`, `win`, `lose`, `draw`, `total`) 
        VALUES (NULL, NEW.season_id, NEW.team_id, 0, 0, 0, 0);
    END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `result`
--

CREATE TABLE `result` (
  `id` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `win` int(11) DEFAULT 0,
  `lose` int(11) DEFAULT 0,
  `draw` int(11) DEFAULT 0,
  `total` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `season_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `team_id_1` int(11) DEFAULT NULL,
  `team_id_2` int(11) DEFAULT NULL,
  `team1_score` int(11) DEFAULT 0,
  `team2_score` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bẫy `schedule`
--
DELIMITER $$
CREATE TRIGGER `delete_schedule_detailschedule` BEFORE DELETE ON `schedule` FOR EACH ROW DELETE FROM detailschedule where schedule_id = old.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_schedule_result` AFTER DELETE ON `schedule` FOR EACH ROW UPDATE result
SET win = (SELECT COUNT(*)
           FROM schedule
           WHERE team1_score > team2_score AND team_id_1 = old.team_id_1),
    lose = (SELECT COUNT(*)
            FROM schedule
            WHERE (team1_score < team2_score AND team_id_1 = old.team_id_1)),
    draw = (SELECT COUNT(*)
            FROM schedule
            WHERE (team1_score = team2_score AND team_id_1 = old.team_id_1)),
                  total=win*3+draw
WHERE team_id = old.team_id_1 and season_id = OLD.season_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_schedule_result_2` AFTER DELETE ON `schedule` FOR EACH ROW UPDATE result
SET win = (SELECT COUNT(*)
           FROM schedule
           WHERE team1_score > team2_score AND team_id_1 = old.team_id_2),
    lose = (SELECT COUNT(*)
            FROM schedule
            WHERE (team1_score < team2_score AND team_id_1 = old.team_id_2)),
    draw = (SELECT COUNT(*)
            FROM schedule
            WHERE (team1_score = team2_score AND team_id_1 = old.team_id_2)),
                  total=win*3+draw
WHERE team_id = old.team_id_2 and season_id = OLD.season_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_schedule` BEFORE INSERT ON `schedule` FOR EACH ROW SET NEW.team1_score = 0, NEW.team2_score = 0
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_schedule_result` AFTER UPDATE ON `schedule` FOR EACH ROW UPDATE result
SET win = (SELECT COUNT(*)
           FROM schedule
           WHERE season_id = NEW.season_id and ((team1_score > team2_score AND team_id_1 = NEW.team_id_1) OR 
                 (team2_score > team1_score AND team_id_2 = NEW.team_id_1))),
    lose = (SELECT COUNT(*)
            FROM schedule
            WHERE season_id = NEW.season_id AND ((team1_score < team2_score AND team_id_1 = NEW.team_id_1) OR 
                  (team2_score < team1_score AND team_id_2 = NEW.team_id_1))),
    draw = (SELECT COUNT(*)
            FROM schedule
            WHERE season_id = NEW.season_id and ((team1_score = team2_score AND team_id_1 = NEW.team_id_1) OR 
                  (team2_score = team1_score AND team_id_2 = NEW.team_id_1))),
                  total=win*3+draw
WHERE team_id = NEW.team_id_1 and season_id = NEW.season_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_schedule_result_2` AFTER UPDATE ON `schedule` FOR EACH ROW UPDATE result
SET win = (SELECT COUNT(*)
           FROM schedule
           WHERE season_id = NEW.season_id AND ((team1_score > team2_score AND team_id_1 = NEW.team_id_2) OR 
                 (team2_score > team1_score AND team_id_2 = NEW.team_id_2))),
    lose = (SELECT COUNT(*)
            FROM schedule
            WHERE season_id = NEW.season_id AND ((team1_score < team2_score AND team_id_1 = NEW.team_id_2) OR 
                  (team2_score < team1_score AND team_id_2 = NEW.team_id_2))),
    draw = (SELECT COUNT(*)
            FROM schedule
            WHERE season_id = NEW.season_id AND ((team1_score = team2_score AND team_id_1 = NEW.team_id_2) OR 
                  (team2_score = team1_score AND team_id_2 = NEW.team_id_2))),
     total = win*3+draw
WHERE team_id = NEW.team_id_2 and season_id = NEW.season_id
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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `soccer`
--

CREATE TABLE `soccer` (
  `id` int(11) NOT NULL,
  `name_soccer` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `category` int(11) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `total_goal` int(11) DEFAULT 0,
  `note` varchar(255) DEFAULT NULL,
  `status` int(255) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bẫy `soccer`
--
DELIMITER $$
CREATE TRIGGER `update_quantity_soccer_after_delete` AFTER DELETE ON `soccer` FOR EACH ROW BEGIN
    -- Update quantity_soccer for the old team_id
    UPDATE detailteam 
    SET quantity_soccer = (
        SELECT COUNT(*) FROM soccer WHERE team_id = OLD.team_id and status = 1
    )
    WHERE detailteam.id = OLD.team_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_quantity_soccer_after_insert` AFTER INSERT ON `soccer` FOR EACH ROW BEGIN
    -- Update quantity_soccer for the new team_id
    UPDATE detailteam 
    SET quantity_soccer = (
        SELECT COUNT(*) FROM soccer WHERE team_id = NEW.team_id and status = 1
    )
    WHERE detailteam.id = NEW.team_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_soccer_detailteam` AFTER UPDATE ON `soccer` FOR EACH ROW UPDATE detailteam
 SET quantity_soccer = (
        SELECT COUNT(*) FROM soccer WHERE team_id = OLD.team_id and status = 1
    )
    WHERE detailteam.id = OLD.team_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_soccer_detailteam2` AFTER UPDATE ON `soccer` FOR EACH ROW BEGIN
    -- Update quantity_soccer for the new team_id
    UPDATE detailteam 
    SET quantity_soccer = (
        SELECT COUNT(*) FROM soccer WHERE team_id = NEW.team_id and status = 1
    )
    WHERE detailteam.id = NEW.team_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `rule` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `detailschedule`
--
ALTER TABLE `detailschedule`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `detailteam`
--
ALTER TABLE `detailteam`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `listteam`
--
ALTER TABLE `listteam`
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
-- Chỉ mục cho bảng `soccer`
--
ALTER TABLE `soccer`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `detailschedule`
--
ALTER TABLE `detailschedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `detailteam`
--
ALTER TABLE `detailteam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `listteam`
--
ALTER TABLE `listteam`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `soccer`
--
ALTER TABLE `soccer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
