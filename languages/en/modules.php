<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  2010 
 * @author     delirius 
 * @package    Paket 
 * @license    GNU/LGPL 
 * @filesource
 */


/**
 * Back end modules
 */
$GLOBALS['TL_LANG']['MOD']['delirius_linkliste'] = array('Linklist with image', '');

/**
 * Front end modules
 */
$GLOBALS['TL_LANG']['FMD']['delirius_linkliste'] = array('Linklist with image', '');


/**
 * Back end fields for tl_module
 */
$GLOBALS['TL_LANG']['tl_module']['option_legend']     = 'Options';

$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_categories'] = array('Categories','If no category is selected all the categories will be issued, also newly created');
$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_fesort'] = array('Order','');
$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_favicon'] = array('Show favicon','A favicon (short for favorite icon) is a small symbol that will include in the address bar of a browser to the left of the URL');
$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_standardfavicon'] = array('Change standard image','');
$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_template'] = array('Template','Choose template. (Template name starts with linkliste_)');

$GLOBALS['TL_LANG']['tl_module']['fesort_option']['random'] = 'Random order';
$GLOBALS['TL_LANG']['tl_module']['fesort_option']['order'] = 'Manually order (as backend)';
$GLOBALS['TL_LANG']['tl_module']['fesort_option']['url'] = 'Alphabetically by link';



?>