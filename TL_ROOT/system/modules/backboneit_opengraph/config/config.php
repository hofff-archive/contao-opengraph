<?php

$GLOBALS['BE_MOD']['system']['bbit_og_types'] = array(
	'tables' => array('tl_bbit_og_types'),
	'icon' => 'system/modules/backboneit_opengraph/html/images/og.png'
);
//$GLOBALS['TL_CTE']['backboneit']['backboneit_opengraph'] = 'ContentOpenGraph';

$GLOBALS['TL_HOOKS']['generatePage'][] = array('OpenGraphInjector', 'generatePageOG');
$GLOBALS['TL_HOOKS']['generatePage'][] = array('OpenGraphInjector', 'inject');
$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array('OpenGraphInjector', 'injectNS');
