drop table maillist_user;

CREATE TABLE `maillist_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `webpage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
  `validated` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
  `validation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subscription_status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  subscribe_date timestamp not null default 0,
  details_updated timestamp default now() on update now(),
  unsubscribe_date date,
  `unsubscribe_reason`  TINYTEXT COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


drop table document_request;

CREATE TABLE `document_request` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  `fullname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  request_date timestamp default '0000-00-00 00:00:00',
  collection_date datetime default '0000-00-00 00:00:00',
  `request_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resource_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
