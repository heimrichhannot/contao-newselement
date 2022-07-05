<?php

namespace HeimrichHannot\Newselement;

use Contao\BackendTemplate;
use Contao\ContentElement;
use Contao\NewsModel;

class ModuleNewsElement extends \ModuleNews
{
    /** @var NewsModel  */
	protected $objArticle;

	protected $blnAddArchive;

	protected $news_template;

	protected $imgSize;

	protected $strTemplate = 'mod_newselement';

    /** @var ContentElement|null */
    protected $element;

    /**
     * @param NewsModel $objArticle
     * @param ContentElement $element
     * @param bool $blnAddArchive
     */
	public function __construct($objArticle, $element, $blnAddArchive=false)
	{
		parent::__construct($objArticle);
		$this->objArticle = $objArticle;
		$this->blnAddArchive = $blnAddArchive;
		$this->news_template = $element->news_template;
		$this->objArticle->cssClass = (strlen($this->objArticle->cssClass) ? $this->objArticle->cssClass . ' ' .$element->cssID[1] : $element->cssID[1]);
		$this->objArticle->cssID =  $element->cssID[0];
		$this->objArticle->size = $element->size;
		$this->imgSize = $element->size;
		$this->news_metaFields = $element->news_metaFields;
        $this->element = $element;

		// required by Module::generate()
		$this->type = 'newselement';
		$this->headline = $element->headline;
		$this->hl = $element->hl;
	}

	public function generate()
	{
        if (TL_MODE == 'BE') {
            if ($this->element instanceof ContentNewsArticle && $this->objArticle) {
                $return = '';
                if ($this->headline) {
                    $return .= '<h1><?= $this->title ?></h1>';
                }
                $return .= '<h2>'.$this->objArticle->headline.'</h2>';

                if ($this->objArticle->teaser) {
                    $teaser            = strip_tags($this->objArticle->teaser, '<b><i><strong>');
                    if (strlen($teaser) > 100) {
                        $teaser = substr($teaser, 0, 100).'…';
                    }
                    $return .= '<span>'.$teaser.'</span>';
                }

                $return .= ' (<a href="contao?do=news&table=tl_content&id='.$this->objArticle->id.'&rt='.REQUEST_TOKEN.'" style="color: #999;">ID: '.$this->objArticle->id.'</a>)';

                return $return;
            } else {
                $objTemplate = new BackendTemplate('be_wildcard');
                $objTemplate->title = $this->headline;

                $objTemplate->wildcard = '### '.mb_strtoupper($GLOBALS['TL_LANG']['FMD'][$this->type][0] ?? 'Newselement').' ###';
                if ($this->objArticle) {
                    $objTemplate->link = $this->objArticle->headline;
                    $objTemplate->id = $this->objArticle->id;
                    $objTemplate->href = 'contao?do=news&table=tl_content&id='.$this->objArticle->id;
                }
            }

            return $objTemplate->parse();
        }

		return parent::generate();
	}

	protected function compile()
	{
		$this->Template->article = parent::parseArticle($this->objArticle);
	}
}