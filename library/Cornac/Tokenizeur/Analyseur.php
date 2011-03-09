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

class Cornac_Tokenizeur_Analyseur {
    public $verifs = 0;
    public $rates = array();
    private $structures = array();
    private $any_token = false; 

    function __construct($restrict = array()) {
        // @todo this structure order has an impact on function and speed. This may be interesting to study
        $this->structures = array(
                                  'Cornac_Tokenizeur_Token_Ifthen', //ifthen',
                                  'Cornac_Tokenizeur_Token_Literals', //literals', 
                                  'Cornac_Tokenizeur_Token_Variable', //'variable', 
                                  'Cornac_Tokenizeur_Token_Array', //'_array', 
                                  'Cornac_Tokenizeur_Token_Rawtext', //'rawtext', 
                                  'Cornac_Tokenizeur_Token_Parenthesis', //parenthesis', 
                                  'Cornac_Tokenizeur_Token_Affectation', //affectation', 
                                  'Cornac_Tokenizeur_Token_For', //'_for',
                                  'Cornac_Tokenizeur_Token_Sequence', //'sequence', 
                                  'Cornac_Tokenizeur_Token_Operation', //'operation', 
                                  'Cornac_Tokenizeur_Token_Functioncall', //'functioncall', 
                                  'Cornac_Tokenizeur_Token_Noscream', //'noscream', 
                                  'Cornac_Tokenizeur_Token_Arglist', //'arglist', 
                                  'Cornac_Tokenizeur_Token_Inclusion', //'inclusion', 
                                  'Cornac_Tokenizeur_Token_Codephp', //'codephp',
                                  'Cornac_Tokenizeur_Token_Concatenation', //'concatenation',
                                  'Cornac_Tokenizeur_Token_Ternaryop', //'ternaryop',
                                  'Cornac_Tokenizeur_Token_Block', //block',
                                  'Cornac_Tokenizeur_Token_Not', //'not',
                                  'Cornac_Tokenizeur_Token_Invert', //'invert',
                                  'Cornac_Tokenizeur_Token_Function', //'_function', // @attention : function must be before logical
                                  'Cornac_Tokenizeur_Token_Logical', //'logical',
                                  'Cornac_Tokenizeur_Token_Preplusplus', //preplusplus',
                                  'Cornac_Tokenizeur_Token_Postplusplus', //'postplusplus',
                                  'Cornac_Tokenizeur_Token_Property', //property',
                                  'Cornac_Tokenizeur_Token_Staticproperty', //property_static',
                                  'Cornac_Tokenizeur_Token_Comparison', //'comparison',
                                  'Cornac_Tokenizeur_Token_Method', //method',
                                  'Cornac_Tokenizeur_Token_Staticmethod', //method_static',
                                  'Cornac_Tokenizeur_Token_New', // @removing '_new',
                                  'Cornac_Tokenizeur_Token_Foreach', //'_foreach',
                                  'Cornac_Tokenizeur_Token_While', //'_while',
                                  'Cornac_Tokenizeur_Token_Dowhile', //'_dowhile',
                                  'Cornac_Tokenizeur_Token_Switch',//'_switch',
                                  'Cornac_Tokenizeur_Token_Case',//'_case',
                                  'Cornac_Tokenizeur_Token_Default',//'_default',
                                  'Cornac_Tokenizeur_Token_Keyvalue', //'keyvalue',
                                  'Cornac_Tokenizeur_Token_Break', //'_break',
                                  'Cornac_Tokenizeur_Token_Continue',// '_continue
                                  'Cornac_Tokenizeur_Token_Opappend', //'opappend',
                                  'Cornac_Tokenizeur_Token_Constant',
                                  'Cornac_Tokenizeur_Token_Staticconstant',
                                  'Cornac_Tokenizeur_Token_Classconstant',
                                  'Cornac_Tokenizeur_Token_Global', // '_global'
                                  'Cornac_Tokenizeur_Token_Return', //'_return',
                                  'Cornac_Tokenizeur_Token_Typehint', //'typehint',
                                  'Cornac_Tokenizeur_Token_Class', //'_class',
                                  'Cornac_Tokenizeur_Token_Interface', //'_interface',
                                  'Cornac_Tokenizeur_Token_Var', //'_var',
                                  'Cornac_Tokenizeur_Token_Reference', //'reference',
                                  'Cornac_Tokenizeur_Token_Sign', //'sign',
                                  'Cornac_Tokenizeur_Token_Cast', //'cast',
                                  'Cornac_Tokenizeur_Token_Static', //'_static',
                                  'Cornac_Tokenizeur_Token_Try',//'_try',
                                  'Cornac_Tokenizeur_Token_Catch', //'_catch',
                                  'Cornac_Tokenizeur_Token_Bitshift', //'bitshift',
                                  'Cornac_Tokenizeur_Token_Throw', //'_throw',
                                  'Cornac_Tokenizeur_Token_Clone', //'_clone',
                                  'Cornac_Tokenizeur_Token_Declare', //'_declare',
                                  'Cornac_Tokenizeur_Token_Shell', //'shell',
                                  'Cornac_Tokenizeur_Token_HaltCompiler', // 'haltCompiler'
                                  'Cornac_Tokenizeur_Token_Closure', // '_closure'
                                  'Cornac_Tokenizeur_Token_Goto', //'_goto',
                                  'Cornac_Tokenizeur_Token_Label', //'label',
                                  'Cornac_Tokenizeur_Token_Nsname', //'_nsname',
                                  'Cornac_Tokenizeur_Token_Namespace', //'_namespace',
                                  'Cornac_Tokenizeur_Token_Use', //'_use',
                                  );
        $this->b = array();
        foreach ($this->structures as $id => $structure) {
            if (!method_exists($structure, 'getRegex')) { continue; }
            $regex = $structure::getRegex(); 
            
            foreach($regex as $r) {
                $object = new $r; 
                $tokens = $object->getTokens();
                
                if ($tokens === false) { 
                    $this->regex[0][$r] = $object;
                    print "$r doesn\'t have getToken()\n"; 
                } elseif (count($tokens) > 0) {
                    foreach($tokens as $token) {
                        if (in_array($token, $restrict) || $token === 0 || $token > 450) {
                            $this->regex[$token][$r] = $object;
                        }
                    }
                } else {
                    $this->regex[0][$r] = $object;
                }
                
                $this->tokens[$r] = $structure;
            }
        }
    }
    
