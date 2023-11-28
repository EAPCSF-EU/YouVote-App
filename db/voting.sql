SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET
time_zone = "+00:00";


CREATE TABLE `category`
(
    `id`         int(11) NOT NULL,
    `contest_id` int(11) DEFAULT NULL,
    `title_ru`   varchar(250) NOT NULL,
    `title_en`   varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `contest`
(
    `id`             int(11) NOT NULL,
    `title_en`       varchar(250) NOT NULL,
    `description_en` text         NOT NULL,
    `title_ru`       varchar(250) NOT NULL,
    `description_ru` text         NOT NULL,
    `start_date`     datetime     NOT NULL,
    `end_date`       datetime     NOT NULL,
    `public`         tinyint(1) NOT NULL,
    `result_panel`   tinyint(1) NOT NULL,
    `voters_limit`   int(11) DEFAULT NULL,
    `range`          tinyint(4) NOT NULL COMMENT 'range for example [1-10]',
    `permalink`      varchar(50)           DEFAULT NULL,
    `image`          varchar(255)          DEFAULT NULL,
    `status`         tinyint(1) NOT NULL,
    `created_at`     datetime     NOT NULL,
    `updated_at`     timestamp    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp ()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DELIMITER
$$
CREATE TRIGGER `set_created_at_contest`
    BEFORE INSERT
    ON `contest`
    FOR EACH ROW SET new.created_at=NOW()
$$
DELIMITER;

CREATE TABLE `migration`
(
    `version`    varchar(180) NOT NULL,
    `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `project`
(
    `id`         int(11) NOT NULL,
    `contest_id` int(11) NOT NULL,
    `title_en`   varchar(250) NOT NULL,
    `title_ru`   varchar(250) NOT NULL,
    `content_en` text                  DEFAULT NULL,
    `content_ru` text                  DEFAULT NULL,
    `image`      varchar(1024)         DEFAULT NULL,
    `created_at` datetime     NOT NULL,
    `updated_at` timestamp    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp ()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DELIMITER
$$
CREATE TRIGGER `set_created_at_project`
    BEFORE INSERT
    ON `project`
    FOR EACH ROW SET new.created_at=NOW()
$$
DELIMITER;

CREATE TABLE `project_to_user`
(
    `project_id` int(11) NOT NULL DEFAULT 0,
    `voter_id`   int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `voter`
(
    `id`                   int(11) NOT NULL,
    `username`             varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `name`                 varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
    `auth_key`             varchar(32) COLLATE utf8_unicode_ci  NOT NULL,
    `password_hash`        varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `confirm_token`        varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `email`                varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `status`               smallint(6) NOT NULL DEFAULT 10,
    `created_at`           int(11) NOT NULL,
    `updated_at`           int(11) NOT NULL,
    `role`                 tinyint(4) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `votes`
(
    `id`          int(11) NOT NULL,
    `user_id`     int(11) NOT NULL,
    `project_id`  int(11) NOT NULL,
    `contest_id`  int(11) NOT NULL,
    `category_id` int(11) NOT NULL,
    `score`       int(2) NOT NULL,
    `created_at`  timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `category`
    ADD PRIMARY KEY (`id`),
  ADD KEY `categories_fk0` (`contest_id`);

ALTER TABLE `contest`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `migration`
    ADD PRIMARY KEY (`version`);

ALTER TABLE `project`
    ADD PRIMARY KEY (`id`),
  ADD KEY `contentder_fk0` (`contest_id`);

ALTER TABLE `project_to_user`
    ADD PRIMARY KEY (`project_id`, `voter_id`),
  ADD UNIQUE KEY `project_user_unique` (`project_id`,`voter_id`),
  ADD KEY `project_to_user_voter` (`voter_id`);

ALTER TABLE `voter`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`status`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

ALTER TABLE `votes`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_id` (`project_id`,`contest_id`,`category_id`,`user_id`) USING BTREE,
  ADD KEY `votes_fk0` (`user_id`),
  ADD KEY `votes_category` (`category_id`),
  ADD KEY `votes_contest` (`contest_id`);


ALTER TABLE `category`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `contest`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `project`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `voter`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `votes`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `category`
    ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`contest_id`) REFERENCES `contest` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

ALTER TABLE `project`
    ADD CONSTRAINT `contentder_fk0` FOREIGN KEY (`contest_id`) REFERENCES `contest` (`id`);

ALTER TABLE `project_to_user`
    ADD CONSTRAINT `project_to_user_ibfk_1` FOREIGN KEY (`voter_id`) REFERENCES `voter` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `project_to_user_voter` FOREIGN KEY (`voter_id`) REFERENCES `voter` (`id`) ON
DELETE
NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `votes`
    ADD CONSTRAINT `votes_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `votes_contest` FOREIGN KEY (`contest_id`) REFERENCES `contest` (`id`),
  ADD CONSTRAINT `votes_fk0` FOREIGN KEY (`user_id`) REFERENCES `voter` (`id`),
  ADD CONSTRAINT `votes_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`);

