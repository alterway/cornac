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

class Cornac_Tokenizeur_Template_Stats extends Cornac_Tokenizeur_Template {
    protected $root = null;
    protected $stats = array('missing' => array());
    
    function __construct($root) {
        parent::__construct();
        
        $this->root = $root;
    }

    function save($filename = null) {
        print_r($this->stats);
    }

    function display($node = null, $niveau = 0) {
        if (is_null($node)) {
            $node = $this->root;
        }
        
        if (!is_object($node)) {
            print "Fatal : attempting to display a non-object in ".__METHOD__."\n\n";
        }
        $class = $node->getTname();
        $method = "display_$class";

        if (method_exists($this, $method)) {
            $this->$method($node, $niveau + 1);
        } else {
            $this->stats['missing'][$method] = 1;
        }
        if (!is_null($node->getNext())){
            $this->display($node->getNext(), $niveau);
        } else {
            if ($niveau == 0) {
                if (count($this->stats['missing']) == 0) { 
                    unset($this->stats['missing']); 
                }
            }
        }
    }
    
    function addStat($name) {
        if (substr($name, 0, 8) == 'display_') {
            $name = substr($name, 8);
        }
        
        if (isset( $this->stats[$name])) {
            $this->stats[$name]++;        
        } else {
            $this->stats[$name] = 1;
        }
    }

