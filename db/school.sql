--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `id` int(10) UNSIGNED NOT NULL,
  `city` tinyint(3) UNSIGNED NOT NULL COMMENT 'FK city.id',
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_city` (`city`);

--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- Constraints for table `school`
--
ALTER TABLE `school`
  ADD CONSTRAINT `school_city` FOREIGN KEY (`city`) REFERENCES `city` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;
