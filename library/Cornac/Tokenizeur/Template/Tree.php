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

class Cornac_Tokenizeur_Template_Tree extends Cornac_Tokenizeur_Template {
    protected $root = null;
    
    function __construct($root) {
        parent::__construct();
        
        $this->root = $root;
    }
    
    function save($filename = null) {
        return true;
    }
    
    function display($node = null, $level = 0, $follow = true) {
        if ($level > 100) {
            print "Fatal : more than 100 level of recursion : aborting\n"; 
            die(__METHOD__."\n");
        }
        if (is_null($node)) {
            if ($level == 0) {
                $node = $this->root;
            } else {
                print_r(xdebug_get_function_stack());        
                print "Attempting to send null to display.";
                die(__METHOD__."\n");
            }
        }
        
        if (!is_object($node)) {
            debug_print_backtrace();
            print "Fatal : attempting to display a non-object in ".__METHOD__."\n\n";
            die(__METHOD__."\n");
        }
        
        $class = $node->getTname();
        $method = "display_$class";
        
        if (method_exists($this, $method)) {
            $this->$method($node, $level + 1);
        } else {
            print "Unknown method  ".$method." for class '".$node->getTname()."'\n";
            die(__METHOD__."\n");
        }

        if ($follow == true) {
            $nodes = array();
            $next = $node;
            while($next = $next->getNext()) {
                $nodes[] = $next;
            }
            
            foreach($nodes as $n) {
                $this->display($n, $level, false);
            }
        }
    }
    
    function display_arginit($node, $level) {
        print str_repeat('  ', $level)." argument and initialisation \n";
        $this->display($node->getVariable(), $level + 1);
         $this->display($node->getValue(), $level + 1);
    }

    function display_arglist($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $elements = $node->getList();
        if (count($elements) == 0) {
            print str_repeat('  ', $level)."Empty arglist\n";
        } else {
            foreach($elements as $id => $e) {
                print str_repeat('  ', $level)."$id : \n";
                if (!is_null($e)) {
                    $this->display($e, $level + 1);
                }
            }
        }
    }

    function display_affectation($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        print str_repeat('  ', $level)."left : \n";
        $this->display($node->getLeft(), $level + 1);
        print str_repeat('  ', $level).$node->getOperator()." \n";
        print str_repeat('  ', $level)."right : \n";
        $this->display($node->getRight(), $level + 1);
    }

    function display__array($node, $level) {
        print str_repeat('  ', $level).$node->getTname()."\n";
        $this->display($node->getVariable(), $level + 1);
        $this->display($node->getIndex(), $level + 1);
    }

    function display_block($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $elements = $node->getList();
        foreach($elements as $id => $e) {
            print str_repeat('  ', $level)."$id : \n";
            $this->display($e, $level + 1);
        }
    }

    function display__break($node, $level) {
         print str_repeat('  ', $level).$node->getTname()." \n";
         print str_repeat('  ', $level)."Number : \"".$node->getLevels()."\"\n";    
    }

    function display__case($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $this->display($node->getCondition(), $level + 1);
        $this->display($node->getBlock(), $level + 1);
    }

    function display_cast($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." (".$node->getCast().")".$node->getExpression()."\n";
        $this->display($node->getExpression(), $level + 1);
    }
    

    function display__catch($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." (".$node->getException().")".$node->getVariable()."\n";
         $this->display($node->getBlock(), $level + 1);
    }

    function display__class($node, $level) {
        print str_repeat('  ', $level).$node->getAbstract().' class '.$node->getName();
        $extends = $node->getExtends();
        if (!is_null($extends)) {
            print " extends ".$extends;
        }
        $implements = $node->getImplements();
        if (count($implements) > 0) {
            print " implements ".join(', ', $implements);
        }
        print "\n";
        $this->display($node->getBlock(), $level + 1);
    }

    function display__clone($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $this->display($node->getExpression(), $level + 1);
    }

