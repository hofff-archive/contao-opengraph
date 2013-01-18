<?php

//$GLOBALS['TL_CTE']['backboneit']['backboneit_opengraph'] = 'ContentOpenGraph';

//$GLOBALS['TL_HOOKS']['generatePage'][] = array('OpenGraphManager', 'generatePageOG');
//$GLOBALS['TL_HOOKS']['generatePage'][] = array('OpenGraphManager', 'inject');

$GLOBALS['BBIT_OG']['TYPES']['general'][] = 'custom';
$GLOBALS['BBIT_OG']['TYPES']['general'][] = 'website';
$GLOBALS['BBIT_OG']['TYPES']['general'][] = 'article';
$GLOBALS['BBIT_OG']['TYPES']['general'][] = 'profile';
$GLOBALS['BBIT_OG']['TYPES']['general'][] = 'book';
$GLOBALS['BBIT_OG']['TYPES']['audio'][] = 'audio.song';
$GLOBALS['BBIT_OG']['TYPES']['audio'][] = 'audio.album';
$GLOBALS['BBIT_OG']['TYPES']['audio'][] = 'audio.playlist';
$GLOBALS['BBIT_OG']['TYPES']['audio'][] = 'audio.radio_station';
$GLOBALS['BBIT_OG']['TYPES']['video'][] = 'video.movie';
$GLOBALS['BBIT_OG']['TYPES']['video'][] = 'video.episode';
$GLOBALS['BBIT_OG']['TYPES']['video'][] = 'video.tv_show';
$GLOBALS['BBIT_OG']['TYPES']['video'][] = 'video.other';
