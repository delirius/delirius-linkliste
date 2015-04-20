<?php 

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
$GLOBALS['TL_LANG']['MOD']['delirius_linkliste'] = array('Linkliste extended', '');

/**
 * Front end modules
 */
$GLOBALS['TL_LANG']['FMD']['delirius_linkliste'] = array('Linkliste extended', '');


/**
 * Back end fields for tl_module
 */
$GLOBALS['TL_LANG']['tl_module']['option_legend']     = 'Optionen';

$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_categories'] = array('Kategorien','Wenn keine Kategorie angewählt ist werden alle Kategorien ausgegeben, auch die neu erstellten');
$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_fesort'] = array('Sortierung','');
$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_favicon'] = array('Favicon aktiv','Aktiviert im Template das Javascript um das externe Favicon zu laden zB. xy.com/favicon.ico');
$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_showimage'] = array('Bild darstellen','');
$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_standardfavicon'] = array('Standard Bild ändern','');
$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_template'] = array('Template','Template wählen. (Templatename beginnt mit linkliste_)');
$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_imagesize'] = array('Bildgrösse','');

$GLOBALS['TL_LANG']['tl_module']['fesort_option']['random'] = 'Reihenfolge zufällig';
$GLOBALS['TL_LANG']['tl_module']['fesort_option']['order'] = 'Reihenfolge manuell (wie Backend)';
$GLOBALS['TL_LANG']['tl_module']['fesort_option']['title'] = 'Reihenfolge alphabetisch nach Link-Titel';
$GLOBALS['TL_LANG']['tl_module']['fesort_option']['url'] = 'Reihenfolge alphabetisch nach Link';



?>
