SET foreign_key_checks = 0;

-- ---------------------------------------------------------------------
-- places subscribed
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_user`;

CREATE TABLE `tbl_user` (
  `user_id`                    int(11) NOT NULL AUTO_INCREMENT,
  `user_name`                  varchar(255) NOT NULL  COMMENT 'unique',

  `email`                      varchar(255) NOT NULL COMMENT 'unique, same as username',
  `password`                   varchar(255) NOT NULL COMMENT 'encrypted',
  
  `first_name`                 varchar(255) NOT NULL,
  `last_name`                  varchar(255) NOT NULL, 
  
  `user_type`                  enum('superadmin','admin','user','business_user') DEFAULT 'user',
  
  `status`                     enum('inactive', 'active', 'deleted', 'banned') DEFAULT 'inactive',
  
  `created_time`               TIMESTAMP NOT NULL DEFAULT 0,
  `modified_time`              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  `created_by`                 int(11) NOT NULL COMMENT 'FK with user',
  `modified_by`                int(11) NOT NULL COMMENT 'FK with user',  
  
  `activation_code`            varchar(255) DEFAULT NULL,  
  `activation_status`          enum('activated', 'not_activated') DEFAULT 'not_activated',
  `activation_time`            datetime NOT NULL DEFAULT 0,
  
  `facebook_id`                varchar(255) DEFAULT NULL,
  `facebook_name`              varchar(255) DEFAULT NULL,
  `registered_with_fb`         enum('Y', 'N') DEFAULT 'N' COMMENT 'For facebook registrations',

  `loggedin_with_fb`           enum('Y', 'N') DEFAULT 'N' COMMENT 'For current session',
  
  `login_status`               enum('logged in', 'logged out') DEFAULT 'logged out',

  `last_login`                 datetime DEFAULT NULL,
  
  `mobile_number`              varchar(64) DEFAULT NULL,
  `mobile_carrier_id`          int(11) DEFAULT NULL COMMENT 'FK with mobile_carrier',
  `send_sms_notification`      enum('Y', 'N') DEFAULT 'N',
  
  `date_of_birth`              date DEFAULT NULL,
  `hometown`                   varchar(255) DEFAULT NULL,
  `marital_status`             enum('Married', 'Single', 'Unknown') DEFAULT NULL,

  `places_want_to_visit`       varchar(255) DEFAULT NULL,
  
  `my_info_permissions`         enum('none', 'friends', 'all') DEFAULT 'all',
  `photos_permissions`          enum('none', 'friends', 'all') DEFAULT 'all',
  `friends_permissions`         enum('none', 'friends', 'all') DEFAULT 'all',
  `blogs_permissions`           enum('none', 'friends', 'all') DEFAULT 'all',
  `travel_options_permissions`  enum('none', 'friends', 'all') DEFAULT 'all',

  `image`                      varchar(255) DEFAULT NULL,

  PRIMARY KEY (`user_id`),
  UNIQUE KEY `unqkey_user_name` (`user_name`),
  UNIQUE KEY `unqkey_email` (`email`),
  UNIQUE KEY `unqkey_facebook_id` (`facebook_id`)


) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

ALTER TABLE tbl_user
ADD CONSTRAINT fk_user_created_by
     FOREIGN KEY (created_by) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_user
ADD CONSTRAINT fk_user_modified_by
     FOREIGN KEY (modified_by) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_user
ADD CONSTRAINT fk_mobile_carrier
     FOREIGN KEY (mobile_carrier_id) 
     REFERENCES tbl_mobile_carrier(mobile_carrier_id);
     
     
-- ---------------------------------------------------------------------
-- country
-- ---------------------------------------------------------------------
  DROP TABLE IF EXISTS `tbl_country`;

  CREATE TABLE `tbl_country` (
    `country_id` int(11) NOT NULL AUTO_INCREMENT,
    `country_name` varchar(512) NOT NULL DEFAULT 'United States of America',
    `iso_code` varchar(32) NOT NULL DEFAULT 'US',
  PRIMARY KEY (`country_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

  INSERT INTO tbl_country set country_name = 'United States of America', iso_code = 'US';
     
