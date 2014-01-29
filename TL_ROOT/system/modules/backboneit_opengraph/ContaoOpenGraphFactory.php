<?php

use Contao\FilesModel;

class ContaoOpenGraphFactory extends Controller {

	public static function create() {
		return new self();
	}

	public function __construct() {
		parent::__construct();
		$this->import('Database');
	}

	public function generateBasicDataByPageID($intID) {
		$objOGBD = new OpenGraphBasicData();
		$objPage = $objOrigin = $this->getPageDetails($intID);
		if(!$objPage) {
			return $objOGBD;
		}

		$arrModes = array('bbit_og_tree');
		$arrTrail = $objPage->trail;

		switch($objPage->bbit_og) {
			case 'bbit_og_disablePage':
			case 'bbit_og_disableTree':
				return $objOGBD;
				break;

			case 'bbit_og_page':
			case 'bbit_og_tree':
				// data in current page available
				break;

			case 'bbit_og_root':
				$arrTrail = array_slice($arrTrail, 0, 1);
			case 'bbit_og_parent':
				$arrModes[] = 'bbit_og_page';
				unset($objPage);
				break;

			default:
				$arrModes[] = 'bbit_og_disableTree';
				unset($objPage);
				break;
		}

		if(!$objPage) {
			$strTrailWildcards = rtrim(str_repeat('?,', count($arrTrail)), ',');
			$strModeWildcards = rtrim(str_repeat('?,', count($arrModes)), ',');
			$arrTrailSet = array(implode(',', $arrTrail));
			$objPage = $this->Database->prepare(
				'SELECT	p.*
				FROM	tl_page AS p
				WHERE	p.id IN (' . $strTrailWildcards . ')
				AND		p.bbit_og IN (' . $strModeWildcards . ')
				AND		(p.bbit_og != \'bbit_og_disableTree\' OR FIND_IN_SET(p.id, ?) > (
							SELECT	COALESCE(MAX(FIND_IN_SET(p2.id, ?)), -1)
							FROM	tl_page AS p2
							WHERE	p2.id IN (' . $strTrailWildcards . ')
							AND		p2.bbit_og = \'bbit_og_parent\'
						))
				ORDER BY FIND_IN_SET(p.id, ?) DESC
				LIMIT	1'
			)->execute(array_merge(
				$arrTrail,
				$arrModes,
				$arrTrailSet,
				$arrTrailSet,
				$arrTrail,
				$arrTrailSet
			));
		}

		if(!$objPage || (!($objPage instanceof \Model) && !$objPage->numRows) || $objPage->bbit_og == 'bbit_og_disableTree') {
			return $objOGBD;
		}


		if(strlen($objPage->bbit_og_title)) {
			$strTitle = $this->replaceInsertTags($objPage->bbit_og_title);
		} elseif(strlen($objOrigin->pageTitle)) {
			$strTitle = $objOrigin->pageTitle;
		} else {
			$strTitle = strip_tags($objOrigin->title);
		}
		$objOGBD->setTitle($strTitle);

		if(strlen($objPage->bbit_og_type)) {
			list($strNamespace, $strType) = explode(' ', $objPage->bbit_og_type, 2);
			if(!strlen($strType)) {
				$strType = $strNamespace;
				unset($strNamespace);
			}
		} else {
			$strType = 'website';
		}
		$objOGBD->setType(new OpenGraphType($strType, $strNamespace));

		$objOGBD->setImageData($this->generateImageData($objPage->bbit_og_image, $objPage->bbit_og_imageSize));

		if(strlen($objPage->bbit_og_url)) {
			$strURL = $this->replaceInsertTags($objPage->bbit_og_url);
		} elseif($objOrigin->id == $GLOBALS['objPage']->id) {
			$strURL = $this->Environment->base . $this->Environment->request;
		} else {
			$strURL = $this->Environment->base . $this->generateFrontendURL($objOrigin->row());
		}
		$objOGBD->setURL($strURL);

		if(strlen($objPage->bbit_og_description)) {
			$strDescription = $this->replaceInsertTags($objPage->bbit_og_description);
		} else {
			$strDescription = $objOrigin->description;
		}
		$strDescription = trim(str_replace(array("\n", "\r"), array(' ' , ''), $strDescription));
		strlen($strDescription) && $objOGBD->setDescription($strDescription);

		if(strlen($objPage->bbit_og_site)) {
			$strSiteName = $this->replaceInsertTags($objPage->bbit_og_site);
		} else {
			$strSiteName = strip_tags($objOrigin->rootTitle);
		}
		strlen($strSiteName) && $objOGBD->setSiteName($strSiteName);


		return $objOGBD;
	}

	public function generateImageData($strImage, $arrSize = null) {
		$objOGID = new OpenGraphImageData();

		$file = FilesModel::findByUuid($strImage);
		$file && $strImage = $file->path;

		if(is_file(TL_ROOT . '/' . $strImage)) {
			$arrSize = deserialize($arrSize, true);
			$strImage = $this->getImage($strImage, $arrSize[0], $arrSize[1], $arrSize[2]);
			$objImage = new File($strImage);
			$objOGID->setURL($this->Environment->base . $strImage);
			$objOGID->setMIMEType($objImage->mime);
			$objOGID->setWidth($objImage->width);
			$objOGID->setHeight($objImage->height);
		}

		return $objOGID;
	}

}
