<?php

namespace HeimrichHannot;

class ModuleNewsArticle extends \ModuleNewsReader
{
	protected $objArticle;

	protected $strTemplate;

	protected $blnAddArchive;

	protected $news_template;

	protected $imgSize;

	public function __construct($objArticle, $objThis, $blnAddArchive=false)
	{
		parent::__construct($objArticle);
		$this->objArticle = $objArticle;
		$this->blnAddArchive = $blnAddArchive;
		$this->news_template = $objThis->news_template;
		$this->objArticle->cssClass = (strlen($this->objNews->cssClass) ? $this->objNews->cssClass . ' ' .$objThis->cssID[1] : $objThis->cssID[1]);
		$this->objArticle->size = $objThis->size;
		$this->imgSize = $objThis->size;
		$this->news_metaFields = $objThis->news_metaFields;
	}

	public function generate()
	{
		return parent::parseArticle($this->objArticle);
	}

	protected function compile()
	{
		return '';
	}
}