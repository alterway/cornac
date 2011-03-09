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

class Cornac_Tokenizeur_Template_Sqlite extends Cornac_Tokenizeur_Template_Db {
    
    function __construct($root, $fichier = null) {
        parent::__construct($root, $fichier);
        
        global $INI;
        
        $this->table = $INI['cornac']['prefix'] ?: 'tokens';
        $this->table_tags = $this->table.'_tags';

        if (isset($INI['sqlite']) && $INI['sqlite']['active'] == true) {
           $this->database = new pdo($INI['sqlite']['dsn']);
        } else {
            print "No database configuration provided (no sqlite)\n";
            die();
        }
        
        $this->database->query('DELETE FROM '.$this->table.' WHERE fichier = "'.$fichier.'"');
        $this->database->query('CREATE TABLE IF NOT EXISTS '.$this->table.' (id       INTEGER PRIMARY KEY AUTOINCREMENT, 
                                                          left   INT UNSIGNED CONSTRAINT KEY DEFAULT "0",
                                                          right   INT UNSIGNED CONSTRAINT KEY DEFAULT "0",
                                                          type     CHAR(20) CONSTRAINT KEY DEFAULT "",
                                                          code     VARCHAR(255) CONSTRAINT KEY DEFAULT "",
                                                          fichier  VARCHAR(255) CONSTRAINT KEY DEFAULT "prec",
                                                          line     INT,
                                                          scope    VARCHAR(255),
                                                          class    VARCHAR(255),
                                                          level    INT UNSIGNED
                                                          )');

        $this->database->query('CREATE TABLE IF NOT EXISTS '.$this->table_tags.' (
  `token_id` int unsigned NOT NULL CONSTRAINT  KEY DEFAULT "0",
  `token_sub_id` int unsigned NOT NULL CONSTRAINT  KEY DEFAULT "0",
  `type` varchar(50) NOT NULL
)');

        $this->root = $root;
    }
}
?>