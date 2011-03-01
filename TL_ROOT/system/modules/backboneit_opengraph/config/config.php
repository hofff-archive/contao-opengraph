<?php

$GLOBALS['BE_MOD']['system']['opengraph_types'] = array(
	'tables' => array('tl_opengraph_types')
);
//$GLOBALS['TL_CTE']['backboneit']['backboneit_opengraph'] = 'ContentOpenGraph';

$GLOBALS['TL_HOOKS']['generatePage'][] = array('OpenGraphInjector', 'generatePageOG');
$GLOBALS['TL_HOOKS']['generatePage'][] = array('OpenGraphInjector', 'inject');
$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array('OpenGraphInjector', 'injectNS');
