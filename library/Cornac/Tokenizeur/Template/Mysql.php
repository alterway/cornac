<?php
/*
   +----------------------------------------------------------------------+
   | Cornac, PHP code inventory                                           |
   +----------------------------------------------------------------------+
   | Copyright (c) 2010 - 2011                                            |
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.01 of the PHP license,      |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | http://www.php.net/license/3_01.txt                                  |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
   | Author: Damien Seguy <damien.seguy@gmail.com>                        |
   +----------------------------------------------------------------------+
 */

class Cornac_Tokenizeur_Template_Mysql extends Cornac_Tokenizeur_Template_Db {
    protected $root = null;
    protected $database = null;
    static public $auto_increment = 0;
    
    function __construct($root, $file = null) {
        parent::__construct($root, $file);

        global $DATABASE;
        $this->database = $DATABASE;

        $this->database->query('DELETE FROM <tokens> WHERE file = "'.$file.'"');
        $this->database->query('CREATE TABLE IF NOT EXISTS <tokens> (
                                                          `id`       INT NOT NULL AUTO_INCREMENT, 
                                                          `left`     INT UNSIGNED, 
                                                          `right`    INT UNSIGNED,
                                                          `type`     CHAR(20),
                                                          `code`     VARCHAR(10000),
                                                          `file`     VARCHAR(255) DEFAULT "prec",
                                                          `line`     INT,
                                                          `scope`    VARCHAR(255),
                                                          `class`    VARCHAR(255),
                                                          `level`    TINYINT UNSIGNED,
                                                          PRIMARY KEY (`id`),
                                                          UNIQUE KEY `id` (`id`),
                                                          KEY `file` (`file`),
                                                          KEY `type` (`type`),
                                                          KEY `left` (`left`),
                                                          KEY `right` (`right`),
                                                          KEY `code` (`code`)
                                                          ) ENGINE=MyISAM DEFAULT CHARSET=latin1');

        $this->database->query('CREATE TEMPORARY TABLE IF NOT EXISTS <tokens_tmp> (
                                                          `id`       INT NOT NULL AUTO_INCREMENT, 
                                                          `left`     INT UNSIGNED, 
                                                          `right`    INT UNSIGNED,
                                                          `type`     CHAR(20),
                                                          `code`     VARCHAR(10000),
                                                          `file`     VARCHAR(255) DEFAULT "prec",
                                                          `line`     INT,
                                                          `scope`    VARCHAR(255),
                                                          `class`    VARCHAR(255),
                                                          `level`    TINYINT UNSIGNED,
                                                          PRIMARY KEY (`id`),
                                                          UNIQUE KEY `id` (`id`),
                                                          KEY `file` (`file`),
                                                          KEY `type` (`type`),
                                                          KEY `left` (`left`),
                                                          KEY `right` (`right`),
                                                          KEY `code` (`code`)
                                                          ) ENGINE=MyISAM DEFAULT CHARSET=latin1');
// @todo clean table based on file. But file is in <tokens>, not in tokens_tags!
//        $this->database->query('DELETE FROM <tokens_tags> WHERE file = "'.$file.'"');
        $this->database->query('CREATE TABLE IF NOT EXISTS <tokens_tags> (
  `token_id` int(10) unsigned NOT NULL,
  `token_sub_id` int(10) unsigned NOT NULL,
  `type` varchar(50) NOT NULL,
  KEY `token_id` (`token_id`),
  KEY `token_sub_id` (`token_sub_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1');

// @todo if exists => stop! 
        $this->database->query('CREATE TEMPORARY TABLE IF NOT EXISTS <tokens_tags_tmp> (
  `token_id` int(10) unsigned NOT NULL,
  `token_sub_id` int(10) unsigned NOT NULL,
  `type` varchar(50) NOT NULL,
  KEY `token_id` (`token_id`),
  KEY `token_sub_id` (`token_sub_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1');
        $this->database->query('DELETE FROM <tokens_tags_tmp>');

/*
    TODO : add extra test to clean tags. THis used to be done with this trigger.
        $this->database->query('DELIMITER //');
        $this->database->query('CREATE TRIGGER auto_tag BEFORE DELETE ON `<tokens>`
FOR EACH ROW
BEGIN
DELETE FROM <tokens_tags> WHERE token_id = OLD.id OR token_sub_id = OLD.id;
END;
//');
        $this->database->query('delimiter ;');
*/
        $this->root = $root;
    }

    function save($filename = null) {
    // @todo take into account initial auto_increment in table, to add in table_tmp and tags_tmp
    
    // @todo needs table lock or transaction
        $res = $this->database->query('LOCK TABLES <tokens> WRITE, <tokens_tmp> WRITE,
                                                   <tokens_tags> WRITE, <tokens_tags_tmp> WRITE');
        $res = $this->database->query('SHOW TABLE STATUS LIKE "<tokens>"');
        $row = $res->fetch();
        
        self::$auto_increment = $row['Auto_increment'];

        $this->database->query('INSERT INTO <tokens> SELECT id + '.$row['Auto_increment'].', `left`, `right`, type, code, file, line, scope, class, level FROM  <tokens_tmp>');
        $this->database->query('DROP TABLE <tokens_tmp>');
        
        $this->database->query('INSERT INTO <tokens_tags> SELECT token_id + '.$row['Auto_increment'].', token_sub_id + '.$row['Auto_increment'].', type FROM  <tokens_tags_tmp>');
        $this->database->query('DROP TABLE <tokens_tags_tmp>');
        $this->database->query('UNLOCK TABLES;');
        return true;
    }

}

?>