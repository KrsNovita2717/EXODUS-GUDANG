-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 07:28 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exodus`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_Login` (`userLogin` VARCHAR(20))   BEGIN
		DELETE FROM login
		WHERE username = userLogin;
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_Login` (`userLogin` VARCHAR(20), `pass` VARCHAR(6), `id_p` INT)   BEGIN
		INSERT INTO login (username, pass_admin, id_pekerja)
		VALUES (userLogin, pass, id_p);
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `manage_brg` (`operator` VARCHAR(10), `id` INT, `nama` VARCHAR(50), `stok` INT, `id_j` INT, `id_d` INT, `id_pekerja` INT)   BEGIN
    DECLARE last_id INT;
    CASE operator
        WHEN 'insert' THEN 
            INSERT INTO barang(barang, stok_tersedia, id_jenis, id_distributor) VALUES (nama, stok, id_j, id_d);
            SET last_id = (SELECT MAX(id_barang) FROM barang);
            CALL manage_transaksi('insert', NULL, stok, CURRENT_TIMESTAMP(), 'new', last_id, id_pekerja);
        WHEN 'update' THEN
            UPDATE barang
            SET
		barang = nama,
                id_jenis = id_j
            WHERE id_barang = id;
        WHEN 'delete' THEN
            DELETE FROM barang
            WHERE id_barang = id;
    END CASE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `manage_distributor` (`operator` VARCHAR(10), `id` INT, `nama` VARCHAR(50), `alamat` VARCHAR(50), `telp` VARCHAR(15))   BEGIN
		CASE operator
		WHEN 'insert' THEN 
			INSERT INTO distributor (nama_distributor, alamat_distributor, no_telp)
			VALUES (nama, alamat, telp);
		WHEN 'update' THEN
			UPDATE distributor
			SET
				nama_distributor = nama,
				alamat_distributor = alamat,
				no_telp = telp
			WHERE id_distributor = id;
		WHEN 'delete' THEN
			DELETE FROM distributor
			WHERE id_distributor = id;
		END CASE;
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `manage_jenis` (`operator` VARCHAR(10), `id` INT, `jenis` VARCHAR(30))   BEGIN
		CASE operator
		WHEN 'insert' THEN 
			INSERT INTO jenis(jenis_barang)
			VALUES (jenis);
		WHEN 'update' THEN
			UPDATE jenis
			SET
				jenis_barang = jenis
			WHERE id_jenis = id;
		WHEN 'delete' THEN
			DELETE FROM jenis
			WHERE id_jenis = id;
		END CASE;
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `manage_pekerja` (`operator` VARCHAR(10), `id` INT, `nama` VARCHAR(50), `telp` VARCHAR(15), `alamat` VARCHAR(50), `jabatan` VARCHAR(50))   BEGIN
		CASE operator
		WHEN 'insert' THEN 
			INSERT INTO pekerja(nama_pekerja, no_telp, alamat_pekerja, jabatan)
			VALUES (nama, telp, alamat, jabatan );
		WHEN 'update' THEN
			UPDATE pekerja
			SET
				nama_pekerja = nama,
				no_telp = telp,
				alamat_pekerja = alamat,
				jabatan = jabatan
			WHERE id_pekerja = id;
		WHEN 'delete' THEN
			DELETE FROM pekerja
			WHERE id_pekerja = id;
		END CASE;
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `manage_transaksi` (`operator` VARCHAR(10), `id` INT, `jumlah` INT, `tgl` TIMESTAMP, `ket` VARCHAR(6), `id_b` INT, `id_p` INT)   BEGIN
    CASE operator
        WHEN 'insert' THEN
            INSERT INTO transaksi (jumlah_barang, tanggal, keterangan, id_barang, id_pekerja)
            VALUES (jumlah, tgl, ket, id_b, id_p);
        WHEN 'update' THEN 
            BEGIN
                DECLARE old_tgl TIMESTAMP;
                SELECT tanggal INTO old_tgl FROM transaksi WHERE id_transaksi = id;
                UPDATE transaksi
                SET transaksi.jumlah_barang = jumlah, transaksi.tanggal = old_tgl
                WHERE transaksi.id_transaksi = id;
            END;
        WHEN 'delete' THEN
            DELETE FROM transaksi
            WHERE transaksi.id_transaksi = id;
    END CASE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_Login` (IN `username_old` VARCHAR(20), IN `pass` VARCHAR(20), IN `id_p` INT, IN `username_new` VARCHAR(20))   BEGIN
    UPDATE login
    SET username = username_new,
        pass_admin = pass,
        id_pekerja = id_p
    WHERE username = username_old;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `barang` varchar(50) NOT NULL,
  `stok_tersedia` int(11) NOT NULL,
  `id_jenis` int(11) DEFAULT NULL,
  `id_distributor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `barang`, `stok_tersedia`, `id_jenis`, `id_distributor`) VALUES
(38, 'kemeja', 10, 17, 7),
(39, 'blouse', 500, 15, 8),
(40, 'kemeja', 400, NULL, 9),
(42, 'blouse', 50, NULL, 7),
(49, 'Kaos', 50, 20, 8),
(52, 'Jaket', 15, 17, 7);

-- --------------------------------------------------------

--
-- Table structure for table `distributor`
--

CREATE TABLE `distributor` (
  `id_distributor` int(11) NOT NULL,
  `nama_distributor` varchar(50) NOT NULL,
  `alamat_distributor` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distributor`
