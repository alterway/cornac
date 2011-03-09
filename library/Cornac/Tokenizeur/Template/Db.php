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

class Cornac_Tokenizeur_Template_Db extends Cornac_Tokenizeur_Template {
    protected $line = 0;
    protected $scope = 'global';
    protected $class = '';
    
    protected $tags = array();
    
    function __construct($root, $fichier = null) {
        parent::__construct();
    }
    
    function save($filename = null) {
        print "Saved in database\n";
    }
    
    function display($node = null, $level = 0) {
    // @question why not move all this into a first template that would check, so we can avoid those tests/die here? 
        if ($level > 200) {
            print_r(xdebug_get_function_stack());        
            print "Attention : over 200 levels of recursion. Aborting.\n"; 
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
            print_r(xdebug_get_function_stack());        
            print "Attention, node $node is not an (".gettype($node).")\n";
            die(__METHOD__."\n");
        }

        $class = $node->getTname();
        if (substr($class, -1) == '_') {
            $method = "display_processedToken";
        } else {
            $method = "display_$class";
        }
        
        if (method_exists($this, $method)) {
            $return = $this->$method($node, $level);
        } else {
            print "Displaying ".__CLASS__." for missing method '".$method."'. Aborting\n";
            die(__METHOD__."\n");
        }
        if (!is_null($node->getNext())){
            $this->display($node->getNext(), $level);
        }

        return $return;
    }
    
////////////////////////////////////////////////////////////////////////
// @section database functions
////////////////////////////////////////////////////////////////////////

    private static $ids = 0;
    
    function getNextId() {
        return $this->ids++;
    }

    private static $intervallaire = 0;
    
    function getIntervalleId() {
        return $this->intervallaire++;
    }

