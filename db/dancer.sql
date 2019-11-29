--
-- Table structure for table `dancer`
--

CREATE TABLE `dancer` (
  `id` int(10) UNSIGNED NOT NULL,
  `city` tinyint(3) UNSIGNED NOT NULL COMMENT 'FK city.id',
  `firstName` text NOT NULL,
  `lastName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for table `dancer`
--
ALTER TABLE `dancer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dancer_city` (`city`);

--
-- AUTO_INCREMENT for table `dancer`
--
ALTER TABLE `dancer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- Constraints for table `dancer`
--
ALTER TABLE `dancer`
  ADD CONSTRAINT `dancer_city` FOREIGN KEY (`city`) REFERENCES `city` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;
