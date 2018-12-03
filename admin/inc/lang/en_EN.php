<?php
// *** LICENSE ***
// oText is free software.
//
// By Fred Nassar (2006) and Timo Van Neerden (since 2010)
// See "LICENSE" file for info.
// *** LICENSE ***

/* ##############################################################################################
   ----------------------------------------- Francais -----------------------------------------*/

$GLOBALS['lang'] = array_merge($GLOBALS['lang'], array(
'id'							=> 'en',

// Navigation
'preferences'					=> 'Settings',
'connexion' 					=> 'Connection',
'enregistrer' 					=> 'Save',
'valider'	 					=> 'Submit',
'annuler'	 					=> 'Cancel',
'editer' 						=> 'Edit',
'activer'	 					=> 'Activate',
'desactiver'	 				=> 'Desactivate',
'mesarticles' 					=> 'My articles',
'mesliens'	 					=> 'My links',
'mesnotes'	 					=> 'My notes',
'mesabonnements'				=> 'My subscriptions',
'monagenda'						=> 'My agenda',
'nouveau' 						=> 'New article',
'supprimer' 					=> 'Delete',
'telecharger' 					=> 'Download',
'deconnexion' 					=> 'Logout',
'oui' 							=> 'Yes',
'non' 							=> 'No',
'ouverts' 						=> 'Open',
'fermes' 						=> 'Closed',
'sur' 							=> 'on',
'ou'							=> 'or',
'label_creee_le'				=> 'created on',
'voir_sur_le_blog'				=> 'See online',
'byte_symbol'					=> 'B',
'using'							=> 'with',
'rendered'						=> 'generated in',
'recherche'						=> 'Search result for',

// Install
'install'						=> 'Installation',
'install_id'					=> 'Choose an username: ',
'install_mdp'					=> 'Choose a password: ',
'install_choose_sgdb'			=> 'Choose your DBMS: ',
'install_err_mysql_usr_empty'	=> 'MySQL Username is empty.',
'install_err_mysql_pss_empty'	=> 'MySQL Password is empty.',
'install_err_mysql_hst_empty'	=> 'MySQL Hostname is empty.',
'install_err_mysql_dba_empty'	=> 'MySQL DB-name is empty',
'install_err_mysql_connect'		=> 'BlogoText is unable to connect to MySQL with these informations.',
'first_titre' 					=> 'My first Blogpost',
'first_edit' 					=> 'Edit me',

// Questions
'question_suppr_article'		=> 'This article and its comments will be deleted!',
'question_suppr_image'			=> 'This image will be deleted!',
'question_suppr_comment'		=> 'This comment will be deleted!',
'question_suppr_fichier'		=> 'This file will be deleted!',
'question_suppr_note'			=> 'This note will be deleted!',
'question_suppr_event'			=> 'This event will be deleted!',
'question_quit_page'			=> 'Leaving this page will have your unsaved modifications lost. Ok?',
'question_clean_rss'			=> 'All the read items will be removed from database, OK?',
'question_show_past_events'		=> 'Display past events?',
'question_entire_day'			=> 'Entire day?',

// Confirmations
'confirm_article_suppr'			=> 'Article has ben deleted',
'confirm_article_ajout'			=> 'Article has been saved',
'confirm_article_maj'			=> 'Article has been updated',
'confirm_fichier_ajout'			=> 'File has been added',
'confirm_fichier_suppr'			=> 'File has been removed',
'confirm_fichier_edit'			=> 'File infos have been edited',
'confirm_prefs_maj'				=> 'Settings have been saved',
'confirm_comment_ajout'			=> 'Comment has been added',
'confirm_comment_suppr'			=> 'Comment has been deleted',
'confirm_comment_edit'			=> 'Comment has been edited',
'confirm_comment_valid'			=> 'Comment status has been edited',
'confirm_link_ajout'			=> 'Link has been added',
'confirm_link_suppr'			=> 'Link has been removed',
'confirm_link_edit'				=> 'Link has been updated',
'confirm_feed_update'			=> 'The feeds have been updated',
'confirm_feeds_edit'			=> 'The feeds have been edited.',
'confirm_feed_ajout'			=> 'The feed has been added.',
'confirm_feed_clean'			=> 'All old feeds have removed.',
'confirm_note_enregistree'		=> 'Notes have been saved.',
'confirm_agenda_updated'		=> 'Agenda has been updated.',

// No-confirmation
'error_image_add'				=> 'File could not have been added',
'error_phpajax'					=> 'Some PHP/Ajax Error happened:',
'error_comment_suppr'			=> 'The comment has not been deleted since an error happened.',
'error_comment_valid'			=> 'The status has not been changed since an error happened.',

// Redirections
'retour_liste'					=> '« Articles list',

// Titres des pages
'bienvenue'						=> 'Welcome',
'titre_identification' 			=> 'Identification',
'titre_articles' 				=> 'Your articles',
'titre_ecrire' 					=> 'Write a new article',
'titre_maj' 					=> 'Update an article',
'titre_commentaires' 			=> 'Comments',
'titre_preferences' 			=> 'Seetings',
'titre_fichier'					=> 'Files',
'titre_maintenance'				=> 'Maintenance',

// Preferences
'prefs_legend_utilisateur'		=> 'User',
'prefs_legend_apparence'		=> 'Appearance',
'prefs_legend_securite'			=> 'Security',
'prefs_legend_langdateheure'	=> 'Language, date &amp; time',
'prefs_legend_configblog'		=> 'Blog &amp; comments',
'prefs_legend_configlinx'		=> 'Links',
'prefs_legend_configrss'		=> 'RSS Feeds',
'pref_auteur'					=> 'Author: ',
'pref_email'					=> 'E-mail address: ',
'pref_identifiant'				=> 'Login: ',
'pref_mdp'						=> 'Actual password: ',
'pref_mdp_nouv'					=> 'New password: ',
'pref_langue'					=> 'Language: ',
'pref_nom_site'					=> 'Site name: ',
'pref_keywords'					=> 'Keywords: ',
'pref_format_date'				=> 'Date format: ',
'pref_format_heure'				=> 'Time format: ',
'pref_racine'					=> 'Blog’s URL: ',
'pref_nb_maxi'					=> 'Amount of articles on homepage: ',
'pref_nb_list'					=> 'Amount of articles on admin list: ',
'pref_nb_list_com'				=> 'Amount of comments on admin list: ',
'pref_nb_list_linx'				=> 'Amount of links on admin list: ',
'pref_fuseau_horaire'			=> 'Timezone: ',
'pref_comm_BoW_list'			=> 'Comments are visible: ',
'pref_comm_white_list'			=> 'Only after you approved them.',
'pref_comm_black_list'			=> 'As soon as they are submited.',
'pref_automatic_keywords'		=> 'Let BlogoText select keywords: ',
'pref_force_email'				=> 'Email is required to comment: ',
'pref_theme'					=> 'Theme: ',
'pref_categories'				=> 'Use tags for articles: ',
'pref_allow_global_coms'		=> 'Close comments on every article: ',
'pref_all'						=> 'All',
'pref_go_to_maintenance'		=> 'Go on maintenance page: ',
'pref_rss_go_to_imp-export'		=> 'Access OPML import/export utility: ',
'pref_label_bookmark_lien'		=> 'Links sharing bookmarklet: ',
'pref_label_crontab_rss'		=> '"Crontab" command for auto updates: ',
'pref_alert_crontab_rss'		=> 'Add this command to your crontab:',
'pref_linx_dl_auto'				=> 'Automaticaly import shared files?',
'pref_ask_everytime'			=> 'Ask each time',
'pref_check_update'				=> 'Check updates automatically',
'pref_id_format'				=> 'Articles URL format:',
'pref_id_format_ymdhis'			=> 'Date-like: '.date('YmdHis'),
'pref_id_format_rand6'			=> 'Random string: -ebd68b-',
'maintenance_optim'				=> 'Cleanup database',

// placeholders
'placeholder_nom_fichier'		=> 'name',
'placeholder_description'		=> 'description',
'placeholder_titre'				=> 'title',
'placeholder_chapo'				=> 'abstract',
'placeholder_notes'				=> 'notes',
'placeholder_contenu'			=> 'content',
'placeholder_motscle'			=> 'keywords',
'placeholder_folder'			=> 'folder',
'placeholder_tags'				=> 'tags',
'placeholder_url'				=> 'url',

// Notes
'note_no_note'					=> 'No notes',
'note_no_event'					=> 'No events',
'note_no_image'					=> 'No images',
'note_no_fichier'				=> 'No files',
'note_no_feed'					=> 'No RSS feed',
'note_no_feed_entry'			=> 'No RSS entry',
'note_no_notifs'				=> 'No notification',

//Formulaire Images
'label_jusqua'					=> 'Up to',
'label_parfichier'				=> ' per file',
'label_codes'			    	=> 'Integration codes:',
'img_upload'					=> 'Sens',
'img_specifier_url'				=> 'From URL',
'img_upload_un_fichier'			=> 'Upload one file',
'img_drop_files_here'			=> 'Drop files here',

// page backup
'bak_succes_save'				=> 'Backup succeded',
'maintenance_ask_do_what'		=> 'What do you want to do?',
'maintenance_export'			=> 'Export',
'maintenance_incl_quoi'			=> 'What do you want in your backup?',
'maintenance_import'			=> 'Import',
'bak_chooseaction'				=> 'What do you want to do?',
'bak_choosefile'				=> 'Choose a file',
'bak_restor_done'				=> 'restoration done',
'bak_optim_done'				=> 'Cleaning done',
'bak_articles_do'				=> 'Include articles',
'bak_comments_do'				=> 'Include comments from articles',
'bak_links_do'					=> 'Include links',
'bak_notes_do'					=> 'Include notes',
'bak_agenda_do'					=> 'Include agenda',
'bak_number_articles'			=> 'How many articles?',
'bak_combien_images'			=> 'How many files?',
'bak_combien_linx'				=> 'How many links?',
'bak_import_btjson'				=> 'Import a JSON backup from Blogotext',
'bak_import_netscape'			=> 'Import links from a Netscape file',
'bak_import_rssopml'			=> 'Import an OPML RSS feeds list',
'bak_export_json'				=> 'Export various data in a JSON file',
'bak_export_netscape'			=> 'Export your links in a HTML bookmark file',
'bak_export_zip'				=> 'Export your database &amp; other files in a zip-file',
'bak_export_opml'				=> 'EXPORT your RSS feeds in an OPML file',
'bak_incl_sqlit'				=> 'Include SQLite file',
'bak_incl_confi'				=> 'Include configuration files',
'bak_incl_files'				=> 'Include images and files',
'bak_incl_theme'				=> 'Include theme files',
'bak_opti_miniature'			=> 'Recreate image thumbnails',
'bak_opti_vacuum'				=> 'Rebuilt/Clean up database',
'bak_opti_recountcomm'			=> 'Rebuilt/Recount articles comments',
'bak_opti_supprreadrss'			=> 'Remove read RSS items',
'bak_dl_fichier'				=> 'Download file.',

// page RSS
'rss_label_all_feeds'			=> 'All feeds',
'rss_label_today_feeds'			=> 'Today',
'rss_label_favs_feeds'			=> 'Bookmarks',
'rss_label_refresh'				=> 'Refresh',
'rss_label_markasread'			=> 'Mark as read',
'rss_label_unfoldall'			=> 'Unfold all',
'rss_label_addfeed'				=> 'Add a feed',
'rss_label_clean'				=> 'Clean',
'rss_label_unread'				=> 'Unread',
'rss_label_titre_flux'			=> 'Feed Title:',
'rss_label_url_flux'			=> 'Feed Link:',
'rss_label_dossier'				=> 'Folder (optional) :',
'rss_label_config'				=> 'Edit feed list',
'rss_nothing_here_note'			=> 'Nothing here? Import an OPML file here: ',
'rss_jsalert_new_link'			=> 'RSS/Atom complete link:',
'rss_jsalert_new_link_folder'	=> 'Put feed in folder (or leave empty):',
'rss_raccourcis_clavier'		=> 'Ctrl+Up = Read previous entry, Ctrl+Down = Read next entry.',
'rss_nouveau_flux'				=> 'new entries.',

// vérifier les mises à jours
'maint_chk_update'				=> 'Updates',
'maint_update_youisgood'		=> 'BlogoText is up to date',
'maint_update_youisbad'			=> 'A new version of BlogoText is available!',
'maint_update_go_dl_it'			=> 'You can download it at:',

// Erreurs
'err_titre' 					=> 'Title is empty',
'err_file_write'				=> 'Can’t create file',
'err_prefs_auteur'				=> 'Author name is empty',
'err_prefs_email'				=> 'Email is incorrect',
'err_prefs_identifiant'			=> 'Username is empty',
'err_prefs_id_mdp'				=> 'To change username, yo have to type your password',
'err_prefs_id_syntaxe'			=> 'The new username can’t contain any \', ", \\, | or = characters.',
'err_prefs_oldmdp'				=> 'Old password is wrong',
'err_prefs_mdp'					=> 'Password must be longer than 6 caracters',
'err_prefs_mdp_weak'			=> 'Password is weak, ok?',
'err_prefs_newmdp'				=> 'To change password, you have to type your old password',
'err_prefs_nbmax'				=> 'Amount of articles is wrong',
'err_prefs_racine'				=> 'You have to give an URL for the blog',
'err_prefs_racine_http'			=> 'URL has to begin with "http://" or "https://"',
'err_prefs_racine_slash'		=> 'URL must end with  "/"',
'err_lien_vide'					=> 'URL is empty',
'err_feed_exists'				=> 'Feed alreday exists.',
'err_feed_wrong_param'			=> 'Wrong request.',

// Titles - liens
'lien_article'					=> 'See online',
'lien_blog'						=> 'Watch online',
'go_to_pref'					=> 'Go to the settings to change description.',

// Label avec ": "
'label_dp_description'			=> 'Description: ',
'label_dp_type'					=> 'Type (extension): ',
'label_dp_dossier'				=> 'Directory: ',
'label_dp_date'					=> 'Date: ',
'label_dp_dimensions'			=> 'Dimentions: ',
'label_dp_visibilite'			=> 'Visibility: ',
'label_dp_etat'					=> 'Visibility: ',
'label_dp_commentaires'			=> 'Comments: ',
'label_dp_poids'				=> 'Filesize: ',
'label_dp_checksum'				=> 'Sha1: ',
'label_dp_identifiant'			=> 'Username: ',
'label_dp_motdepasse'			=> 'Password: ',

// Modes
'ecrire'						=> 'Edit: ',
'apercu'						=> 'Preview',

// Labels
'label_date'					=> 'Date',
'label_titre'					=> 'Title',
'label_contenu'					=> 'Content',
'label_description'				=> 'Description',
'label_publie'					=> 'Published',
'label_publies'					=> 'Published',
'label_invisible'				=> 'Invisible',
'label_invisibles'				=> 'Invisible',
'label_note_ajout'				=> 'Add a note',
'label_feed_ajout'				=> 'Add a feed',
'label_event_ajout'				=> 'Add an event',
'label_add_title'				=> 'Add a title',
'label_add_location'			=> 'Add a location',
'label_add_description'			=> 'Add a description',
'label_feed_new'				=> 'New fedd',
'label_article_derniers'		=> 'Last articles',
'label_comment_derniers'		=> 'Last comments',
'label_link_derniers'			=> 'Last links',
'label_note_derniers'			=> 'Last notes',
'label_fichier_derniers'		=> 'Last files',
'label_link'					=> 'link',
'label_links'					=> 'links',
'label_element'					=> 'element',
'label_elements'				=> 'elements',
'label_image'					=> 'image',
'label_images'					=> 'images',
'label_feeds'					=> 'feeds',
'label_feed_entry'				=> 'feed entry',
'label_feed_entrys'				=> 'feed entries',
'label_import-export'			=> 'Import/Export',
'label_fichier'					=> 'file',
'label_fichiers'				=> 'files',
'label_note'					=> 'Note',
'label_notes'					=> 'Notes',
'label_agenda'					=> 'Agenda',
'label_event'					=> 'Event',
'label_events'					=> 'Events',
'label_nouv_lien'				=> 'Add a link…',
'label_lien_priv'				=> 'Link is private?',
'label_file_priv'				=> 'File is private?',
'label_stay_logged'				=> 'Stay connected?',
'label_resume'					=> 'Home',
'label_dl_fichier'				=> 'Also import file localy? ',
'label_all_comm_by_author'		=> 'All comments by this author',
'label_planned'					=> 'planned',

));
