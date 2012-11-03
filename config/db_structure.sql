
-- structure for domains
-- This table stores all hosted domains
DROP TABLE IF EXISTS `domains`;
CREATE TABLE IF NOT EXISTS `domains` (
  `domain_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'just a unique ID',
  `domain_name` varchar(255) NOT NULL COMMENT 'the domain',
  PRIMARY KEY (`domain_id`),
  UNIQUE KEY `domain_name` (`domain_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Stores the virtual domains that are hosted' AUTO_INCREMENT=1 ;


-- structure of users
-- This table stores all user accounts
-- 
-- A user account is defined by its username and the assigned domain (see the
-- unique key constraint 'email').
--
-- The real email-address is constructed by the username (local part of the 
-- address) and the domain_name (fetched from 'domains', domain part of the
-- mail address).
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'just a unique ID',
  `username` varchar(255) NOT NULL COMMENT 'the local-part of the mail address',
  `domain_id` int(10) unsigned NOT NULL COMMENT 'FK to ''domains''',
  `location` char(32) NOT NULL COMMENT 'the MailDir location',
  `password` char(32) NOT NULL COMMENT 'the user''s password hash',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`username`,`domain_id`),
  UNIQUE KEY `location` (`location`),
  KEY `users_domain` (`domain_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stores the user information' AUTO_INCREMENT=1 ;


-- structure of aliases
-- This table stores aliases
-- 
-- An alias is a special email address, which will be forwarded to a certain
-- destination mail address.
-- 
-- The 'aliasname' corresponds to the 'username' of the 'users'-table. The 
-- complete alias is constructed by the aliasname (local part of the address)
-- and the domain_name (fetched from 'domains', domain part of the address).
DROP TABLE IF EXISTS `aliases`;
CREATE TABLE IF NOT EXISTS `aliases` (
  `alias_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'just a unique ID',
  `aliasname` varchar(255) NOT NULL COMMENT 'local-part of an alias',
  `domain_id` int(10) unsigned NOT NULL COMMENT 'FK to table ''domains''',
  `destination` varchar(255) NOT NULL COMMENT 'the destination eMail address',
  PRIMARY KEY (`alias_id`),
  UNIQUE KEY `aliasname` (`aliasname`,`domain_id`),
  KEY `alias_domain` (`domain_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stores the aliases' AUTO_INCREMENT=1 ;


-- Adds a foreign key constraint to 'aliases' to assure correct domain_ids
ALTER TABLE `aliases`
  ADD CONSTRAINT `alias_domain` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`domain_id`) ON DELETE CASCADE;


-- Adds a foreign key constraint to 'users' to assure correct domain _ids
ALTER TABLE `users`
  ADD CONSTRAINT `users_domain` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`domain_id`) ON DELETE CASCADE;