--

INSERT INTO `distributor` (`id_distributor`, `nama_distributor`, `alamat_distributor`, `no_telp`) VALUES
(7, 'PT Chenel', 'Jalan Pahlawan', '085828194839'),
(8, 'PT Madu', 'Jalan Pangeran', '085728197812'),
(9, 'PT Sentosa', 'Jalan Kutilang 1', '081228155817');

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id_jenis` int(11) NOT NULL,
  `jenis_barang` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `jenis_barang`) VALUES
(15, 'flanel'),
(17, 'wol'),
(20, 'katun');

--
-- Triggers `jenis`
--
DELIMITER $$
CREATE TRIGGER `NoDuplicateJenis` BEFORE INSERT ON `jenis` FOR EACH ROW BEGIN
IF EXISTS (SELECT * FROM jenis WHERE jenis_barang = NEW.jenis_barang) THEN
	    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Jenis barang sudah ada.';
	    END IF;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `laporan_transaksi`
-- (See below for the actual view)
--
CREATE TABLE `laporan_transaksi` (
`Tanggal Transaksi` timestamp
,`Nama Barang` varchar(50)
,`Jenis Barang` varchar(30)
,`Status Transaksi` varchar(6)
,`Jumlah Barang` int(11)
,`Nama Pekerja` varchar(20)
);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(20) NOT NULL,
  `pass_admin` varchar(20) NOT NULL,
  `id_pekerja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `pass_admin`, `id_pekerja`) VALUES
('dhea2', '12345', 19),
('dita1', '12345', 20);

-- --------------------------------------------------------

--
-- Table structure for table `pekerja`
--

CREATE TABLE `pekerja` (
  `id_pekerja` int(11) NOT NULL,
  `nama_pekerja` varchar(20) NOT NULL,
  `no_telp` varchar(12) NOT NULL,
  `alamat_pekerja` varchar(50) NOT NULL,
  `jabatan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pekerja`
--

INSERT INTO `pekerja` (`id_pekerja`, `nama_pekerja`, `no_telp`, `alamat_pekerja`, `jabatan`) VALUES
(19, 'Dhea', '081345642341', 'Jalan Mengkudu, No 19', 'Admin'),
(20, 'Dita', '083456738563', 'Jalan Betutu', 'Kepala');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `keterangan` varchar(6) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `id_pekerja` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `jumlah_barang`, `tanggal`, `keterangan`, `id_barang`, `id_pekerja`) VALUES
(62, 200, '2024-05-04 04:32:58', 'new', 38, 19),
(63, 500, '2024-05-04 04:36:47', 'new', 39, 19),
(64, 400, '2024-05-04 04:37:26', 'new', 40, 19),
(70, 100, '2024-05-06 06:29:29', 'new', 42, 19),
(78, 50, '2024-05-07 07:05:16', 'out', 42, 19),
(80, 100, '2024-05-07 07:06:11', 'out', 38, 19),
(82, 5, '2024-05-07 07:06:32', 'in', 38, 19),
(84, 1, '2024-05-07 07:06:56', 'in', 38, 19),
(85, 2, '2024-05-07 07:07:38', 'in', 38, 19),
(86, 2, '2024-05-07 07:07:49', 'in', 38, 19),
(88, 100, '2024-05-07 07:08:48', 'out', 38, 19),
(91, 50, '2024-05-12 05:15:17', 'new', NULL, 20),
(92, 10, '2024-05-12 10:51:13', 'new', NULL, NULL),
(93, 5, '2024-05-12 10:58:11', 'in', NULL, 20),
(94, 50, '2024-05-12 15:05:05', 'new', NULL, 20),
(95, 3, '2024-05-12 15:05:40', 'new', NULL, 20),
(96, 3, '2024-05-12 15:06:55', 'new', NULL, 20),
(97, 50, '2024-05-15 04:41:46', 'new', 49, 20),
(98, 5, '2024-05-15 04:49:23', 'new', NULL, 20),
(99, 5, '2024-05-15 04:56:41', 'new', NULL, 20),
(101, 15, '2024-05-15 05:04:15', 'new', 52, 20);

