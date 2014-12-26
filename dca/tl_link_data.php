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
                'id' => 'primary',
                'pid' => 'index'
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
            'checkLinksCategorie' => array
                (
                'label' => &$GLOBALS['TL_LANG']['MSC']['checklinkscategorie'],
                'href' => '',
                'icon' => 'show.gif',
                'button_callback' => array('class_link_dat', 'checkLinkButton')
            ),
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
            'toggle' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_delirius_kategorien_data']['toggle'],
                'icon' => 'visible.gif',
                'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => array('class_link_dat', 'toggleIcon')
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
        'default' => '{dataset_legend},published,url,target,url_text,url_title,description,image;'
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
            'default' => 'http://www.',
            'eval' => array('mandatory' => false, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'fieldType' => 'radio', 'tl_class' => 'w50 wizard'),
            'wizard' => array
                (
                array('class_link_dat', 'pagePicker')
            ),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'target' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_link_data']['target'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'default' => '1',
            'eval' => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50 m12'),
            'sql' => "char(1) NOT NULL default ''"
        ),
        'url_text' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_link_data']['url_text'],
            'exclude' => true,
            'sorting' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'clr w50'),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'url_title' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_link_data']['url_title'],
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
            'inputType' => 'text',
            'default' => 'http://',
            'eval' => array('mandatory' => false, 'maxlength' => 255),
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
            'sql' => "blob NULL"
        ),
        'be_error' => array
            (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'be_warning' => array
            (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'be_text' => array
            (
            /*
              'label' => &$GLOBALS['TL_LANG']['tl_link_data']['be_text'],
              'inputType' => 'text',
              'eval' => array('tl_class' => 'long', 'disabled' => true),
             * 
             */
            'sql' => "varchar(255) NOT NULL default ''"
        ),
    )
);

