<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Newsarticle
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'HeimrichHannot',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'HeimrichHannot\ModuleNewsArticle'  => 'system/modules/newsarticle/ModuleNewsArticle.php',
	'HeimrichHannot\ContentNewsArticle' => 'system/modules/newsarticle/ContentNewsArticle.php',
));
