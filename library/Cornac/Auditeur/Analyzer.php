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

// @todo : centraliser les rquêtes SQL 
// @todo : mettre en parmètre 
abstract class Cornac_Auditeur_Analyzer {
    protected  $occurrences = 0;
    protected  $files_identifies = 0;
    protected  $total_de_files = 0;
    protected  $ini = array();
    public static    $mid   = null;
    public static    $table = null;
    
    const FORMAT_DEFAULT = 0;
    const FORMAT_HTMLLIST = 1;
    const FORMAT_DOT = 2;
    const FORMAT_SCOPE = 3;
    const FORMAT_ATTRIBUTE = 4;
    
    const WEB_DISPLAY = 'yes';
    const WEB_NOT_DISPLAY = 'no';

    protected  $format = Cornac_Auditeur_Analyzer::FORMAT_HTMLLIST;
    protected  $web = Cornac_Auditeur_Analyzer::WEB_DISPLAY;

    function __construct($database) {
        $this->mid = $database;
        $this->format_export = Cornac_Auditeur_Analyzer::FORMAT_DEFAULT;
        
       $this->name = str_replace('Cornac_Auditeur_Analyzer_', '', get_class($this));
    }
    
    abstract function analyse();

    function getdescription() {
        return $this->description;
    }

    function gettitle() {
        if (isset($this->title)) {
            return $this->title;
        } else {
            return $this->description.' (old way) ';
        }
    }
    
    function getnombre() {
        return $this->occurrences;
    } 
    
    function init_file() {
        setlocale(LC_TIME, "fr_FR");
        $date = strftime("%A %d %B %Y %H:%M:%S ");
        
        $this->export = "<html><body>
        <table>
            <tr><td><a href=\"index.html\">Index</td><td>&nbsp;</td></tr>
            <tr><td>Production</td><td>$date</td></tr>
            <tr><td>Nombre de files</td><td>{$this->total_de_files}</td></tr>
            <tr><td>Nombre de files identifi&eacute;s</td><td>{$this->files_identifies}</td></tr>
            <tr><td>Nombre d'occurrences</td><td>{$this->occurrences}</td></tr>
        </table>
        <p>&nbsp;</p>
        ";
    }

    function finish_file() {
        $this->export .= "
        <table>
            <tr><td><a href=\"index.html\">Index</td><td>&nbsp;</td></tr>
        </table>
        <p>&nbsp;</p>
</body></html>";
    }
    
    function save_file($name) {
        file_put_contents('export/'.$this->getfilename(), $this->export);
    }

    function getfilename() {
        if ($this->format_export == Cornac_Auditeur_Analyzer::FORMAT_DOT) {
            return $this->name.".dot";
        } else {
            return $this->name.".html";
        }
    }

    function sauve() {
        if (!isset($this->name)) {
            print "This class has no name (not even the default name!)\n";
            return false;
        }
        if ($this->name == __CLASS__) { 
            print "This class has no name (the default name!)\n";
            return false;
        }
        
        $now = date('c');
        $this->exec_query("REPLACE INTO <report_module> VALUES ('$this->name', '$now', '{$this->format}', '{$this->web}')");

    }

    function print_query($query) {
        print $this->prepare_query($query)."\n";
        die(__METHOD__);
    }

    function prepare_query($query) {
        $query = $this->mid->setup_query($query);

        // @note removing literals between '', to avoid search collision
        $check = preg_replace("/'[^']+'/is", '', $query);
        if (preg_match_all('/<\w+>/', $check, $r)) {
            print "There are some more tables to process : ".join(', ', $r[0])."\n";
        }
        
        return $query;
    }
    
    function exec_query($query) {
        $query = $this->prepare_query($query);
        
        $res = $this->mid->query($query);
        $erreur = $this->mid->errorInfo();
        
        if ($erreur[2]) {
            print_r($erreur);
            print $query;
            return false;
        }
        
        return $res;
    }

    function exec_init_attributes_column($attribute) {
        $query = "DESC <report_attributes>";
        $res = $this->exec_query($query);
        
        $columns = $res->fetchAll();
        
        foreach($columns as $column) {
            if ($column['Field'] == $attribute) {
            // @doc found! just go
                return true;
            }
        }
        // @doc not found : we need to add this
        $query = "ALTER TABLE <report_attributes> ADD COLUMN $attribute ENUM ('Yes','No') DEFAULT 'No' NOT NULL";
        $this->exec_query($query);
        
        return true;
    }

