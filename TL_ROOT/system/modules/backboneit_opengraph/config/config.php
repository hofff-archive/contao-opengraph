<?php

$GLOBALS['BE_MOD']['design']['page']['bbit_og_facebookLint'] = array('ContaoOpenGraphBackend', 'keyFacebookLint');

$GLOBALS['TL_HOOKS']['generatePage'][] = array('ContaoOpenGraphFrontend', 'inject');

$GLOBALS['BBIT_OG']['TYPES'][] = 'website';
$GLOBALS['BBIT_OG']['TYPES'][] = 'article';
$GLOBALS['BBIT_OG']['TYPES'][] = 'profile';
$GLOBALS['BBIT_OG']['TYPES'][] = 'book';
$GLOBALS['BBIT_OG']['TYPES'][] = 'music.song';
$GLOBALS['BBIT_OG']['TYPES'][] = 'music.album';
$GLOBALS['BBIT_OG']['TYPES'][] = 'music.playlist';
$GLOBALS['BBIT_OG']['TYPES'][] = 'music.radio_station';
$GLOBALS['BBIT_OG']['TYPES'][] = 'video.movie';
$GLOBALS['BBIT_OG']['TYPES'][] = 'video.episode';
$GLOBALS['BBIT_OG']['TYPES'][] = 'video.tv_show';
$GLOBALS['BBIT_OG']['TYPES'][] = 'video.other';
