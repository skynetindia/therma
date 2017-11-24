ALTER TABLE `hotel_main` ADD `treatment_commission` INT NOT NULL COMMENT 'Percentage for comission (%)' AFTER `commission`, ADD `location_priority` INT NOT NULL DEFAULT '100' COMMENT 'Recommended from 1 to 100' AFTER `treatment_commission`;
ALTER TABLE `hotel_main` ADD `country` VARCHAR(150) NOT NULL AFTER `address`;
ALTER TABLE `hotel_main` CHANGE `commission` `commission` VARCHAR(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Percentage for hotel commission';

----- 23-11-2017 -------------

ALTER TABLE `hotel_season` ADD `markets` VARCHAR(255) NOT NULL COMMENT 'ALL: All the country, conutry code put here' AFTER `category`;
ALTER TABLE `countries` ADD `flag_image` VARCHAR(150) NOT NULL AFTER `e_status`;

ALTER TABLE `taxinomies_meals` ADD `is_deleted` INT NOT NULL DEFAULT '0' AFTER `user_id`;