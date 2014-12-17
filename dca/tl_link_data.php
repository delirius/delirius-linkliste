<?php

if (!defined('TL_ROOT'))
    die('You can not access this file directly!');

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
 * Table tl_link_data
 */
$GLOBALS['TL_DCA']['tl_link_data'] = array
    (
// Config
    'config' => array
        (
        'dataContainer' => 'Table',
        'ptable' => 'tl_link_category',
        'sql' => array
            (
            'keys' => array
                (
                'id' => 'primary'
            )
        ),
    ),
// List
    'list' => array
        (
        'sorting' => array
            (
            'mode' => 4,
            'fields' => array('sorting'),
            'flag' => 1,
            'panelLayout' => 'search,sort',
            'headerFields' => array('title', 'published'),
            'child_record_callback' => array('class_link_dat', 'listLinks')
        ),
        'label' => array
            (
            'fields' => array('title'),
            'format' => '%s'
        ),
        'global_operations' => array
            (
            'all' => array
                (
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="e"'
            )
        ),
        'operations' => array
            (
            'edit' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_link_data']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.gif'
            ),
            'copy' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_link_data']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif'
            ),
            'cut' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_link_data']['cut'],
                'href' => 'act=paste&amp;mode=cut',
                'icon' => 'cut.gif'
            ),
            'delete' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_link_data']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            ),
            'show' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_link_data']['show'],
                'href' => 'act=show',
                'icon' => 'show.gif'
            )
        )
    ),
// Palettes
    'palettes' => array
        (
        '__selector__' => array(''),
        'default' => '{dataset_legend},published,url,url_text,description,image,url_protocol'
    ),
// Subpalettes
    'subpalettes' => array
        (
        '' => ''
    ),
// Fields
    'fields' => array
        (
        'id' => array
            (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
            (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'sorting' => array
            (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp' => array
            (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'published' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_link_data']['published'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'default' => '1',
            'eval' => array('mandatory' => false, 'maxlength' => 255),
            'sql' => "char(1) NOT NULL default ''"
        ),
        'url' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_link_data']['url'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'default' => 'www.',
            'save_callback' => array(array('class_link_dat', 'removeProtocol')),
            'eval' => array('mandatory' => true, 'maxlength' => 255, 'rgxp' => 'url', 'tl_class' => 'w50'),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'url_text' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_link_data']['url_text'],
            'exclude' => true,
            'sorting' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'url_protocol' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_link_data']['url_protocol'],
            'exclude' => true,
            'inputType' => 'text',
            'default' => 'http://',
            'eval' => array('mandatory' => true, 'maxlength' => 255),
            'sql' => "varchar(128) NOT NULL default ''"
        ),
        'description' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_link_data']['description'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'textarea',
            'eval' => array('style' => 'height:48px', 'tl_class' => 'clr', 'rte' => 'tinyMCE'),
            'sql' => "text NULL"
        ),
        'image' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_link_data']['image'],
            'exclude' => true,
            'exclude' => true,
            'inputType' => 'fileTree',
            'eval' => array('fieldType' => 'radio', 'files' => true, 'filesOnly' => true, 'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes']),
            'sql' => "binary(16) NULL"
        )
    )
);

class class_link_dat extends Backend
{

    public function listLinks($arrRow)
    {
        $arrRow['url'] = html_entity_decode($arrRow['url']); // Anchor

        $objRequest = new Request();
        $objRequest->send($arrRow['url_protocol'] . $arrRow['url']);

        $strError = '';

        if ($objRequest->hasError())
        {
            if ($objRequest->__get('code') == 0)
            {
                $strError = ' <span style="color:red">invalid host</span>';
            } elseif ($objRequest->__get('code') >= 400)
            {
                $strError = ' <span style="color:red">not found (' . $objRequest->__get('error') . ')</span>';
            } elseif ($objRequest->__get('code') >= 300)
            {
                $strError = ' <span style="color:blue">redirect (' . $objRequest->__get('error') . ')</span>';
            }
        }

        $line = '';
        $line .= '<div class="cte_type ' . (($arrRow["published"] == 1) ? '' : 'un') . 'published">';
        $line .= $arrRow['url_text'];
        $line .= " - ";
        $line .= '<a href="' . $arrRow['url_protocol'] . $arrRow['url'] . '"' . LINK_NEW_WINDOW . '>' . $arrRow['url'] . '</a>' . $strError;
        $line .= "</div>";
        $line .= "<div>";
        $line .= $arrRow['description'];
        $line .= "</div>";

        $line .= "\n";


        return($line);
    }

    public function removeProtocol($var, $dc)
    {
        $var = preg_replace('/^http:\/\/|^https:\/\//', '', $var);

        return($var);
    }

}

// class
?>