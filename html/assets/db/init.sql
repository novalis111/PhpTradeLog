--
-- table config
--
CREATE TABLE `config` (
  `id`    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key`   VARCHAR(50)               DEFAULT NULL,
  `value` VARCHAR(255)              DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO `config` (`key`, `value`) VALUES ('version', '1');

--
-- table brokers
--
CREATE TABLE `brokers` (
  `id`    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` VARCHAR(50)      NOT NULL,
  `rates` VARCHAR(255)     NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO `brokers` (`id`, `token`, `rates`) VALUES (1, 'SURE', 'ps=0.01;psmin=4.95');

--
-- table accounts
--
CREATE TABLE `accounts` (
  `id`        INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `broker_id` INT(11) UNSIGNED NOT NULL
    REFERENCES brokers (id)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  `token`     VARCHAR(50)      NOT NULL,
  `cash`      DECIMAL(11, 2)   NOT NULL,
  `margin`    INT(3)           NOT NULL DEFAULT 50,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO `accounts` (`broker_id`, `token`, `cash`, `margin`) VALUES (1, 'Paper', '5000.00', '600');
INSERT INTO `accounts` (`broker_id`, `token`, `cash`, `margin`) VALUES (1, 'Live', '5000.00', '600');

--
-- table trades
--
CREATE TABLE `trades` (
  `id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_id` INT(11) UNSIGNED NOT NULL
    REFERENCES accounts (id)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  `date`       DATETIME         NOT NULL,
  `source`     VARCHAR(255)              DEFAULT NULL,
  `symbol`     VARCHAR(25)      NOT NULL DEFAULT '',
  `side`       VARCHAR(25)      NOT NULL DEFAULT '',
  `type`       VARCHAR(25)      NOT NULL DEFAULT '',
  `pos_size`   INT(11)          NOT NULL,
  `price`      DECIMAL(8, 4)             DEFAULT NULL,
  `comissions` DECIMAL(8, 4)             DEFAULT NULL,
  `notes`      VARCHAR(500)              DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;