    function display__closure($node, $level) {
        print str_repeat('  ', $level)."function() using ";
        print $node->getArgs()." ".$node->getBlock()." \n";
        $this->display($node->getArgs(), $level + 1);
        $this->display($node->getBlock(), $level + 1);
    }

    function display_keyvalue($node, $level) {
        print str_repeat('  ', $level).$node->getKey()." => ".$node->getValue()."\n";
        $this->display($node->getKey(), $level + 1);
        $this->display($node->getValue(), $level + 1);
    }

    function display_comparison($node, $level) {
         print str_repeat('  ', $level).$node->getTname()." \n";
         print str_repeat('  ', $level)."left : \n";
         $this->display($node->getLeft(), $level + 1);
         print str_repeat('  ', $level)."operateur : ".$node->getOperator()."\n";
         print str_repeat('  ', $level)."right : \n";
         $this->display($node->getRight(), $level + 1);
    }

    function display__continue($node, $level) {
         print str_repeat('  ', $level).$node->getTname().$node->getLevels()." \n";
    }
    
    function display_ternaryop($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." ".$node->getCode()."\n";
        print str_repeat('  ', $level).$node->getCondition();
        print " ? ".$node->getThen()." : ".$node->getElse()."\n";
        $this->display($node->getCondition(), $level + 1);
        $this->display($node->getThen(), $level + 1);
        $this->display($node->getElse(), $level + 1);
    }

    function display_codephp($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." ".$node->getCode()."\n";
        print str_repeat('  ', $level)."code : \n";
        $this->display($node->getphp_code(), $level + 1);
    }

    function display_concatenation($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $elements = $node->getList();
        foreach($elements as $id => $e) {
            print str_repeat('  ', $level)."$id : \n";
            $this->display($e, $level + 1);
        }
    }

    function display__constant($node, $level) {
         print str_repeat('  ', $level).$node->getTname()." (";
         print str_repeat('  ', $level)."".$node->getName()." )\n";    
    }

    function display_constant_static($node, $level) {
         print str_repeat('  ', $level).$node->getTname()." (";
         print str_repeat('  ', $level)."".$node->getClass()."::".$node->getConstant()." )\n";    
    }

    function display_constant_class($node, $level) {
         print str_repeat('  ', $level).$node->getTname()." ";
         print str_repeat('  ', $level)."".$node->getName()." = ".$node->getConstant()." \n";    
    }

    function display_bitshift($node, $level) {
         print str_repeat('  ', $level).$node->getTname()." \n";
         print str_repeat('  ', $level)."left : \n";
         $this->display($node->getLeft(), $level + 1);
         print str_repeat('  ', $level)."operation : ".$node->getOperator()."\n";
         print str_repeat('  ', $level)."right : \n";
         $this->display($node->getRight(), $level + 1);
    }

    function display__declare($node, $level) {
         print str_repeat('  ', $level).$node->getTname()." \n";
         print str_repeat('  ', $level + 1).' ticks = '.$node->getTicks()."\n";
         print str_repeat('  ', $level + 1).' encoding = '.$node->getEncoding()."\n";
         $n = $node->getBlock();
         if (!is_null($n)) {
             $this->display($n, $level + 1);
         }
    }
    
    function display__default($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $this->display($node->getBlock(), $level + 1);
    }

    function display__empty_($node, $level) {
        print str_repeat('  ', $level)."[empty]\n";
    }

    function display__for($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        print str_repeat('  ', $level)."  Init : ".$node->getInit().";\n";
        print str_repeat('  ', $level)."  End  : ".$node->getEnd().";\n";
        print str_repeat('  ', $level)."  Incr : ".$node->getIncrement().";\n";
        $this->display($node->getBlock(), $level + 1);
    }

    function display__foreach($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." (".$node->getArray()." as ".$node->getKey()." => ".$node->getValue().")\n";
         $this->display($node->getBlock(), $level + 1);
    }

