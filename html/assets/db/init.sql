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
-- table trades
--
CREATE TABLE `trades` (
  `id`                     INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date`                   DATETIME         NOT NULL,
  `source`                 VARCHAR(255)              DEFAULT NULL,
  `symbol`                 VARCHAR(25)      NOT NULL DEFAULT '',
  `type`                   VARCHAR(25)      NOT NULL DEFAULT '',
  `pos_size`               INT(11)          NOT NULL,
  `price_buy`              DECIMAL(7, 4)             DEFAULT NULL,
  `price_sell`             DECIMAL(7, 4)             DEFAULT NULL,
  `sum_return`             DECIMAL(7, 4)             DEFAULT NULL,
  `price_total_investment` DECIMAL(7, 4)             DEFAULT NULL,
  `price_total_comissions` DECIMAL(7, 4)             DEFAULT NULL,
  `notes`                  VARCHAR(500)              DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;