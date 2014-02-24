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

		$newsarticle = new ModuleNewsArticle($objArticle, $this);

		if(TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard  = '### NEWSARTICLE ### <br /><br />';
			$objTemplate->wildcard .= $newsarticle->generate();
			return $objTemplate->parse();
		}



		return $newsarticle->generate();
	}

	protected function compile()
	{
		return;
	}
}