    function exec_query_attributes($attribute, $query) {
        $query = $this->prepare_query($query);
        
        $tmp = $this->exec_init_tmp_table('report_attributes');

        $this->exec_init_attributes_column($attribute);

        $query = "INSERT INTO $tmp $query";
        $this->exec_query($query);

        $query = "UPDATE <report_attributes> TA, $tmp TMP 
SET TA.$attribute = 'Yes' 
WHERE TA.id = TMP.id";
        $this->exec_query($query);

        $query = "DELETE FROM TMP
USING <report_attributes> TA, $tmp TMP
WHERE TA.id = TMP.id
";
        $this->exec_query($query);

        $query = "INSERT INTO <report_attributes> (id, $attribute)
SELECT id, 'Yes' FROM $tmp TMP";
        $this->exec_query($query);

        $query = "DROP TABLE tmp_report_attributes";
        $this->exec_query($query);

        return true;
    }

    function exec_query_insert($report, $query) {
        $tmp = $this->exec_init_tmp_table($report);
        
        $query = "INSERT INTO tmp_$report $query";
        $this->exec_query($query);

        $this->exec_flush($report);

        return true;
    }
    
    function exec_query_insert_one($report, $query) {
        if (!$this->inited) {
            $this->exec_init_tmp_table($report);
        }

        $query = "INSERT INTO tmp_$report $query";
        $this->exec_query($query);
        
        return true;
    }

    function exec_flush($report) {
        $query = "INSERT INTO <$report> SELECT * FROM tmp_$report";
        $this->exec_query($query);

        $query = "DROP TABLE tmp_$report";
        $this->exec_query($query);

        return true;
    }
    
