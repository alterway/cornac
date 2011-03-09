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

class Cornac_Tokenizeur_Token {
    protected $next = null;
    protected $prev = null;
    
    static public $root = null;

    protected $token = null;
    protected $code = null;
    protected $line = -1;
    protected $id = null;

    protected $tname = 'Token';

    static private $test_id = null;

// configuration @_
    public $structures = null;

    const ANY_TOKEN = 0;
    
    public function __construct() {

    }

    public function getTname() {
        return $this->tname;
    }

    function __call($method, $args) {
        if (substr($method, 0, 3) == 'get') {
            $membre = strtolower(substr($method, 3));
            if (isset($this->$membre)) {
                return $this->$membre;
            }
        }
        print_r(xdebug_get_function_stack());        
        die("$method is unknown method!\n");
    }
     
    function setId($id) {
        $this->id = $id;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setLine($line) {
        $this->line = $line;
    }

    function setToken($token) {
        $this->token = $token;
    }
    
    function getId() {
        return $this->id;
    }

    function getCode() {
        return $this->code;
    }

    function getLine() {
        if (isset($this->line)) {
            return $this->line;
        } else {
            return "NULL";
        
        }
    }

    function getToken() {
        return $this->token;
    }

    function copyToken($t) {
        $this->setId($t->getId());
        $this->setToken($t->getToken());
        $this->setCode($t->getCode());
        $this->setLine($t->getLine());
    }

    function append(Cornac_Tokenizeur_Token $t) {
        $this->next = $t;
        $t->setPrev($this);
    }

    function prepend(Cornac_Tokenizeur_Token $t) {
        $this->prev = $t;
        $t->setNext($this);
    }

    function insert(Cornac_Tokenizeur_Token $t, $type = "after") {
        if ($type == "before") {
            $prev = $this->prev; 

            $prev->setNext($t);
            $t->setNext($this);
            
            $this->prev = $t;
            $t->setPrev($prev);
        } elseif ($type == "after") {
            $next = $this->next; 
            
            $this->setNext($t);
            $t->setNext($next);

            if (!is_null($next)) {
               $next->setPrev($t);
            }
            $t->setPrev($this);
            
            $this->next = $t;
            $t->setNext($next);
        } else {
            die("Can't insert this type : $type. Must be 'after' or 'before'");
        } 
    }

    function replace(Cornac_Tokenizeur_Token $t) {
        $next = $t->getNext();
        $prev = $t->getPrev();

        $this->setNext( $next);
        $this->setPrev( $prev);

        if (!is_null($next)) {
            $next->setPrev($this);
        }
        if (!is_null($prev)) {
            $prev->setNext($this);
        }
    }

    function removeNext() {
        if (is_null($this->next)) {
            return ;
        }
        if (is_null($this->getNext(1))) {
            $this->setNext(null);
        } else {
            $this->getNext(1)->setPrev($this);
            $this->setNext($this->getNext(1));
        }
    }

    function removePrev() {
        if (is_null($this->prev)) {
            return ;
        }
        if (is_null($this->getPrev(1))) {
            $this->setPrev(null);
        } else {
            $this->getPrev(1)->setNext($this);
            $this->setPrev($this->getPrev(1));
        }
    }

    function removeCurrent() {
        $next = $this->next;
        $prev = $this->prev;
        
        if (is_null($next)) {
            // @empty_ifelse
        } else {
            $next->setPrev($prev);
        }

        if (is_null($prev)) {
            // @empty_ifelse
        } else {
            $prev->setNext($next);
        }
        
        $this->next = null;
        $this->prev = null;
    }
    
    function detach() {
        $this->prev = null;
        $this->next = null;
    }
    
    function setPrev($t) {
        $this->prev = $t;
    }

    function setNext($t) {
        $this->next = $t;
    }

    function getPrev($n = 0) {
        $n++;
        $return = $this;
        while($n > 0) {
            $return = $return->prev;
            if (is_null($return)) { return NULL; }
            $n--;
        }
        
        return $return;
    }

    function hasNext($n = 0) {
        $n++;
        $return = $this;
        while($n > 0) {
            $return = $return->next;
            if (is_null($return)) { return false; }
            $n--;
        }
        
        return true;
    }

    function hasPrev($n = 0) {
        $n++;
        $return = $this;
        while($n > 0) {
            $return = $return->prev;
            if (is_null($return)) { return false; }
            $n--;
        }
        
        return true;
    }

    function getNext($n = 0) {
        if ($n == 0) { return $this->next; }
        // @note no test. This seems to work, as HasNext is always used. Maybe we can remove hasnext usage, and put it here?
        if ($n == 1) { return $this->next->next; }

        $n++;
        $return = $this;
        while($n > 0) {
            $return = $return->next;
            if (is_null($return)) { return NULL; }
            $n--;
        }
        
        return $return;
    }
    
    function __toString() {
        return $this->token.' "'.$this->code.'"';
    }

    static public function factory(Cornac_Tokenizeur_Token $t, $class = 'Token') {
        $regex = $class::getRegex(); 
        
        foreach($regex as $r) {
            $r = new $r;
            
            if (!$r->check($t)) {
                unset($r);
                continue;
            }
        
            $return = Cornac_Tokenizeur_Token::applyRegex($t, $class, $r);
            Cornac_Log::getInstance('tokenizer')->log($t->getTname()." => ".get_class($return));
            return $return; 
        }
        return $t;
    }

    function makeProcessed($class, $token) {
        $clone = clone $token;
        
        if (!in_array($class, array('_extends_',
                                    '_implements_',
                                    '_classname_',
                                    '_interfacename_',
                                    '_abstract_',
                                    '_final_',
                                    '_static_',
                                    '_continue_',
                                    '_break_',
                                    '_catch_',
                                    '_ppp_',
                                    '_nsseparator_',
                                    '_typehint_',
                                    '_sign_',
                                    '_postplusplus_',
                                    '_preplusplus_',
                                    '_operation_',
                                    '_label_',
                                    '_comparison_',
                                    '_cast_',
                                    '_logical_',
                                    '_goto',
                                    '_nsname_',
                                    '_usednsname_',
                                    '_reference_',
                                    '_bitshift_',
                                    '_affectation_',
                                    '_functionname_',
                                    '_foreacharray_',
                                    '_goto_',
                                    ))) { 
            print "Attempt to process a token to an unknown class : $class!\n";
            die(__METHOD__);
        }

        $class = 'Cornac_Tokenizeur_Token_Processed_'. ucfirst(strtolower(substr($class, 1, -1)));
        $return = new $class($clone);
        $return->replace($clone);
        $return->setToken($token->getToken());
        $return->setLine($token->getLine());
        
        return $return;
    }

    static function applyRegex($t, $class, $r) { 
        $args = $r->getArgs();
        
        foreach($args as $id => $arg) {
            if ($arg > 0) {
                $args[$id] = $t->getNext($arg - 1);
            } elseif ($arg < 0) {
                $args[$id] = $t->getPrev(abs($arg + 1));
            } else {        
                $args[$id] = $t;
            }
        }
        
        if (!class_exists($class)) {
            $class = 'Cornac_Tokenizeur_Token_'.ucfirst(strtolower($class));
        }

        if (empty($args)) {
            $return = new $class();
        } else {
            $return = new $class($args);
        }
        $return->copyToken($t);

        $remove = $r->getRemove();
        foreach($remove as $arg) {
            if ($arg > 0) {
                $t->removeNext();
            } elseif ($arg < 0) {
                $t->removePrev();
            } else {
                // @empty_ifelse this is an error. Should be trapped
            }
        }

        $return->replace($t);
        $return->setToken(0);
        $return->neutralise();
        
        unset($r);
        
        return $return;
    }
    
    // @note must be redefined by each class. 
    function neutralise() {
        print get_class($this)." didn't overload ".__METHOD__."\n";
    }

    function display($d = 0 , $f = 0) {
        for($i = $d; $i < $f; $i++) {
            if ($i < 0) {
                print "$i) ".$this->getPrev(abs($i))."\n";
            } elseif ($i > 0) {
                print "$i) ".$this->getNext(abs($i))."\n";
            } else {
                print "$i-) ".$this->getPrev()."\n";
                print "0) ".$this."\n";
                print "$i+) ".$this->getNext()."\n";
            }
        }
        print "\n";
    }

    public function checkCode($code) {
        if (!is_array($code)) {
            $code = array($code);
        }
        return in_array($this->getCode(), $code);
    }

    public function checkNotCode($code) {
        return !$this->checkCode($code);
    }

    public function checkIsOperator() {
        if ($this->token != 0) { return false; }
        return false;
    }

    public function checkOperator($code) {
        if (!$this->checkClass('Token')) { return false; }
        if (!in_array($this->getToken(), array(0, 
                                               T_OBJECT_OPERATOR, 
                                               T_CONCAT_EQUAL,
                                               T_SL_EQUAL,
                                               T_SR_EQUAL,
                                               T_SL,
                                               T_SR,
                                               T_OR_EQUAL, 
                                               T_AND_EQUAL, 
                                               T_XOR_EQUAL, 
                                               T_PLUS_EQUAL, 
                                               T_MINUS_EQUAL, 
                                               T_MOD_EQUAL, 
                                               T_MUL_EQUAL, 
                                               T_DIV_EQUAL, 
                                               T_CURLY_OPEN,
                                               T_DEC,
                                               T_INC,
                                               T_DOUBLE_COLON,
                                               T_NS_SEPARATOR,
                                               ))) { return false; }

        if (is_array($code)) {
            return in_array($this->getCode(), $code);
        } else {
            return $this->getCode() == $code;
        }
    }

    public function checkNotOperator($code) {
        return !$this->checkOperator($code);
    }

    public function checkToken($token) {
        if (!is_array($token)) {
            $token = array($token);
        }
        return in_array($this->getToken(), $token);
    }

    public function checkNotToken($token) {
        return !$this->checkToken($token);
    }
    
    public function checkClass($classes) {
        if (!isset($this->tname)) {
            print get_class($this)." has no tname\n";
            die();
        }

        if (!is_array($classes)) {
            return $this->tname == $classes;
        } else {
            return in_array($this->tname, $classes);
        }
    }

    public function checkNotClass($classes) {
        return !$this->checkClass($classes);
    }

    public function checkSubclass($classes) {
        // @note classes must be an array
        $classes = 'Cornac_Tokenizeur_Token_'.ucfirst(strtolower($classes));
        return is_subclass_of($this, $classes);
    }

    public function checkNotSubclass($classes) {
        return !$this->checkSubclass($classes);
    }

    public function checkFunction() {
        if ($this->checkClass('_nsname')) {
        // @note name with namespace
            return true; 
        } else {
            return in_array($this->token,array(T_STRING, 
                                               T_ARRAY, 
                                               T_ISSET, 
                                               T_PRINT, 
                                               T_ECHO, 
                                               T_EXIT, 
                                               T_EMPTY, 
                                               T_LIST, 
                                               T_UNSET,
                                               T_EVAL,
                                               T_STATIC));
        }
    }

    public function checkNotFunction() {
        return !$this->checkFunction();
    }
    
    public function checkBeginInstruction() {
        if (in_array($this->code, array('(','{','[',',','?',':','.','==','+=','-=',
                                        '.=', '=','.=','*=','+=','-=','/=','%=','>>=',
                                        '&=','^=','>>>=', '|=','<<=','>>=','/','*','%',
                                        '>','<','<=','>=',';','=>','&&','||' ))) {
            return true;
        }
        if (in_array($this->token, array(T_OPEN_TAG,            T_IS_EQUAL, 
                                         T_ECHO,                T_PRINT,
                                         T_IS_SMALLER_OR_EQUAL, T_IS_NOT_IDENTICAL,
                                         T_IS_NOT_EQUAL,        T_IS_IDENTICAL, 
                                         T_IS_GREATER_OR_EQUAL, T_CASE, 
                                         T_RETURN, T_EXIT, T_INT_CAST, T_DOUBLE_CAST, 
                                         T_STRING_CAST, T_ARRAY_CAST, T_BOOL_CAST,
                                         T_OBJECT_CAST, T_UNSET_CAST, T_ELSE))) {
            return true;
        }
        if ($this->checkClass(array('rawtext','sequence','ifthen',
                                    'functioncall','affectation',
                                    'parenthesis','block','sequence',
                                    '_global','_use','_static'))) {
            return true;
        }
        return false;
    }

    public function checkEndInstruction() {
        if (in_array($this->code, array(',',')',';',']',':','?',',','}','/','*','%'))) {
            return true;
        }
        if (in_array($this->token, array(T_CLOSE_TAG, T_ENDIF, T_ENDFOREACH, T_ENDFOR, T_ELSE))) {
            return true;
        }
        if ($this->checkSubclass("instruction")) {
            return true;
        }
        return false;
    }

    public function checkNotEndInstruction() {
        return !$this->checkEndInstruction(); 
    }

    public function checkGenericCase() {
        if (in_array($this->token, array(T_CASE,T_DEFAULT))) {
            return true;
        }
        if ($this->checkClass('_case')) {
            return true;
        }
        return false;
    }

    function checkForBlock($and_block = false) {
        $list  = array('sequence',
                       'operation',
                       'rawtext',
                       'affectation',
                       'ifthen',
                       'preplusplus',
                       'postplusplus',
                       '_for',
                       '_foreach',
                       '_break',
                       '_continue',
                       '_return',
                       '_function',
                       'functioncall',
                       '_switch',
                       '_try',
                       '_throw',
                       '_var',
                       'noscream',
                       '_constant',
                       'constant_class',
                       '_while',
                       '_global',
                       '_use',
                       '_dowhile',
                       'logical',
                       'method',
                       'method_static',
                       'literals',
                       'inclusion',
                       '_class',
                       '_goto',
                       'label',
                       '_interface',
                       'property',
                       '_static',
                       'ternaryop',
                       '_clone',
                       '_declare',
// @dont Don't put variable in this list    'variable',
                                       );
        if ($and_block) {
            $list[] = 'block';
        }
        
        if ($this->checkNotClass($list)) {
            return false;
        }
        
        if (!$this->hasNext()) { return true; }
        
        return $this->getNext()->checkNotOperator(array('->','[','(','::'));
    }

    function checkForComparison() {
        $liste = array('==','>','<','<=','>=','===','!==','<=>','!=');
        return $this->checkCode($liste);
    }

    function checkForAssignation() {
        if ($this->checkNotClass('Token')) { return false; }
        $liste = array('=','.=','*=','+=','-=','/=','%=','>>=','&=','^=', '|=','<<=');
        return $this->checkOperator($liste);
    }

    function checkForLogical() {
        if ($this->checkNotClass('Token')) { return false; }
        $liste = array(T_LOGICAL_OR, T_LOGICAL_AND, T_LOGICAL_XOR, T_BOOLEAN_AND, T_BOOLEAN_OR, T_INSTANCEOF);
        if ($this->checkToken($liste)) { 
            return true;
        }
        
        if ($this->checkOperator(array('&','|','^'))) {
            return true;
        }
        
        return false;
    }

    function checkForVariable() {
        $liste = array('variable','_array','property');
        return $this->checkClass($liste);
    }

    function checkForCast() {
        $liste = array(T_INT_CAST, 
                       T_DOUBLE_CAST, 
                       T_STRING_CAST,
                       T_ARRAY_CAST,
                       T_BOOL_CAST,
                       T_OBJECT_CAST,
                       T_UNSET_CAST);
        return $this->checkToken($liste);
    }

    function stopOnError($message) {
        $bt = debug_backtrace();
        print "Message : $message\n";
        print_r($bt[0]);
        die();
    }
}

function display_entree($entree) {
        foreach($entree as $id => $e) {
            print "$id) $e\n";
        }
        print "------\n";
}

?>