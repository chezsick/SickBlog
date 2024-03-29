<?php
// *** LICENSE ***
// oText is free software.
//
// By Fred Nassar (2006) and Timo Van Neerden (since 2010)
// See "LICENSE" file for info.
// *** LICENSE ***

require_once 'inc/boot.php';


// anti XSS : /index.php/%22onmouseover=prompt(971741)%3E or /index.php/ redirects all on index.php
// if there is a slash after the "index.php", the file is considered as a folder, but the code inside it still executed.
if (strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME'].'/') === 0) {
	header('Location: '.$_SERVER['SCRIPT_NAME']);
	exit;
}

// If no config: go to install process.
if ( !file_exists('config/user.ini') or !file_exists('config/prefs.php') ) {
	header('Location: admin/install.php');
	die;
}

// gzip compression
if (extension_loaded('zlib')) {
	if (ob_get_length() > 0) {
		ob_end_clean();
	}
	ob_start("ob_gzhandler");
}

header('Content-Type: text/html; charset=UTF-8');

session_start([
    'cookie_lifetime' => 86400*365,
    'cookie_secure'   => true,
    'cookie_httponly' => true,
]);

$GLOBALS['db_handle'] = open_base();


/*****************************************************************************
 some misc requests
******************************************************************************/

// Old syntaxed ID in URL : redirects to new ID syntax
/*if ( isset($_GET['d']) and preg_match('#^\d{4}/\d{2}/\d{2}/\d{2}/\d{2}/\d{2}#', $_GET['d']) ) {
	$tab = explode('/', $_GET['d']);
	$oldid = substr($tab['0'].$tab['1'].$tab['2'].$tab['3'].$tab['4'].$tab['5'], '0', '14');
	$id = substr(md5($oldid), 0, 6);

 	header("HTTP/1.1 301 Moved Permanently");
	header('Location: '.URL_ROOT.get_blogpath($id, substr(array_slice($tab, 5)[0], 3) ));
	exit;


}*/

// Random article
if (isset($_GET['random'])) {
	try {
		// getting nb articles, gen random num, then select one article is much faster than "sql(order by rand limit 1)"
		$result = $GLOBALS['db_handle']->query("SELECT count(ID) FROM articles WHERE bt_statut=1 AND bt_date <= ".date('YmdHis'))->fetch();
		if ($result[0] == 0) {
			header('Location: '.$_SERVER['SCRIPT_NAME']);
		}
		$rand = mt_rand(0, $result[0] - 1);
		$tableau = liste_elements("SELECT * FROM articles WHERE bt_statut=1  AND bt_date <= ".date('YmdHis')." LIMIT $rand, 1", array());
	} catch (Exception $e) {
		die('Erreur rand: '.$e->getMessage());
	}

	header('Location: '.URL_ROOT.$tableau[0]['bt_link']);
	exit;
}

// unsubscribe request from comments-newsletter and redirect on main page
if ( isset($_GET['unsub'], $_GET['mail'], $_GET['article']) and $_GET['unsub'] == 1 ) {
	$res = unsubscribe(htmlspecialchars($_GET['mail']), htmlspecialchars($_GET['article']), (isset($_GET['all']) ? 1 : 0));
	if ($res == TRUE) {
		header('Location: '.basename($_SERVER['SCRIPT_NAME']).'?unsubscriben=yes');
	} else {
		header('Location: '.basename($_SERVER['SCRIPT_NAME']).'?unsubscriben=no');
	}
}