    function exec_init_tmp_table($report) {
        // @todo support report and report_dot
        if ($report == 'report') {
        // @note be aware that tmp_table need id as NULL column, so auto_increment is managed in the report table
        $this->mid->query('
CREATE TEMPORARY TABLE IF NOT EXISTS tmp_report (
  `id` tinyint(10),
  `file` varchar(500) NOT NULL,
  `element` varchar(10000) NOT NULL,
  `token_id` int(10) unsigned NOT NULL,
  `module` varchar(50) NOT NULL,
  `checked` tinyint(1) NOT NULL,
  KEY `element` (`element`),
  KEY `module` (`module`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1');

            return 'tmp_report';
// @todo handle nicely when tmp_report is already here!
        } elseif ($report == 'report_dot') {
        // @note be aware that tmp_table need id as NULL column, so auto_increment is managed in the report table
        $this->mid->query('
CREATE TEMPORARY TABLE `tmp_report_dot` (
  `a` varchar(255) NOT NULL,
  `b` varchar(255) NOT NULL,
  `cluster` varchar(255) NOT NULL DEFAULT "",
  `module` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1');

// @todo handle nicely when tmp_report is already here!
            return 'tmp_report_dot';
        } elseif ($report = 'report_attributes') {
            $this->mid->query('
CREATE TEMPORARY TABLE `tmp_report_attributes` (
  `id` integer(12) NOT NULL PRIMARY KEY
) ENGINE=MyISAM DEFAULT CHARSET=latin1');

            // @todo no check on correct execution? 
            return 'tmp_report_attributes';
        } else {
            print "\$report is not (report or report_dot) : $report\n\n";
            die(__METHOD__);
        } 
    }
    
    function dependsOn() {
        return array();
    }
    
    function clean_report() {
        $query = <<<SQL
DELETE FROM <report_module> WHERE module='{$this->name}'
SQL;
        $this->exec_query($query);
        
        if ($this->format == Cornac_Auditeur_Analyzer::FORMAT_HTMLLIST) {
            $query = <<<SQL
DELETE FROM <report> WHERE module='{$this->name}'
SQL;
            $this->exec_query($query);
        } elseif ($this->format == Cornac_Auditeur_Analyzer::FORMAT_DOT) {
            $query = <<<SQL
DELETE FROM <report_dot> WHERE module='{$this->name}'
SQL;
            $this->exec_query($query);
        } elseif ($this->format == Cornac_Auditeur_Analyzer::FORMAT_ATTRIBUTE) {
            $query = <<<SQL
UPDATE <report_attributes> SET {$this->name} = 'No'
SQL;
            $this->exec_query($query);
        }
    }

    static public function getPHPConstants($ext = null) {
        if (is_null($ext)) {
            $ini = parse_ini_file('dict/constant2ext.ini', false);
            
    // @note : not useful, but maybe later...
            $extras = array();

            return array_merge($ini['constant'], $extras);
        } else {
            $ini = parse_ini_file('dict/constant2ext.ini', true);
            
            if (isset($ini[$ext])) {
                return $ini[$ext]['constant'];
            } else {
                return array();
            }
        }
    }    
    
    static public function getPHPFunctions($ext = null) {
        if (is_null($ext)) {
            $ini = parse_ini_file('dict/functions2ext.ini', false);
    
            $extras = array('echo','print','die','exit','isset','empty','array','list','unset','eval','dl');

            return array_merge($ini['function'], $extras);
        } else {
            $ini = parse_ini_file('dict/functions2ext.ini', true);
            
            if (isset($ini[$ext])) {
                return $ini[$ext]['function'];
            } else {
                return array();
            }
        }
    }
    
    static public function getPHPExtensions() {
        $ini = parse_ini_file('dict/functions2ext.ini', true);
        
        $exts = array_keys($ini);
        return $exts;
    }

    static public function getDrupal5Hooks() {
        $hook = parse_ini_file('dict/drupal5_hook.ini', false);
        return $hook['hook'];
    }

    static public function getDrupal6Hooks() {
        $hook = parse_ini_file('dict/drupal6_hook.ini', false);
        return $hook['hook'];
    }

    static public function getDrupal7Hooks() {
        $hook = parse_ini_file('dict/drupal7_hook.ini', false);
        return $hook['hook'];
    }

    static public function getPHPClasses() {
        $classes = parse_ini_file('dict/class2ext.ini', false);
        return $classes['classes'];
    }

    static public function getPHPExtClasses() {
        $classes = parse_ini_file('dict/class2ext.ini', true);
        return $classes;
    }

    static public function getZendFrameworkClasses() {
        $classes = parse_ini_file('dict/zfClasses.ini', true);
        return $classes['classes'];
    }

    static public function getSymfonyClasses() {
        $classes = parse_ini_file('dict/sfClasses.ini', true);
        return $classes['classes'];
    }

    static public function getPearClasses() {
        $classes = parse_ini_file('dict/pearClasses.ini', true);
        return $classes['classes'];
    }

    static public function getPHPKeywords() {
        $keywords = parse_ini_file('dict/keywords.ini', true);
        return $keywords['keyword'];
    }

    static public function getPHPHandlers() {
        $functions = parse_ini_file('dict/phphandlers.ini', true);
        return $functions['function'];
    }

    static public function getPopLib() {
        $list = parse_ini_file('dict/poplib.ini', true);
        return $list;
    }

    static public function getPHPGPC() {
        return array('$_GET','$_POST','$_COOKIE','$_REQUEST','$_FILES','$_SESSION',
                     '$HTTP_GET_VARS','$HTTP_POST_VARS','$HTTP_COOKIE_VARS','$HTTP_FILES_VARS', '$HTTP_SESSION_VARS',
                     '$HTTP_RAW_POST_DATA',
                     '$_ENV','$_SERVER',
                     '$HTTP_ENV_VARS','$HTTP_SERVER_VARS',
                     '$http_response_header','$php_errormsg','$argv','$argc',);
    }


    static public function getPHPStandardFunctions() {
        // @todo this depends on PHP used for exécution : we should extract this somewhere else
	    $language_structures = array('echo','print','die','exit','isset','empty','array','list','unset','eval');
	    $ext_array = array('iterator_to_array', 'sqlite_array_query', 'sqlite_fetch_array', 'call_user_func_array', 'call_user_method_array', 'forward_static_call_array', 'is_array', 'array_walk', 'array_walk_recursive', 'in_array', 'array_search', 'array_fill', 'array_fill_keys', 'array_multisort', 'array_push', 'array_pop', 'array_shift', 'array_unshift', 'array_splice', 'array_slice', 'array_merge', 'array_merge_recursive', 'array_replace', 'array_replace_recursive', 'array_keys', 'array_values', 'array_count_values', 'array_reverse', 'array_reduce', 'array_pad', 'array_flip', 'array_change_key_case', 'array_rand', 'array_unique', 'array_intersect', 'array_intersect_key', 'array_intersect_ukey', 'array_uintersect', 'array_intersect_assoc', 'array_uintersect_assoc', 'array_intersect_uassoc', 'array_uintersect_uassoc', 'array_diff', 'array_diff_key', 'array_diff_ukey', 'array_udiff', 'array_diff_assoc', 'array_udiff_assoc', 'array_diff_uassoc', 'array_udiff_uassoc', 'array_sum', 'array_product', 'array_filter', 'array_map', 'array_chunk', 'array_combine', 'array_key_exists');
	    
	    return array_merge($ext_array, $language_structures);
    }
    
    public function init($ini) {
        $this->ini = $ini;
    }

    public function make_in($array) {
        return "'".join("', '", $array)."'";
    }
    
    function concat() {
        $args = func_get_args();
        
        global $OPTIONS;
        if (isset($OPTIONS->mysql) && $OPTIONS->mysql['active'] == true) {
            return "CONCAT(".join(",", $args).")";
        } elseif (isset($OPTIONS->sqlite) && $OPTIONS->sqlite['active'] == true) {
            return "".join("||", $args)."";
        } else {
            print "Concat isn't defined for this database!";
            die(__METHOD__);
        }
    }

    function disabled() {
        print "Module '{$this->name}' is disabled\n";
        return;
    }
}
?>