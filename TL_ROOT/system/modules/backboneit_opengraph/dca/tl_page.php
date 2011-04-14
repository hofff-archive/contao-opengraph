<?php

$ns = 'backboneit_opengraph';

$this->loadLanguageFile($ns);

foreach(array('regular', 'root') as $strKey) {
	$GLOBALS['TL_DCA']['tl_page']['palettes'][$strKey] = preg_replace(
		'@(\{meta_legend\}[^;]*;)@',
		'$1{backboneit_opengraph_legend},backboneit_opengraph_handdown,backboneit_opengraph;',
		$GLOBALS['TL_DCA']['tl_page']['palettes'][$strKey]
	);
}

$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'backboneit_opengraph';
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['backboneit_opengraph']
	= 'backboneit_opengraph_title,backboneit_opengraph_type,'
	. 'backboneit_opengraph_description,backboneit_opengraph_image,'
	
	// address
	. 'backboneit_opengraph_street,backboneit_opengraph_geo,'
	. 'backboneit_opengraph_postal,backboneit_opengraph_locality,'
	. 'backboneit_opengraph_region,backboneit_opengraph_country,'
	
	// contact
	. 'backboneit_opengraph_email,'
	. 'backboneit_opengraph_phone,backboneit_opengraph_fax,'
	
	// video
	. 'backboneit_opengraph_video,backboneit_opengraph_videodim,'
	
	// audio
	. 'backboneit_opengraph_audio,backboneit_opengraph_audiotitle,'
	. 'backboneit_opengraph_audioartist,backboneit_opengraph_audioalbum,'
	
	. 'backboneit_opengraph_isbn,backboneit_opengraph_upc';
	
	
$GLOBALS['TL_DCA']['tl_page']['fields'] = array_merge($GLOBALS['TL_DCA']['tl_page']['fields'], array(
	'backboneit_opengraph_handdown' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['opengraph_handdown'],
		'exclude'		=> true,
		'inputType'		=> 'checkbox',
		'eval'			=> array(
			'tl_class'			=> 'clr w50 cbx'
		)
	),
	'backboneit_opengraph' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['opengraph'],
		'exclude'		=> true,
		'inputType'		=> 'checkbox',
		'eval'			=> array(
			'submitOnChange'	=> true,
			'tl_class'			=> 'w50 cbx'
		)
	),
	'backboneit_opengraph_title' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['title'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 255,
			'tl_class'			=> 'clr w50'
		)
	),
	'backboneit_opengraph_type' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['type'],
		'exclude'		=> true,
		'inputType'		=> 'select',
		'default'		=> 'website',
		'options_callback' => array('OpenGraphDCA', 'getTypeOptions'),
		'reference'		=> &$GLOBALS['TL_LANG'][$ns]['type_labels'],
		'eval'			=> array(
			'mandatory'			=> true,
			'tl_class'			=> 'w50'
		)
	),
	'backboneit_opengraph_description' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['description'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 1022,
			'tl_class'			=> 'clr long'
		)
	),
	'backboneit_opengraph_image' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['image'],
		'exclude'		=> true,
		'inputType'		=> 'fileTree',
		'eval'			=> array(
			'mandatory'			=> true,
			'files'				=> true,
			'filesOnly'			=> true,
			'extensions'		=> 'jpg,jpeg,gif,png',
			'fieldType'			=> 'radio',
			'tl_class'			=> 'clr'
		)
	),
	'backboneit_opengraph_street' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['street'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 255,
			'tl_class'			=> 'clr w50'
		)
	),
	'backboneit_opengraph_geo' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['geo'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 100,
			'multiple'			=> true,
			'size'				=> 2,
			'rgxp'				=> 'digit',
			'tl_class'			=> 'w50'
		)
	),
	'backboneit_opengraph_postal' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['postal'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 255,
			'tl_class'			=> 'clr w50'
		)
	),
	'backboneit_opengraph_locality' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['locality'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 255,
			'tl_class'			=> 'w50'
		)
	),
	'backboneit_opengraph_region' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['region'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 255,
			'tl_class'			=> 'clr w50'
		)
	),
	'backboneit_opengraph_country' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['country'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 255,
			'tl_class'			=> 'w50'
		)
	),
	'backboneit_opengraph_email' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['email'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 255,
			'rgxp'				=> 'email',
			'tl_class'			=> 'clr w50'
		)
	),
	'backboneit_opengraph_phone' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['phone'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 255,
			'rgxp'				=> 'phone',
			'tl_class'			=> 'clr w50'
		)
	),
	'backboneit_opengraph_fax' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['fax'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 255,
			'rgxp'				=> 'phone',
			'tl_class'			=> 'w50'
		)
	),
	'backboneit_opengraph_video' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['video'],
		'exclude'		=> true,
		'inputType'		=> 'fileTree',
		'eval'			=> array(
			'files'				=> true,
			'filesOnly'			=> true,
			'extensions'		=> 'flv,swf,mp4',
			'fieldType'			=> 'radio',
			'tl_class'			=> 'clr'
		)
	),
	'backboneit_opengraph_videodim' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['videoDim'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'save_callback'	=> array(
			array('OpenGraphDCA', 'validateDimension')
		),
		'eval'			=> array(
			'maxlength'			=> 100,
			'multiple'			=> true,
			'size'				=> 2,
			'rgxp'				=> 'digit',
			'tl_class'			=> 'clr w50'
		)
	),
	'backboneit_opengraph_audio' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['audio'],
		'exclude'		=> true,
		'inputType'		=> 'fileTree',
		'eval'			=> array(
			'files'				=> true,
			'filesOnly'			=> true,
			'extensions'		=> 'mp3',
			'fieldType'			=> 'radio',
			'tl_class'			=> 'clr'
		)
	),
	'backboneit_opengraph_audiotitle' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['audioTitle'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 255,
			'tl_class'			=> 'clr w50'
		)
	),
	'backboneit_opengraph_audioartist' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['audioArtist'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 255,
			'tl_class'			=> 'w50'
		)
	),
	'backboneit_opengraph_audioalbum' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['audioAlbum'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 255,
			'tl_class'			=> 'clr w50'
		)
	),
	'backboneit_opengraph_isbn' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['isbn'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 255,
			'tl_class'			=> 'clr w50'
		)
	),
	'backboneit_opengraph_upc' => array(
		'label'			=> &$GLOBALS['TL_LANG'][$ns]['upc'],
		'exclude'		=> true,
		'inputType'		=> 'text',
		'eval'			=> array(
			'maxlength'			=> 255,
			'tl_class'			=> 'w50'
		)
	)
));