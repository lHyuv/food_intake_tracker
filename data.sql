INSERT INTO `roles` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
('4a106c3b-2666-48cb-8bee-a72a778f77fa', 'Admin', 'Active', NULL, NULL),
('80c62f6f-6dfe-4c6f-a193-0c4ae4de9b9f', 'Client', 'Active', NULL, NULL);

INSERT INTO `health_issues` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01f5b5fe-4454-4cc4-833b-a87795ed6e7a', 'High Blood', 'Active', NULL, NULL, NULL),
('342e41b2-008b-43cd-9179-62e58ac4e83a', 'Ailment affected by excessive Sugar e.g. Diabetes', 'Active', NULL, NULL, NULL),
('bc424a21-20ec-4c0e-aa2a-0a2ca1791675', 'Ailment affected by excessive Salt e.g. Kidney Problems', 'Active', NULL, NULL, NULL);

ALTER TABLE roles
ADD deleted_at DATETIME NULL;

ALTER TABLE userissues
ADD deleted_at DATETIME NULL; 