    private function analog($message, $duration, $success) {
//        return false;
        // @todo move this to Cornac_log class! 
        if (!isset($this->fp)) {
            $this->fp = fopen("/tmp/analyseur.log","a");
        }
        $duration *= 1000000;
        $this->order++;
        fwrite($this->fp, "$this->order\t$message\t$duration\t".getmypid()."\t$success\n");
    }

    public function setAny_Token($flag) {
        $this->any_token = true;
    }

    public function upgrade(Cornac_Tokenizeur_Token $t) {
        $token = $t->getToken();
        
        // @note we won't process those one. Just skip it. 
        if ($t->checkOperator(array(']','}',')',':',';'))) { return $t; }
        if ($t->checkToken(array(T_ENDDECLARE, 
                                 T_ENDFOR,
                                 T_ENDFOREACH, 
                                 T_ENDIF, 
                                 T_ENDSWITCH, 
                                 T_ENDWHILE, 
                                 T_END_HEREDOC))) { return $t; }

        if ($token > 0 && isset($this->regex[$token])) {
            foreach($this->regex[$token] as $name => $regex) {
                $this->verifs++;
                
                $debut = microtime(true);
                if (!$regex->check($t)) {
                    $fin = microtime(true);
                    $this->analog($name, $fin - $debut, 0);
                    $this->rates[] = $name;
                    continue;
                }
                $fin = microtime(true);
                $this->analog($name, $fin - $debut, 1);
    
                $return = Cornac_Tokenizeur_Analyseur::applyRegex($t, $this->tokens[$name], $regex);
                Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".get_class($return));
                return $return; 
            }
        } // @empty_else
        
        $code = $t->getCode();
        if (isset($this->regex[$code])) {
            foreach($this->regex[$code] as $name => $regex) {
                $this->verifs++;

                $debut = microtime(true);
                if (!$regex->check($t)) {
                    $fin = microtime(true);
                    $this->analog($name, $fin - $debut, 0);
                    $this->rates[] = $name;
                    continue;
                }
                $fin = microtime(true);
                $this->analog($name, $fin - $debut, 1);
                
                $return = Cornac_Tokenizeur_Analyseur::applyRegex($t, $this->tokens[$name], $regex);
                if ($return->getLine() == -1) { 
                    print $t->getLine()."\n"; 
                    print $return."\n"; 
                    die(__METHOD__."\n"); 
                }
                Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".get_class($return));
                return $return; 
            }
        }   // @empty_else
        
        if (!$this->any_token) { return $t; }
        
        foreach($this->regex[0] as $name => $regex) {
            $debut = microtime(true);
            if (!$regex->check($t)) {
                $fin = microtime(true);
                $this->analog($name, $fin - $debut, 0);
                continue;
            }
            $fin = microtime(true);
            $this->analog($name, $fin - $debut, 1);

            $return = Cornac_Tokenizeur_Analyseur::applyRegex($t, $this->tokens[$name], $regex);
            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".get_class($return));
            return $return; 
        }
        return $t;
    }
    
    function applyRegex($token, $class, $regex) { 
        $args = $regex->getArgs();
        
        $argNext = 0;
        $tNext = $token;
        foreach($args as $id => $arg) {
            if ($arg > 0) {
                $args[$id] = $tNext->getNext($arg - $argNext - 1);
                $argNext = $arg;
                $tNext = $args[$id];
            } elseif ($arg < 0) {
                $args[$id] = $token->getPrev(abs($arg + 1));
            } else {        
                $args[$id] = $token;
            }
        }
        
        $return = new $class($args);
        $return->copyToken($token);

        $remove = $regex->getRemove();
        foreach($remove as $arg) {
            if ($arg > 0) {
                $token->removeNext($arg - 1);
            } elseif ($arg < 0) {
                $token->removePrev($arg + 1);
            }   // @empty_else
        }

        $return->replace($token);
        $return->setToken(0);
        $return->neutralise();
        
        $regex->reset();
        
        return $return;
    }
}

?>