/*****************************************************************************
 Show one post : 1 blogpost (with comments)
******************************************************************************/
// Single Blog Post
if ( isset($_GET['d']) and ( preg_match('#^\d{4}/\d{2}/\d{2}/\d{2}/\d{2}/\d{2}#', $_GET['d']) or preg_match('#^[0-9a-z]{6}--#', $_GET['d']) ) ) {

	if (preg_match('#^\d{4}/\d{2}/\d{2}/\d{2}/\d{2}/\d{2}#', $_GET['d']) ) {
		$tab = explode('/', $_GET['d']);
		$id = substr($tab['0'].$tab['1'].$tab['2'].$tab['3'].$tab['4'].$tab['5'], '0', '14');
	} elseif (preg_match('#^[0-9a-z]{6}--#', $_GET['d']) ) {
		$id = substr($_GET['d'], 0, 6);
	}

	// 'admin' connected is allowed to see draft articles, but not 'public'. Same for article posted with a date in the future.
	if (empty($_SESSION['user_id'])) {
		$query = "SELECT * FROM articles WHERE bt_id=? AND bt_date <=? AND bt_statut=1 LIMIT 1";
		$billets = liste_elements($query, array($id, date('YmdHis')));
	} else {
		$query = "SELECT * FROM articles WHERE bt_id=? LIMIT 1";
		$billets = liste_elements($query, array($id));
	}
	if ( !empty($billets[0]) ) {
		// TRAITEMENT new commentaire
		$erreurs_form = array();
		if (isset($_POST['_verif_envoi'], $_POST['commentaire'], $_POST['captcha'], $_POST['token'], $_POST['auteur'], $_POST['email'], $_POST['webpage']) and ($billets[0]['bt_allow_comments'] == '1' )) {
			// COOKIES
			if (isset($_POST['allowcuki'])) { // si cookies autorisés, conserve les champs remplis
				if (isset($_POST['auteur'])) {  setcookie('auteur_c', $_POST['auteur'], time() + 365*24*3600, null, null, true, true); }
				if (isset($_POST['email'])) {   setcookie('email_c', $_POST['email'], time() + 365*24*3600, null, null, true, true); }
				if (isset($_POST['webpage'])) { setcookie('webpage_c', $_POST['webpage'], time() + 365*24*3600, null, null, true, true); }
				setcookie('subscribe_c', (isset($_POST['subscribe']) and $_POST['subscribe'] == 'on' ) ? 1 : 0, time() + 365*24*3600, null, null, true, true);
				setcookie('cookie_c', 1, time() + 365*24*3600, null, null, true, true);
			}

			// COMMENT POST INIT
			$comment = init_post_comment($id, 'public');
			if (isset($_POST['enregistrer'])) {
				$erreurs_form = valider_form_commentaire($comment, 'public');
			}
		} else { unset($_POST['enregistrer']); }

		//afficher_form_commentaire($id, 'public', $erreurs_form, '');
		if (empty($erreurs_form) and isset($_POST['enregistrer'])) {
			traiter_form_commentaire($comment, 'public');
		}

		afficher_index($billets[0], 'post', $erreurs_form);
	}
	else { afficher_index(NULL, 'list', ''); }

}

// single link post
elseif ( isset($_GET['id']) and preg_match('#\d{14}#', $_GET['id']) ) {
	$tableau = liste_elements("SELECT * FROM links WHERE bt_id=? AND bt_statut=1", array($_GET['id']));
	afficher_index($tableau, 'list', '');
}


// List of all articles
elseif (isset($_GET['liste'])) {
	$query = "SELECT bt_date,bt_id,bt_title,bt_nb_comments,bt_link FROM articles WHERE bt_date <= ".date('YmdHis')." AND bt_statut=1 ORDER BY bt_date DESC";
	$tableau = liste_elements($query, array());
	afficher_liste($tableau);
}

