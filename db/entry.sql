--
-- Table structure for table `entry`
--

CREATE TABLE `entry` (
  `id` int(10) UNSIGNED NOT NULL,
  `comp` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'FK comp.id',
  `event` tinyint(3) UNSIGNED NOT NULL COMMENT 'FK event.id',
  `level` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK level.id',
  `lead` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK dancer.id',
  `follow` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK dancer.id',
  `other` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK dancer.id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for table `entry`
--
ALTER TABLE `entry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entry_comp` (`comp`),
  ADD KEY `entry_lead` (`lead`),
  ADD KEY `entry_follow` (`follow`),
  ADD KEY `entry_other` (`other`);


--
-- AUTO_INCREMENT for table `entry`
--
ALTER TABLE `entry`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- Constraints for table `entry`
--
ALTER TABLE `entry`
  ADD CONSTRAINT `entry_comp` FOREIGN KEY (`comp`) REFERENCES `comp` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `entry_follow` FOREIGN KEY (`follow`) REFERENCES `dancer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `entry_lead` FOREIGN KEY (`lead`) REFERENCES `dancer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `entry_other` FOREIGN KEY (`other`) REFERENCES `dancer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;
