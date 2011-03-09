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
   | Author: Damien Seguy <damien.seguy@alterway.fr>                      |
   +----------------------------------------------------------------------+
 */

// @todo this should change name, and probably calling script (no use in reader. May be export...)
class Cornac_Auditeur_Render_Html {
    private $db = null;
    private $folder = '.';
    
    function __construct($folders ) {
        global $DATABASE;

        $this->db = $DATABASE;
    }
    
    function SetFolder($path) {
        $this->folder = realpath($path);
    }
    
    function render($lines) {
        $this->render_summary();
        $this->render_analyzers();
        $this->render_files();
        $this->render_dot();
    }
    
    function render_summary() {
            $sql = <<<SQL
SELECT TRM.module, TRM.fait, COUNT(*) AS count
FROM <report_module> TRM
JOIN <report> TR
    ON TR.module = TRM.module
GROUP BY TR.module
ORDER BY TR.module
SQL;
        $res = $this->db->query($sql);
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows as $id => $row) {
            $rows[$id]['url'] = "analyzers/".$row['module'].".html";
        }

            $sql = <<<SQL
SELECT TRM.module, TRM.fait, COUNT(*) AS count
FROM <report_module> TRM
JOIN <report_dot> TR
    ON TR.module = TRM.module
GROUP BY TR.module
ORDER BY TR.module
SQL;
        $res = $this->db->query($sql);
        $rows2 = $res->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows2 as $id => $row) {
            $row['url'] = "dots/".$row['module'].".html";
            $rows[] = $row;
        }

        $view = new Cornac_View();
        $view->rows = $rows;
        $html = $view->process('template/reports.php');
        
        file_put_contents($this->folder.'/sommaire.html', $html);
    }

    function render_analyzers() {
    // @todo also check this is a folder
        if (!file_exists($this->folder.'/analyzers/')) {
            mkdir($this->folder.'/analyzers/', 0755);
        }
        
        $sql = <<<SQL
SELECT module FROM <report_module> ORDER BY module
SQL;
        $analyzers = $this->db->query_one_array($sql);

        foreach($analyzers as $analyzer) {
            $view = new Cornac_View();

            $view->url_main = '../sommaire.html';
            $view->url_reports = '../sommaire.html';
            $view->url_report_file = '../files/'.$analyzer.'.html';
            $view->analyzer = $analyzer;

            $stats = array();

// @todo this is ugly! Make this better soon!
            $sql = <<<SQL
SELECT DISTINCT TR.element
FROM <report> TR
JOIN <tokens> T1
    ON TR.token_id = T1.id
WHERE module='$analyzer'
ORDER BY element, TR.file, line
SQL;
            $res = $this->db->query($sql);
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);

            $stats['distinct'] = count($rows);

            $sql = <<<SQL
SELECT TR.element, TR.file, T1.line
FROM <report> TR
JOIN <tokens> T1
    ON TR.token_id = T1.id
WHERE module='$analyzer'
ORDER BY element, file, line
SQL;
            $res = $this->db->query($sql);
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);

            $stats['total'] = count($rows);

            $view->rows = $rows;
            $view->stats = $stats;
            file_put_contents($this->folder.'/analyzers/'.$analyzer.'.html',  $view->process('template/reports_analyzer.php', $rows));
        }
    }
    
    function render_files() {
    // @todo also check this is a folder
        if (!file_exists($this->folder.'/files/')) {
            mkdir($this->folder.'/files/', 0755);
        }
        
        $sql = <<<SQL
SELECT module 
FROM <report_module> 
WHERE format='html'
ORDER BY module
SQL;
        $analyzers = $this->db->query_one_array($sql);

        foreach($analyzers as $analyzer) {
        
            $view = new Cornac_View();

            $view->url_main = '../sommaire.html';
            $view->url_reports = '../sommaire.html';
            $view->url_report_analyzer = '../analyzers/'.$analyzer.'.html';
            $view->analyzer = $analyzer;

            $stats = array();

// @todo this is ugly! Make this better soon!
            $sql = <<<SQL
SELECT DISTINCT TR.file
FROM <report> TR
JOIN <tokens> T1
    ON TR.token_id = T1.id
WHERE module='$analyzer'
ORDER BY element, TR.file, line
SQL;
            $res = $this->db->query($sql);
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);

            $stats['distinct'] = count($rows);

            $sql = <<<SQL
SELECT TR.element, TR.file, T1.line
FROM <report> TR
JOIN <tokens> T1
    ON TR.token_id = T1.id
WHERE module='$analyzer'
ORDER BY file, line, element
SQL;
            $res = $this->db->query($sql);
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);

            $stats['total'] = count($rows);

            $view->rows = $rows;
            $view->stats = $stats;
            file_put_contents($this->folder.'/files/'.$analyzer.'.html',  $view->process('template/reports_files.php', $rows));
        }
    }

    function render_dot() {
    // @todo also check this is a folder
        if (!file_exists($this->folder.'/dots/')) {
            mkdir($this->folder.'/dots/', 0755);
        }
        
        $sql = <<<SQL
SELECT module 
FROM <report_module> 
WHERE format = 'dot'
ORDER BY module
SQL;
        $analyzers = $this->db->query_one_array($sql);

        foreach($analyzers as $analyzer) {
            // @todo export data in file format. 
        }
    }
}

?>