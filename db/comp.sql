--
-- Table structure for table `comp`
--

CREATE TABLE `comp` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `city` tinyint(3) UNSIGNED NOT NULL COMMENT 'FK city.id',
  `name` text NOT NULL,
  `year` char(4) NOT NULL,
  `folder` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Indexes for table `comp`
--
ALTER TABLE `comp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city` (`city`);

--
-- AUTO_INCREMENT for table `comp`
--
ALTER TABLE `comp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- Constraints for table `comp`
--
ALTER TABLE `comp`
  ADD CONSTRAINT `comp_city` FOREIGN KEY (`city`) REFERENCES `city` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
