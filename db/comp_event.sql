--
-- Table structure for table `comp_event`
--

CREATE TABLE `comp_event` (
  `id` int(10) UNSIGNED NOT NULL,
  `comp` int(10) UNSIGNED NOT NULL COMMENT 'FK comp.id',
  `event` tinyint(3) UNSIGNED NOT NULL COMMENT 'FK event.id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Events offered by each comp';


--
-- Indexes for table `comp_event`
--
ALTER TABLE `comp_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comp_event_comp` (`comp`),
  ADD KEY `comp_event_event` (`event`);


--
-- AUTO_INCREMENT for table `comp_event`
--
ALTER TABLE `comp_event`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- Constraints for table `comp_event`
--
ALTER TABLE `comp_event`
  ADD CONSTRAINT `comp_event_comp` FOREIGN KEY (`comp`) REFERENCES `comp` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `comp_event_event` FOREIGN KEY (`event`) REFERENCES `event` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;