    function savenode($node, $level) {
        global $file;
        
        if (($node->getline() + 0) > 0) {
            $this->line = $node->getline() + 0;
        } 
        
        $requete = "INSERT INTO <tokens_tmp> VALUES 
            (NULL ,
             '".$node->myleft."',
             '".$node->myright."',
             '".$node->getTname()."',
             ".$this->database->quote($node->getCode()).",
             '$file',
             ". $node->getLine() .",
             '". $this->scope ."',
             '". $this->class ."',
             '". $level ."'
             )";

        $this->database->query($requete);
        if ($this->database->errorCode() != 0) {
            print $requete."\n";
            print_r($this->database->errorInfo());
            die(__METHOD__."\n");
        }
        
        $return = $this->database->lastinsertid();
        
        if (is_array($this->tags) && count($this->tags) > 0) {
            foreach($this->tags as $label => $tokens) {
                foreach($tokens as $token) {
                    $requete = "INSERT INTO <tokens_tags_tmp> VALUES 
                    ($return ,
                     '".$token."',
                     '".$label."')";
    
                    $this->database->query($requete);
                    if ($this->database->errorCode() != 0) {
                        print $requete."\n";
                        print_r($this->database->errorInfo());
                        die(__METHOD__."\n");
                    }
                }
            }
        }
        
        $this->tags = array();
        $node->database_id = $return;
        
        return $return;
    }

////////////////////////////////////////////////////////////////////////
// @section database functions
////////////////////////////////////////////////////////////////////////
    function display_processedToken($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_affectation($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $tags = array();
        $tags['left'][] = $this->display($node->getLeft(), $level + 1);
        $tags['operator'][] = $this->display($node->getOperator(), $level + 1);
        $tags['right'][] = $this->display($node->getRight(), $level + 1);

        $node->myright = $this->getIntervalleId();
        $this->tags = $tags;
        return $this->savenode($node, $level);
    }

    function display_arginit($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');
        
        $this->display($node->getVariable(), $level + 1);
        $this->display($node->getValue(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_arglist($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $elements = $node->getList();
        if (count($elements) == 0) {
            $processedToken = new Cornac_Tokenizeur_Token_Processed_Empty(new Cornac_Tokenizeur_Token());
            $this->display($processedToken, $level + 1);
            // @note create an empty token, to materialize the empty list
        } else {
            foreach($elements as $id => &$e) {
                if (!is_null($e)) {
                    $this->display($e, $level + 1);
                }
            }
        }

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_block($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        if ($node->checkCode('{')) {
            $node->setCode('');
        }

        $elements = $node->getList();
        foreach($elements as $id => &$e) {
            $this->display($e, $level + 1);
        }
        $node->myright = $this->getIntervalleId();
        $return = $this->savenode($node, $level);
        return $return;
    }

    function display__break($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $this->display($node->getLevels(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__case($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        if (!is_null($m = $node->getCondition())) {
            $this->display($m, $level + 1);
        }
        $this->display($node->getBlock(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_cast($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $this->display($node->getExpression(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__catch($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $this->display($node->getException(), $level + 1);
        $this->display($node->getVariable(), $level + 1);
        $this->display($node->getBlock(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__continue($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $this->display($node->getLevels(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }
    
    function display_ternaryop($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $this->display($node->getCondition(), $level + 1);
        $this->display($node->getThen(), $level + 1);
        $this->display($node->getElse(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_codephp($node, $level) {
        if (!isset($node->dotId)) {
            $node->dotId = $this->getNextId();
        }
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $this->display($node->getphp_code(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__class($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');
        $previous_class = $this->class;
        $this->class = $node->getName()->getCode();

        $tags = array();
        $abstract = $node->getAbstract();
        if(!is_null($abstract)) {
            $tags['abstract'][] = $this->display($abstract, $level + 1);            
        }

        $tags['name'][] = $this->display($node->getName(), $level + 1);            

        $extends = $node->getExtends();
        if (!is_null($extends)) {
            $tags['extends'][] = $this->display($extends, $level + 1);            
        }

        $implements = $node->getImplements();
        if (count($implements) > 0) {
            foreach($implements as $implement) {
                $tags['implements'][] =  $this->display($implement, $level + 1);            
            }
        }

        $tags['block'][] = $this->display($node->getBlock(), $level + 1);            

        $node->myright = $this->getIntervalleId();
        $this->tags = $tags;
        $res = $this->savenode($node, $level);
        $this->class = $previous_class;
        return $res;
    }

    function display__clone($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $this->display($node->getExpression(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__closure($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $tags = array();
        $tags['args'][] = $this->display($node->getArgs(), $level + 1);
        $tags['block'][] = $this->display($node->getBlock(), $level + 1);

        $this->tags = $tags;
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_keyvalue($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $this->display($node->getKey(), $level + 1);
        $this->display($node->getValue(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_comparison($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode($node->getOperator()->getCode());

        $tags = array();
        $tags['right'][] = $this->display($node->getLeft(), $level + 1);
        $tags['operator'][] = $this->display($node->getOperator(), $level + 1);
        $tags['left'][] = $this->display($node->getRight(), $level + 1);
        $this->tags = $tags;
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_concatenation($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $elements = $node->getList();
        $labels = array();

        foreach($elements as $id => &$e) {
            $this->display($e, $level + 1);            
        }

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__constant($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_constant_static($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $class = $node->getClass();
        $this->display($class, $level + 1);
        $method = $node->getConstant();
        $this->display($method, $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_constant_class($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $class = $node->getName();
        $this->display($class, $level + 1);
        $constant = $node->getConstant();
        $this->display($constant, $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

   function display_bitshift($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $this->display($node->getLeft(), $level + 1);
        $this->display($node->getOperator(), $level + 1);
        $this->display($node->getRight(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__declare($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $tags = array();

        $ticks = $node->getTicks();
        if (!is_null($ticks)) {
            $tags['ticks'][] = $this->display($ticks, $level + 1);
        }
        $encoding = $node->getEncoding();
        if (!is_null($encoding)) {
            $tags['encoding'][] = $this->display($encoding, $level + 1);
        }
        $n = $node->getBlock();
        if (!is_null($n)) {
            $tags['block'][] = $this->display($n, $level + 1);
        }
        $this->tags = $tags;

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }
    
    function display__default($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $this->display($node->getBlock(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__empty_($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('[empty]');

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__for($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $tags = array();

        if (!is_null($f = $node->getInit())) {
            $tags['init'][] = $this->display($f, $level + 1);
        }
        if (!is_null($f = $node->getEnd())) {
            $tags['end'][] = $this->display($f, $level + 1);
        }
        if (!is_null($f = $node->getIncrement())) {
            $tags['increment'][] = $this->display($f, $level + 1);
        }
        $tags['block'][] = $this->display($node->getBlock(), $level + 1);
        $this->tags = $tags;

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__foreach($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $tags = array();
        $tags['array'][] = $this->display($node->getArray(), $level + 1);

        $key = $node->getKey();
        if (!is_null($key)) {
           $tags['key'][] = $this->display($key, $level + 1);
        }
        $tags['value'][] = $this->display($node->getValue(), $level + 1);
        $tags['block'][] = $this->display($node->getBlock(), $level + 1);

        $node->myright = $this->getIntervalleId();
        $this->tags = $tags;
        return $this->savenode($node, $level);
    }

    function display__function($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $previous_class = $this->scope;
        $this->scope = $node->getName()->getCode();

        $tags = array();
        if (!is_null($m = $node->getVisibility())) {
            $tags['visibility'][] = $this->display($m, $level + 1);
        }
        if (!is_null($m = $node->getAbstract())) {
            $tags['abstract'][] = $this->display($m, $level + 1);
        }
        if (!is_null($m = $node->getStatic())) {
            $tags['static'][] = $this->display($m, $level + 1);
        }
        $tags['name'][] = $this->display($node->getName(), $level + 1);
        // @note reading function name
        $node->setCode($node->getName()->getCode());
        $tags['args'][] = $this->display($node->getArgs(), $level + 1);
        $tags['block'][] = $this->display($node->getBlock(), $level + 1);

        $node->myright = $this->getIntervalleId();

        $this->tags = $tags;
        $res = $this->savenode($node, $level);
        $this->scope = $previous_class;
        return $res;
    }

    function display_functioncall($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $tags = array();
        $tags['function'][] = $this->display($node->getFunction(), $level + 1);
        $node->setCode($node->getFunction()->getCode());
        $tags['args'][] = $this->display($node->getArgs(), $level + 1);

        $node->myright = $this->getIntervalleId();
        $this->tags = $tags;
        return $this->savenode($node, $level);
    }

    function display__global($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        $elements = $node->getVariables();
        foreach($elements as $id => $e) {
            $this->display($e, $level + 1);
        }

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);    
    }

    function display__goto($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        $label = $node->getLabel();
        $this->display($label, $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);    
    }

    function display_ifthen($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $conditions = $node->getCondition();
        $thens = $node->getThen();
        $labels = array();

        $tags = array();
        
        foreach($conditions as $id => &$condition) {
            $condition->setCode('elseif');
            $tags['condition'][] = $this->display($condition, $level + 1);
            $tags['then'][] = $this->display($thens[$id], $level + 1);
        }
        
        $else = $node->getElse();
        if (!is_null($else)){
            $else->setCode('else');
            $tags['else'][] = $this->display($else, $level + 1);
        }

        $node->myright = $this->getIntervalleId();
        $this->tags = $tags;
        return $this->savenode($node, $level);
    }

    function display_inclusion($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $this->display($node->getInclusion(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);        
    }

    function display__interface($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $previous_class = $this->class;
        $this->class = $node->getName()->getCode();

        $e = $node->getExtends();
        if (count($e) > 0) {
            foreach($e as $ex) {
                $this->display($ex, $level + 1);
            }
        }
        $this->display($node->getBlock(), $level + 1);

        $node->myright = $this->getIntervalleId();
        $res = $this->savenode($node, $level);
        $this->class = $previous_class;
        return $res;
    }

    function display_invert($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        $this->display($node->getExpression(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);        
    }

    function display_label($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        $this->display($node->getName(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_literals($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);        
    }

    function display_logical($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $tags = array();
        $tags['right'][] = $this->display($node->getLeft(), $level + 1);
        $tags['operator'][] = $this->display($node->getOperator(), $level + 1);
        $tags['left'][] = $this->display($node->getRight(), $level + 1);
        $this->tags = $tags;
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);        
    }

    function display_method($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $tags = array();
        $tags['object'][] = $this->display($node->getObject(), $level + 1);
        $tags['method'][] = $this->display($node->getMethod(), $level + 1);        
        
        $node->myright = $this->getIntervalleId();
        $this->tags = $tags;
        return $this->savenode($node, $level);        
    }

    function display_method_static($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $tags = array();
        $tags['class'][] = $this->display($node->getClass(), $level + 1);
        $tags['method'][] = $this->display($node->getMethod(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        $this->tags = $tags;
        return $this->savenode($node, $level);        
    }

    function display__new($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $tags = array();
        $tags['name'][] = $this->display($node->getClass(), $level + 1);
        $tags['args'][] = $this->display($node->getArgs(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        $this->tags = $tags;
        return $this->savenode($node, $level);        
    }

    function display__namespace($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $tags = array();
        $tags['name'][] = $this->display($node->getNamespace(), $level + 1);
        $node->setCode($node->getNamespace()->getCode());
        
        $node->myright = $this->getIntervalleId();
        $this->tags = $tags;
        return $this->savenode($node, $level);        
    }
    
    function display__nsname($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);        
    }

    function display_noscream($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $this->display($node->getExpression(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);        
    }

    function display_not($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        $this->display($node->getExpression(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);        
    }

    function display_opappend($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        $this->display($node->getVariable(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);        
    }

    function display_operation($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        $this->display($node->getLeft(), $level + 1);
        $this->display($node->getOperation(), $level + 1);
        $this->display($node->getRight(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);        
    }

    function display_parenthesis($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        $this->display($node->getContenu(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);        
    }

    function display_preplusplus($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        $this->display($node->getVariable(), $level + 1);
        $this->display($node->getOperator(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);    
    }

    function display_postplusplus($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        $this->display($node->getVariable(), $level + 1);
        $this->display($node->getOperator(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);    
    }

    function display_property($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        $tags = array();
        $tags['object'][] = $this->display($node->getObject(), $level + 1);
        $tags['property'][] = $this->display($node->getProperty(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        $this->tags = $tags;
        return $this->savenode($node, $level);        
    }

    function display_property_static($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        $this->display($node->getClass(), $level + 1);
        $this->display($node->getProperty(), $level + 1);
        
        $tags = array();
        $tags['class'][] = $this->display($node->getClass(), $level + 1);
        $tags['property'][] = $this->display($node->getProperty(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        $this->tags = $tags;
        return $this->savenode($node, $level);        
    }

    function display_rawtext($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_reference($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $this->display($node->getExpression(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__return($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        if (!is_null($return = $node->getReturn())) {
            $this->display($return, $level + 1);
        }

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_sequence($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $elements = $node->getElements();
        if (count($elements) == 0) {
            // @empty_else 
        } else {
            $labels = array();
            $id = 0;
            foreach($elements as $id => &$e) {
               $this->display($e, $level + 1);
            }
        }

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_shell($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $elements = $node->getExpression();
        foreach($elements as $id => $e) {
            $this->display($e, $level + 1);
        }

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_sign($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $this->display($node->getSign(), $level + 1);
        $this->display($node->getExpression(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__static($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $this->display($node->getExpression(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__switch($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $this->display($node->getCondition(), $level + 1);
        $this->display($node->getBlock(), $level + 1);
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__use($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $tags = array();
        $tags['name'][] = $this->display($node->getNamespace(), $level + 1);
        $alias = $node->getAlias();
        if (!is_null($alias)) {
            $tags['alias'][] = $this->display($alias, $level + 1);
        }
        
        $node->myright = $this->getIntervalleId();
        $this->tags = $tags;
        return $this->savenode($node, $level);        
    }

    function display__array($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $tags = array();
        $tags['array'][] = $this->display($node->getVariable(), $level + 1);
        $tags['index'][] = $this->display($node->getIndex(), $level + 1);
        $this->tags = $tags;
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__throw($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $this->display($node->getException(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__try($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $this->display($node->getBlock(), $level + 1);

        $elements = $node->getCatch();
        foreach($elements as $id => &$e) {
            $this->display($e, $level + 1);
        }
        
        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_typehint($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');

        $this->display($node->getType(), $level + 1);
        $this->display($node->getName(), $level + 1);

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__var($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        $node->setCode('');
        
        if (!is_null($node->getVisibility())) {
            $this->display($node->getVisibility(), $level + 1);
        }
        if (!is_null($node->getStatic())) {
            $this->display($node->getStatic(), $level + 1);
        }
        $variables = $node->getVariable();
        if (count($variables) > 0) {
            $inits = $node->getInit();
            foreach($variables as $id => $variable) {
                $node->setCode($variable->getCode());
                $this->display($variable, $level + 1);
                if (!is_null($inits[$id])) {
                    $this->display($inits[$id], $level + 1);
                }
            }
        
        }

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display_variable($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();
        
        $name = $node->getName();
        if (is_object($name)) {
            $this->display($name, $level + 1);
            $node->setCode("$".$name->getCode());
        }

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__while($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $tags = array();
        $tags['condition'][] = $this->display($node->getCondition(), $level + 1);
        $tags['block'][] = $this->display($node->getBlock(), $level + 1);
        $this->tags = $tags;

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }

    function display__dowhile($node, $level) {
        $node->myId = $this->getNextId();
        $node->myleft = $this->getIntervalleId();

        $tags = array();
        $tags['condition'][] = $this->display($node->getCondition(), $level + 1);
        $tags['block'][] = $this->display($node->getBlock(), $level + 1);
        $this->tags = $tags;

        $node->myright = $this->getIntervalleId();
        return $this->savenode($node, $level);
    }
    
    function display_Token($node, $level) {
        print_r(xdebug_get_function_stack());        
        print "Warning : displayed raw Token : '$node'\n";
        die();
    }
}

?>