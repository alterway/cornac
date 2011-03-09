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

require_once 'PHPUnit/Autoload.php'; 

class Framework_AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PHPUnit Framework');
 
        $tests = array( 
        'class.Quality_Indenting.test.php',
        'class.Classes_Abstracts.test.php',
        'class.Classes_Definitions.test.php',
        'class.Classes_DoubleDeclaration.test.php',
        'class.Classes_Finals.test.php',
        'class.Classes_Interfaces.test.php',
        'class.Classes_MethodsCount.test.php',
        'class.Classes_MethodsSpecial.test.php',
        'class.Classes_MethodsWithoutPpp.test.php',
        'class.Classes_News.test.php',
        'class.Classes_Php.test.php',
        'class.Classes_Properties.test.php',
        'class.Classes_PropertiesPublic.test.php',
        'class.Classes_PropertiesUndefined.test.php',
        'class.Classes_PropertiesUnused.test.php',
        'class.Classes_PropertiesUsed.test.php',
        'class.Classes_Statics.test.php',
        'class.Classes_This.test.php',
        'class.Classes_ToStringNoArg.test.php',
        'class.Classes_Undefined.test.php',
        'class.Classes_Unused.test.php',
        'class.Commands_Html.test.php',
        'class.Constants_Definitions.test.php',
        'class.Ext_DieExit.test.php',
        'class.Ext_Dir.test.php',
        'class.Ext_Ereg.test.php',
        'class.Ext_Errors.test.php',
        'class.Ext_Evals.test.php',
        'class.Ext_Execs.test.php',
        'class.Ext_File.test.php',
        'class.Ext_Filter.test.php',
        'class.Ext_Headers.test.php',
        'class.Ext_Image.test.php',
        'class.Ext_Ldap.test.php',
        'class.Ext_Mssql.test.php',
        'class.Ext_Mysql.test.php',
        'class.Ext_Mysqli.test.php',
        'class.Ext_Random.test.php',
        'class.Ext_Session.test.php',
        'class.Ext_Upload.test.php',
        'class.Ext_VarDump.test.php',
        'class.Ext_Xdebug.test.php',
        'class.Ext_Xml.test.php',
        'class.Functions_ArglistCalled.test.php',
        'class.Functions_ArglistDefined.test.php',
        'class.Functions_ArglistDiscrepencies.test.php',
        'class.Functions_ArglistReferences.test.php',
        'class.Functions_ArglistUnused.test.php',
        'class.Functions_ArrayUsage.test.php',
        'class.Functions_CalledBack.test.php',
        'class.Functions_CodeAfterReturn.test.php',
        'class.Functions_DoubleDeclaration.test.php',
        'class.Functions_Emptys.test.php',
        'class.Functions_Handlers.test.php',
        'class.Functions_Inclusions.test.php',
        'class.Functions_Occurrences.test.php',
        'class.Functions_Php.test.php',
        'class.Functions_Recursive.test.php',
        'class.Functions_Security.test.php',
        'class.Functions_Undefined.test.php',
        'class.Functions_Unused.test.php',
        'class.Functions_UnusedReturn.test.php',
        'class.Functions_WithoutReturns.test.php',
        'class.Literals_InArglist.test.php',
        'class.Literals_Long.test.php',
        'class.Literals_RawtextWhitespace.test.php',
        'class.Literals_Reused.test.php',
        'class.Php_Arobases.test.php',
        'class.Php_ArrayDefinitions.test.php',
        'class.Php_ArrayMultiDim.test.php',
        'class.Php_ClassesConflict.test.php',
        'class.Php_ConstantConflict.test.php',
        'class.Php_FunctionsConflict.test.php',
        'class.Php_Globals.test.php',
        'class.Php_InclusionPath.test.php',
        'class.Php_Keywords.test.php',
        'class.Php_Modules.test.php',
        'class.Php_References.test.php',
        'class.Php_RegexStrings.test.php',
        'class.Php_Returns.test.php',
        'class.Php_Throws.test.php',
        'class.Quality_DangerousCombinaisons.test.php',
        'class.Quality_ExternalLibraries.test.php',
        'class.Quality_FilesMultipleDefinition.test.php',
        'class.Quality_GpcConcatenation.test.php',
        'class.Quality_GpcModified.test.php',
        'class.Structures_AffectationLiterals.test.php',
        'class.Structures_AffectationsVariables.test.php',
        'class.Structures_BlockOfCalls.test.php',
        'class.Structures_CaseWithoutBreak.test.php',
        'class.Structures_ComparisonConstants.test.php',
        'class.Structures_FluentInterface.test.php',
        'class.Structures_ForeachKeyValue.test.php',
        'class.Structures_ForeachKeyValueOutside.test.php',
        'class.Structures_ForeachUnused.test.php',
        'class.Structures_Iffectations.test.php',
        'class.Structures_IfWithoutComparison.test.php',
        'class.Structures_LinesLoaded.test.php',
        'class.Structures_LoopsInfinite.test.php',
        'class.Structures_LoopsLong.test.php',
        'class.Structures_LoopsNested.test.php',
        'class.Structures_LoopsOneLiner.test.php',
        'class.Structures_SwitchWithoutDefault.test.php',
        'class.Variables_LongNames.test.php',
        'class.Variables_Names.test.php',
        'class.Variables_OneLetter.test.php',
        'class.Variables_Session.test.php',
        'class.Variables_Unaffected.test.php',
        'class.Variables_Variables.test.php',
        'class.Zf_Action.test.php',
        'class.Zf_Classes.test.php',
        'class.Zf_Controller.test.php',
        'class.Zf_Dependencies.test.php',
        'class.Zf_Redirect.test.php',
        'class.Zf_Session.test.php',
        'class.Zf_SQL.test.php',
        // 'class.Php_InclusionLinks.test.php',  @todo tests with dot format will come later
        'class.Literals_Definitions.test.php',
        'class.Classes_PropertiesChained.test.php',
        'class.Php_Namespace.test.php',
        'class.Structures_IfNested.test.php',
        'class.Quality_GpcAssigned.test.php',
        'class.Quality_ClassesNotInSameFile.test.php',
        'class.Variables_Affected.test.php',
        'class.Quality_StrposEquals.test.php',
        'class.Quality_ConstructNameOfClass.test.php',
        'class.Drupal_Hook7.test.php',
        'class.Drupal_Hook6.test.php',
        'class.Drupal_Hook5.test.php',
        'class.Structures_FluentProperties.test.php',
        'class.Classes_InterfacesUnused.test.php',
        'class.Classes_InterfacesUsed.test.php',
        'class.Variables_AllCaps.test.php',
        'class.Variables_StrangeChars.test.php',
        'class.Classes_Accessors.test.php',
        'class.Constants_Usage.test.php',
        'class.Constants_HasLowerCase.test.php',
        'class.Php_NewByReference.test.php',
        'class.Php_SetlocaleWithString.test.php',
        'class.Php_ObsoleteFunctionsIn53.test.php',
        'class.Commands_Sql.test.php',
        'class.Commands_SqlConcatenation.test.php',
        'class.Functions_NonPhp.test.php',
        'class.Php_FunctionsCalls.test.php',
        'class.Classes_Constants.test.php',
        'class.Quality_GpcAsArgument.test.php',
        'class.Quality_MktimeIsdst.test.php',
        'class.Functions_CallByReference.test.php',
        'class.Classes_MagicMethodWrongVisibility.test.php',
        'class.Php_FuncGetArgOutOfFunctionScope.test.php',
        'class.Quality_IniSetObsolet53.test.php',
        'class.Php_ObsoleteModulesIn53.test.php',
        'class.Php_Clearstatcache.test.php',
        'class.Structures_Constants.test.php',
        'class.Php_ReservedWords53.test.php',
        'class.Php_Phpinfo.test.php',
        'class.Php_Php53NewClasses.test.php',
        'class.Functions_Relay.test.php',
        // new tests
        );
        
        foreach($tests as $i => $test ) {
            $file = trim($test); // @note precaution. I happened to leave some white space 
            if (!file_exists('class/'.$file)) {
                unset($tests[$i]); 
                print "Test file '$test' not available : omitted\n";
                continue;
            }
            require (dirname(__FILE__)."/class/".$file);
            
            $code = file_get_contents(dirname(__FILE__)."/class/".$file);
            if (!preg_match('$class (.*?_Test) $', $code, $r)) {
                print "Couldn't find the test class in file '$file'\n";
                die();
            }
            
            $script = substr($file, 6, -9); 
            if (!file_exists("scripts/$script.php")) {
                print "Couldn't find the script file $script for the test in file '$file'\n";
                die();
            };
        }
         
         foreach($tests as $test) {
             $test = substr($test, 6); // @doc remove class.
             $test = substr($test, 0, -4); // @doc remove .php
             $test = str_replace('.','_', $test); // @doc remove .
             $test = ucwords($test);
             $test = str_replace('_test','_Test', $test);
             
            $suite->addTestSuite($test);
         }
 
        return $suite;
    }
}
?>