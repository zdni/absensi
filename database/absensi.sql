-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 14 Jul 2021 pada 15.42
-- Versi Server: 5.7.34-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activities`
--

CREATE TABLE `activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type_id` int(10) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `activities`
--

INSERT INTO `activities` (`id`, `name`, `type_id`) VALUES
(1, 'Aktivitas Utama 1', 0000000001),
(2, 'Aktivitas Utama 2', 0000000001),
(3, 'Aktivitas Tambahan 1', 0000000002),
(4, 'Aktivitas Tambahan 2', 0000000002);

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_state`
--

CREATE TABLE `activity_state` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `activity_state`
--

INSERT INTO `activity_state` (`id`, `name`, `color`) VALUES
(1, 'Belum Ditanggapi', 'ffc107'),
(2, 'Diterima', '28a745'),
(3, 'Ditolak', 'dc3545');

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_type`
--

CREATE TABLE `activity_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `activity_type`
--

INSERT INTO `activity_type` (`id`, `name`) VALUES
(1, 'Utama'),
(2, 'Tambahan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `employee_id_number` varchar(255) NOT NULL,
  `position_id` int(10) UNSIGNED NOT NULL,
  `organization_id` int(10) UNSIGNED NOT NULL,
  `religion_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `employee_id_number`, `position_id`, `organization_id`, `religion_id`) VALUES
(2, 14, '198002082008012010', 2, 1, 1),
(4, 16, '12345678901', 1, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_activity`
--

CREATE TABLE `employee_activity` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `checked_employee_id` int(10) UNSIGNED DEFAULT NULL,
  `activity_id` int(10) UNSIGNED NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `result` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `minutes` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `employee_activity`
--

INSERT INTO `employee_activity` (`id`, `employee_id`, `checked_employee_id`, `activity_id`, `state_id`, `result`, `date`, `start_time`, `end_time`, `minutes`, `description`) VALUES
(1, 2, 4, 1, 1, 10, '2021-07-01', '2021-06-30 23:00:00', '2021-06-30 23:30:00', 30, '-'),
(2, 2, 4, 2, 2, 10, '2021-07-01', '2021-06-30 23:30:00', '2021-07-01 04:00:00', 270, '-'),
(3, 2, 4, 3, 3, 10, '2021-07-01', '2021-07-01 05:00:00', '2021-07-01 08:00:00', 180, '-\r\n'),
(4, 2, 4, 4, 2, 10, '2021-07-01', '2021-07-01 08:00:00', '2021-07-13 08:20:00', 20, '-'),
(5, 2, 4, 1, 1, 10, '2021-07-02', '2021-07-01 23:00:00', '2021-07-01 23:30:00', 30, '-'),
(6, 2, 4, 2, 2, 10, '2021-07-02', '2021-07-01 23:30:00', '2021-07-02 04:00:00', 270, '-'),
(7, 2, 4, 3, 3, 10, '2021-07-02', '2021-07-02 05:00:00', '2021-07-02 08:00:00', 180, '-\r\n'),
(8, 2, 4, 4, 2, 10, '2021-07-02', '2021-07-02 08:00:00', '2021-07-02 08:20:00', 20, '-'),
(9, 2, 4, 1, 1, 10, '2021-07-03', '2021-07-02 23:00:00', '2021-07-01 23:30:00', 30, '-'),
(10, 2, 4, 2, 2, 10, '2021-07-03', '2021-07-02 23:30:00', '2021-07-03 04:00:00', 270, '-'),
(11, 2, 4, 3, 3, 10, '2021-07-03', '2021-07-03 05:00:00', '2021-07-03 08:00:00', 180, '-\r\n'),
(12, 2, 4, 4, 2, 10, '2021-07-03', '2021-07-03 08:00:00', '2021-07-03 08:20:00', 20, '-'),
(13, 2, 4, 1, 1, 10, '2021-07-04', '2021-07-03 23:00:00', '2021-07-03 23:30:00', 30, '-'),
(14, 2, 4, 2, 2, 10, '2021-07-04', '2021-07-03 23:30:00', '2021-07-04 04:00:00', 270, '-'),
(15, 2, 4, 3, 3, 10, '2021-07-04', '2021-07-04 05:00:00', '2021-07-04 08:00:00', 180, '-\r\n'),
(16, 2, 4, 4, 2, 10, '2021-07-04', '2021-07-04 08:00:00', '2021-07-04 08:20:00', 20, '-'),
(18, 2, NULL, 1, 1, 2, '2021-07-14', '2021-07-14 07:07:07', '2021-07-14 07:20:07', 13, 'asdasd');

-- --------------------------------------------------------

--
-- Struktur dari tabel `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'uadmin', 'user admin'),
(3, 'employee', '-'),
(4, 'validator', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `link` varchar(50) NOT NULL,
  `list_id` varchar(200) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `position` int(4) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `menus`
--

INSERT INTO `menus` (`id`, `menu_id`, `name`, `link`, `list_id`, `icon`, `status`, `position`, `description`) VALUES
(101, 1, 'Beranda', 'admin/', 'home_index', 'home', 1, 1, '-'),
(102, 1, 'Group', 'admin/group', 'group_index', 'home', 1, 2, '-'),
(103, 1, 'Setting', 'admin/menus', '-', 'cogs', 1, 3, '-'),
(104, 1, 'User', 'admin/user_management', 'user_management_index', 'users', 1, 4, '-'),
(106, 103, 'Menu', 'admin/menus', 'menus_index', 'circle', 1, 1, '-'),
(108, 2, 'Pengguna', 'uadmin/users', 'users_index', 'home', 1, 2, '-'),
(110, 4, 'Aktifitas Pegawai', 'validator/report', 'report_index', 'home', 1, 2, '-'),
(111, 2, 'Data Master', 'uadmin/masters', '-', 'home', 1, 1, '-'),
(112, 111, 'Aktifitas', 'uadmin/activities', 'activities_index', 'home', 1, 1, '-'),
(113, 111, 'Jabatan', 'uadmin/positions', 'positions_index', 'home', 1, 1, '-'),
(114, 111, 'OPD', 'uadmin/organizations', 'organizations_index', 'home', 1, 1, '-'),
(115, 111, 'Jenis Aktifitas', 'uadmin/activity_type', 'activity_type_index', 'home', 1, 1, '-'),
(116, 111, 'Status Aktifitas', 'uadmin/activity_state', 'activity_state_index', 'home', 1, 1, '-'),
(117, 3, 'Dashboard', 'employee/home', 'home_index', 'home', 1, 1, '-'),
(118, 3, 'Aktifitas', 'employee/activities', 'activities_index', 'home', 1, 1, '-'),
(119, 3, 'Log Informasi', 'employee/log', 'log_index', 'home', 1, 1, '-'),
(120, 2, 'Aktifitas Pegawai', 'validator/report', 'report_index', 'home', 1, 2, '-'),
(121, 4, 'Dashboard', 'employee/home', 'home_index', 'home', 1, 1, '-'),
(122, 4, 'Aktifitas', 'employee/activities', 'activities_index', 'home', 1, 1, '-'),
(123, 4, 'Log Informasi', 'employee/log', 'log_index', 'home', 1, 1, '-'),
(124, 4, 'Validasi Aktivitas', 'validator/validate', 'validate_index', 'home', 1, 1, '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `organizations`
--

CREATE TABLE `organizations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `sequence`) VALUES
(1, 'OPD 1', 0),
(2, 'OPD 2', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `positions`
--

CREATE TABLE `positions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `positions`
--

INSERT INTO `positions` (`id`, `name`, `sequence`) VALUES
(1, 'Jabatan 1', 0),
(2, 'Jabatan 2', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `religions`
--

CREATE TABLE `religions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `religions`
--

INSERT INTO `religions` (`id`, `name`) VALUES
(1, 'Islam'),
(2, 'Kristen'),
(3, 'Katolik'),
(4, 'Hindu'),
(5, 'Buddha'),
(6, 'Konghucu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `image` text NOT NULL,
  `address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `phone`, `image`, `address`) VALUES
(1, '127.0.0.1', 'admin@fixl.com', '$2y$12$XpBgMvQ5JzfvN3PTgf/tA.XwxbCOs3mO0a10oP9/11qi1NUpv46.u', 'admin@fixl.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1626247443, 1, 'Admin', 'istrator', '081342989185', 'USER_1_1571554027.jpeg', 'admin'),
(13, '::1', 'uadmin@gmail.com', '$2y$10$78SZyvKRKMU7nPCew9w4nOpEUmJ1SeTV4L4ZG2NXXSfbEaswqoepq', 'uadmin@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1568678256, 1626170401, 1, 'admin', 'Dinas', '00', 'USER_13_1568678463.jpg', 'jln mutiara no 8'),
(14, '::1', 'employee@gmail.com', '$2y$10$.MWFRcRMOduNfxroZpgnOe.dgfDiZVnDDhG/QJ7aWjW2HPXr57zX2', 'employee@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1625887077, 1626243446, 1, 'Pegawai', '(Contoh)', '123456789012', 'default.jpg', 'jalan'),
(16, '::1', 'admin.employee@gmail.com', '$2y$10$CI0ZX1aKG6aCtiyYS5xxA.c0ZXPhTETbvOB9v/SDnIq1lrdjJLccW', 'admin.employee@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1626170439, 1626247484, 1, 'Pegawai', 'Validasi', '089876351278', 'default.jpg', 'jalan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(29, 13, 2),
(36, 14, 3),
(38, 16, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `activity_state`
--
ALTER TABLE `activity_state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_type`
--
ALTER TABLE `activity_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `organization_id` (`organization_id`),
  ADD KEY `religion_id` (`religion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `employee_activity`
--
ALTER TABLE `employee_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_id` (`activity_id`),
  ADD KEY `state_id` (`state_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `checked_employee_id` (`checked_employee_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `religions`
--
ALTER TABLE `religions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `activity_state`
--
ALTER TABLE `activity_state`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `activity_type`
--
ALTER TABLE `activity_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `employee_activity`
--
ALTER TABLE `employee_activity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;
--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `religions`
--
ALTER TABLE `religions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `activity_type` (`id`);

--
-- Ketidakleluasaan untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`),
  ADD CONSTRAINT `employees_ibfk_3` FOREIGN KEY (`religion_id`) REFERENCES `religions` (`id`),
  ADD CONSTRAINT `employees_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `employee_activity`
--
ALTER TABLE `employee_activity`
  ADD CONSTRAINT `employee_activity_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  ADD CONSTRAINT `employee_activity_ibfk_3` FOREIGN KEY (`state_id`) REFERENCES `activity_state` (`id`),
  ADD CONSTRAINT `employee_activity_ibfk_4` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `employee_activity_ibfk_5` FOREIGN KEY (`checked_employee_id`) REFERENCES `employees` (`id`);

--
-- Ketidakleluasaan untuk tabel `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