/*****************************************************************************
 show by lists of more than one post
******************************************************************************/
else {
	$annee = date('Y'); $mois = date('m'); $jour = '';
	$array = array();
	$query = "SELECT * FROM ";

	// paramètre mode : quelle table "mode" ?
	if (isset($_GET['mode'])) {
		switch($_GET['mode']) {
			case 'comments':
				$query = "SELECT c.*, a.bt_title FROM ";
				$where = 'commentaires';
				break;
			case 'links':
				$where = 'links';
				break;
			case 'blog':
			default:
				$where = 'articles';
				break;
		}
	} else {
		$where = 'articles';
	}

	switch($where) {
		case 'commentaires':
			$query .= "commentaires AS c, articles AS a ";
			break;
		default:
			$query .= $where.' ';
			break;
	}

	// paramètre de recherche uniquement dans les éléments publiés :
	switch($where) {
		case 'commentaires':
			$query .= 'WHERE c.bt_statut=1 ';
			break;
		default:
			$query .= 'WHERE bt_statut=1 ';
			break;
	}


	// paramètre de date "d"
	if (isset($_GET['d']) and preg_match('#^\d{4}(/\d{2})?(/\d{2})?#', $_GET['d'])) {
		$date = '';
		$dates = array();
		$tab = explode('/', $_GET['d']);
		if ( isset($tab['0']) and preg_match('#\d{4}#', ($tab['0'])) ) { $date .= $tab['0']; $annee = $tab['0']; }
		if ( isset($tab['1']) and preg_match('#\d{2}#', ($tab['1'])) ) { $date .= $tab['1']; $mois = $tab['1']; }
		if ( isset($tab['2']) and preg_match('#\d{2}#', ($tab['2'])) ) { $date .= $tab['2']; $jour = $tab['2']; }

		if (!empty($date)) {
			switch ($where) {
				case 'articles':
					$sql_date = "bt_date LIKE ? ";
					break;
				case 'commentaires':
					$sql_date = "c.bt_id LIKE ? ";
					break;
				default:
					$sql_date = "bt_id LIKE ? ";
					break;
			}
			$array[] = $date.'%';
		} else {
			$sql_date = "";
		}
	}

	// paramètre de recherche "q"
	if (isset($_GET['q'])) {
		$arr = parse_search($_GET['q']);
		$array = array_merge($array, $arr);
		switch ($where) {
			case 'articles' :
				$sql_q = implode(array_fill(0, count($arr), '( bt_content || bt_title ) LIKE ? '), 'AND ');
				break;
			case 'links' :
				$sql_q = implode(array_fill(0, count($arr), '( bt_content || bt_title || bt_link ) LIKE ? '), 'AND ');
				break;
			case 'commentaires' :
				$sql_q = implode(array_fill(0, count($arr), 'c.bt_content LIKE ? '), 'AND ');
				break;
			default:
				$sql_q = "";
				break;
		}
	}

	// paramètre de tag "tag"
	if (isset($_GET['tag'])) {
		switch ($where) {
			case 'articles' :
				$sql_tag = "( bt_tags LIKE ? OR bt_tags LIKE ? OR bt_tags LIKE ? OR bt_tags LIKE ? ) ";
				$array[] = $_GET['tag'];
				$array[] = $_GET['tag'].', %';
				$array[] = '%, '.$_GET['tag'].', %';
				$array[] = '%, '.$_GET['tag'];
				break;
			case 'links' :
				$sql_tag = "( bt_tags LIKE ? OR bt_tags LIKE ? OR bt_tags LIKE ? OR bt_tags LIKE ? ) ";
				$array[] = $_GET['tag'];
				$array[] = $_GET['tag'].', %';
				$array[] = '%, '.$_GET['tag'].', %';
				$array[] = '%, '.$_GET['tag'];
				break;
			default:
				$sql_tag = " ";
				break;
		}
	}

	// paramètre d’auteur "author" FIXME !

	// paramètre ORDER BY (pas un paramètre, mais ajouté à la $query quand même)
	switch ($where) {
		case 'articles' :
			$sql_order = "ORDER BY bt_date DESC ";
			break;
		case 'commentaires' :
			$sql_order = "ORDER BY c.bt_id DESC ";
			break;
		default:
			$sql_order = "ORDER BY bt_id DESC ";
			break;
	}

	// paramètre de filtrage date (pas un paramètre, mais ajouté quand même)
	switch ($where) {
		case 'articles' :
			$sql_a_p = "bt_date <= ".date('YmdHis')." ";
			break;
		case 'commentaires' :
			$sql_a_p = "c.bt_id <= ".date('YmdHis')." AND c.bt_article_id=a.bt_id ";
			break;
		default:
			$sql_a_p = "bt_id <= ".date('YmdHis')." ";
			break;
	}

	// paramètre de page "p"
	if (isset($_GET['p']) and is_numeric($_GET['p']) and $_GET['p'] >= 1) {
		$sql_p = 'LIMIT '.$GLOBALS['max_bill_acceuil'] * $_GET['p'].', '.$GLOBALS['max_bill_acceuil'];
	} elseif (empty($sql_date) ) {
		$sql_p = 'LIMIT '.$GLOBALS['max_bill_acceuil']; // no limit for $date param, is param is valid
	} else {
		$sql_p = '';
	}

	// Concaténation de tout ça.
	$glue = 'AND ';
	if (!empty($sql_date)) {
		$query .= $glue.$sql_date;
	}
	if (!empty($sql_q)) {
		$query .= $glue.$sql_q;
	}
	if (!empty($sql_tag)) {
		$query .= $glue.$sql_tag;
	}

	$query .= $glue.$sql_a_p.$sql_order.$sql_p;
	$tableau = liste_elements($query, $array);
	$GLOBALS['param_pagination'] = array('nb' => count($tableau), 'nb_par_page' => $GLOBALS['max_bill_acceuil']);
	afficher_index($tableau, 'list', '');
}

 $end = microtime(TRUE);
 echo ' <!-- Rendered in '.round(($end - $begin),6).' seconds -->';

?>
