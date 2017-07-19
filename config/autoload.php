<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
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
	// Modules
	'HeimrichHannot\Newselement\ModuleNewsElement'  => 'system/modules/newselement/modules/ModuleNewsElement.php',

	// Elements
	'HeimrichHannot\Newselement\ContentNewsArticle' => 'system/modules/newselement/elements/ContentNewsArticle.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_newselement' => 'system/modules/newselement/templates/modules',
));
