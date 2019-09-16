<?php



$dc = &$GLOBALS['TL_DCA']['tl_content'];

$dc['palettes']['newselement'] = '{type_legend},type,headline;{news_legend},news_archive,news,news_template,size,news_metaFields;{protected_legend:hide},protected;{expert_legend:hide},guests,invisible,cssID,space';

$GLOBALS['TL_DCA']['tl_content']['fields']['news_archive'] = array(
	'label'                 => &$GLOBALS['TL_LANG']['tl_content']['news_archive'],
	'exclude'               => true,
	'inputType'             => 'select',
	'options_callback'      => array('tl_content_newsarticle', 'getNewsArchives'),
	'eval'					=> array('submitOnChange'=>true, 'chosen'=>true, 'includeBlankOption' => true),
	'sql'					=> "int(10) unsigned NOT NULL default '0'",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['news'] = array(
	'label'                 => &$GLOBALS['TL_LANG']['tl_content']['news'],
	'exclude'               => true,
	'search'                => true,
	'inputType'             => 'select',
	'reference'				=> &$GLOBALS['TL_LANG']['tl_content']['news'],
	'options_callback'      => array('tl_content_newsarticle', 'getNews'),
	'eval'                  => array('submitOnChange'=>true, 'chosen'=>true, 'includeBlankOption' => true),
	'wizard' => array
	(
		array('tl_content_newsarticle', 'editNewsLink')
	),
	'sql'					=> "int(10) unsigned NOT NULL default '0'",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['news_template'] = array(
	'label'                 => &$GLOBALS['TL_LANG']['tl_content']['news'],
	'default'               => 'news_short',
	'exclude'               => true,
	'inputType'             => 'select',
	'options_callback'      => array('tl_content_newsarticle', 'getNewsTemplates'),
	'eval'                  => array('tl_class'=>'w50', 'chosen'=>true),
	'sql'					=> "varchar(64) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['news_metaFields'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_content']['news_metaFields'],
	'default'               => array('date', 'author'),
	'exclude'               => true,
	'inputType'             => 'checkbox',
	'options'               => array('date', 'author', 'comments'),
	'reference'             => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                  => array('multiple'=>true, 'tl_class'=>'clr'),
	'sql'					=> "varchar(255) NOT NULL default ''",
);

class tl_content_newsarticle extends Backend
{

	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	public function editNewsLink(DataContainer $dc)
	{
		return ($dc->value < 1) ? '' : ' <a href="contao/main.php?do=news&amp;table=tl_news&amp;act=edit&amp;id=' . $dc->value . '" title="'.sprintf(specialchars($GLOBALS['TL_LANG']['tl_content']['editalias'][1]), $dc->value).'" style="padding-left:3px;">' . $this->generateImage('alias.gif', $GLOBALS['TL_LANG']['tl_content']['editalias'][0], 'style="vertical-align:top;"') . '</a>';
	}

	public function getNewsArchives(DataContainer $dc)
	{
		if (!$this->User->isAdmin && !is_array($this->User->news))
		{
			return array();
		}

		$arrArchives = array();
		$objArchives = $this->Database->execute("SELECT id, title FROM tl_news_archive ORDER BY title");

		while ($objArchives->next())
		{
			if ($this->User->isAdmin || $this->User->hasAccess($objArchives->id, 'news'))
			{
				$arrArchives[$objArchives->id] = $objArchives->title;
			}
		}

		return $arrArchives;
	}

	public function getNews(DataContainer $dc)
	{
		if (!$this->User->isAdmin && !is_array($this->User->news) && $dc->activeRecord->news_archive < 1)
		{
			return array();
		}

		$arrNews = array();

		$objNews = $this->Database->prepare('SELECT * FROM tl_news WHERE pid = ? ORDER BY date DESC')->execute($dc->activeRecord->news_archive);

		while ($objNews->next())
		{
			if ($this->User->isAdmin || $this->User->hasAccess($objNews->pid, 'news'))
			{
				if($objNews->published == 0)
				{
					$arrNews['unpublished'][$objNews->id] = $objNews->headline;
					continue;
				}

				$arrNews[$objNews->id] = $objNews->headline;
			}
		}

		return $arrNews;
	}

	public function getNewsTemplates(DataContainer $dc)
	{
		$intPid = $dc->activeRecord->pid;

		// get parent Template
		$objLayout = $this->Database->prepare("SELECT l.pid FROM tl_page p LEFT JOIN tl_article a ON a.pid = p.id LEFT JOIN tl_layout l ON l.id = p.layout WHERE a.id = ?")->execute($intPid);

		if($objLayout->numRows)
		{
			$intPid = $objLayout->pid;
		}

		if ($this->Input->get('act') == 'overrideAll')
		{
			$intPid = $this->Input->get('id');
		}

		return $this->getTemplateGroup('news_', $intPid);
	}

}