    function display__function($node, $level) {
        print str_repeat('  ', $level).$node->getVisibility().$node->getAbstract().$node->getStatic()."function ".$node->getName()." ".$node->getArgs()."\n";
        $this->display($node->getBlock(), $level + 1);
    }

    function display_functioncall($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." ".$node->getCode()."\n";
        print str_repeat('  ', $level)."function call : ".$node->getFunction().": \n";

        $args = $node->getArgs();
        $this->display($args, $level + 1);
    }

    function display__global($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $elements = $node->getVariables();
        foreach($elements as $id => $e) {
            print str_repeat('  ', $level)."$id : \n";
            $this->display($e, $level + 1);
        }
    }

    function display__goto($node, $level) {
        print str_repeat('  ', $level).'GOTO '.$node->getLabel()." \n";
    }

    function display____halt_compiler($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
    }

    function display_ifthen($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." ".$node->getCode()."\n";
        $conditions = $node->getCondition();
        $thens = $node->getThen();
        foreach($conditions as $id => $condition) {
            print str_repeat('  ', $level)."Condition $id) \n";
            $this->display($condition, $level + 1);
            $this->display($thens[$id], $level + 1);
        }
        if (!is_null($node->getElse())){
            print str_repeat('  ', $level)." else \n";
            $this->display($node->getElse(), $level + 1);
        }
    }

    function display_inclusion($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." ".$node->getCode()."\n";

        $inclusion = $node->getInclusion();
        $this->display($inclusion, $level + 1);
    }

    function display__interface($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." ".$node->getName()."\n";
        $e = $node->getExtends();
        if (count($e) > 0) {
            print str_repeat('  ', $level).' extends '.join(', ', $e)."\n";
        }
        $this->display($node->getBlock(), $level + 1);
    }

    function display_invert($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." ~\n";
        $this->display($node->getExpression(), $level + 1);
    }

    function display_label($node, $level) {
        print str_repeat('  ', $level).' '.$node->getName()." : \n";
    }

    function display_logical($node, $level) {
         print str_repeat('  ', $level).$node->getTname()." \n";
         print str_repeat('  ', $level)."left : \n";
         $this->display($node->getLeft(), $level + 1);
         print str_repeat('  ', $level)."operateur : ".$node->getOperator()."\n";
         print str_repeat('  ', $level)."right : \n";
         $this->display($node->getRight(), $level + 1);
    }

    function display_not($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." ".$node->getCode()."\n";
         $this->display($node->getExpression(), $level + 1);
    }

    function display_literals($node, $level) {
// @todo add delimiter in the display
        print str_repeat('  ', $level).$node->getTname()." ".$node->getLiteral()."\n";
    }

    function display_method($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." ".$node->getObject()."\n";
        $method = $node->getMethod();
        print str_repeat('  ', $level)."method call : ".$method.": \n";
        $this->display($method, $level + 1);
    }

    function display_method_static($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $method = $node->getMethod();
        print str_repeat('  ', $level).$node->getClass()."::".$method.": \n";
        $this->display($method, $level + 1);
    }

    function display__new($node, $level) {
         print str_repeat('  ', $level).' new '.$node->getClass()." ".$node->getArgs()." \n";
    }

    function display__namespace($node, $level) {
        print str_repeat('  ', $level).'namespace '.$node->getNamespace()."\n";
    }
    
    function display__nsname($node, $level) {
        print str_repeat('  ', $level).' NSName '.join('\\', $node->getNamespace())."\n";
    }
    
    function display_noscream($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." @\n";
        $this->display($node->getExpression(), $level + 1);
    }

    function display_opappend($node, $level) {
        print str_repeat('  ', $level).$node->getVariable()."[]\n";
         $this->display($node->getVariable(), $level + 1);
    }

    function display_operation($node, $level) {
         print str_repeat('  ', $level).$node->getTname()." \n";
         print str_repeat('  ', $level)."left : \n";
         $this->display($node->getLeft(), $level + 1);
         print str_repeat('  ', $level)."operation : ".$node->getOperation()."\n";
         print str_repeat('  ', $level)."right : \n";
         $this->display($node->getRight(), $level + 1);
    }

