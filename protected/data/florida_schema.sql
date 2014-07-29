
SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;


-- ---------------------------------------------------------------------
-- places user
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


) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

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
     
     
ALTER TABLE tbl_user CHANGE `places_want_to_visit`  `places_want_to_visit` TEXT  DEFAULT NULL;
ALTER TABLE tbl_user ADD COLUMN `places_visited` TEXT  DEFAULT NULL;

ALTER TABLE tbl_user ADD COLUMN `language` VARCHAR(255)  DEFAULT NULL;
     
-- ---------------------------------------------------------------------
-- country
-- ---------------------------------------------------------------------
  DROP TABLE IF EXISTS `tbl_country`;

  CREATE TABLE `tbl_country` (
    `country_id` int(11) NOT NULL AUTO_INCREMENT,
    `country_name` varchar(512) NOT NULL DEFAULT 'United States of America',
    `iso_code` varchar(32) NOT NULL DEFAULT 'US',
  PRIMARY KEY (`country_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

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
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

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
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

ALTER TABLE tbl_city
ADD CONSTRAINT fk_city_state
     FOREIGN KEY (state_id) 
     REFERENCES tbl_state(state_id);

-- alter  table tbl_city  change city_name city_name varchar(512) NOT NULL DEFAULT '';
-- alter  table tbl_city  change city_alternate_name city_alternate_name varchar(512) NOT NULL DEFAULT '';

ALTER TABLE tbl_city ADD COLUMN `latitude`  DECIMAL (10,8)  DEFAULT NULL;
ALTER TABLE tbl_city ADD COLUMN `longitude` DECIMAL (10,8)  DEFAULT NULL;
     
-- ---------------------------------------------------------------------
-- City Admin User
-- ---------------------------------------------------------------------
 
 DROP TABLE IF EXISTS `tbl_city_admin`;
  
 CREATE TABLE `tbl_city_admin` (
  `city_admin_id`   int(11) NOT NULL AUTO_INCREMENT,
  `city_id`         int(11) NOT NULL,    -- fk to city
  `user_id`         int(11) NOT NULL,    -- fk to user 
  PRIMARY KEY        (`city_admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
  
  
ALTER TABLE tbl_city_admin
ADD CONSTRAINT fk_city_admin_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_city_admin
ADD CONSTRAINT fk_city_admin_city_id
     FOREIGN KEY (city_id) 
     REFERENCES tbl_city(city_id);  
     
     
-- ---------------------------------------------------------------------
-- places visited
-- ---------------------------------------------------------------------
 DROP TABLE IF EXISTS `tbl_places_visited`;
 
  CREATE TABLE `tbl_places_visited` (
    `places_visted_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `city_id` int(11) NOT NULL,
  PRIMARY KEY (`places_visted_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

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
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

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
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;


ALTER TABLE tbl_page
ADD CONSTRAINT fk_page_created_by
     FOREIGN KEY (created_by) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_page
ADD CONSTRAINT fk_page_modified_by
     FOREIGN KEY (modified_by) 
     REFERENCES tbl_user(user_id);    
     
     

-- ---------------------------------------------------------------------
-- photo - for additional photos
-- ---------------------------------------------------------------------

 DROP TABLE IF EXISTS `tbl_photo`;

 CREATE TABLE `tbl_photo` (
    `photo_id`        int(11) NOT NULL AUTO_INCREMENT,
    `photo_type`      enum('city', 'state', 'business', 'user', 'general', 'event') DEFAULT 'general',
    `entity_id`       int(11) NOT NULL, 
    `caption`         varchar(255) NOT NULL DEFAULT '',
    `title`           varchar(255) NOT NULL DEFAULT '',
    `path`            varchar(512) NOT NULL DEFAULT '',
    `thumbnail`       varchar(512) NOT NULL DEFAULT '',
  PRIMARY KEY (`photo_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

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
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
  
  
ALTER TABLE tbl_saved_search
ADD CONSTRAINT fk_saved_search_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE `tbl_saved_search` ADD COLUMN filter_activity varchar(255);
ALTER TABLE `tbl_saved_search` ADD COLUMN filter_activitytype varchar(255);
     
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
  `add_request_processing_time`   TIMESTAMP COMMENT 'Used for rejection as well',
  `add_request_processed_by`      int(11) DEFAULT NULL,
  `add_request_rejection_reason`  varchar(255) DEFAULT NULL,

  
  `claim_status`               ENUM('Claimed', 'Unclaimed') DEFAULT 'Unclaimed',
  `claim_processing_time`      TIMESTAMP DEFAULT 0 COMMENT 'Used for rejection as well',
  `claimed_by`                 int(11)DEFAULT NULL,
  `claim_rejection_reason`     varchar(255) DEFAULT NULL,
  
  
  `is_active`                  enum('Y', 'N') DEFAULT 'N',
  `is_featured`                enum('Y', 'N') DEFAULT 'N',
  `is_closed`                  enum('Y', 'N') DEFAULT 'N',

  `activation_code`            varchar(255) DEFAULT NULL,  
  `activation_status`          enum('activated', 'not_activated') DEFAULT 'not_activated',
  `activation_time`            TIMESTAMP,

  PRIMARY KEY (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;


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

ALTER TABLE tbl_business ADD COLUMN `latitude`  DECIMAL (10,8)  DEFAULT NULL;
ALTER TABLE tbl_business ADD COLUMN `longitude` DECIMAL (10,8)  DEFAULT NULL;
ALTER TABLE tbl_business ADD COLUMN `report_closed_reference` TEXT  DEFAULT NULL;
ALTER TABLE tbl_business ADD COLUMN `report_closed_by`    int(11)       DEFAULT NULL;
ALTER TABLE tbl_business ADD COLUMN `report_closed_date` DATE DEFAULT NULL;
ALTER TABLE tbl_business CHANGE COLUMN `is_closed` `is_closed`  enum('Y','N','Pending')  DEFAULT 'N';


ALTER TABLE tbl_business
ADD CONSTRAINT fk_business_report_closed_by
     FOREIGN KEY (report_closed_by) 
     REFERENCES tbl_user(user_id);



-- --------
--  Changes to capture hotels as businesses (as opposed to using seperate table)
-- --------
ALTER TABLE tbl_business ADD COLUMN `business_type` VARCHAR(128)  DEFAULT NULL;
ALTER TABLE tbl_business ADD COLUMN `star_rating`   INT(2)        DEFAULT NULL;
ALTER TABLE tbl_business ADD COLUMN `low_rate`      double        DEFAULT NULL;
ALTER TABLE tbl_business ADD COLUMN `room_count`    int(11)       DEFAULT NULL;
ALTER TABLE tbl_business ADD COLUMN `opening_time`  VARCHAR(255)  DEFAULT NULL;
ALTER TABLE tbl_business ADD COLUMN `closing_time`  VARCHAR(255 ) DEFAULT NULL;
ALTER TABLE tbl_business ADD COLUMN `import_reference`  VARCHAR(255) DEFAULT NULL;
ALTER TABLE tbl_business ADD COLUMN `import_source`    VARCHAR(255) DEFAULT NULL;

ALTER TABLE tbl_business CHANGE COLUMN `star_rating` `star_rating`  double         DEFAULT NULL;

ALTER TABLE tbl_business ADD COLUMN `is_for_review` enum('Y', 'N') DEFAULT 'N';

-- ---------------------------------------------------------------------
-- Business User
-- ---------------------------------------------------------------------
 
 DROP TABLE IF EXISTS `tbl_business_user`;
  
 CREATE TABLE `tbl_business_user` (
  `business_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id`      int(11) NOT NULL,    -- fk to business
  `user_id`          int(11) NOT NULL,    -- fk to user 
  `primary_user`     enum('Y', 'N') DEFAULT 'N',
  PRIMARY KEY        (`business_user_id`),
  UNIQUE KEY         `idx_business_primary_user` (`business_id`,`user_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
  
  
ALTER TABLE tbl_business_user
ADD CONSTRAINT fk_business_user_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_business_user
ADD CONSTRAINT fk_business_user_business
     FOREIGN KEY (business_id) 
     REFERENCES tbl_business(business_id);  
     
-- ---------------------------------------------------------------------
-- User subscribed Businesses
-- ---------------------------------------------------------------------

  DROP TABLE IF EXISTS `tbl_subscribed_business`;
  
  CREATE TABLE `tbl_subscribed_business` (
    `subscribed_business_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `business_id` int(11) NOT NULL,
  PRIMARY KEY (`subscribed_business_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

ALTER TABLE tbl_subscribed_business
ADD CONSTRAINT fk_subscribed_business_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_subscribed_business
ADD CONSTRAINT fk_subscribed_business_business
     FOREIGN KEY (business_id) 
     REFERENCES tbl_business(business_id);
     
-- ---------------------------------------------------------------------
-- Category
-- ---------------------------------------------------------------------
 
DROP TABLE IF EXISTS `tbl_category`; 
     
CREATE TABLE `tbl_category` (
  `category_id`             int(11) NOT NULL AUTO_INCREMENT,
  `parent_id`               int(11) DEFAULT NULL,
  `category_name`           varchar(128) NOT NULL,
  `category_description`    varchar(255) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE tbl_category
ADD CONSTRAINT fk_category_category_parent
     FOREIGN KEY (parent_id) 
     REFERENCES tbl_category(category_id);  
 
-- ---------------------------------------------------------------------
-- Business Review
-- ---------------------------------------------------------------------
 
DROP TABLE IF EXISTS `tbl_business_review`; 
     
CREATE TABLE `tbl_business_review` (
  `business_review_id`      int(11) NOT NULL AUTO_INCREMENT,
  `business_id`             int(11) NOT NULL,
  `user_id`                 int(11) NOT NULL,
  `rating`                  int(11) DEFAULT NULL,
  `review_text`             text,
  `review_reply`            text,
  `review_date`             date DEFAULT NULL,
  `publish_status`          enum('Y', 'N') DEFAULT 'Y',  
  PRIMARY KEY (`business_review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE tbl_business_review
ADD CONSTRAINT tbl_business_review_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_business_review
ADD CONSTRAINT tbl_business_review_business
     FOREIGN KEY (business_id) 
     REFERENCES tbl_business(business_id);
 
     
-- ---------------------------------------------------------------------
-- Business Category
-- ---------------------------------------------------------------------
 
 DROP TABLE IF EXISTS `tbl_business_category`;
  
 CREATE TABLE `tbl_business_category` (
  `business_category_id`    int(11) NOT NULL AUTO_INCREMENT,
  `business_id`             int(11) NOT NULL,    -- fk to business
  `category_id`             int(11) NOT NULL,    -- fk to user 
  `primary_category`        enum('Y', 'N') DEFAULT 'N',
  PRIMARY KEY        (`business_category_id`),
  UNIQUE KEY         `idx_business_primary_category` (`business_id`,`category_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
  
  
ALTER TABLE tbl_business_category
ADD CONSTRAINT fk_business_category_category
     FOREIGN KEY (category_id) 
     REFERENCES tbl_category(category_id);
     
     
ALTER TABLE tbl_business_category
ADD CONSTRAINT fk_business_category_business
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
  
  `external_event_source` varchar(255) DEFAULT NULL,
  `external_event_id`   varchar(64) DEFAULT NULL,

    
  PRIMARY KEY (`event_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;


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
     
    ALTER TABLE tbl_event
    ADD CONSTRAINT fk_event_business
         FOREIGN KEY (event_business_id) 
         REFERENCES tbl_business(business_id);
         
    ALTER TABLE tbl_event
    ADD CONSTRAINT fk_event_category
         FOREIGN KEY (event_category_id) 
         REFERENCES tbl_event_category(category_id);


ALTER TABLE tbl_event ADD COLUMN `user_id`  int(11) NOT NULL;

ALTER TABLE tbl_event
ADD CONSTRAINT fk_event_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);

         
-- ---------------------------------------------------------------------
-- tbl_user_event
-- ---------------------------------------------------------------------
  DROP TABLE IF EXISTS `tbl_user_event`;
  
  CREATE TABLE `tbl_user_event` (
    `user_event_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `event_id` int(11) NOT NULL,
  PRIMARY KEY (`user_event_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

ALTER TABLE tbl_user_event
ADD CONSTRAINT fk_user_event_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
     
ALTER TABLE tbl_user_event
ADD CONSTRAINT fk_user_event_event
     FOREIGN KEY (event_id) 
     REFERENCES tbl_event(event_id);
          
-- ---------------------------------------------------------------------
-- event category
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_event_category`;

CREATE TABLE `tbl_event_category` (
  `category_id`             int(11) NOT NULL AUTO_INCREMENT,
  `parent_id`               int(11) DEFAULT NULL,
  `category_name`           varchar(128) NOT NULL,
  `category_description`    varchar(255) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE tbl_event_category
ADD CONSTRAINT fk_event_category_category_parent
     FOREIGN KEY (parent_id) 
     REFERENCES tbl_event_category(category_id);
     
ALTER TABLE tbl_event_category ADD COLUMN `search_tags`  text  DEFAULT NULL;


-- ---------------------------------------------------------------------
-- tbl_restaurant_certificate
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_restaurant_certificate`;

CREATE TABLE IF NOT EXISTS `tbl_restaurant_certificate` (
  `certificate_id` int(11) NOT NULL AUTO_INCREMENT,
  `certificate_number` varchar(255) NOT NULL,
  `purchase_amount` decimal(13,2) NOT NULL,
  `certificate_value` decimal(13,2) NOT NULL,
  `purchase_date` date NOT NULL,
  `business_id` int(11) DEFAULT NULL,
  `purchased_by_business_date` date DEFAULT NULL,
  `availability_status` enum('Available','Purchased') DEFAULT NULL,
  `redeemer_email` varchar(64) DEFAULT NULL,
  `redeemer_user_id` int(11) DEFAULT NULL,
  `redeem_date` date DEFAULT NULL,
  PRIMARY KEY (`certificate_id`),
  KEY `fk_restaurant_certificate_business` (`business_id`),
  KEY `redeemer_user_id` (`redeemer_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `tbl_restaurant_certificate`
  ADD CONSTRAINT `fk_restaurant_certificate_user` FOREIGN KEY (`redeemer_user_id`) REFERENCES `tbl_user` (`user_id`),
  ADD CONSTRAINT `fk_restaurant_certificate_business` FOREIGN KEY (`business_id`) REFERENCES `tbl_business` (`business_id`);

     
ALTER TABLE tbl_restaurant_certificate ADD COLUMN `issue_date` DATE DEFAULT NULL;
ALTER TABLE tbl_restaurant_certificate ADD COLUMN `redeem_code` varchar(255) DEFAULT NULL;
ALTER TABLE tbl_restaurant_certificate DROP COLUMN `redeemer_email`;


   
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;


  
ALTER TABLE tbl_mail_template
ADD CONSTRAINT fk_mail_template_created_by
     FOREIGN KEY (created_by) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_mail_template
ADD CONSTRAINT fk_mail_template_modified_by
     FOREIGN KEY (modified_by) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_mail_template ADD COLUMN subject VARCHAR(255) DEFAULT null;

-- ---------------------------------------------------------------------
-- advert
-- ---------------------------------------------------------------------
 
 DROP TABLE IF EXISTS `tbl_advertisement`;
 
CREATE TABLE `tbl_advertisement` (
  `advertisement_id`    int(11) NOT NULL AUTO_INCREMENT,

  `advert_type`         enum('Google', 'Custom', 'Any') DEFAULT 'Any',
  
  `title`               varchar(255) DEFAULT NULL,
  `content`             TEXT NOT NULL,
  `image`               TEXT DEFAULT NULL,
  
  `created_time`        TIMESTAMP NOT NULL DEFAULT 0,
  `modified_time`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  `created_by`          int(11) NOT NULL COMMENT 'FK with user',
  `modified_by`         int(11) NOT NULL COMMENT 'FK with user',
  
  `published`           enum('Y', 'N') DEFAULT 'N',
  
  `publish_date`        DATE DEFAULT NULL,
  `expiry_date`         DATE DEFAULT NULL,

  `user_id`             int(11) DEFAULT NULL,
  
  `maximum_ads_views`           double DEFAULT NULL,
  `maximum_ads_clicks`          double DEFAULT NULL,

  `ads_views`           double DEFAULT NULL,
  `ads_clicks`          double DEFAULT NULL,

  PRIMARY KEY (`advertisement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



  
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
     

-- Added new fields for tbl_advertisement
ALTER TABLE `tbl_advertisement` ADD COLUMN `custom_code` TEXT NULL DEFAULT NULL  ;
ALTER TABLE `tbl_advertisement` ADD COLUMN `business_id` int(11) NULL DEFAULT NULL  ;

ALTER TABLE `tbl_advertisement` ADD COLUMN `url` varchar(512) DEFAULT NULL;
ALTER TABLE `tbl_advertisement` CHANGE COLUMN `advert_type` `advert_type` enum('Google', 'Custom', 'Any', 'Banner') DEFAULT 'Any';
ALTER TABLE `tbl_advertisement` CHANGE COLUMN `image` `image` varchar(1024) DEFAULT NULL;






ALTER TABLE tbl_advertisement
ADD CONSTRAINT tbl_advertisement_business
     FOREIGN KEY (business_id) 
     REFERENCES tbl_business(business_id);
     
-- ---------------------------------------------------------------------
-- Mobile Carriers
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_mobile_carrier`;

CREATE TABLE `tbl_mobile_carrier` (
  `mobile_carrier_id`         int(11) NOT NULL AUTO_INCREMENT,
  `mobile_carrier_name`       varchar(255) NOT NULL,
  `can_send`                  enum('Y', 'N') DEFAULT 'N',
  `recipient_address`         varchar(255) DEFAULT NULL,
  `notes`                     TEXT default NULL,
  PRIMARY KEY (`mobile_carrier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---------------------------------------------------------------------
-- system settings
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_system_settings`;

CREATE TABLE `tbl_system_settings` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute`   varchar(255) NOT NULL,
  `value`       varchar(4096) NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- ---------------------------------------------------------------------
-- language
-- ---------------------------------------------------------------------
 -- From http://snipplr.com/view/61741/languages-table/


-- ----------------------------
--  Table structure for `languages`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_language`;
CREATE TABLE `tbl_language` (
  `language_id` int(11) NOT NULL auto_increment,
  `name` mediumtext NOT NULL,
  `short` mediumtext NOT NULL,
  PRIMARY KEY  (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `languages`
-- ----------------------------
BEGIN;
INSERT INTO `tbl_language` VALUES ('1', 'English', 'en'), ('2', 'German', 'de'), ('3', 'French', 'fr'), ('4', 'Dutch', 'nl'), ('5', 'Italian', 'it'), ('6', 'Spanish', 'es'), ('7', 'Polish', 'pl'), ('8', 'Russian', 'ru'), ('9', 'Japanese', 'ja'), ('10', 'Portuguese', 'pt'), ('11', 'Swedish', 'sv'), ('12', 'Chinese', 'zh'), ('13', 'Catalan', 'ca'), ('14', 'Ukrainian', 'uk'), ('15', 'Norwegian (Bokmål)', 'no'), ('16', 'Finnish', 'fi'), ('17', 'Vietnamese', 'vi'), ('18', 'Czech', 'cs'), ('19', 'Hungarian', 'hu'), ('20', 'Korean', 'ko'), ('21', 'Indonesian', 'id'), ('22', 'Turkish', 'tr'), ('23', 'Romanian', 'ro'), ('24', 'Persian', 'fa'), ('25', 'Arabic', 'ar'), ('26', 'Danish', 'da'), ('27', 'Esperanto', 'eo'), ('28', 'Serbian', 'sr'), ('29', 'Lithuanian', 'lt'), ('30', 'Slovak', 'sk'), ('31', 'Malay', 'ms'), ('32', 'Hebrew', 'he'), ('33', 'Bulgarian', 'bg'), ('34', 'Slovenian', 'sl'), ('35', 'Volapük', 'vo'), ('36', 'Kazakh', 'kk'), ('37', 'Waray-Waray', 'war'), ('38', 'Basque', 'eu'), ('39', 'Croatian', 'hr'), ('40', 'Hindi', 'hi'), ('41', 'Estonian', 'et'), ('42', 'Azerbaijani', 'az'), ('43', 'Galician', 'gl'), ('44', 'Simple English', 'simple'), ('45', 'Norwegian (Nynorsk)', 'nn'), ('46', 'Thai', 'th'), ('47', 'Newar / Nepal Bhasa', 'new'), ('48', 'Greek', 'el'), ('49', 'Aromanian', 'roa-rup'), ('50', 'Latin', 'la'), ('51', 'Occitan', 'oc'), ('52', 'Tagalog', 'tl'), ('53', 'Haitian', 'ht'), ('54', 'Macedonian', 'mk'), ('55', 'Georgian', 'ka'), ('56', 'Serbo-Croatian', 'sh'), ('57', 'Telugu', 'te'), ('58', 'Piedmontese', 'pms'), ('59', 'Cebuano', 'ceb'), ('60', 'Tamil', 'ta'), ('61', 'Belarusian (Taraškievica)', 'be-x-old'), ('62', 'Breton', 'br'), ('63', 'Latvian', 'lv'), ('64', 'Javanese', 'jv'), ('65', 'Albanian', 'sq'), ('66', 'Belarusian', 'be'), ('67', 'Marathi', 'mr'), ('68', 'Welsh', 'cy'), ('69', 'Luxembourgish', 'lb'), ('70', 'Icelandic', 'is'), ('71', 'Bosnian', 'bs'), ('72', 'Yoruba', 'yo'), ('73', 'Malagasy', 'mg'), ('74', 'Aragonese', 'an'), ('75', 'Bishnupriya Manipuri', 'bpy'), ('76', 'Lombard', 'lmo'), ('77', 'West Frisian', 'fy'), ('78', 'Bengali', 'bn'), ('79', 'Ido', 'io'), ('80', 'Swahili', 'sw'), ('81', 'Gujarati', 'gu'), ('82', 'Malayalam', 'ml'), ('83', 'Western Panjabi', 'pnb'), ('84', 'Afrikaans', 'af'), ('85', 'Low Saxon', 'nds'), ('86', 'Sicilian', 'scn'), ('87', 'Urdu', 'ur'), ('88', 'Kurdish', 'ku'), ('89', 'Cantonese', 'zh-yue'), ('90', 'Armenian', 'hy'), ('91', 'Quechua', 'qu'), ('92', 'Sundanese', 'su'), ('93', 'Nepali', 'ne'), ('94', 'Zazaki', 'diq'), ('95', 'Asturian', 'ast'), ('96', 'Tatar', 'tt'), ('97', 'Neapolitan', 'nap'), ('98', 'Irish', 'ga'), ('99', 'Chuvash', 'cv'), ('100', 'Samogitian', 'bat-smg'), ('101', 'Walloon', 'wa'), ('102', 'Amharic', 'am'), ('103', 'Kannada', 'kn'), ('104', 'Alemannic', 'als'), ('105', 'Buginese', 'bug'), ('106', 'Burmese', 'my'), ('107', 'Interlingua', 'ia');
COMMIT;



-- ---------------------------------------------------------------------
-- activity
-- ---------------------------------------------------------------------

 DROP TABLE IF EXISTS `tbl_activity`;

 CREATE TABLE `tbl_activity` (
    `activity_id`     int(11) NOT NULL AUTO_INCREMENT,
    `keyword`         varchar(255) NOT NULL,
    `language`        varchar(8) NOT NULL DEFAULT 'en',
    `related_words`   text,
  PRIMARY KEY (`activity_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
  

  ALTER TABLE tbl_activity ADD COLUMN `event_categories`  varchar(1024) DEFAULT NULL;
-- ---------------------------------------------------------------------
-- Business Activity
-- ---------------------------------------------------------------------
 
 DROP TABLE IF EXISTS `tbl_business_activity`;
  
 CREATE TABLE `tbl_business_activity` (
  `business_activity_id`    int(11) NOT NULL AUTO_INCREMENT,
  `business_id`             int(11) NOT NULL,    -- fk to biz
  `activity_id`             int(11) NOT NULL,    -- fk to activity
  `activity_type_id`        int(11) NOT NULL,    -- fk to activity_type
  PRIMARY KEY        (`business_activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
  
-- alter table tbl_business_activity add column `activity_type_id` int(11) NOT NULL;
  
ALTER TABLE tbl_business_activity
ADD CONSTRAINT fk_business_activity_business_id
     FOREIGN KEY (business_id) 
     REFERENCES tbl_business(business_id);
     
ALTER TABLE tbl_business_activity
ADD CONSTRAINT fk_business_activity_activity_id
     FOREIGN KEY (activity_id) 
     REFERENCES tbl_activity(activity_id);

ALTER TABLE tbl_business_activity
ADD CONSTRAINT fk_business_activity_activity_type
     FOREIGN KEY (activity_type_id) 
     REFERENCES tbl_activity_type(activity_type_id);
     
alter  table tbl_business_activity change `activity_type_id` `activity_type_id` int(11) DEFAULT NULL;
-- ---------------------------------------------------------------------
-- activity
-- ---------------------------------------------------------------------

 DROP TABLE IF EXISTS `tbl_activity_type`;

 CREATE TABLE `tbl_activity_type` (
    `activity_type_id`  int(11) NOT NULL AUTO_INCREMENT,
    `keyword`           varchar(255) NOT NULL,
    `activity_id`       int(11) NOT NULL,    -- fk to activity
    `language`          varchar(8) NOT NULL DEFAULT 'en',
    `related_words`     text,
  PRIMARY KEY (`activity_type_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
  

ALTER TABLE tbl_activity_type
ADD CONSTRAINT fk_activity_type_activity_id
     FOREIGN KEY (activity_id) 
     REFERENCES tbl_activity(activity_id);
       

-- ---------------------------------------------------------------------
-- CSV Import
-- ---------------------------------------------------------------------

 DROP TABLE IF EXISTS `hotel_import`;

 CREATE TABLE `hotel_import` (
  `hotelid_ppn` varchar(255),
  `hotelid_a` varchar(255),
  `hotelid_b` varchar(255),
  `hotelid_t` varchar(255),
  `hotel_name` varchar(255),
  `hotel_address` varchar(255),
  `city` varchar(255),
  `cityid_ppn` varchar(255),
  `state` varchar(255),
  `state_code` varchar(255),
  `country` varchar(255),
  `country_code` varchar(255),
  `latitude` varchar(255),
  `longitude` varchar(255),
  `area_id` varchar(255),
  `postal_code` varchar(255),
  `star_rating` varchar(255),
  `low_rate` varchar(255),
  `currency_code` varchar(255),
  `review_rating` varchar(255),
  `review_count` varchar(255),
  `rank_score_ppn` varchar(255),
  `chain_id_ppn` varchar(255),
  `thumbnail` varchar(255),
  `has_photos` varchar(255),
  `room_count` varchar(255),
  `check_in` varchar(255),
  `check_out` varchar(255),
  `property_description` varchar(255),
  `amenity_codes` varchar(255),
  `active` varchar(255),
  `mod_date_time` varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  

-- ---------------------------------------------------------------------
-- BusinessDB Import
-- ---------------------------------------------------------------------
 DROP TABLE IF EXISTS `businessdb_import`;

 CREATE TABLE `businessdb_import` (
  `﻿ID` varchar(32) DEFAULT NULL,
  `source` varchar(32) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip` varchar(32) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `latitude` varchar(32) DEFAULT NULL,
  `longitude` varchar(32) DEFAULT NULL,
  `TableID` varchar(32) DEFAULT NULL,
  `TP` varchar(32) DEFAULT NULL,
  `zip5` varchar(32) DEFAULT NULL,
  `manta_Category` varchar(255) DEFAULT NULL,
  `manta_SubCategory` varchar(255) DEFAULT NULL,
  `manta_industry` varchar(255) DEFAULT NULL,
  `old_db_sic` varchar(255) DEFAULT NULL,
  `old_db_category` varchar(255) DEFAULT NULL,
  `gogo_category` varchar(255) DEFAULT NULL,
  `gogo_Subcategory` varchar(255) DEFAULT NULL,
  `gogo_Source_URL` varchar(255) DEFAULT NULL,
  `manta_source_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `businessdb_import` ADD COLUMN `record_id` int(11) unsigned PRIMARY KEY AUTO_INCREMENT;
ALTER TABLE `businessdb_import` ADD COLUMN source_filename varchar(255);
ALTER TABLE `businessdb_import` ADD COLUMN date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `businessdb_import` ADD COLUMN import_date  DATETIME;
ALTER TABLE `businessdb_import` ADD COLUMN sync_date  DATETIME;
ALTER TABLE `businessdb_import` ADD COLUMN import_comment TEXT;
ALTER TABLE `businessdb_import` ADD COLUMN sync_comment TEXT;

-- ---------------------------------------------------------------------
-- Manta, Gogobot Import
-- ---------------------------------------------------------------------
 DROP TABLE IF EXISTS `imported_business`;

CREATE TABLE `imported_business` (
  `ID1` int(11) DEFAULT NULL,
  `ID` int(11) DEFAULT NULL,
  `source` tinytext,
  `company_name` tinytext,
  `address` tinytext,
  `city` tinytext,
  `zip` tinytext,
  `phone` tinytext,
  `email` tinytext,
  `website` tinytext,
  `manta_category` tinytext,
  `manta_subcategory` tinytext,
  `manta_industry` tinytext,
  `old_db_sic` tinytext,
  `old_db_category` tinytext,
  `gogo_category` tinytext,
  `gogo_subcategory` tinytext,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `gogo_source_url` tinytext,
  `manta_source_url` tinytext,
  `TableID` int(11) DEFAULT NULL,
  `TP` tinytext,
  `zip5` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---------------------------------------------------------------------
-- Restaurant.com imports
-- ---------------------------------------------------------------------
 DROP TABLE IF EXISTS `restaurant_import`;


CREATE TABLE restaurant_import
(
  PROGRAMNAME   VARCHAR(255)
, PROGRAMURL    VARCHAR(255)
, CATALOGNAME   VARCHAR(255)
, LASTUPDATED   VARCHAR(32)
, NAME          VARCHAR(255)
, KEYWORDS      TEXT
, DESCRIPTION   TEXT
, SKU           VARCHAR(32)
, MANUFACTURER  VARCHAR(32)
, MANUFACTURERID VARCHAR(32)
, UPC           VARCHAR(32)
, ISBN          VARCHAR(32)
, CURRENCY      VARCHAR(6)
, SALEPRICE     VARCHAR(32)
, PRICE         VARCHAR(32)
, RETAILPRICE   VARCHAR(32)
, FROMPRICE     VARCHAR(32)
, BUYURL        VARCHAR(255)
, IMPRESSIONURL VARCHAR(255)
, IMAGEURL      VARCHAR(255)
, ADVERTISERCATEGORY VARCHAR(64)
, THIRDPARTYID  VARCHAR(32)
, THIRDPARTYCATEGORY VARCHAR(64)
, AUTHOR        VARCHAR(64)
, ARTIST        VARCHAR(64)
, TITLE         VARCHAR(32)
, PUBLISHER     VARCHAR(64)
, LABEL         VARCHAR(64)
, FORMAT        VARCHAR(32)
, SPECIAL       VARCHAR(32)
, GIFT          VARCHAR(32)
, PROMOTIONALTEXT VARCHAR(255)
, STARTDATE     VARCHAR(32)
, ENDDATE       VARCHAR(32)
, OFFLINE       VARCHAR(32)
, ONLINE        VARCHAR(32)
, INSTOCK       VARCHAR(8)
, `CONDITION`   VARCHAR(64)
, WARRANTY      VARCHAR(64)
, STANDARDSHIPPINGCOST VARCHAR(32)
);

ALTER TABLE `restaurant_import` ADD COLUMN `record_id` int(11) unsigned PRIMARY KEY AUTO_INCREMENT;
ALTER TABLE `restaurant_import` ADD COLUMN source_filename varchar(255);
ALTER TABLE `restaurant_import` ADD COLUMN date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `restaurant_import` ADD COLUMN import_date  DATETIME;
ALTER TABLE `restaurant_import` ADD COLUMN sync_date  DATETIME;
ALTER TABLE `restaurant_import` ADD COLUMN import_comment TEXT;
ALTER TABLE `restaurant_import` ADD COLUMN sync_comment TEXT;
ALTER TABLE `restaurant_import` ADD COLUMN sync_business_id int(11) DEFAULT NULL;

-- ---------------------------------------------------------------------
-- Ticket Network Events
-- ---------------------------------------------------------------------

 DROP TABLE IF EXISTS `tbl_tn_event`;

 CREATE TABLE `tbl_tn_event` (
  `tn_event_id`             int(11) NOT NULL AUTO_INCREMENT,
  `tn_id`                   int(11) NOT NULL,
  `tn_child_category_id`    int(11),
  `tn_parent_category_id`   int(11),
  `tn_grandchild_category_id`  int(11),
  `tn_city`                 varchar(255),
  `tn_state_id`             int(11),
  `tn_state_name`           varchar(255),
  `tn_country_id`           int(11),
  `tn_date`                 varchar(255),
  `tn_display_date`         varchar(255),
  `tn_map_url`              varchar(512),
  `tn_interactive_map_url`  varchar(512),
  `tn_event_name`           varchar(512),
  `tn_venue`                varchar(255),
  `tn_venue_id`             int(11),
  `tn_venue_configuration_id`   int(11),
  PRIMARY KEY (`tn_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




-- ---------------------------------------------------------------------
-- Getyourguide Imports
-- ---------------------------------------------------------------------
 DROP TABLE IF EXISTS `getyourguide_import`;

 CREATE TABLE `getyourguide_import` (
  `getyourguide_external_id` INT(32) NOT NULL,
  `last_modification_datetime` varchar(64) DEFAULT NULL,
  `title` varchar(1024) DEFAULT NULL,
  `abstract` TEXT NULL,
  `categories` TEXT DEFAULT NULL,
  `destination` TEXT DEFAULT NULL,
  `price` varchar(1024) DEFAULT NULL,
  `prices_description` varchar(255) DEFAULT NULL,
  `rating` varchar(16) DEFAULT NULL,
  `pictures` TEXT DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `language` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `getyourguide_import` ADD COLUMN `record_id` int(11) unsigned PRIMARY KEY AUTO_INCREMENT;
ALTER TABLE `getyourguide_import` ADD COLUMN source_filename varchar(255);
ALTER TABLE `getyourguide_import` ADD COLUMN date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `getyourguide_import` ADD COLUMN import_date  DATETIME;
ALTER TABLE `getyourguide_import` ADD COLUMN sync_date  DATETIME;
ALTER TABLE `getyourguide_import` ADD COLUMN import_comment TEXT;
ALTER TABLE `getyourguide_import` ADD COLUMN sync_comment TEXT;


-- ---------------------------------------------------------------------
-- Getyourguide Local storage
-- ---------------------------------------------------------------------
 DROP TABLE IF EXISTS `tbl_getyourguide_product`;

 CREATE TABLE `tbl_getyourguide_product` (
  `product_id`                  int(11) unsigned AUTO_INCREMENT,
  `gyg_id`                      INT(32) NOT NULL,
  `gyg_last_modify_time`        DATETIME,
  `gyg_title`                   varchar(1024) DEFAULT NULL,
  `gyg_abstract`                TEXT NULL,
  `gyg_destination_list`        TEXT DEFAULT NULL,
  `gyg_price`                   varchar(255) DEFAULT NULL,
  `gyg_price_description`       varchar(255) DEFAULT NULL,
  `gyg_rating`                  varchar(16) DEFAULT NULL,
  `gyg_url`                     varchar(255) DEFAULT NULL,
  `gyg_language`                varchar(32) DEFAULT NULL,
  PRIMARY   KEY (`product_id`),
  UNIQUE    KEY `unqkey_gyg_id` (`gyg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ---------------------------------------------------------------------
-- Get-a-room Imports
-- ---------------------------------------------------------------------
 DROP TABLE IF EXISTS `getaroom_import`;

 CREATE TABLE `getaroom_import` (
  `lat`                 varchar(32) NOT NULL,
  `lng`                 varchar(32) NOT NULL,
  `location_city`       varchar(255) DEFAULT NULL,
  `location_country`    varchar(255) DEFAULT NULL,
  `location_state`      varchar(255) DEFAULT NULL,
  `location_street`     varchar(255) DEFAULT NULL,
  `location_zip`        varchar(255) DEFAULT NULL,
  `permalink`           varchar(255) DEFAULT NULL,
  `rating`              varchar(255) DEFAULT NULL,
  `review_rating`       varchar(255) DEFAULT NULL,
  
  `short_description`   TEXT DEFAULT NULL,
  `thumbnail_filename`  varchar(1024) DEFAULT NULL,
  `time_zone`           varchar(255) DEFAULT NULL,
  `title`               varchar(1024) DEFAULT NULL,
  `uuid`                varchar(1024) DEFAULT NULL,
  
  `sanitized_description`   TEXT DEFAULT NULL,
  `market`              varchar(1024) DEFAULT NULL,
  `amenity`             TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `getaroom_import` ADD COLUMN `record_id` int(11) unsigned PRIMARY KEY AUTO_INCREMENT;
ALTER TABLE `getaroom_import` ADD COLUMN source_filename varchar(255);
ALTER TABLE `getaroom_import` ADD COLUMN date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `getaroom_import` ADD COLUMN import_date  DATETIME;
ALTER TABLE `getaroom_import` ADD COLUMN sync_date  DATETIME;
ALTER TABLE `getaroom_import` ADD COLUMN import_comment TEXT;
ALTER TABLE `getaroom_import` ADD COLUMN sync_comment TEXT;


-- ---------------------------------------------------------------------
-- Search log summary - quick log for all seaches
-- ---------------------------------------------------------------------

 DROP TABLE IF EXISTS `tbl_search_log_summary`;

 CREATE TABLE `tbl_search_log_summary` (
  `search_summary_id`   int(11) NOT NULL AUTO_INCREMENT,
  `search_origin`   varchar(255) NOT NULL DEFAULT '',
  `search_details`  text NOT NULL,
  `search_count`    int(11) NOT NULL DEFAULT 0,
  `search_tag`      varchar(255) NOT NULL DEFAULT '',
  `search_tag_type`  varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`search_summary_id`),
  INDEX      `unqkey_search_log_search_origin` (`search_origin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ---------------------------------------------------------------------
-- Search log history - detailed log for every search
-- ---------------------------------------------------------------------
 
 DROP TABLE IF EXISTS `tbl_search_history`;
  
 CREATE TABLE `tbl_search_history` (
  `search_id`        int(11) NOT NULL AUTO_INCREMENT,
  `user_id`          int(11) DEFAULT NULL,    -- fk to user
  `user_location`    int(11) DEFAULT NULL,    -- fk to user
  `created_time`     timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `search_details` text NOT NULL DEFAULT '',       -- Serialised string with filter details
  PRIMARY KEY (`search_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
  
ALTER TABLE `tbl_search_history` ADD COLUMN filter_activity varchar(255);
ALTER TABLE `tbl_search_history` ADD COLUMN filter_activitytype varchar(255);
  
  
ALTER TABLE tbl_search_history
ADD CONSTRAINT fk_search_history_search_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);  
-- ---------------------------------------------------------------------
-- my friend
-- ---------------------------------------------------------------------
  DROP TABLE IF EXISTS `tbl_my_friend`;
  
  CREATE TABLE `tbl_my_friend` (
    `my_friend_id`      int(11) NOT NULL AUTO_INCREMENT,
    `user_id`           int(11) NOT NULL,
    `friend_id`         int(11) NOT NULL,
    `created_time`      TIMESTAMP NOT NULL DEFAULT 0,
    `connected_by`      varchar(255) default null comment 'Site, facebook, ...',
  PRIMARY KEY (`my_friend_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

ALTER TABLE tbl_my_friend
ADD CONSTRAINT my_friend_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_my_friend
ADD CONSTRAINT my_friend_friend
     FOREIGN KEY (friend_id) 
     REFERENCES tbl_user(user_id);

ALTER TABLE `tbl_my_friend` ADD COLUMN friend_status ENUM('Pending', 'Approved', 'Rejected');
ALTER TABLE `tbl_my_friend` ADD COLUMN request_time  DATETIME;
ALTER TABLE `tbl_my_friend` ADD COLUMN process_time  DATETIME;

ALTER TABLE `tbl_my_friend` CHANGE COLUMN friend_status friend_status ENUM('Pending', 'Approved', 'Rejected', 'Blocked');



-- ---------------------------------------------------------------------
-- user messages
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_user_message`;

CREATE TABLE `tbl_user_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL,
  `recipient` int(11) NOT NULL,
  `sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `read` enum('Y','N') DEFAULT 'N',
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `reply_to` int(11) DEFAULT NULL,

  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE tbl_user_message
ADD CONSTRAINT user_message_recipient
     FOREIGN KEY (recipient) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_user_message
ADD CONSTRAINT user_message_sender
     FOREIGN KEY (sender) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE `tbl_user_message` ADD COLUMN message_bucket ENUM('Inbox', 'Archive', 'Pending Delete') DEFAULT 'Inbox';
ALTER TABLE `tbl_user_message` ADD COLUMN message_category VARCHAR(255) DEFAULT NULL;

-- ---------------------------------------------------------------------
-- Question
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_post_question`;

CREATE TABLE `tbl_post_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `tags` text DEFAULT NULL,
  `answers` int(11) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `votes` int(11) NOT NULL DEFAULT 0,
  `status` enum('Open','Closed', 'Published', 'Unublished') DEFAULT 'Open',
  `category_id` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_date` timestamp DEFAULT 0,
  `entity_type`      enum('city', 'state', 'business', 'user', 'general', 'event') DEFAULT 'general',
  `entity_id`       int(11) NOT NULL, 
  `reply_to` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE tbl_post_question
ADD CONSTRAINT post_question_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_post_question
ADD CONSTRAINT post_question_parent
     FOREIGN KEY (reply_to) 
     REFERENCES tbl_post_question(id);

            
ALTER TABLE `tbl_post_question` ADD COLUMN post_type enum('Question', 'Rant', 'Rave', 'Solution') DEFAULT 'Question';
ALTER TABLE `tbl_post_question` ADD COLUMN question_rating_value int(11) DEFAULT NULL;


     
-- ---------------------------------------------------------------------
-- Answer
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_post_answer`;

CREATE TABLE `tbl_post_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `tags` text DEFAULT NULL,
  `votes` int(11) NOT NULL DEFAULT 0,
  `status` enum('Open','Closed', 'Published', 'Unublished') DEFAULT 'Open',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_date` timestamp DEFAULT 0,
  `reply_to` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE tbl_post_answer
ADD CONSTRAINT post_answer_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_post_answer
ADD CONSTRAINT post_answer_question
     FOREIGN KEY (question_id) 
     REFERENCES tbl_post_question(id);
     
     
ALTER TABLE tbl_post_answer
ADD CONSTRAINT post_answer_parent
     FOREIGN KEY (reply_to) 
     REFERENCES tbl_post_answer(id);
     
alter table tbl_post_answer change column `alias` `alias` varchar(255);
alter table tbl_post_answer change column `title` `title` varchar(255);

-- ---------------------------------------------------------------------
-- Post tag
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_post_tag`;

CREATE TABLE `tbl_post_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `frequency` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ---------------------------------------------------------------------
-- Post Votes
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_post_vote`;

CREATE TABLE `tbl_post_vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `entity_type`      enum('question', 'answer')  NOT NULL,
  `entity_id`       int(11) NOT NULL,
  `vote`       int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_date` timestamp DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE tbl_post_vote
ADD CONSTRAINT post_vote_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);


     
     
-- ---------------------------------------------------------------------
-- post subscription
-- ---------------------------------------------------------------------
  DROP TABLE IF EXISTS `tbl_post_subscribed`;
  
  CREATE TABLE `tbl_post_subscribed` (
    `post_subscribed_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `post_id` int(11) NOT NULL,
  PRIMARY KEY (`post_subscribed_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

ALTER TABLE tbl_post_subscribed
ADD CONSTRAINT fk_post_subscribed_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_post_subscribed
ADD CONSTRAINT fk_post_subscribed_post
     FOREIGN KEY (post_id) 
     REFERENCES tbl_post_question(id);
     
     
     
-- ---------------------------------------------------------------------
--  My Trip
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_trip`;
CREATE TABLE `tbl_trip` (
  `trip_id` int(11) NOT NULL AUTO_INCREMENT,
  `trip_name` varchar(150) DEFAULT NULL,
  `description` text,
  `trip_status` enum('Active', 'Cancelled', 'Complete') DEFAULT 'Active',
  `user_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_date` timestamp DEFAULT 0,
  PRIMARY KEY (`trip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE tbl_trip
ADD CONSTRAINT tbl_trip_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
-- ---------------------------------------------------------------------
--  My Trip Locations
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_trip_leg`;
CREATE TABLE `tbl_trip_leg` (
  `trip_leg_id` int(11) NOT NULL AUTO_INCREMENT,
  `trip_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `leg_start_date` date DEFAULT NULL,
  `leg_end_date` date DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`trip_leg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE tbl_trip_leg
ADD CONSTRAINT tbl_trip_leg_trip
     FOREIGN KEY (trip_id) 
     REFERENCES tbl_trip(trip_id);
     
ALTER TABLE tbl_trip_leg
ADD CONSTRAINT tbl_trip_leg_city
     FOREIGN KEY (city_id) 
     REFERENCES tbl_city(city_id);

     
-- ---------------------------------------------------------------------
-- User profile settings
-- ---------------------------------------------------------------------
  DROP TABLE IF EXISTS `tbl_user_profile`;

  CREATE TABLE `tbl_user_profile` (
  `user_profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `alert_business_review` enum('Y','N') DEFAULT 'Y',
  `alert_review_comment`  enum('Y','N') DEFAULT 'Y',
  `alert_like_complaint_response` enum('Y','N') DEFAULT 'Y',
  `alert_forum_response` enum('Y','N') DEFAULT 'Y',
  `alert_answer_voted` enum('Y','N') DEFAULT 'Y',
  `alert_trip_question_response` enum('Y','N') DEFAULT 'Y',
  
  `alert_upcoming_event_trip` enum('Y','N') DEFAULT 'Y',
  `alert_upcoming_event_places_wantogo` enum('Y','N') DEFAULT 'N',
  `alert_upcoming_event_places_visited` enum('Y','N') DEFAULT 'N',
  
  `event_alert_frequency` enum('Daily','Immediately') DEFAULT 'Daily',
  
  PRIMARY KEY (`user_profile_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

  
ALTER TABLE tbl_user_profile
ADD CONSTRAINT tbl_user_profile_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
     
-- ---------------------------------------------------------------------
-- Page views
-- ---------------------------------------------------------------------
  DROP TABLE IF EXISTS `tbl_page_view`;

  CREATE TABLE `tbl_page_view` (
  `tbl_page_view_id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) NOT NULL,
  `entity_type` VARCHAR(255) DEFAULT NULL,
  `ip_address` VARCHAR(255) DEFAULT NULL,
  `visit_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`tbl_page_view_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;



-- ---------------------------------------------------------------------
-- Paypal raw trx log
-- ---------------------------------------------------------------------
  CREATE TABLE IF NOT EXISTS `tbl_paypallog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `raw` text NOT NULL,
  `result` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--

-- tbl_restaurant_certificate_purchases

--


CREATE TABLE IF NOT EXISTS `tbl_restaurant_certificate_purchases` (
  `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `totalcost` float(13,2) NOT NULL,
  `status` enum('created','verified') NOT NULL DEFAULT 'created',
  `deliveredcount` int(11) NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL,
  `approved_time` datetime DEFAULT NULL,
  PRIMARY KEY (`purchase_id`),
  KEY `business_id` (`business_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


--ALTER TABLE `tbl_restaurant_certificate_purchases`
--  ADD CONSTRAINT `tbl_certificate_purchases_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`),
--  ADD CONSTRAINT `tbl_certificate_purchases_business` FOREIGN KEY (`business_id`) REFERENCES `tbl_business` (`business_id`);

  
-- ---------------------------------------------------------------------
-- questionnaire
-- ---------------------------------------------------------------------
 DROP TABLE IF EXISTS `tbl_questionnaire`;

  CREATE TABLE `tbl_questionnaire` (
  `questionnaire_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) DEFAULT NULL,
  `question` VARCHAR(1024) NOT NULL DEFAULT '',
  `question_type` enum('Subjective','Objective') NOT NULL DEFAULT 'Objective',
  `deliveredcount` int(11) NOT NULL DEFAULT '0',
  `answer` TEXT DEFAULT NULL,

  `created_time`        TIMESTAMP NOT NULL DEFAULT 0,
  `modified_time`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  `created_by`          int(11) NOT NULL COMMENT 'FK with user',
  `modified_by`         int(11) NOT NULL COMMENT 'FK with user',
  
  `business_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,

  PRIMARY KEY (`questionnaire_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;


ALTER TABLE tbl_questionnaire
ADD CONSTRAINT fk_questionnaire_created_by
     FOREIGN KEY (created_by) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_questionnaire
ADD CONSTRAINT fk_questionnaire_modified_by
     FOREIGN KEY (modified_by) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_questionnaire
ADD CONSTRAINT fk_questionnaire_user
     FOREIGN KEY (user_id) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_questionnaire
ADD CONSTRAINT fk_questionnaire_business
     FOREIGN KEY (business_id) 
     REFERENCES tbl_business(business_id);
  
  
     
-- ---------------------------------------------------------------------
-- tbl_package
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_package`;

CREATE TABLE IF NOT EXISTS `tbl_package` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(250) NOT NULL,
  `package_image` text,
  `package_description` text,
  `package_expire` int(11) DEFAULT NULL,
  `package_price` decimal(10,2) DEFAULT NULL,
  `created_time` timestamp NULL DEFAULT 0,
  `modified_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by`  int(11) NOT NULL COMMENT 'FK with user',
  `modified_by` int(11) NOT NULL COMMENT 'FK with user', 
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


ALTER TABLE tbl_package
ADD CONSTRAINT fk_package_created_by
     FOREIGN KEY (created_by) 
     REFERENCES tbl_user(user_id);
     
ALTER TABLE tbl_package
ADD CONSTRAINT fk_package_modified_by
     FOREIGN KEY (modified_by) 
     REFERENCES tbl_user(user_id);
     
-- ---------------------------------------------------------------------
-- tbl_package_item_type
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_package_item_type`;

CREATE TABLE IF NOT EXISTS `tbl_package_item_type` (
  `package_item_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text NOT NULL,
  `has_quantity` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`package_item_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_package_item_type`
--

INSERT INTO `tbl_package_item_type` (`package_item_type_id`, `name`, `description`, `has_quantity`) VALUES
(1, 'banners', '', 1),
(2, 'private survey', '', 0),
(3, 'Restaurant.com certificates', '', 1),
(4, 'Coupons', '', 1),
(5, 'auto reply', '', 0);


-- ---------------------------------------------------------------------
-- tbl_package_item
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_package_item`;


CREATE TABLE IF NOT EXISTS `tbl_package_item` (
  `package_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `item_type_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`package_item_id`),
  KEY `FK_tbl_package_items1` (`package_id`),
  KEY `package_id` (`package_id`),
  KEY `item_type_id` (`item_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


--
-- Constraints for table `tbl_package_item`
--
-- THIS ALTER TABLE IS BROKEN
ALTER TABLE `tbl_package_item`
  ADD CONSTRAINT `FK_tbl_package_items1` FOREIGN KEY (`package_id`) REFERENCES `tbl_package` (`package_id`),
  ADD CONSTRAINT `FK_tbl_package_items` FOREIGN KEY (`package_id`) REFERENCES `tbl_package` (`package_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_package_item_ibfk_1` FOREIGN KEY (`item_type_id`) REFERENCES `tbl_package_item_type` (`package_item_type_id`);
-- THIS ALTER TABLE IS BROKEN


--
-- tbl_my_package
--
DROP TABLE IF EXISTS `tbl_my_package`;

CREATE TABLE IF NOT EXISTS `tbl_my_package` (
  `my_package_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expire_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`my_package_id`),
  KEY `package_id` (`package_id`),
  KEY `business_id` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for table `tbl_my_package`
--
ALTER TABLE `tbl_my_package`
  ADD CONSTRAINT `tbl_my_package_ibfk_2` FOREIGN KEY (`business_id`) REFERENCES `tbl_business` (`business_id`),
  ADD CONSTRAINT `tbl_my_package_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `tbl_package` (`package_id`);




--
-- tbl_my_package_item
--
DROP TABLE IF EXISTS `tbl_my_package_item`;

CREATE TABLE IF NOT EXISTS `tbl_my_package_item` (
  `my_package_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `my_package_id` int(11) NOT NULL,
  `item_type_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`my_package_item_id`),
  KEY `my_package_id` (`my_package_id`),
  KEY `item_type_id` (`item_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

--
-- Constraints for table `tbl_my_package_item`
--
ALTER TABLE `tbl_my_package_item`
  ADD CONSTRAINT `tbl_my_package_item_ibfk_2` FOREIGN KEY (`item_type_id`) REFERENCES `tbl_package_item_type` (`package_item_type_id`),
  ADD CONSTRAINT `tbl_my_package_item_ibfk_1` FOREIGN KEY (`my_package_id`) REFERENCES `tbl_my_package` (`my_package_id`);





--
-- tbl_package_purchase
--
DROP TABLE IF EXISTS `tbl_package_purchase`;

CREATE TABLE IF NOT EXISTS `tbl_package_purchase` (
  `package_purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `status` enum('created','verified') NOT NULL,
  `total_cost` float NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `verified_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`package_purchase_id`),
  KEY `package_id` (`package_id`),
  KEY `user_id` (`user_id`),
  KEY `business_id` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Constraints for table `tbl_package_purchase`
--
ALTER TABLE `tbl_package_purchase`
  ADD CONSTRAINT `tbl_package_purchase_ibfk_3` FOREIGN KEY (`business_id`) REFERENCES `tbl_business` (`business_id`),
  ADD CONSTRAINT `tbl_package_purchase_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`);


-- ---------------------------------------------------------------------
-- business_coupon
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_coupon`;
  
  CREATE TABLE `tbl_coupon` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `coupon_name` varchar(250) NOT NULL,
  `count_created` int(11) NOT NULL DEFAULT 1,
  `count_available` int(11) NOT NULL,
  `coupon_expiry` DATE DEFAULT NULL,
  `coupon_photo` varchar(1024) DEFAULT NULL,
  `coupon_description` varchar(4096) DEFAULT NULL,
  `terms` text DEFAULT NULL,
  `active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `coupon_value` decimal(10,2) DEFAULT NULL,
  `coupon_value_type` enum('%','$') NOT NULL DEFAULT '$',
  `created_time` timestamp NULL DEFAULT 0,
  `modified_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by`  int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

   ALTER TABLE tbl_coupon
   ADD CONSTRAINT fk_coupon_created_by
        FOREIGN KEY (created_by) 
        REFERENCES tbl_user(user_id);
        
   ALTER TABLE tbl_coupon
   ADD CONSTRAINT fk_coupon_modified_by
        FOREIGN KEY (modified_by) 
        REFERENCES tbl_user(user_id);
        
    
   ALTER TABLE tbl_coupon
   ADD CONSTRAINT fk_coupon_business
        FOREIGN KEY (business_id) 
        REFERENCES tbl_business(business_id);
     
        
-- ---------------------------------------------------------------------
-- business_coupon
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_coupon_print_log`;
  
  CREATE TABLE `tbl_coupon_print_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL,
  `print_time` timestamp NULL DEFAULT 0,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

   ALTER TABLE tbl_coupon_print_log
   ADD CONSTRAINT fk_coupon_print_log_coupon
        FOREIGN KEY (coupon_id) 
        REFERENCES tbl_coupon(coupon_id);

-- ---------------------------------------------------------------------
-- pages
-- ---------------------------------------------------------------------
  DROP TABLE IF EXISTS `tbl_page`;

  CREATE TABLE `tbl_page` (
    `page_id` int(11) NOT NULL AUTO_INCREMENT,
    `page_name` varchar(512) NOT NULL,
    `page_type` int(11) NOT NULL,
  PRIMARY KEY (`page_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
  
-- ---------------------------------------------------------------------
-- banners
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tbl_banner`;
  
  CREATE TABLE `tbl_banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `banner_title` varchar(255) NOT NULL,
  `banner_description` varchar(4096) DEFAULT NULL,
  `banner_url` varchar(255) NOT NULL,
  `banner_expiry` DATE DEFAULT NULL,
  `banner_photo` varchar(1024) DEFAULT NULL,
  `banner_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `banner_view_limit` int(11) NOT NULL DEFAULT 1,
  `banner_views` int(11) NOT NULL DEFAULT 0,
  `banner_clicks` int(11) NOT NULL DEFAULT 0,
  `created_time` timestamp NULL DEFAULT 0,
  `modified_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by`  int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

   ALTER TABLE tbl_banner
   ADD CONSTRAINT fk_banner_created_by
        FOREIGN KEY (created_by) 
        REFERENCES tbl_user(user_id);
        
   ALTER TABLE tbl_banner
   ADD CONSTRAINT fk_banner_modified_by
        FOREIGN KEY (modified_by) 
        REFERENCES tbl_user(user_id);
        
    
   ALTER TABLE tbl_banner
   ADD CONSTRAINT fk_banner_business
        FOREIGN KEY (business_id) 
        REFERENCES tbl_business(business_id);
     
        
-- ---------------------------------------------------------------------
-- banner page list
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_banner_page`;
  
  CREATE TABLE `tbl_banner_page` (
  `banner_page_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  PRIMARY KEY (`banner_page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

   ALTER TABLE tbl_banner_page
   ADD CONSTRAINT fk_banner_page_banner
        FOREIGN KEY (banner_id) 
        REFERENCES tbl_banner(banner_id);
        
   ALTER TABLE tbl_banner_page
   ADD CONSTRAINT fk_banner_page_page
        FOREIGN KEY (page_id) 
        REFERENCES tbl_page(page_id);

-- ---------------------------------------------------------------------
-- ---------------------------------------------------------------------
-- END
-- ---------------------------------------------------------------------
-- ---------------------------------------------------------------------

