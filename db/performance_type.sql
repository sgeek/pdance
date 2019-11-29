--
-- Table structure for table `performance_type`
--

CREATE TABLE `performance_type` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Indexes for table `performance_type`
--
ALTER TABLE `performance_type`
  ADD PRIMARY KEY (`id`);


--
-- AUTO_INCREMENT for table `performance_type`
--
ALTER TABLE `performance_type`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
