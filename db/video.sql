--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `id` int(10) UNSIGNED NOT NULL,
  `entry` int(10) UNSIGNED NOT NULL COMMENT 'FK entry.id',
  `follow` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK dancer.id',
  `round` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'FK round.id',
  `heat` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Heat/etc number',
  `type` tinyint(3) UNSIGNED NOT NULL COMMENT 'FK performance_type.id',
  `perm_lead` tinyint(1) NOT NULL DEFAULT '0',
  `perm_follow` tinyint(1) NOT NULL DEFAULT '0',
  `perm_other` tinyint(1) NOT NULL DEFAULT '0',
  `perm_final` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Permissions are finalised for this video',
  `seconds` int(10) UNSIGNED NOT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `code` char(6) NOT NULL COMMENT 'timecode',
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_entry` (`entry`),
  ADD KEY `video_follow` (`follow`),
  ADD KEY `video_round` (`round`),
  ADD KEY `video_type` (`type`);


--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_entry` FOREIGN KEY (`entry`) REFERENCES `entry` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `video_follow` FOREIGN KEY (`follow`) REFERENCES `dancer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `video_round` FOREIGN KEY (`round`) REFERENCES `round` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `video_type` FOREIGN KEY (`type`) REFERENCES `performance_type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;
