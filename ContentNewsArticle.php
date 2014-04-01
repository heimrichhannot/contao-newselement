<?php

namespace HeimrichHannot;

class ContentNewsArticle extends \ContentElement
{

	public function generate()
	{
		$time = time();

		// Get news item
		$objArticle = \NewsModel::findPublishedByParentAndIdOrAlias($this->news, array($this->news_archive));

		if ($objArticle === null)
		{
			return '';
		}

		if(TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');
			// requires existing template from autoload.ini
			$this->news_template = 'news_latest';
			$newsarticle = new ModuleNewsArticle($objArticle, $this);
			$objTemplate->wildcard = $newsarticle->generate();
			
			return $objTemplate->parse();
		}
		
		$newsarticle = new ModuleNewsArticle($objArticle, $this);
		return $newsarticle->generate();
	}

	protected function compile()
	{
		return;
	}
}