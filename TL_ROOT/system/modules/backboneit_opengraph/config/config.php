<?php

$GLOBALS['TL_HOOKS']['generatePage'][] = array('ContaoOpenGraphManager', 'inject');

$GLOBALS['BBIT_OG']['TYPES'][] = new OpenGraphType('website');
$GLOBALS['BBIT_OG']['TYPES'][] = new OpenGraphType('article');
$GLOBALS['BBIT_OG']['TYPES'][] = new OpenGraphType('profile');
$GLOBALS['BBIT_OG']['TYPES'][] = new OpenGraphType('book');
$GLOBALS['BBIT_OG']['TYPES'][] = new OpenGraphType('music.song');
$GLOBALS['BBIT_OG']['TYPES'][] = new OpenGraphType('music.album');
$GLOBALS['BBIT_OG']['TYPES'][] = new OpenGraphType('music.playlist');
$GLOBALS['BBIT_OG']['TYPES'][] = new OpenGraphType('music.radio_station');
$GLOBALS['BBIT_OG']['TYPES'][] = new OpenGraphType('video.movie');
$GLOBALS['BBIT_OG']['TYPES'][] = new OpenGraphType('video.episode');
$GLOBALS['BBIT_OG']['TYPES'][] = new OpenGraphType('video.tv_show');
$GLOBALS['BBIT_OG']['TYPES'][] = new OpenGraphType('video.other');
