<?php

namespace HeimrichHannot\Newselement;

class ModuleNewsElement extends \ModuleNews
{
	protected $objArticle;

	protected $blnAddArchive;

	protected $news_template;

	protected $imgSize;

	protected $strTemplate = 'mod_newselement';

	public function __construct($objArticle, $objThis, $blnAddArchive=false)
	{
		parent::__construct($objArticle);
		$this->objArticle = $objArticle;
		$this->blnAddArchive = $blnAddArchive;
		$this->news_template = $objThis->news_template;
		$this->objArticle->cssClass = (strlen($this->objNews->cssClass) ? $this->objNews->cssClass . ' ' .$objThis->cssID[1] : $objThis->cssID[1]);
		$this->objArticle->cssID =  $objThis->cssID[0];
		$this->objArticle->size = $objThis->size;
		$this->imgSize = $objThis->size;
		$this->news_metaFields = $objThis->news_metaFields;

		// required by Module::generate()
		$this->type = 'newselement';
		$this->headline = $objThis->headline;
		$this->hl = $objThis->hl;
	}

	public function generate()
	{
//		$this->Template = new \FrontendTemplate($this->strTemplate);
//
//		$this->compile();

		return parent::generate();
	}

	protected function compile()
	{
		$this->Template->article = parent::parseArticle($this->objArticle);
	}
}