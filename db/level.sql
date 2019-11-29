--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(6) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);


--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
