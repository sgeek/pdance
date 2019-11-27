--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `country` char(2) NOT NULL DEFAULT 'AU'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Each city that hosts comp/s and/or school/s';


--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);


--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;