    function display_arginit($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getVariable(), $niveau + 1);
        $this->display($node->getValue(), $niveau + 1);
    }

    function display_arglist($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $elements = $node->getList();
        if (is_array($elements)) {
            foreach($elements as $id => $e) {
                if (!is_null($e)) {
                    $this->display($e, $niveau + 1);
                }
            }
        }
    }

    function display_affectation($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getLeft(), $niveau + 1);
        $this->display($node->getOperator(), $niveau + 1);
        $this->display($node->getRight(), $niveau + 1);
    }

    function display_block($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $elements = $node->getList();
        foreach($elements as $id => $e) {
            $this->display($e, $niveau + 1);
        }
    }

    function display__break($node, $niveau) {
        $this->addStat(__FUNCTION__);
    }

    function display__case($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getCondition(), $niveau + 1);
        $this->display($node->getBlock(), $niveau + 1);
    }

    function display_cast($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getExpression(), $niveau + 1);
    }

    function display__catch($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getException(), $niveau + 1);
        $this->display($node->getVariable(), $niveau + 1);
        $this->display($node->getBlock(), $niveau + 1);
    }

    function display__class($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $extends = $node->getExtends();
        if (!is_null($extends)) {
            $this->display($extends, $niveau + 1);
        }
        $implements = $node->getImplements();
        if (count($implements) > 0) {
            foreach($implements as $i) {
                $this->display($i, $niveau + 1);
            }
        }
        $this->display($node->getBlock(), $niveau + 1);
    }

    function display_keyvalue($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getKey(), $niveau + 1);
        $this->display($node->getValue(), $niveau + 1);
    }

    function display__clone($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getExpression(), $niveau + 1);
    }

    function display_comparison($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getLeft(), $niveau + 1);
        $this->display($node->getRight(), $niveau + 1);
    }
    
    function display_ternaryop($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getCondition(), $niveau + 1);
        $this->display($node->getThen(), $niveau + 1);
        $this->display($node->getElse(), $niveau + 1);
    }

    function display_codephp($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getphp_code(), $niveau + 1);
    }

    function display_concatenation($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $elements = $node->getList();
        foreach($elements as $id => $e) {
            $this->display($e, $niveau + 1);
        }
    }

    function display__continue($node, $niveau) {
        $this->addStat(__FUNCTION__);
    }

    function display__constant($node, $niveau) {
        $this->addStat(__FUNCTION__);
    }

    function display_constant_static($node, $niveau) {
        $this->addStat(__FUNCTION__);
         $this->display($node->getClass(), $niveau + 1);
         $this->display($node->getConstant(), $niveau + 1);
    }

    function display_constant_class($node, $niveau) {
        $this->addStat(__FUNCTION__);
         $this->display($node->getName(), $niveau + 1);
         $this->display($node->getConstant(), $niveau + 1);
    }

    function display_bitshift($node, $niveau) {
        $this->addStat(__FUNCTION__);
         $this->display($node->getLeft(), $niveau + 1);
         $this->display($node->getOperator(), $niveau + 1);
         $this->display($node->getRight(), $niveau + 1);
    }

    function display__declare($node, $niveau) {
        $this->addStat(__FUNCTION__);
         $this->display($node->getTicks(), $niveau + 1);
         $this->display($node->getEncoding(), $niveau + 1);
         $n = $node->getBlock();
         if (!is_null($n)) {
             $this->display($n, $niveau + 1);
         }
    }

    function display__default($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getBlock(), $niveau + 1);
    }

    function display__for($node, $niveau) {
        $this->addStat(__FUNCTION__);

        $init = $node->getInit();
        if (!is_null($init)) {
            $this->display($init, $niveau + 1);
        }

        $end = $node->getEnd();
        if (!is_null($end)) {
            $this->display($end, $niveau + 1);
        }

        $increment = $node->getIncrement();
        if (!is_null($increment)) {
            $this->display($increment, $niveau + 1);
        }
        
        $this->display($node->getBlock(), $niveau + 1);
    }

    function display__foreach($node, $niveau) {
        $this->addStat(__FUNCTION__);

        $gets = array('getArray','getKey','getValue','getBlock');

        foreach($gets as $get) {
            $list = $node->$get();
            if (!is_null($list)) {
                $this->display($list, $niveau + 1);
            }
        }
    }

  function display__function($node, $niveau) {
        $this->addStat(__FUNCTION__);

        $this->display($node->getName(), $niveau + 1);
        $this->display($node->getArgs(), $niveau + 1);
        $this->display($node->getBlock(), $niveau + 1);
    }

    function display__global($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $elements = $node->getVariables();
        foreach($elements as $id => $e) {
            $this->display($e, $niveau + 1);
        }
    }

    function display__goto($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getLabel(), $niveau + 1);
    }

    function display_functioncall($node, $niveau) {
        $this->addStat(__FUNCTION__);

        $args = $node->getArgs();
        $this->display($args, $niveau + 1);
    }

    function display____halt_compiler($node, $niveau) {
        $this->addStat(__FUNCTION__);
    }

    function display_ifthen($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $conditions = $node->getCondition();
        $thens = $node->getThen();
        foreach($conditions as $id => $condition) {
            $this->display($condition, $niveau + 1);
            $this->display($thens[$id], $niveau + 1);
        }
        if (!is_null($node->getElse())){
            $this->display($node->getElse(), $niveau + 1);
        }
    }

    function display_inclusion($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $inclusion = $node->getInclusion();
        $this->display($inclusion, $niveau + 1);
    }

    function display__interface($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getName(), $niveau + 1);
        $this->display($node->getBlock(), $niveau + 1);
    }

    function display_invert($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getExpression(), $niveau + 1);
    }

    function display_label($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getName(), $niveau + 1);
    }

    function display_logical($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getLeft(), $niveau + 1);
        $this->display($node->getOperator(), $niveau + 1);
        $this->display($node->getRight(), $niveau + 1);
    }

    function display_literals($node, $niveau) {
        $this->addStat(__FUNCTION__);
    }

    function display_method($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getObject(), $niveau + 1);
        $this->display($node->getMethod(), $niveau + 1);
    }

    function display_method_static($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getClass(), $niveau + 1);
        $this->display($node->getMethod(), $niveau + 1);
    }

    function display__new($node, $niveau) {
         print str_repeat('  ', $niveau).' new '.$node->getClass()." ".$node->getArgs()." \n";
    }

    function display_noscream($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getExpression(), $niveau + 1);
    }

    function display_not($node, $niveau) {
        $this->addStat(__FUNCTION__);
         $this->display($node->getExpression(), $niveau + 1);
    }

    function display_opappend($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getVariable(), $niveau + 1);
    }

    function display_operation($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getLeft(), $niveau + 1);
        $this->display($node->getRight(), $niveau + 1);
    }

    function display_parenthesis($node, $niveau) {
        $this->addStat(__FUNCTION__);
    }

    function display_preplusplus($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getOperator(), $niveau + 1);
        $this->display($node->getVariable(), $niveau + 1);
    }
    
    function display_property($node, $niveau) {
        $this->addStat(__FUNCTION__);
    }

    function display_property_static($node, $niveau) {
        $this->addStat(__FUNCTION__);
    }

    function display_postplusplus($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getOperator(), $niveau + 1);
        $this->display($node->getVariable(), $niveau + 1);
    }

    function display_rawtext($node, $niveau) {
        $this->addStat(__FUNCTION__);
    }

    function display_reference($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getExpression(), $niveau + 1);
    }

    function display__return($node, $niveau) {
        $this->addStat(__FUNCTION__);
        if (!is_null($node->getReturn())) {
            $this->display($node->getReturn(), $niveau + 1);
        }
    }

    function display_sequence($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $elements = $node->getElements();
        foreach($elements as $id => $e) {
            $this->display($e, $niveau + 1);
        }
    }

    function display_sign($node, $niveau) {
        $this->addStat(__FUNCTION__);
         $this->display($node->getsign(), $niveau + 1);
         $this->display($node->getExpression(), $niveau + 1);
    }

    function display__static($node, $niveau) {
        $this->addStat(__FUNCTION__);
         $this->display($node->getExpression(), $niveau + 1);
    }

    function display__switch($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getCondition(), $niveau + 1);
        $this->display($node->getBlock(), $niveau + 1);
    }

    function display__array($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getVariable(), $niveau + 1);
        $this->display($node->getIndex(), $niveau + 1);
    }

    function display_processedToken($node, $niveau) {
        $this->addStat(__FUNCTION__);
    }

    function display__throw($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getException(), $niveau + 1);
    }
    
    function display__try($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getBlock(), $niveau + 1);
        $elements = $node->getCatch();
        foreach($elements as $id => $e) {
            $this->display($e, $niveau + 1);
        }
    }

    function display_typehint($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getName(), $niveau + 1);
        $this->display($node->getType(), $niveau + 1);
    }

    function display__var($node, $niveau) {
        $this->addStat(__FUNCTION__);

        $variables = $node->getVariable();
        foreach($variables as $var) {
            $this->display($var, $niveau + 1);
        }

        $inits = $node->getInit();
        foreach($inits as $init) {
            if (is_null($init)) {continue;}
            $this->display($init, $niveau + 1);
        }
    }

    function display_variable($node, $niveau) {
        $this->addStat(__FUNCTION__);
    }

    function display__while($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getCondition(), $niveau + 1);
        $this->display($node->getBlock(), $niveau + 1);
    }

    function display__dowhile($node, $niveau) {
        $this->addStat(__FUNCTION__);
        $this->display($node->getCondition(), $niveau + 1);
        $this->display($node->getBlock(), $niveau + 1);
    }

    function display_Token($node, $niveau) {
        print $node."".$node->getId()."\n";
        $this->addStat(__FUNCTION__);
    }
}

?>