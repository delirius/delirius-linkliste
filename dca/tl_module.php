<?php

if (!defined('TL_ROOT'))
    die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Leo Feyer 2005
 * @author     Leo Feyer <leo@typolight.org>
 * @package    News
 * @license    LGPL
 * @filesource
 */
/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['delirius_linkliste'] = '{title_legend},name,type;{option_legend},delirius_linkliste_categories,delirius_linkliste_fesort,delirius_linkliste_template,delirius_linkliste_showimage,delirius_linkliste_standardfavicon,delirius_linkliste_imagesize,delirius_linkliste_favicon;{expert_legend:hide},cssID,space;style';




/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['delirius_linkliste_categories'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_categories'],
    'exclude' => true,
    'inputType' => 'checkboxWizard',
    'foreignKey' => 'tl_link_category.title',
    'eval' => array('multiple' => true, 'mandatory' => false,'tl_class' => 'm12'),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['delirius_linkliste_fesort'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_fesort'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => array('random', 'order', 'url'),
    'reference' => &$GLOBALS['TL_LANG']['tl_module']['fesort_option'],
    'eval' => array('mandatory' => true, 'tl_class' => 'w50'),
    'sql' => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['delirius_linkliste_template'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_template'],
    'default' => 'linkliste_standard',
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => array('tl_module_linkliste', 'getTemplates'),
    'eval' => array('tl_class' => 'w50'),
    'sql' => "varchar(64) NOT NULL default ''"
);


$GLOBALS['TL_DCA']['tl_module']['fields']['delirius_linkliste_favicon'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_favicon'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'default' => '1',
    'eval' => array('mandatory' => false),
    'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['delirius_linkliste_showimage'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_showimage'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'default' => '1',
    'eval' => array('mandatory' => false),
    'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['delirius_linkliste_standardfavicon'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_standardfavicon'],
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => array('files' => true, 'fieldType' => 'radio', 'filesOnly' => true, 'extensions' => 'jpg,jpeg,png,gif,ico'),
    'sql' => "blob NULL"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['delirius_linkliste_imagesize'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_imagesize'],
    'exclude' => true,
    'inputType' => 'imageSize',
    'options' => $GLOBALS['TL_CROP'],
    'reference' => &$GLOBALS['TL_LANG']['MSC'],
    'eval' => array('rgxp' => 'digit', 'nospace' => true, 'helpwizard' => true),
    'sql' => "varchar(64) NOT NULL default ''"
);

class tl_module_linkliste extends Backend
{

    /**
     * Return all event templates as array
     * @param object
     * @return array
     */
    public function getTemplates(DataContainer $dc)
    {
        return $this->getTemplateGroup('linkliste_', $dc->activeRecord->pid);
    }

}

?>