-- ---------------------------------------------------------------------
-- state
-- ---------------------------------------------------------------------
  DROP TABLE IF EXISTS `tbl_state`;

  CREATE TABLE `tbl_state` (
    `state_id` int(11) NOT NULL AUTO_INCREMENT,
    `state_name` varchar(512) NOT NULL DEFAULT 'Florida',
    `country_id` int(11) NOT NULL,
    `time_zone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`state_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

ALTER TABLE tbl_state
ADD CONSTRAINT fk_state_country
     FOREIGN KEY (country_id) 
     REFERENCES tbl_country(country_id);
     
  INSERT INTO tbl_state set state_name = 'Florida', country_id = 1;
  
-- ---------------------------------------------------------------------
-- city
-- ---------------------------------------------------------------------

 DROP TABLE IF EXISTS `tbl_city`;

 CREATE TABLE `tbl_city` (
    `city_id`           int(11) NOT NULL AUTO_INCREMENT,
    `city_name`         varchar(512) NOT NULL DEFAULT 'Florida',
    `city_alternate_name`    varchar(1024) NOT NULL DEFAULT 'Florida',
    `state_id`          int(11) NOT NULL,
    `time_zone`         varchar(50) DEFAULT NULL,
    
    `is_featured`       enum('Y', 'N') DEFAULT 'N',
    `isactive`          enum('Y', 'N') DEFAULT 'N',

    `description`      TEXT NOT NULL COMMENT 'Description',
    `more_information` TEXT NOT NULL COMMENT 'More Info',
 
    `image` text,
  PRIMARY KEY (`city_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

ALTER TABLE tbl_city
ADD CONSTRAINT fk_city_state
     FOREIGN KEY (state_id) 
     REFERENCES tbl_state(state_id);

     
-- ---------------------------------------------------------------------
-- places visited
-- ---------------------------------------------------------------------
 DROP TABLE IF EXISTS `tbl_places_visited`;
 
  CREATE TABLE `tbl_places_visited` (
    `places_visted_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `city_id` int(11) NOT NULL,
  PRIMARY KEY (`places_visted_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

ALTER TABLE tbl_places_visited
ADD CONSTRAINT fk_places_visited_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_places_visited
ADD CONSTRAINT fk_places_visited_city
     FOREIGN KEY (city_id) 
     REFERENCES tbl_city(city_id);
     
     

-- ---------------------------------------------------------------------
-- places subscribed
-- ---------------------------------------------------------------------
  DROP TABLE IF EXISTS `tbl_places_subscribed`;
  
  CREATE TABLE `tbl_places_subscribed` (
    `places_subscribed_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `city_id` int(11) NOT NULL,
  PRIMARY KEY (`places_subscribed_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

ALTER TABLE tbl_places_subscribed
ADD CONSTRAINT fk_places_subscribed_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_places_subscribed
ADD CONSTRAINT fk_places_subscribed_city
     FOREIGN KEY (city_id) 
     REFERENCES tbl_city(city_id);
     
    
-- ---------------------------------------------------------------------
-- page
-- ---------------------------------------------------------------------
 DROP TABLE IF EXISTS `tbl_page`;

  CREATE TABLE `tbl_page` (    
    
  `page_id` int(5) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(512) NOT NULL DEFAULT 'Florida',

  `page_type` ENUM('city', 'state', 'static') default 'static',

  `page_contents` text,
  
  `created_time`               TIMESTAMP NOT NULL DEFAULT 0,
  `modified_time`              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  `created_by`                 int(11) NOT NULL COMMENT 'FK with user',
  `modified_by`                int(11) NOT NULL COMMENT 'FK with user',  
    
  PRIMARY KEY (`page_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;


ALTER TABLE tbl_page
ADD CONSTRAINT fk_page_created_by
     FOREIGN KEY (created_by) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_page
ADD CONSTRAINT fk_page_modified_by
     FOREIGN KEY (modified_by) 
     REFERENCES tbl_user(user_id);    
     
     

-- ---------------------------------------------------------------------
-- photo
-- ---------------------------------------------------------------------

 DROP TABLE IF EXISTS `tbl_photo`;

 CREATE TABLE `tbl_photo` (
    `photo_id`        int(11) NOT NULL AUTO_INCREMENT,
    `photo_type`      enum('city', 'state', 'location', 'user', 'general', 'site') DEFAULT 'general',
    `entity_id`       int(11) NOT NULL, 
    `caption`         varchar(255) NOT NULL DEFAULT '',
    `title`           varchar(255) NOT NULL DEFAULT '',
    `path`            varchar(512) NOT NULL DEFAULT '',
    `thumbnail`       varchar(512) NOT NULL DEFAULT '',
  PRIMARY KEY (`photo_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

-- Can be done in Yii using condition on relations
-- 'city' => array(self::BELONGS_TO, 'City', 'city_id', 'condition' => 'photo_type = "city"'),
-- 'location' => array(self::BELONGS_TO, 'Locations', 'location_id', 'condition' => 'photo_type = "location"'),


-- ---------------------------------------------------------------------
-- saved_search
-- ---------------------------------------------------------------------
 
 DROP TABLE IF EXISTS `tbl_saved_search`;
  
 CREATE TABLE `tbl_saved_search` (
  `search_id`        int(11) NOT NULL AUTO_INCREMENT,
  `user_id`          int(11) NOT NULL,    -- fk to user 
  `search_name`      varchar(255) NOT NULL DEFAULT '',
  `created_time`     timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `search_details` text NOT NULL DEFAULT '',       -- Serialised string with filter details
  PRIMARY KEY (`search_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;
  
  
ALTER TABLE tbl_saved_search
ADD CONSTRAINT fk_saved_search_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);    
     
-- ---------------------------------------------------------------------
-- business
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_business`;

CREATE TABLE `tbl_business` (
  `business_id`             int(11) NOT NULL AUTO_INCREMENT,
  
  `business_name`           varchar(255) NOT NULL,
  `business_address1`       longtext,
  `business_address2`       longtext,
  `business_city_id`        int(11) DEFAULT NULL,
  `business_zipcode`        varchar(16) DEFAULT NULL,
  `business_phone_ext`      varchar(16) DEFAULT NULL,
  `business_phone`          varchar(16) DEFAULT NULL,
  `business_email`          varchar(255) DEFAULT NULL,
  `business_website`        varchar(255) DEFAULT NULL,
 
  `business_description`    text,
  
  `image`                   text,
  
  `business_allow_review`   enum('Y', 'N') DEFAULT 'N',
  `business_allow_rating`   enum('Y', 'N') DEFAULT 'N',
  
  
  `business_keywords`       text,

  `created_time`            TIMESTAMP NOT NULL DEFAULT 0,
  `modified_time`           TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  `created_by`              int(11) NOT NULL COMMENT 'FK with user',
  `modified_by`             int(11) NOT NULL COMMENT 'FK with user',  
  
  `add_request_processing_status` ENUM('Accepted', 'Rejected') DEFAULT 'Rejected',
  `add_request_processing_time`   TIMESTAMP NOT NULL COMMENT 'Used for rejection as well',
  `add_request_processed_by`      int(11) NOT NULL,
  `add_request_rejection_reason`  varchar(255) NOT NULL,

  
  `claim_status`               ENUM('Claimed', 'Unclaimed') DEFAULT 'Unclaimed',
  `claim_processing_time`      TIMESTAMP NOT NULL  COMMENT 'Used for rejection as well',
  `claimed_by`                 int(11) NOT NULL,
  `claim_rejection_reason`     varchar(255) NOT NULL,
  
  
  `is_active`                  enum('Y', 'N') DEFAULT 'N',
  `is_featured`                enum('Y', 'N') DEFAULT 'N',
  `is_closed`                  enum('Y', 'N') DEFAULT 'N',

  `activation_code`            varchar(255) DEFAULT NULL,  
  `activation_status`          enum('activated', 'not_activated') DEFAULT 'not_activated',
  `activation_time`            TIMESTAMP,

  PRIMARY KEY (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;


ALTER TABLE tbl_business
ADD CONSTRAINT fk_business_created_by
     FOREIGN KEY (created_by) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_business
ADD CONSTRAINT fk_business_modified_by
     FOREIGN KEY (modified_by) 
     REFERENCES tbl_user(user_id);
  
ALTER TABLE tbl_business
ADD CONSTRAINT fk_business_claimed_by
     FOREIGN KEY (claimed_by) 
     REFERENCES tbl_user(user_id);

ALTER TABLE tbl_business
ADD CONSTRAINT fk_business_user_request_processed
     FOREIGN KEY (add_request_processed_by) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_business
ADD CONSTRAINT fk_business_city
     FOREIGN KEY (business_city_id) 
     REFERENCES tbl_city(city_id);


  -- `business_review` text,
  --`business_aboutus` longtext,
  --`business_specialities` longtext,
  --`business_year_established` longtext,
  --`business_history` longtext,
  
  --`business_img` varchar(500) DEFAULT NULL,
  --`business_lat` varchar(100) DEFAULT NULL,
  --`business_long` varchar(100) DEFAULT NULL,
  --`business_verify_code` int(11) DEFAULT NULL,
  --`business_verified` tinyint(2) DEFAULT '0',



-- ---------------------------------------------------------------------
-- saved_search
-- ---------------------------------------------------------------------
 
 DROP TABLE IF EXISTS `tbl_business_user`;
  
 CREATE TABLE `tbl_business_user` (
  `business_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id`      int(11) NOT NULL,    -- fk to business
  `user_id`          int(11) NOT NULL,    -- fk to user 
  `primary_user`     enum('Y', 'N') DEFAULT 'N',
  PRIMARY KEY        (`business_user_id`),
  UNIQUE KEY         `idx_business_primary_user` (`business_id`,`user_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;
  
  
ALTER TABLE tbl_business_user
ADD CONSTRAINT fk_business_user_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_business_user
ADD CONSTRAINT fk_business_user_business
     FOREIGN KEY (business_id) 
     REFERENCES tbl_business(business_id);  
     
     
-- ---------------------------------------------------------------------
-- event
-- ---------------------------------------------------------------------
 DROP TABLE IF EXISTS `tbl_event`;

  CREATE TABLE `tbl_event` (    
    
  `event_id`            int(11) NOT NULL AUTO_INCREMENT,

  `event_title`         varchar(255) NOT NULL,
  `event_description`   text,

  `event_type`          enum('public', 'private', 'meetups'),
  
  `event_start_date`    date NOT NULL,
  `event_end_date`      date NOT NULL,
  `event_start_time`    time,
  `event_end_time`      time,
  `event_frequency`     varchar(64) DEFAULT NULL,
  
  `event_address1`      varchar(1024) DEFAULT NULL,
  `event_address2`      varchar(1024) DEFAULT NULL,
  `event_street`        varchar(512) DEFAULT NULL,
  `event_city_id`       int(11) DEFAULT NULL,
  `event_phone_no`      varchar(32) DEFAULT NULL,
  `event_show_map`      enum('Y', 'N') DEFAULT 'N',
  
  `event_photo`         text,
  
  `event_category_id`   int(11) NOT NULL COMMENT 'tbl_category',
  
  `event_business_id`   int(11) NOT NULL COMMENT 'tbl_business',
  
  `event_latitude`      DECIMAL (10,8)  DEFAULT NULL,
  `event_longitude`     DECIMAL (10,8)  DEFAULT NULL,
  
  
  `event_tag`           text NOT NULL,
  
  
  `created_time`        TIMESTAMP NOT NULL DEFAULT 0,
  `modified_time`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  `created_by`          int(11) NOT NULL COMMENT 'FK with user',
  `modified_by`         int(11) NOT NULL COMMENT 'FK with user',  
  
  `is_featured`         enum('Y', 'N') DEFAULT 'N',
  `is_popular`          enum('Y', 'N') DEFAULT 'N',
  
  `event_status`        ENUM('Inactive', 'Active','Closed', 'Cancelled') DEFAULT 'Inactive',
  
  `cost`                varchar(255) DEFAULT NULL, 
    
  `event_views`         integer(11) DEFAULT '0', 
    
  PRIMARY KEY (`event_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;


ALTER TABLE tbl_event
ADD CONSTRAINT fk_event_created_by
     FOREIGN KEY (created_by) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_event
ADD CONSTRAINT fk_event_modified_by
     FOREIGN KEY (modified_by) 
     REFERENCES tbl_user(user_id);
     
     
	ALTER TABLE tbl_event
	ADD CONSTRAINT fk_event_city
	     FOREIGN KEY (event_city_id) 
	     REFERENCES tbl_city(city_id);
     
 
-- ---------------------------------------------------------------------
-- tbl_user_event
-- ---------------------------------------------------------------------
  DROP TABLE IF EXISTS `tbl_user_event`;
  
  CREATE TABLE `tbl_user_event` (
    `user_event_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `event_id` int(11) NOT NULL,
  PRIMARY KEY (`user_event_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

ALTER TABLE tbl_user_event
ADD CONSTRAINT fk_user_event_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
     
ALTER TABLE tbl_user_event
ADD CONSTRAINT fk_user_event_event
     FOREIGN KEY (event_id) 
     REFERENCES tbl_event(event_id);
          
-- ---------------------------------------------------------------------
-- saved_search
-- ---------------------------------------------------------------------
 
 DROP TABLE IF EXISTS `tbl_restaurant_certificate`;
  
 CREATE TABLE `tbl_restaurant_certificate` (
 
  `certificate_id`          int(11) NOT NULL AUTO_INCREMENT,
  `certificate_number`      varchar(255) DEFAULT NULL,
  `purchase_amount`         DECIMAL(13,2) DEFAULT NULL,
  `discount`                DECIMAL(13,2) DEFAULT NULL,
  `purchase_date`           DATE DEFAULT NULL,
  
  `business_id`             int(11) DEFAULT NULL,
  `purchased_by_business_date` DATETIME DEFAULT NULL,

  `availability_status`     ENUM('Available', 'Purchased'),
  
  `redeemer_email`          varchar(64) DEFAULT NULL,
  `redeemer_user_id`        int(11) DEFAULT NULL,
  `redeem_date`             DATETIME DEFAULT NULL,  

  PRIMARY KEY (`certificate_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;
  
  
ALTER TABLE tbl_restaurant_certificate
ADD CONSTRAINT fk_restaurant_certificate_business
     FOREIGN KEY (business_id) 
     REFERENCES tbl_business(business_id);  
     
   
-- ---------------------------------------------------------------------
-- email template
-- ---------------------------------------------------------------------
 
 DROP TABLE IF EXISTS `tbl_mail_template`;
 
 CREATE TABLE `tbl_mail_template` (
  `template_id`         int(11) NOT NULL AUTO_INCREMENT,
  `template_name`       varchar(128) NOT NULL,
  `msg`                 text NOT NULL,
  `isreadonly`          enum('Y', 'N') DEFAULT 'N',

  `created_time`        TIMESTAMP NOT NULL DEFAULT 0,
  `modified_time`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  `created_by`          int(11) NOT NULL COMMENT 'FK with user',
  `modified_by`         int(11) NOT NULL COMMENT 'FK with user',
  
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;


  
ALTER TABLE tbl_mail_template
ADD CONSTRAINT fk_mail_template_created_by
     FOREIGN KEY (created_by) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_mail_template
ADD CONSTRAINT fk_mail_template_modified_by
     FOREIGN KEY (modified_by) 
     REFERENCES tbl_user(user_id);
     

-- ---------------------------------------------------------------------
-- advert
-- ---------------------------------------------------------------------
 
 DROP TABLE IF EXISTS `tbl_advertisement`;
 
CREATE TABLE `tbl_advertisement` (
  `advertisement_id`    int(11) NOT NULL AUTO_INCREMENT,

  `advert_type`         enum('Google', 'Custom', 'Any') DEFAULT 'Any',
  
  `title`               varchar(255) DEFAULT NULL,
  `content`             TEXT NOT NULL,
  -- `google_code`         text,
  `image`               text,
  
  `created_time`        TIMESTAMP NOT NULL DEFAULT 0,
  `modified_time`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  `created_by`          int(11) NOT NULL COMMENT 'FK with user',
  `modified_by`         int(11) NOT NULL COMMENT 'FK with user',
  
  `published`           enum('Y', 'N') DEFAULT 'N',
  
  `publish_date`        DATE,
  `expiry_date`         DATE,
  

  `user_id`             int(11) DEFAULT NULL,
  
  
  `maximum_ads_views`           double DEFAULT NULL,
  `maximum_ads_clicks`          double DEFAULT NULL,

  `ads_views`           double DEFAULT NULL,
  `ads_clicks`          double DEFAULT NULL,

  PRIMARY KEY (`advertisement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



  
ALTER TABLE tbl_advertisement
ADD CONSTRAINT fk_advertisement_created_by
     FOREIGN KEY (created_by) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_advertisement
ADD CONSTRAINT fk_advertisement_modified_by
     FOREIGN KEY (modified_by) 
     REFERENCES tbl_user(user_id);
     
     
ALTER TABLE tbl_advertisement
ADD CONSTRAINT fk_advertisement_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     

-- alter table tbl_advertisement change column piblish_date publish_date DATE;
     
-- ---------------------------------------------------------------------
-- Mobile Carriers
-- ---------------------------------------------------------------------
 DROP TABLE IF EXISTS `tbl_mobile_carrier`;

CREATE TABLE `tbl_mobile_carrier` (
  `mobile_carrier_id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile_carrier_name`       varchar(255) NOT NULL,
  PRIMARY KEY (`mobile_carrier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ---------------------------------------------------------------------
-- system settings
-- ---------------------------------------------------------------------


CREATE TABLE `tbl_system_settings` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute`   varchar(255) NOT NULL,
  `value`       varchar(4096) NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- ---------------------------------------------------------------------
-- END
-- ---------------------------------------------------------------------