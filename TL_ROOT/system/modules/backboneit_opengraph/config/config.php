<?php

$GLOBALS['BE_MOD']['system']['backboneit_opengraph_types'] = array(
	'tables' => array('tl_backboneit_opengraph_types'),
	'icon' => 'system/modules/backboneit_opengraph/images/og.png'
);
//$GLOBALS['TL_CTE']['backboneit']['backboneit_opengraph'] = 'ContentOpenGraph';

$GLOBALS['TL_HOOKS']['generatePage'][] = array('OpenGraphInjector', 'generatePageOG');
$GLOBALS['TL_HOOKS']['generatePage'][] = array('OpenGraphInjector', 'inject');
$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array('OpenGraphInjector', 'injectNS');
