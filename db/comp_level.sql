--
-- Table structure for table `comp_level`
--

CREATE TABLE `comp_level` (
  `id` int(10) UNSIGNED NOT NULL,
  `comp` int(10) UNSIGNED NOT NULL COMMENT 'FK comp.id',
  `level` tinyint(3) UNSIGNED NOT NULL COMMENT 'FK level.id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Levels recognised by each comp';


--
-- Indexes for table `comp_level`
--
ALTER TABLE `comp_level`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comp_level_comp` (`comp`),
  ADD KEY `comp_level_level` (`level`);


--
-- AUTO_INCREMENT for table `comp_level`
--
ALTER TABLE `comp_level`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- Constraints for table `comp_level`
--
ALTER TABLE `comp_level`
  ADD CONSTRAINT `comp_level_comp` FOREIGN KEY (`comp`) REFERENCES `comp` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `comp_level_level` FOREIGN KEY (`level`) REFERENCES `level` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;
