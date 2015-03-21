<?php
    return <<<END
        CREATE TABLE IF NOT EXISTS addressbooks (
        id INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
        principaluri VARCHAR(255),
        displayname VARCHAR(255),
        uri VARCHAR(200),
        description TEXT,
        synctoken INT(11) UNSIGNED NOT NULL DEFAULT '1',
        UNIQUE(principaluri(100), uri(100))
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        CREATE TABLE IF NOT EXISTS cards (
            id INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            addressbookid INT(11) UNSIGNED NOT NULL,
            carddata MEDIUMBLOB,
            uri VARCHAR(200),
            lastmodified INT(11) UNSIGNED,
            etag VARBINARY(32),
            size INT(11) UNSIGNED NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        CREATE TABLE IF NOT EXISTS addressbookchanges (
            id INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            uri VARCHAR(200) NOT NULL,
            synctoken INT(11) UNSIGNED NOT NULL,
            addressbookid INT(11) UNSIGNED NOT NULL,
            operation TINYINT(1) NOT NULL,
            INDEX addressbookid_synctoken (addressbookid, synctoken)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        CREATE TABLE IF NOT EXISTS calendarobjects (
            id INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            calendardata MEDIUMBLOB,
            uri VARBINARY(200),
            calendarid INTEGER UNSIGNED NOT NULL,
            lastmodified INT(11) UNSIGNED,
            etag VARBINARY(32),
            size INT(11) UNSIGNED NOT NULL,
            componenttype VARBINARY(8),
            firstoccurence INT(11) UNSIGNED,
            lastoccurence INT(11) UNSIGNED,
            uid VARCHAR(200),
            UNIQUE(calendarid, uri)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        CREATE TABLE IF NOT EXISTS calendars (
            id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            principaluri VARBINARY(100),
            displayname VARCHAR(100),
            uri VARBINARY(200),
            synctoken INTEGER UNSIGNED NOT NULL DEFAULT '1',
            description TEXT,
            calendarorder INT(11) UNSIGNED NOT NULL DEFAULT '0',
            calendarcolor VARBINARY(10),
            timezone TEXT,
            components VARBINARY(20),
            transparent TINYINT(1) NOT NULL DEFAULT '0',
            UNIQUE(principaluri, uri)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        CREATE TABLE IF NOT EXISTS calendarchanges (
            id INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            uri VARCHAR(200) NOT NULL,
            synctoken INT(11) UNSIGNED NOT NULL,
            calendarid INT(11) UNSIGNED NOT NULL,
            operation TINYINT(1) NOT NULL,
            INDEX calendarid_synctoken (calendarid, synctoken)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        CREATE TABLE IF NOT EXISTS calendarsubscriptions (
            id INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            uri VARCHAR(200) NOT NULL,
            principaluri VARCHAR(100) NOT NULL,
            source TEXT,
            displayname VARCHAR(100),
            refreshrate VARCHAR(10),
            calendarorder INT(11) UNSIGNED NOT NULL DEFAULT '0',
            calendarcolor VARCHAR(10),
            striptodos TINYINT(1) NULL,
            stripalarms TINYINT(1) NULL,
            stripattachments TINYINT(1) NULL,
            lastmodified INT(11) UNSIGNED,
            UNIQUE(principaluri, uri)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        CREATE TABLE IF NOT EXISTS schedulingobjects (
            id INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            principaluri VARCHAR(255),
            calendardata MEDIUMBLOB,
            uri VARCHAR(200),
            lastmodified INT(11) UNSIGNED,
            etag VARCHAR(32),
            size INT(11) UNSIGNED NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        CREATE TABLE IF NOT EXISTS locks (
            id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            owner VARCHAR(100),
            timeout INTEGER UNSIGNED,
            created INTEGER,
            token VARBINARY(100),
            scope TINYINT,
            depth TINYINT,
            uri VARBINARY(1000),
            INDEX(token),
            INDEX(uri(100))
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        CREATE TABLE IF NOT EXISTS principals (
            id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            uri VARCHAR(200) NOT NULL,
            email VARCHAR(80),
            displayname VARCHAR(80),
            vcardurl VARCHAR(255),
            UNIQUE(uri)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        CREATE TABLE IF NOT EXISTS groupmembers (
            id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            principal_id INTEGER UNSIGNED NOT NULL,
            member_id INTEGER UNSIGNED NOT NULL,
            UNIQUE(principal_id, member_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        CREATE TABLE IF NOT EXISTS propertystorage (
            id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            path VARBINARY(1024) NOT NULL,
            name VARBINARY(100) NOT NULL,
            value MEDIUMBLOB
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        CREATE UNIQUE INDEX path_property ON propertystorage (path(600), name(100));

        CREATE TABLE IF NOT EXISTS users (
            id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50),
            digesta1 VARCHAR(32),
            UNIQUE(username)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
END;
