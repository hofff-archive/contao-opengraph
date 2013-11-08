<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Backboneit_opengraph
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'AbstractOpenGraphData'   => 'system/modules/backboneit_opengraph/AbstractOpenGraphData.php',
	'ContaoOpenGraphBackend'  => 'system/modules/backboneit_opengraph/ContaoOpenGraphBackend.php',
	'ContaoOpenGraphFactory'  => 'system/modules/backboneit_opengraph/ContaoOpenGraphFactory.php',
	'ContaoOpenGraphFrontend' => 'system/modules/backboneit_opengraph/ContaoOpenGraphFrontend.php',
	'OpenGraphBasicData'      => 'system/modules/backboneit_opengraph/OpenGraphBasicData.php',
	'OpenGraphData'           => 'system/modules/backboneit_opengraph/OpenGraphData.php',
	'OpenGraphImageData'      => 'system/modules/backboneit_opengraph/OpenGraphImageData.php',
	'OpenGraphProperty'       => 'system/modules/backboneit_opengraph/OpenGraphProperty.php',
	'OpenGraphProtocol'       => 'system/modules/backboneit_opengraph/OpenGraphProtocol.php',
	'OpenGraphType'           => 'system/modules/backboneit_opengraph/OpenGraphType.php',
));
