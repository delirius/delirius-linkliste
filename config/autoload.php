<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Delirius_linkliste
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'class_linkliste' => 'system/modules/delirius_linkliste/class_linkliste.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'linkliste_standard' => 'system/modules/delirius_linkliste/templates',
));
