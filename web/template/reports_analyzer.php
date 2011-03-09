<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cornac</title>
<link type='text/css' rel='stylesheet' href='css/thickbox.css' />
<link type="text/css" rel="stylesheet" href="css/search.css" />
<link type='text/css' rel='stylesheet' href='css/demo_page.css' />
<link type='text/css' rel='stylesheet' href='css/demo_table.css' />
<link type="text/css" rel="stylesheet" href="css/cornac.css" />
<script language='javascript' type='text/javascript' src='js/jquery.js'></script>
<script language='javascript' type='text/javascript' src='js/lightbox.js'></script>
<script language='javascript' type='text/javascript' src='js/search.js'></script>
<script language='javascript' type='text/javascript' src='js/fonction.js'></script>
<script type="text/javascript" language="javascript" src="table/js/jquery.dataTables.js"></script>

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#dashboard2').dataTable();
	} );
</script>
<script>
	$(document).ready(function(){
    $("#displayBloc").click(function () {
        $("#monBloc").slideToggle("slow");
	    $(this).toggleClass("enroule"); return false;
    });
});
</script>
</head>

<body>
<div id="page_interieur">
	<div id="header">
		<div id="contenu-header">
        	
            <div class="logo">
            	<a href="index.html" alt="Cornac" title="Cornac">Cornac</a>
            </div><!--logo-->
            <div class="header-droite">	
                <div class="boutons">
                    
                    <div class="liens">                   
                    <a title="Inscription / Connexion" class="thickbox" href="#TB_inline?height=300&width=600&inlineId=login&modal=false">Se connecter</a>
                  	<a title="anglais" class="lang" href="">English</a>
               		</div>
                    
               		<div id="filter">
                    <form action="" method="get">
                        <fieldset>
                            <input type="text" id="searchBar" />
                            <input type="submit" value="Search" id="searchButton" />
                        </fieldset>
                    </form>
                    </div>
                  
                </div><!--bouton-->
                
                <div class="haut-en-tete">
                
                    
                </div><!--haut-en-tete-->
        	</div>    
        </div><!--contenu header-->
        
    </div><!--header-->
    
    <div id="en-tete-interieur">
    	<div class="accroche">
        
            <div class="savoir-plus">
                <div class="filter"></div>
                
                <a title="En Savoir Plus" class="thickbox" href="#TB_inline?height=200&width=400&inlineId=savoir&modal=false">En savoir plus</a>
            </div><!--savoir plus-->
        </div><!--accroche-->
       
    </div><!--en-tete-->
   <div id="scrollingDiv">
	<div id="colonne">
    	<a id="displayBloc" class="deroule nom_fichier" href="#"><span class="nom"><?php echo $application.' / '.$analyzer; ?> </span><span class="roulement"></span></a>
        <div class="boutons_navigation">
            <div class="retour"><a href="<?php echo $url_reports; ?>" alt="retour" title="retour">Retour</a></div>
            <div class="precedent"><a href="<?php echo $url_previous; ?>" alt="precedent" title="precedent">Précédent</a></div>
            <div class="suivant"><a href="<?php echo $url_next; ?>" alt="Suivant" title="Suivant">Suivant</a></div>
		</div>
        <div id="monBloc">
            <?php
            $i = 0;
            $lis = array();
            foreach($stats as $name => $value) {
                $i++;
                $lis[$i % 4][] = '<li class="item_1"><span class="categorie">'.$name.'</span><span class="nbre">'.$value.'</span></li>';
            }
            
            $html = '';
            foreach($lis as $li) {
                $html .= '<ul class="items">'."\n".join("\n", $li)."\n</ul>\n";
            }
            
            print $html;
            ?>
        </div>
    </div>
	
</div>

    <div id="conteneur_interieur">
           	<div class="conteneur_interieur-inner">
            	<table cellpadding="0" cellspacing="0" border="0" class="display" id="dashboard2">
                    <thead>
                        <tr>
                            <th class="left">Code</th>
                            <th>File</th>
                            <th>Line</th>
                            <th> </th>
                        </tr>
                    </thead>
                    
                    <tbody>
<?php
$html = '';
foreach($rows as $id => $row) {
    $html .= <<<HTML
                        <tr>
                            <td class="fichier">{$row['element']}</td>
                            <td class="color2 center">{$row['file']}</td>
                            <td class="color3 center">{$row['line']}</td>
                            <td class="checkbox center">&nbsp;</td>
                        </tr>
HTML;
}
echo $html;
?>
                    </tbody>
                    <tfoot>
                        <tr class="tfoot1">
                            <th class="left">Code</th>
                            <th>File</th>
                            <th>Line</th>
                            <th> </th>
                        </tr>
                        <!--
                        <tr class="tfoot2">
                            <th class="left">distinct</th>
                            <th>Browser</th>
                            <th>Platform(s)</th>
                            <th> </th>
                        </tr>
                        -->
                 	 </tfoot>
               </table>   
                  
                                
            </div><!--conteneur-inner-->
    </div><!--conteneur gris-->
	
    <div id="footer">
    </div><!--footer-->
    <div id="login" style="display:none;">
		<div class="inscription">
            <span class="boxtitle"></span>
            <form method="GET" target="_parent">
                <p>Adresse email : 
                <input type="text" name="email" value="moi@nomdedomaine.com" maxlength="60" size="60">
                <br/>
                Login :
                <input type="text" name="" value="" maxlength="60" size="60">
                <br/>
                Mot de passe :
                <input type="password" name="" value="" maxlenght="60" size="60">
                <br/>
                Confirmer votre Mot de passe :
                <input type="password" name="" value="" maxlenght="60" size="60">
                </p>
            </form>
    	</div>
        <div class="connexion">
        </div>
	</div>
    <div id="savoir" style="display:none;">
    <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
    <p>Integer id enim nibh, vitae elementum metus. Nulla et vehicula nisi. Ut et enim ac risus facilisis consequat. Donec at malesuada nibh. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ligula mauris, accumsan sed ultricies id, fringilla quis quam. Sed vel massa tortor. Mauris nisi urna, aliquam non cursus quis, ornare id felis. Duis luctus gravida eleifend. <a href="http://www.google.fr" alt="google" target="_blank">Nulla sollicitudin</a> scelerisque felis vel feugiat.</p>
    </div>
</div><!--page interieur-->
</body>
</html>
