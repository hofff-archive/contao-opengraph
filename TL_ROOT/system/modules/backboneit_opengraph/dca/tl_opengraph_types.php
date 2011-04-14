<?php

$GLOBALS['TL_DCA']['tl_opengraph_types'] = array(
	'config' => array(
		'dataContainer'		=> 'Table',
	),
	
	'list' => array(
		'sorting' => array(
			'mode'		=> 1,
			'fields'	=> array('label'),
			'flag'		=> 1
		),
		'label' => array(
			'fields'	=> array('label', 'prefix', 'name', 'namespace'),
			'format'	=> '<strong>%s</strong> %s:%s <span style="color:#b3b3b3; padding-left:3px;">[%s]</span>'
		),
		'global_operations' => array(
			'all' => array(
				'label'		=> &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'		=> 'act=select',
				'class'		=> 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array(
			'edit' => array(
				'label'	=> &$GLOBALS['TL_LANG']['tl_opengraph_types']['edit'],
				'href'	=> 'act=edit',
				'icon'	=> 'edit.gif'
			),
			'copy' => array(
				'label'	=> &$GLOBALS['TL_LANG']['tl_opengraph_types']['copy'],
				'href'	=> 'act=copy',
				'icon'	=> 'copy.gif'
			),
			'delete' => array(
				'label'	=> &$GLOBALS['TL_LANG']['tl_opengraph_types']['delete'],
				'href'	=> 'act=delete',
				'icon'	=> 'delete.gif'
			),
			'show' => array(
				'label'	=> &$GLOBALS['TL_LANG']['tl_opengraph_types']['show'],
				'href'	=> 'act=show',
				'icon'	=> 'show.gif'
			)
		)
	),

	
	'palettes' => array(
		'default'	=> '{opengraph_types_legend},label,prefix,name,namespace'
	),

	'fields' => array(
		'label' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_opengraph_types']['label'],
			'inputType'		=> 'text',
			'eval'			=> array(
				'unique'		=> true,
				'maxlength'		=> 255,
				'tl_class'		=> 'clr w50'
			)
		),
		'prefix' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_opengraph_types']['prefix'],
			'inputType'		=> 'text',
			'save_callback'	=> array(
				array('OpenGraphDCA', 'validateNCName')
			),
			'eval'			=> array(
				'mandatory'		=> true,
				'maxlength'		=> 16,
				'tl_class'		=> 'clr w50'
			)
		),
		'name' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_opengraph_types']['name'],
			'inputType'		=> 'text',
			'save_callback'	=> array(
				array('OpenGraphDCA', 'validateNCName')
			),
			'eval'			=> array(
				'mandatory'		=> true,
				'maxlength'		=> 255,
				'tl_class'		=> 'w50'
			)
		),
		'namespace' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_opengraph_types']['namespace'],
			'inputType'		=> 'text',
			'eval'			=> array(
				'mandatory'		=> true,
				'maxlength'		=> 1022,
				'rpgx'			=> 'url',
				'tl_class'		=> 'clr long'
			)
		)
	)
	
);