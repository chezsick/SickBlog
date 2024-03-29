<?php
// *** LICENSE ***
// oText is free software.
//
// By Fred Nassar (2006) and Timo Van Neerden (since 2010)
// See "LICENSE" file for info.
// *** LICENSE ***

require_once 'inc/boot.php';
operate_session();
setcookie('lastAccessRss', time(), time()+365*24*60*60, null, null, false, true);
$GLOBALS['liste_flux'] = open_serialzd_file(FEEDS_DB);

// DEBUT PAGE
afficher_html_head($GLOBALS['lang']['mesabonnements'], "feeds");
afficher_topnav($GLOBALS['lang']['mesabonnements'], ''); #top

echo '<div id="axe">'."\n";
echo '<div id="page">'."\n";
$out_html = '';

// list of websites
$out_html .= "\t".'<ul id="feed-list">'."\n";
$out_html .= "\t\t".'<li class="special">'."\n";
$out_html .= "\t\t\t".'<ul>'."\n";
$out_html .= "\t\t\t\t".'<li class="all-feeds active-site" id="global-post-counter">'.$GLOBALS['lang']['rss_label_all_feeds'].'</li>'."\n";
$out_html .= "\t\t\t\t".'<li class="today-feeds" id="today-post-counter">'.$GLOBALS['lang']['rss_label_today_feeds'].'</li>'."\n";
$out_html .= "\t\t\t\t".'<li class="fav-feeds" id="favs-post-counter">'.$GLOBALS['lang']['rss_label_favs_feeds'].'</li>'."\n";
$out_html .= "\t\t\t".'</ul>'."\n";
$out_html .= "\t\t".'</li>'."\n";
$out_html .= "\t\t".'<li class="feed-folder" data-nbrun="" data-folder="" hidden>'."\n";
$out_html .= "\t\t\t".'<a class="unfold"></a>'."\n";
$out_html .= "\t\t\t".'<ul></ul>'."\n";
$out_html .= "\t\t".'</li>'."\n";
$out_html .= "\t\t".'<li class="feed-site" data-nbrun="" data-feed-hash="" style="" hidden><button type="button" class="feed-site-edit"></button></li>'."\n";
$out_html .= "\t".'</ul>'."\n";
// list of posts (with buttons & elements count)
$out_html .= "\t".'<div id="rss-list">'."\n";
$out_html .= "\t\t".'<div id="posts-wrapper">'."\n";
$out_html .= "\t\t\t".'<div id="post-list-title">'."\n";
$out_html .= "\t\t\t\t".'<ul class="posts-actions-buttons">'."\n";
$out_html .= "\t\t\t\t\t".'<li><button type="button" id="markasread" title="'.$GLOBALS['lang']['rss_label_markasread'].'">'.$GLOBALS['lang']['rss_label_markasread'].'</button></li>'."\n";
$out_html .= "\t\t\t\t\t".'<li><button type="button" id="openallitemsbutton" title="'.$GLOBALS['lang']['rss_label_unfoldall'].'">'.$GLOBALS['lang']['rss_label_unfoldall'].'</button></li>'."\n";
$out_html .= "\t\t\t\t\t".'<li><button type="button" id="reloadFeeds" title="'.$GLOBALS['lang']['rss_label_reload'].'">'.$GLOBALS['lang']['rss_label_reload'].'</button></li>'."\n";
$out_html .= "\t\t\t\t\t".'<li><button type="button" id="refreshFeeds" title="'.$GLOBALS['lang']['rss_label_refresh'].'">'.$GLOBALS['lang']['rss_label_refresh'].'</button></li>'."\n";
$out_html .= "\t\t\t\t".'</ul>'."\n";
$out_html .= "\t\t\t\t".'<p><span id="post-counter"></span> '.$GLOBALS['lang']['label_elements'].'</p>'."\n";
$out_html .= "\t\t\t\t".'<div class="item-menu-options">'."\n";
$out_html .= "\t\t\t\t\t".'<ul>'."\n";
$out_html .= "\t\t\t\t\t\t".'<li><button type="button" onclick="goToUrl(\'maintenance.php#form_import\')">Import/export</button></li>'."\n";
$out_html .= "\t\t\t\t\t\t".'<li><button type="button" id="deleteOld">'.$GLOBALS['lang']['rss_label_clean'].'</button></li>'."\n";
$out_html .= "\t\t\t\t\t".'</ul>'."\n";
$out_html .= "\t\t\t\t".'</div>'."\n";
$out_html .= "\t\t\t".'</div>'."\n";
$out_html .= "\t\t\t".'<ul id="post-list">'."\n";
$out_html .= "\t\t\t\t".'<li id="" data-datetime="" data-id="" data-sitehash="" data-is-fav="" data-folder="" hidden>'."\n";
$out_html .= "\t\t\t\t\t".'<div class="post-head">'."\n";
$out_html .= "\t\t\t\t\t\t".'<a href="#" class="lien-fav"></a>'."\n";
$out_html .= "\t\t\t\t\t\t".'<div class="folder"></div>'."\n";
$out_html .= "\t\t\t\t\t\t".'<a href="#" title="" class="post-title" target="_blank" data-id=""></a>'."\n";
$out_html .= "\t\t\t\t\t\t".'<div class="meta">'."\n";
$out_html .= "\t\t\t\t\t\t\t".'<span class="site"></span><time class="date"></time>'."\n";
$out_html .= "\t\t\t\t\t\t\t".'<span class="share">'."\n";
$out_html .= "\t\t\t\t\t\t\t\t".'<a href="" target="_blank" class="lien-share"></a>'."\n";
$out_html .= "\t\t\t\t\t\t\t\t".'<a href="" target="_blank" class="lien-open"></a>'."\n";
$out_html .= "\t\t\t\t\t\t\t\t".'<a href="" target="_blank" class="lien-mail"></a>'."\n";
$out_html .= "\t\t\t\t\t\t\t".'</span>'."\n";
$out_html .= "\t\t\t\t\t\t".'</div>'."\n";
$out_html .= "\t\t\t\t\t".'</div>'."\n";
$out_html .= "\t\t\t\t\t".'<div class="rss-item-content"></div>'."\n";
$out_html .= "\t\t\t\t\t".'<hr class="clearboth">'."\n";
$out_html .= "\t\t\t\t".'</li>'."\n";
$out_html .= "\t\t\t\t".'</ul>'."\n";
$out_html .= "\t\t".'</div>'."\n";
$out_html .= "\t\t".'<div class="keyshortcut">'.$GLOBALS['lang']['rss_raccourcis_clavier'].'</div>'."\n";
$out_html .= "\t".'</div>'."\n";
// the edit popup
$out_html .= "\t".'<div id="popup-wrapper" hidden>'."\n";
$out_html .= "\t\t".'<form class="popup-edit-feed" hidden>'."\n";
$out_html .= "\t\t\t".'<div class="popup-title">'."\n";
$out_html .= "\t\t\t\t".'<button class="submit button-cancel" type="button"></button>'."\n";
$out_html .= "\t\t\t".'</div>'."\n";
$out_html .= "\t\t\t".'<div class="popup-content feed-content">'."\n";
$out_html .= "\t\t\t\t".'<div class="feed-content-error"></div>'."\n";
$out_html .= "\t\t\t\t".'<div class="feed-content-url">'."\n";
$out_html .= "\t\t\t\t\t".'<label for="feed-url"><input type="text" class="text" name="feed-url" value="" placeholder=" " /><span>'.$GLOBALS['lang']['rss_label_url_flux'].'</span></label>'."\n";
$out_html .= "\t\t\t\t".'</div>'."\n";
$out_html .= "\t\t\t\t".'<div class="feed-content-title">'."\n";
$out_html .= "\t\t\t\t\t".'<label for="feed-title"><input type="text" class="text" name="feed-title" value="" placeholder=" " /><span>'.$GLOBALS['lang']['rss_label_titre_flux'].'</span></label>'."\n";
$out_html .= "\t\t\t\t".'</div>'."\n";
$out_html .= "\t\t\t\t".'<div class="feed-content-folder">'."\n";
$out_html .= "\t\t\t\t\t".'<label for="feed-folder"><input type="text" class="text" name="feed-folder" value="" placeholder=" " /><span>'.$GLOBALS['lang']['rss_label_dossier'].'</span></label>'."\n";
$out_html .= "\t\t\t\t".'</div>'."\n";
$out_html .= "\t\t\t\t".'<div class="feed-content-lastpost"><span>DERNIER POST : </span><time></time></div>'."\n";
$out_html .= "\t\t\t".'</div>'."\n";
$out_html .= "\t\t\t".'<div class="popup-footer feed-footer">'."\n";
$out_html .= "\t\t\t\t".'<button class="submit button-delete" type="button" name="supprimer">'.$GLOBALS['lang']['supprimer'].'</button>'."\n";
$out_html .= "\t\t\t\t".'<button class="submit button-submit" type="button" name="editer">'.$GLOBALS['lang']['enregistrer'].'</button>'."\n";
$out_html .= "\t\t\t".'</div>'."\n";
$out_html .= "\t\t".'</form>'."\n";
$out_html .= "\t".'</div>'."\n";

// (+) button
$out_html .= "\t".'<button type="button" id="fab" class="add-feed" title="'.$GLOBALS['lang']['rss_label_config'].'">'.$GLOBALS['lang']['rss_label_addfeed'].'</button>'."\n";
$out_html .= "\t".'<span id="popup-notif"><span id="count-posts"><span id="counter"></span></span><span id="message-return"></span></span>'."\n";

// get list of posts from DB
// send to browser
//$out_html .= send_rss_json($tableau, true, false);
$out_html .= php_lang_to_js();
$out_html .=  "\n".'<script src="style/scripts/javascript.js"></script>'."\n";
$out_html .=  "\n".'<script>'."\n";
$out_html .=  'var token = \''.new_token().'\';'."\n";
$out_html .=  'new RssReader();'."\n";
$out_html .=  'var scrollPos = 0;'."\n";

$out_html .=  "\n".'</script>'."\n";

echo $out_html;

footer($begin);
