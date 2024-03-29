<?php
// *** LICENSE ***
// oText is free software.
//
// By Fred Nassar (2006) and Timo Van Neerden (since 2010)
// See "LICENSE" file for info.
// *** LICENSE ***

require_once 'inc/boot.php';
operate_session();


// transforme les valeurs numériques d’un tableau pour les ramener la valeur max du tableau à $maximum. Les autres valeurs du tableau sont à l’échelle
function scaled_size($tableau, $maximum) {
	$ratio = max(array_values($tableau))/$maximum;
	$return = array();
	foreach ($tableau as $key => $value) {
		if ($ratio != 0) {
			$return[] = array('nb'=> $value , 'nb_scale' => floor($value/$ratio), 'date' => $key);
		} else {
			$return[] = array('nb'=> $value , 'nb_scale' => 0, 'date' => $key);
		}
	}
	return $return;
}

/*
 * compte le nombre d’éléments dans la base, pour chaque mois les $i derniers mois.
 * retourne un tableau YYYYMM => nb;
*/
function get_tableau_date($data_type) {
	$table_months = array();
	for ($i = 96 ; $i >= 0 ; $i--) {
		$table_months[date('Ym', mktime(0, 0, 0, date("m")-$i, 1, date("Y")))] = 0;
	}

	// met tout ça au format YYYYMMDDHHIISS où DDHHMMSS vaut 00000000 (pour correspondre au format de l’ID de BT qui est \d{14}
	$max = max(array_keys($table_months)).date('dHis');
	$min = min(array_keys($table_months)).'00000000';
	$bt_date = ($data_type == 'articles' or $data_type == 'rss') ? 'bt_date' : 'bt_id';

	$query = "SELECT substr($bt_date, 1, 6) AS date, count(*) AS idbydate FROM $data_type WHERE $bt_date BETWEEN $min AND $max GROUP BY date ORDER BY date";
	try {
		$req = $GLOBALS['db_handle']->prepare($query);
		$req->execute();
		$tab = $req-> fetchAll(PDO::FETCH_ASSOC);
		foreach ($tab as $i => $month) {
			if (isset($table_months[$month['date']])) {
				$table_months[$month['date']] = $month['idbydate'];
			}
		}
	} catch (Exception $e) {
		die('Erreur 86459: '.$e->getMessage());
	}
	return $table_months;
}


// DEBUT PAGE
afficher_html_head($GLOBALS['lang']['label_resume'], "index");
afficher_topnav($GLOBALS['lang']['label_resume'], ''); #top


echo '<div id="axe">'."\n";
echo '<div id="page">'."\n";


echo '<div id="graphs">'."\n";

/* Une recherche a été faite : affiche la recherche */
if (!empty($_GET['q'])) {
	$q = htmlspecialchars($_GET['q']);

	$nb_articles = liste_elements_count("SELECT count(ID) AS nbr FROM articles WHERE ( bt_content || bt_title ) LIKE ?", array('%'.$q.'%'));
	$nb_liens = liste_elements_count("SELECT count(ID) AS nbr FROM links WHERE ( bt_content || bt_title || bt_link ) LIKE ?", array('%'.$q.'%'));
	$nb_commentaires = liste_elements_count("SELECT count(ID) AS nbr FROM commentaires WHERE bt_content LIKE ?", array('%'.$q.'%'));
	$nb_feeds = liste_elements_count("SELECT count(ID) AS nbr FROM rss WHERE ( bt_content || bt_title ) LIKE ?", array('%'.$q.'%'));
	$nb_notes = liste_elements_count("SELECT count(ID) AS nbr FROM notes WHERE ( bt_content || bt_title ) LIKE ?", array('%'.$q.'%'));
	$nb_files = liste_elements_count("SELECT count(ID) AS nbr FROM images WHERE ( bt_content || bt_filename ) LIKE ?", array('%'.$q.'%'));

	$html = '';
	$html .= '<div class="graph">'."\n";
	$html .= '<div class="form-legend">'.$GLOBALS['lang']['recherche'].'  <span style="font-style: italic">'.htmlspecialchars($_GET['q']).'</span></div>'."\n";
	$html .= '<ul id="resultat-recherche">'."\n";
	$html .= "\t".'<li><a href="articles.php?q='.htmlspecialchars($_GET['q']).'">'.nombre_objets($nb_articles, 'article').'</a></li>'."\n";
	$html .= "\t".'<li><a href="links.php?q='.htmlspecialchars($_GET['q']).'">'.nombre_objets($nb_liens, 'link').'</a></li>'."\n";
	$html .= "\t".'<li><a href="commentaires.php?q='.htmlspecialchars($_GET['q']).'">'.nombre_objets($nb_commentaires, 'commentaire').'</a></li>'."\n";
	$html .= "\t".'<li><a href="fichiers.php?q='.htmlspecialchars($_GET['q']).'">'.nombre_objets($nb_files, 'fichier').'</a></li>'."\n";
	$html .= "\t".'<li><a href="notes.php?q='.htmlspecialchars($_GET['q']).'">'.nombre_objets($nb_notes, 'note').'</a></li>'."\n";
	$html .= "\t".'<li><a href="feed.php?q='.htmlspecialchars($_GET['q']).'">'.nombre_objets($nb_feeds, 'feed_entry').'</a></li>'."\n";
	$html .= '</ul>'."\n";
	$html .= '</div>'."\n";
	echo $html;

}