    function display_parenthesis($node, $level) {
         print str_repeat('  ', $level).$node->getTname()." \n";
         print str_repeat('  ', $level)."( \"".$node->getContenu()."\" )\n";    
    }

    function display_preplusplus($node, $level) {
         print str_repeat('  ', $level).$node->getOperator().$node->getVariable()." \n";
         $this->display($node->getVariable(), $level + 1);
    }

    function display_postplusplus($node, $level) {
         print str_repeat('  ', $level).$node->getVariable().$node->getOperator()." \n";
         $this->display($node->getVariable(), $level + 1);
    }

    function display_property($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." ".$node->getObject()."".$node->getProperty()."->\n";
    }

    function display_property_static($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." ".$node->getClass()."::".$node->getProperty()."->\n";
    }

    function display_rawtext($node, $level) {
         print str_repeat('  ', $level).$node->getTname()." \n";
         print str_repeat('  ', $level)."Texte : \"".$node->getText()."\"\n";    
    }

    function display_reference($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." &\n";
        $this->display($node->getExpression(), $level + 1);
    }

    function display__return($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        print str_repeat('  ', $level)."return : \"".$node->getReturn()."\"\n";    
    }

    function display_sequence($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $elements = $node->getElements();
        foreach($elements as $id => $e) {
            print str_repeat('  ', $level)."$id : \n";
            $this->display($e, $level + 1);
        }
    }

    function display_shell($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $elements = $node->getExpression();
        foreach($elements as $id => $e) {
            print str_repeat('  ', $level)."$id : \n";
            $this->display($e, $level + 1);
        }
    }

    function display_sign($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." ".$node->getsign().$node->getExpression()."\n";
        $this->display($node->getExpression(), $level + 1);
    }

    function display__static($node, $level) {
         print str_repeat('  ', $level).$node->getTname()." \n";
         $this->display($node->getExpression(), $level + 1);
    }

    function display__switch($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $this->display($node->getCondition(), $level + 1);
        $this->display($node->getBlock(), $level + 1);
    }

    function display__use($node, $level) {
        $return = str_repeat('  ', $level).'use '.$node->getNamespace();
        
        $alias = $node->getAlias();
        if (!is_null($alias)) {
            $return .= " as ".$alias;
        }
        
        print $return."\n";
    }

    function display__throw($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $this->display($node->getException(), $level + 1);
    }

    function display_processedToken($node, $level) {
        print $node->getTname();
    
        print str_repeat('  ', $level).$node->getCode()." \n";
    }

    function display_typehint($node, $level) {
        print str_repeat('  ', $level).$node->getTname()."\n";
        $this->display($node->getType(), $level + 1);
        $this->display($node->getName(), $level + 1);
    }

    function display__try($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $this->display($node->getBlock(), $level + 1);
        $elements = $node->getCatch();
        foreach($elements as $id => $e) {
            print str_repeat('  ', $level)."$id : \n";
            $this->display($e, $level + 1);
        }
    }

    function display__var($node, $level) {
        print str_repeat('  ', $level)." ".$node->getVisibility().$node->getStatic();
        
        $vars = $node->getVariable();
        $inits = $node->getInit();
        $r = array();
        foreach($vars as $id => $var) {
            if (isset($inits[$id])) {
                $r[] = "$var = {$inits[$id]}";
            } else {
                $r[] = "$var";
            }
        }
        
        print join(', ', $r)."\n";
    }

    function display_variable($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." ".$node->getName()."\n";
    }

    function display__while($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $this->display($node->getCondition(), $level + 1);
        $this->display($node->getBlock(), $level + 1);
    }

    function display__dowhile($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." \n";
        $this->display($node->getBlock(), $level + 1);
        $this->display($node->getCondition(), $level + 1);
    }
    
    function display_Token($node, $level) {
        print str_repeat('  ', $level).$node->getTname()." ".$node->getCode()." (default display)\n";
    }

}

?>