--
-- Triggers `transaksi`
--
DELIMITER $$
CREATE TRIGGER `Transaksi_AfterDelete` AFTER DELETE ON `transaksi` FOR EACH ROW BEGIN
    IF old.keterangan = 'in' OR old.keterangan = 'new' THEN
	    UPDATE barang SET
		    stok_tersedia = stok_tersedia + old.jumlah_barang
		    WHERE barang.id_barang = old.id_barang;
    ELSEIF old.keterangan = 'out' THEN
	    UPDATE barang SET
		    stok_tersedia = stok_tersedia + old.jumlah_barang
		    WHERE barang.id_barang = old.id_barang;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Transaksi_BeforeIN` BEFORE INSERT ON `transaksi` FOR EACH ROW BEGIN
DECLARE stok_saat_ini INT;
IF NEW.keterangan = 'in' AND EXISTS (SELECT * FROM barang WHERE id_barang = NEW.id_barang) THEN
    UPDATE barang AS b 
    SET b.stok_tersedia = b.stok_tersedia + NEW.jumlah_barang
    WHERE b.id_barang = NEW.id_barang;
ELSEIF NEW.keterangan = 'out' THEN
    SELECT stok_tersedia INTO stok_saat_ini FROM barang 
    WHERE barang.id_barang = NEW.id_barang;
    IF NEW.jumlah_barang > stok_saat_ini THEN
        -- Sinyal SQLSTATE untuk menampilkan pesan kesalahan
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stok barang tidak mencukupi. Silahkan hubungi distributor produk';
    ELSE
        UPDATE barang AS b 
        SET b.stok_tersedia = b.stok_tersedia - NEW.jumlah_barang 
        WHERE b.id_barang = NEW.id_barang;
    END IF;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Transaksi_BeforeUP` BEFORE UPDATE ON `transaksi` FOR EACH ROW BEGIN
    DECLARE stok_saat_ini INT;

    IF OLD.jumlah_barang != NEW.jumlah_barang THEN
        IF OLD.keterangan = 'in' OR OLD.keterangan = 'new' THEN
            UPDATE barang SET stok_tersedia = stok_tersedia - OLD.jumlah_barang + NEW.jumlah_barang WHERE id_barang = OLD.id_barang;
        ELSEIF OLD.keterangan = 'out' THEN
            SELECT stok_tersedia INTO stok_saat_ini FROM barang WHERE id_barang = OLD.id_barang;

            IF NEW.jumlah_barang > stok_saat_ini THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stok barang tidak mencukupi. Silahkan hubungi distributor produk';
            ELSE
                UPDATE barang SET stok_tersedia = stok_tersedia + OLD.jumlah_barang - NEW.jumlah_barang WHERE id_barang = OLD.id_barang;
            END IF;
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure for view `laporan_transaksi`
--
DROP TABLE IF EXISTS `laporan_transaksi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `laporan_transaksi`  AS   (select `t`.`tanggal` AS `Tanggal Transaksi`,`b`.`barang` AS `Nama Barang`,`j`.`jenis_barang` AS `Jenis Barang`,`t`.`keterangan` AS `Status Transaksi`,`t`.`jumlah_barang` AS `Jumlah Barang`,`p`.`nama_pekerja` AS `Nama Pekerja` from (((`transaksi` `t` left join `barang` `b` on(`t`.`id_barang` = `b`.`id_barang`)) left join `jenis` `j` on(`j`.`id_jenis` = `b`.`id_jenis`)) left join `pekerja` `p` on(`t`.`id_pekerja` = `p`.`id_pekerja`)))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `fk_brg_jenis` (`id_jenis`),
  ADD KEY `fk_brg_distrib` (`id_distributor`);

--
-- Indexes for table `distributor`
--
ALTER TABLE `distributor`
  ADD PRIMARY KEY (`id_distributor`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`),
  ADD KEY `fk_login_pekerja` (`id_pekerja`);

--
-- Indexes for table `pekerja`
--
ALTER TABLE `pekerja`
  ADD PRIMARY KEY (`id_pekerja`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_trans_brg` (`id_barang`),
  ADD KEY `fk_trans_pekerja` (`id_pekerja`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `distributor`
--
ALTER TABLE `distributor`
  MODIFY `id_distributor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pekerja`
--
ALTER TABLE `pekerja`
  MODIFY `id_pekerja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `fk_brg_distrib` FOREIGN KEY (`id_distributor`) REFERENCES `distributor` (`id_distributor`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_brg_jenis` FOREIGN KEY (`id_jenis`) REFERENCES `jenis` (`id_jenis`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `fk_loginPekerja` FOREIGN KEY (`id_pekerja`) REFERENCES `pekerja` (`id_pekerja`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_trans_brg` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trans_pekerja` FOREIGN KEY (`id_pekerja`) REFERENCES `pekerja` (`id_pekerja`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