/* sinon, affiche les graphes. */

else {
	$total_articles = liste_elements_count("SELECT count(ID) AS nbr FROM articles", array());
	$total_links = liste_elements_count("SELECT count(ID) AS nbr FROM links", array());
	$total_comms = liste_elements_count("SELECT count(ID) AS nbr FROM commentaires", array());
	$total_rss = liste_elements_count("SELECT count(ID) AS nbr FROM rss", array());
	$total_notes = liste_elements_count("SELECT count(ID) AS nbr FROM notes", array());
	$total_fichiers = liste_elements_count("SELECT count(ID) AS nbr FROM images", array());

	if (!$total_articles == 0) {
		echo '<div class="graph">'."\n";
		// print sur chaque div pour les articles.
		echo '<div class="form-legend">'.ucfirst($GLOBALS['lang']['label_articles']).'</div>'."\n";
		echo '<div class="graph-container" id="graph-container-article">'."\n";
			echo '<canvas height="150" width="400"></canvas>'."\n";
			echo '<div class="graphique" id="articles">'."\n";
				$table = scaled_size(get_tableau_date('articles'), 150);
				$table = array_reverse($table);
				echo "\t".'<div class="month"><div class="month-bar" style="height: 151px; margin-top:20px;"></div></div>'."\n";
				foreach ($table as $i => $data) {
					echo "\t".'<div class="month">'."\n";
					echo "\t\t".'<div class="month-bar" style="height: '.$data['nb_scale'].'px; margin-top:'.max(3-$data['nb_scale'], 0).'px"></div>'."\n";
					echo "\t\t".'<span class="month-nb">'.$data['nb'].'</span>'."\n";
					echo "\t\t".'<a href="articles.php?filtre='.$data['date'].'"><span class="month-name">'.mb_substr(mois_en_lettres(substr($data['date'],4,2)),0,3)."<br/>".substr($data['date'],2,2).'</span></a>'."\n";
					echo "\t".'</div>'."\n";
				}
			echo '</div>'."\n";
		echo '</div>'."\n";
		echo '</div>'."\n";
	}

	if (!$total_comms == 0) {
		echo '<div class="graph">'."\n";
		// print sur chaque div pour les com.
		echo '<div class="form-legend">'.ucfirst($GLOBALS['lang']['label_commentaires']).'</div>'."\n";
		echo '<div class="graph-container" id="graph-container-commentaires">'."\n";
			echo '<canvas height="150" width="400"></canvas>'."\n";
			echo '<div class="graphique" id="commentaires">'."\n";
				$table = scaled_size(get_tableau_date('commentaires'), 150);
				$table = array_reverse($table);
				echo "\t".'<div class="month"><div class="month-bar" style="height: 151px; margin-top:20px;"></div></div>'."\n";
				foreach ($table as $i => $data) {
					echo "\t".'<div class="month">'."\n";
					echo "\t\t".'<div class="month-bar" style="height: '.$data['nb_scale'].'px; margin-top:'.max(3-$data['nb_scale'], 0).'px"></div>'."\n";
					echo "\t\t".'<span class="month-nb">'.$data['nb'].'</span>'."\n";
					echo "\t\t".'<a href="commentaires.php?filtre='.$data['date'].'"><span class="month-name">'.mb_substr(mois_en_lettres(substr($data['date'],4,2)),0,3)."<br/>".substr($data['date'],2,2).'</span></a>'."\n";
					echo "\t".'</div>'."\n";
				}
			echo '</div>'."\n";
		echo '</div>'."\n";
		echo '</div>'."\n";
	}

	if (!$total_links == 0) {
		echo '<div class="graph">'."\n";
		// print sur chaque div pour les liens.
		echo '<div class="form-legend">'.ucfirst($GLOBALS['lang']['label_links']).'</div>'."\n";
		echo '<div class="graph-container" id="graph-container-links">'."\n";
			echo '<canvas height="150" width="400"></canvas>'."\n";
			echo '<div class="graphique" id="links">'."\n";
				$table = scaled_size(get_tableau_date('links'), 150);
				$table = array_reverse($table);
				echo "\t".'<div class="month"><div class="month-bar" style="height: 151px; margin-top:20px;"></div></div>'."\n";
				foreach ($table as $i => $data) {
					echo "\t".'<div class="month">'."\n";
					echo "\t\t".'<div class="month-bar" style="height: '.$data['nb_scale'].'px; margin-top:'.max(3-$data['nb_scale'], 0).'px"></div>'."\n";
					echo "\t\t".'<span class="month-nb">'.$data['nb'].'</span>'."\n";
					echo "\t\t".'<a href="links.php?filtre='.$data['date'].'"><span class="month-name">'.mb_substr(mois_en_lettres(substr($data['date'],4,2)),0,3)."<br/>".substr($data['date'],2,2).'</span></a>'."\n";
					echo "\t".'</div>'."\n";
				}
			echo '</div>'."\n";
		echo '</div>'."\n";
		echo '</div>'."\n";
	}
	if (!$total_notes == 0) {
		echo '<div class="graph">'."\n";
		// print sur chaque div pour les liens.
		echo '<div class="form-legend">'.ucfirst($GLOBALS['lang']['label_notes']).'</div>'."\n";
		echo '<div class="graph-container" id="graph-container-notes">'."\n";
			echo '<canvas height="150" width="400"></canvas>'."\n";
			echo '<div class="graphique" id="notes">'."\n";
				$table = scaled_size(get_tableau_date('notes'), 150);
				$table = array_reverse($table);
				echo "\t".'<div class="month"><div class="month-bar" style="height: 151px; margin-top:20px;"></div></div>'."\n";
				foreach ($table as $i => $data) {
					echo "\t".'<div class="month">'."\n";
					echo "\t\t".'<div class="month-bar" style="height: '.$data['nb_scale'].'px; margin-top:'.max(3-$data['nb_scale'], 0).'px"></div>'."\n";
					echo "\t\t".'<span class="month-nb">'.$data['nb'].'</span>'."\n";
					echo "\t\t".'<a href="notes.php?filtre='.$data['date'].'"><span class="month-name">'.mb_substr(mois_en_lettres(substr($data['date'],4,2)),0,3)."<br/>".substr($data['date'],2,2).'</span></a>'."\n";
					echo "\t".'</div>'."\n";
				}
			echo '</div>'."\n";
		echo '</div>'."\n";
		echo '</div>'."\n";
	}

	if (!$total_fichiers == 0) {
		echo '<div class="graph">'."\n";
		// print sur chaque div pour les liens.
		echo '<div class="form-legend">'.ucfirst($GLOBALS['lang']['label_fichiers']).'</div>'."\n";
		echo '<div class="graph-container" id="graph-container-files">'."\n";
			echo '<canvas height="150" width="400"></canvas>'."\n";
			echo '<div class="graphique" id="images">'."\n";
				$table = scaled_size(get_tableau_date('images'), 150);
				$table = array_reverse($table);
				echo "\t".'<div class="month"><div class="month-bar" style="height: 151px; margin-top:20px;"></div></div>'."\n";
				foreach ($table as $i => $data) {
					echo "\t".'<div class="month">'."\n";
					echo "\t\t".'<div class="month-bar" style="height: '.$data['nb_scale'].'px; margin-top:'.max(3-$data['nb_scale'], 0).'px"></div>'."\n";
					echo "\t\t".'<span class="month-nb">'.$data['nb'].'</span>'."\n";
					echo "\t\t".'<a href="fichiers.php?filtre='.$data['date'].'"><span class="month-name">'.mb_substr(mois_en_lettres(substr($data['date'],4,2)),0,3)."<br/>".substr($data['date'],2,2).'</span></a>'."\n";
					echo "\t".'</div>'."\n";
				}
			echo '</div>'."\n";
		echo '</div>'."\n";
		echo '</div>'."\n";
	}

	if (!$total_rss == 0) {
		echo '<div class="graph">'."\n";
		// print sur chaque div pour les liens.
		echo '<div class="form-legend">'.ucfirst($GLOBALS['lang']['label_feeds']).'</div>'."\n";
		echo '<div class="graph-container" id="graph-container-feeds">'."\n";
			echo '<canvas height="150" width="400"></canvas>'."\n";
			echo '<div class="graphique" id="feeds">'."\n";
				$table = scaled_size(get_tableau_date('rss'), 150);
				$table = array_reverse($table);
				echo "\t".'<div class="month"><div class="month-bar" style="height: 151px; margin-top:20px;"></div></div>'."\n";
				foreach ($table as $i => $data) {
					echo "\t".'<div class="month">'."\n";
					echo "\t\t".'<div class="month-bar" style="height: '.$data['nb_scale'].'px; margin-top:'.max(3-$data['nb_scale'], 0).'px"></div>'."\n";
					echo "\t\t".'<span class="month-nb">'.$data['nb'].'</span>'."\n";
					echo "\t\t".'<a href="feed.php?filtre='.$data['date'].'"><span class="month-name">'.mb_substr(mois_en_lettres(substr($data['date'],4,2)),0,3)."<br/>".substr($data['date'],2,2).'</span></a>'."\n";
					echo "\t".'</div>'."\n";
				}
			echo '</div>'."\n";
		echo '</div>'."\n";
		echo '</div>'."\n";
	}
}

echo '</div>'."\n";
echo "\n".'<script src="style/scripts/javascript.js"></script>'."\n";
echo "\n".'<script>'."\n";
echo '\'use strict\''."\n";
echo 'var canvas = document.querySelectorAll(".graph-container canvas");'."\n";
echo 'var containers = document.querySelectorAll(".graph-container");'."\n";
echo 'var graphiques = document.querySelectorAll(".graph-container .graphique");'."\n";
echo 'window.addEventListener("resize", respondCanvas );'."\n";
echo 'respondCanvas();'."\n";
echo "\n".'</script>'."\n";

footer($begin);

