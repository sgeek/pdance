--
-- Table structure for table `comp_dancer`
--

CREATE TABLE `comp_dancer` (
  `id` int(10) UNSIGNED NOT NULL,
  `comp` int(10) UNSIGNED NOT NULL COMMENT 'FK comp.id',
  `dancer` int(10) UNSIGNED NOT NULL COMMENT 'FK dancer.id',
  `bib` int(10) UNSIGNED NOT NULL,
  `school` int(10) UNSIGNED NOT NULL COMMENT 'FK school.id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for table `comp_dancer`
--
ALTER TABLE `comp_dancer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `competitor_comp` (`comp`),
  ADD KEY `competitor_dancer` (`dancer`),
  ADD KEY `competitor_school` (`school`);

--
-- AUTO_INCREMENT for table `comp_dancer`
--
ALTER TABLE `comp_dancer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- Constraints for table `comp_dancer`
--
ALTER TABLE `comp_dancer`
  ADD CONSTRAINT `competitor_comp` FOREIGN KEY (`comp`) REFERENCES `comp` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `competitor_dancer` FOREIGN KEY (`dancer`) REFERENCES `dancer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `competitor_school` FOREIGN KEY (`school`) REFERENCES `school` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;
