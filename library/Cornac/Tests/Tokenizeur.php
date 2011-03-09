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

class Cornac_Tests_Tokenizeur extends PHPUnit_Framework_TestCase {

    protected function generic_test($test) {
        if (!file_exists('scripts/'.$test.'.test.php')) {
            print "\nTest script 'scripts/$test.test.php' is missing\n";
            $this->assertEquals(true, false);
        }

        if (!file_exists('exp/'.$test.'.test.exp')) {
            print "\nLe fichier d'attendu 'exp/$test.test.exp' est manquant\n";
            $this->assertEquals(true, false);
        }

        $retour = shell_exec('cd ../../; php bin/tok -f tests/tokenizeur/scripts/'.$test.'.test.php -I testsunitaires -g tree');

        $exp = file_get_contents('exp/'.$test.'.test.exp');
        $exp = str_replace('tests/tokenizeur/','tests/tokenizeur/scripts/', $exp);
        $exp = str_replace('scripts/scripts/','scripts/', $exp);

// @todo check if those lines are still here really
        $retour = preg_replace("/Fichier de directives : .*?\n/is",'', $retour);
        $retour = preg_replace("/Directives files : .*?\n/is",'', $retour);
        $retour = preg_replace("/Cycles = -1\n/is",'', $retour);        
        $retour = str_replace("No more tasks to work on. Finishing.\n",'', $retour);
        
        $this->assertEquals($retour, $exp);        
    }

}

?>