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
 * Table tl_link_category
 */
$GLOBALS['TL_DCA']['tl_link_category'] = array
    (
// Config
    'config' => array
        (
        'dataContainer' => 'Table',
        'ctable' => array('tl_link_data'),
        'label' => &$GLOBALS['TL_LANG']['tl_link_category']['category'],
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
            'mode' => 1,
            'fields' => array('title'),
            'flag' => 1,
        ),
        'label' => array
            (
            'fields' => array('title'),
            'format' => '<strong>%s</strong>',
            'label_callback' => array('class_link_cat', 'getRowLabel')
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
            'checkLinksCategorie' => array
                (
                'label' => &$GLOBALS['TL_LANG']['MSC']['checklinkscategorie'],
                'href' => 'table=tl_link_data',
                'button_callback' => array('class_link_cat', 'checkLinkButton')
            ),
            'edit' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_link_category']['edit'],
                'href' => 'table=tl_link_data',
                'icon' => 'edit.svg',
                'attributes' => 'class="contextmenu"'
            ),
            'copy' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_link_category']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.svg'
            ),
            'delete' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_link_category']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            )
        /*
          'show' => array
          (
          'label' => &$GLOBALS['TL_LANG']['tl_link_category']['show'],
          'href' => 'act=show',
          'icon' => 'show.gif'
          ),
         *
         */
        )
    ),
// Palettes
    'palettes' => array
        (
        '__selector__' => array(''),
        'default' => '{category_legend},published,title,description,image'
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
            'label' => &$GLOBALS['TL_LANG']['tl_link_category']['published'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'default' => '1',
            'eval' => array('mandatory' => false, 'maxlength' => 255),
            'sql' => "char(1) NOT NULL default ''"
        ),
        'title' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_link_category']['title'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => array('mandatory' => true, 'maxlength' => 255),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'description' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_link_category']['description'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'textarea',
            'eval' => array('style' => 'height:48px', 'tl_class' => 'clr', 'rte' => 'tinyMCE'),
            'sql' => "text NULL"
        ),
        'image' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_link_category']['image'],
            'exclude' => true,
            'exclude' => true,
            'inputType' => 'fileTree',
            'eval' => array('fieldType' => 'radio', 'files' => true, 'filesOnly' => true, 'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes']),
            'sql' => "blob NULL"
        )
    )
);

class class_link_cat extends Backend
{

    public function getRowLabel($row)
    {
        if ($row['image'])
        {
            $objFile = \FilesModel::findById($row['image']);

            if ($objFile !== null)
            {
                $preview = $objFile->path;
                $image = '<img src="' . $this->getImage($preview, 65, 45, 'center_center') . '" alt="' . htmlspecialchars($label) . '" style="display: inline-block;vertical-align: top;*display:inline;zoom:1;padding-right:8px;" />';
            }
        }

        if ($row['title'])
        {
            $text = '<span class="name">' . $row['title'] . '</span>';
        }

        $objData = \Database::getInstance()->prepare('SELECT COUNT(id) as cc FROM tl_link_data WHERE pid = ?')->execute($row['id']);
        if ($objData->cc > 0)
        {
            $text .= ' (' . $objData->cc . ')';
        }


        return $image . $text;


        // return $this->replaceInsertTags('{{image::/' . $objFile->path . '?width=55&height=65}}');
    }

    public function checkLinkButton($row, $href, $label, $title, $icon, $attributes)
    {
        $return = '';



        $objData = \Database::getInstance()->prepare('SELECT SUM(be_warning) as be_warning, SUM(be_error) as be_error FROM tl_link_data WHERE pid = ?')->execute($row['id']);

        if (false):
        echo '<pre>';
        print_r($objData);
        echo '</pre>';
        endif;

        if ($objData->be_warning > 0)
        {
            $warning = ' <span class="linkliste_orange" title="Warning">&nbsp;' . $objData->be_warning . '&nbsp;</span>';
        }
        if ($objData->be_error > 0)
        {
            $error = ' <span class="linkliste_red" title="Error">&nbsp;' . $objData->be_error . '&nbsp;</span>';
        }

        $image = '<img src="bundles/deliriuslinkliste/check.svg" width="16" height="16">';

        $return .= '<a class="be_button" href="/contao/main.php?do=delirius_linkliste&amp;table=tl_link_data&amp;id=' . $row['id'] . '&key=checklink' . '" title="' . $GLOBALS['TL_LANG']['MSC']['checklinkscategorie'] . '"' . $attributes . '>' . $warning . $error . '&nbsp;' . $image . '</a>&nbsp;&nbsp;';

        return $return;
    }

}

// class
?>