class class_link_dat extends Backend
{

    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1));
            $this->redirect($this->getReferer());
        }



        $href .= '&amp;tid=' . $row['id'] . '&amp;state=' . ($row['published'] ? '' : 1);

        if (!$row['published'])
        {
            $icon = 'invisible.gif';
        }


        return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label) . '</a> ';
    }

    /**
     * Disable/enable a user group
     * @param integer
     * @param boolean
     */
    public function toggleVisibility($intId, $blnVisible)
    {
        // Check permissions to edit
        Input::setGet('id', $intId);
        Input::setGet('act', 'toggle');



        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_page']['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_page']['fields']['published']['save_callback'] as $callback)
            {
                $this->import($callback[0]);
                $blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
            }
        }

        // Update the database
        $this->Database->prepare("UPDATE tl_link_data SET published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
                ->execute($intId);
    }

    public function checkLink($linkliste_id, $linkliste_url = '')
    {
        
        if ($linkliste_url == '')
        {
            $objData = $this->Database->prepare("SELECT url FROM tl_link_data WHERE id = ?")->execute($linkliste_id);
            $linkliste_url = $objData->url;
        }
        if ($linkliste_url == '')
        {
            return false;
        }
        $linkliste_url = html_entity_decode($linkliste_url); // Anchor

        if (strstr($linkliste_url, 'link_url'))
        {
            $linkliste_url = '{{env::url}}/' . $linkliste_url;
            $linkliste_url = $this->replaceInsertTags($linkliste_url);
        }
        $objRequest = new Request();
        $objRequest->send($linkliste_url);

        if (false):
            echo '<pre>';
            print_r($objRequest);
            echo '</pre>';
        endif;

        $this->Database->prepare("UPDATE tl_link_data SET be_error = 0, be_warning = 0, be_text = '' WHERE id = ?")->execute($linkliste_id);
        $error = '';

        if ($objRequest->code == 0)
        {
            $this->Database->prepare("UPDATE tl_link_data SET be_error = 1 WHERE id=?")->execute($linkliste_id);
            if (strstr($objRequest->error, 'Name or service not known'))
            {
                $error = 'Name or service not known';
            } else
            {
                $error = $objRequest->error;
            }
        } elseif ($objRequest->code >= 400)
        {
            $this->Database->prepare("UPDATE tl_link_data SET be_error = 1 WHERE id=?")->execute($linkliste_id);
            $error = $objRequest->error;
        } elseif ($objRequest->code >= 300)
        {
            $this->Database->prepare("UPDATE tl_link_data SET be_warning = 1 WHERE id=?")->execute($linkliste_id);
            if ($objRequest->code == 301)
            {
                $error = 'Moved Permanently';
            } else
            {
                $error = $objRequest->error;
            }
        }
        if ($error != '' || $objRequest->code > 0)
        {
            $this->Database->prepare("UPDATE tl_link_data SET be_text = ? WHERE id=?")->execute($objRequest->code . ' ' . $error, $linkliste_id);
            //$objRequest->response
        }
    }

    public function listLinks($arrRow)
    {
        if (\Input::get('key') == 'checklink' && \Input::get('id') != '' )
        {

            $objData = $this->Database->prepare("SELECT url,id FROM tl_link_data WHERE pid = ?")->execute(\Input::get('id'));
            while ($objData->next())
            {
                $this->checkLink($objData->id, $objData->url);
            }
            $this->redirect($this->getReferer());
        }


        if ($arrRow['image'])
        {
            $objFile = \FilesModel::findById($arrRow['image']);

            if ($objFile !== null)
            {
                $preview = $objFile->path;
                $image = '<img src="' . $this->getImage($preview, 65, 45, 'center_center') . '" alt="' . htmlspecialchars($label) . '" style="display: inline-block;vertical-align: top;*display:inline;zoom:1;padding-right:8px;" />';
            }
        }


        $query = ' SELECT * FROM tl_link_data WHERE id = ? ';
        $objData = $this->Database->prepare($query)->execute($arrRow['id']);

        if ($objData->be_warning > 0)
        {
            $warning = ' <span class="linkliste_orange" title="Warning">&nbsp;' . $objData->be_text . '&nbsp;</span>';
        }
        if ($objData->be_error > 0)
        {
            $error = ' <span class="linkliste_red" title="Error">&nbsp;' . $objData->be_text . '&nbsp;</span>';
        }

        if (strstr($arrRow['url'], 'link_url'))
        {
            $arrRow['url'] = $this->replaceInsertTags($arrRow['url']);
        }

        $line = '';
        $line .= '<div>';
        $line .= $image;
        $line .= '<a href="' . $arrRow['url'] . '" title="' . $arrRow['url'] . '"' . LINK_NEW_WINDOW . '>' . ($arrRow['url_text'] != '' ? $arrRow['url_text'] : $arrRow['url']) . '</a>' . $warning . $error;
        $line .= "</div>";
        $line .= "<div>";
        $line .= $arrRow['description'];
        $line .= "</div>";

        $line .= "\n";


        return($line);
    }

    public function checkLinkButton($row, $href, $label, $title, $icon, $attributes)
    {


        if (\Input::get('checklink') != '')
        {
            $this->checkLink(\Input::get('checklink'));
            $this->redirect($this->getReferer());
        }

        $image = 'system/modules/delirius_linkliste/html/check.png';
        return '<a class="be_button" href="/contao/main.php?do=delirius_linkliste&amp;table=tl_link_data&amp;checklink=' . $row['id'] . '" title="' . $GLOBALS['TL_LANG']['MSC']['checklink'] . '"' . $attributes . '>' . $warning . $error . '&nbsp;' . Image::getHtml($image) . '</a>&nbsp;&nbsp;';
    }

    public function pagePicker(DataContainer $dc)
    {
        return ' <a href="contao/page.php?do=' . Input::get('do') . '&amp;table=' . $dc->table . '&amp;field=' . $dc->field . '&amp;value=' . str_replace(array('{{link_url::', '}}'), '', $dc->value) . '" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']) . '" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':765,\'title\':\'' . specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])) . '\',\'url\':this.href,\'id\':\'' . $dc->field . '\',\'tag\':\'ctrl_' . $dc->field . ((Input::get('act') == 'editAll') ? '_' . $dc->id : '') . '\',\'self\':this});return false">' . Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
    }

}

// class
?>