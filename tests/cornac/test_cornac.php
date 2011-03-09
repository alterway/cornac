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

class Cornac_Framework_TestCase extends PHPUnit_Framework_TestCase {
    public function test_help() {
        $shell = <<<SHELL
cd ../..; ./cornac.php -h
SHELL;

        $retour = shell_exec($shell);
        
        $this->assertContains( '-?', $retour);
        $this->assertContains( '-d', $retour);
        $this->assertContains( '-o', $retour);
        $this->assertContains( '-s', $retour);
    }
    
    public function test_empty() {
        $shell = <<<SHELL
cd ../..; ./cornac.php
SHELL;

        $retour = shell_exec($shell);
        $this->assertContains( 'Usage : ./cornac -d <source folder> -o <output folder>', $retour);
    }

    public function test_destination() {
        $shell = <<<SHELL
cd ../..; ./cornac.php -d ./tests/cornac/appli/
SHELL;

        $retour = shell_exec($shell);
        $this->assertContains( 'Usage : ./cornac -d <source folder> -o <output folder>', $retour);
    }
}

?>