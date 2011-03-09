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

class Cornac_Format_File2png {
    private $scale=10;
    private $array = array();
    private $img = null;
    private $webcolors = array();
    private $colors = array();

    function __construct() {
        $this->webcolors['aqua'] = '#00FFFF';
        $this->webcolors['gray'] = '#808080';
        $this->webcolors['navy'] = '#000080';
        $this->webcolors['silver'] = '#C0C0C0';
        $this->webcolors['black'] = '#000000';
        $this->webcolors['green'] = '#008000';
        $this->webcolors['olive'] = '#808000';
        $this->webcolors['teal'] = '#008080';
        $this->webcolors['blue'] = '#0000FF';
        $this->webcolors['lime'] = '#00FF00';
        $this->webcolors['purple'] = '#800080';
        $this->webcolors['white'] = '#FFFFFF';
        $this->webcolors['fuchsia'] = '#FF00FF';
        $this->webcolors['maroon'] = '#800000';
        $this->webcolors['red'] = '#FF0000';
        $this->webcolors['yellow'] = '#FFFF00';
        $this->webcolors['grey'] = '#C0C0C0';
    }

    function setArray($array) {
        $this->array = $array;
    }

    function process() {
        $this->path2array($this->array);

        $large = $this->large($this->array);
        $deep = $this->deep($this->array) ;

        $this->img = imagecreatetruecolor($large * $this->scale, $deep * $this->scale);
        $grey = $this->getcolor('grey');
        $white = $this->getcolor('white');
        $black = $this->getcolor('black');
        $red = $this->getcolor('red');
        imagefilledrectangle($this->img, 0, 0, $large * $this->scale -1, $deep * $this->scale -1, $grey);
        imagerectangle($this->img, 0, 0, $large * $this->scale -1, $deep * $this->scale -1, $black);

        $img = $this->draw($this->array);
    }

    function draw($array, &$x_dir = 0, $y_dir = 1) {
        $black = $this->getcolor('black');
        $red = $this->getcolor('red');
        $white = $this->getcolor('white');

        $init = $x_dir;
        $x_leaf = $x_dir;
        $y_leaf = $y_dir;

        foreach($array as $a) {
            if (!is_array($a)) {
                list($file, $color) = explode(';', $a);
                $color = $this->getcolor($color);

                imagefilledrectangle($this->img, $x_leaf * $this->scale, $y_leaf * $this->scale, ($x_leaf + 1) * $this->scale, ($y_leaf + 1) * $this->scale, $color);
                imagerectangle($this->img, $x_leaf * $this->scale, $y_leaf * $this->scale, ($x_leaf + 1) * $this->scale, ($y_leaf + 1) * $this->scale, $white);
                $y_leaf++;
            }
        }

        if ($y_leaf > $y_dir) { $x_dir++; }
        foreach($array as $a) {
            if (is_array($a)) {

                // recursive
                $y_dir++;
                $this->draw($a, $x_dir, $y_dir);
                $y_dir--;
                // @note go on
            }
        }

        $end = $x_dir + 1;

    // folder

        $color = imagecolorallocate($this->img, rand(0,255),0,0);
        imagefilledrectangle($this->img, $init * $this->scale, ($y_dir - 1) * $this->scale, ($end -2 ) * $this->scale , ($y_dir ) * $this->scale, $white);
        imagerectangle($this->img, $init * $this->scale, ($y_dir - 1) * $this->scale, ($end -1) * $this->scale - 1, ($y_dir ) * $this->scale, $red);
    }

    function save($filename = null) {
        if (!is_null($filename)) {
            imagepng($this->img, $filename);
        } else {
            header('Content-Type: image/png');
            imagepng($this->img);
        }
    }

    function path2array() {
        $retour = array();

        foreach($this->array as $path) {
            $dirs = explode('/', $path);
            $retour = array_merge_recursive($retour, $this->array2multi($dirs));
        }

        $this->array = $retour;
    }
    
    function array2multi($array) {
        $f = array_shift($array);
        if (count($array) > 0) {
            $retour[$f] = $this->array2multi($array);
        } else {
            $retour = array($f => $f);
        }
        
        return $retour;
    }


    function getcolor($color) {
        if (isset($this->colors[$color])) {
            return $this->colors[$color];
        }
        // @todo support direct colors
        $r = hexdec(substr($this->webcolors[$color], 1,2));
        $g = hexdec(substr($this->webcolors[$color], 3,4));
        $b = hexdec(substr($this->webcolors[$color], 5,6));
        return $this->colors[$color] = imagecolorallocate($this->img, $r, $g, $b);
    }

    function large($array) {
        $large = 0;
        $leafs = 0;
        foreach($array as $a) {
            if (is_array($a)) {
                $large += $this->large($a);
            } else {
                $leafs++;
            }
        }

        if ($leafs > 0) {
            $large++;
        }

        return $large;
    }

    function deep($array, $level = 0) {
        $depth = 1;

        $max = 0;
        $leafs = 0;
        foreach($array as $a) {
            if (is_array($a)) {
                $d = $this->deep($a, $level + 1);
                if ($d > $max) {$max = $d; }
            } else {
                $leafs++;
            }
        }

        if ($leafs > $max + 1) {
            $depth = $leafs + 1;
        } else {
            $depth = $max + 1;
        }

        return $depth;
    }
}
?>