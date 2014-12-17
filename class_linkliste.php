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
 * Class class_linkliste
 *
 * @copyright  2010
 * @author     delirius
 * @package    Controller
 */
class class_linkliste extends Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'linkliste_standard';


    /**
     * Generate module
     */
    protected function compile()
    {


        $objParams = $this->Database->prepare("SELECT * FROM tl_module WHERE id=?")
                ->limit(1)
                ->execute($this->id);


        //delirius_linkliste_categories
        if ($objParams->delirius_linkliste_categories != '')
        {
            $arrCat = deserialize($objParams->delirius_linkliste_categories);
            $strAnd = ' AND b.id IN ('.implode(',',$arrCat).') ';
        }

        // random, order, title
        if ($objParams->delirius_linkliste_fesort == 'random')
        {
            $strOrder = ' b.sorting, RAND()';
        } elseif ($objParams->delirius_linkliste_fesort == 'order')
        {
            $strOrder = ' b.sorting, a.sorting';
        } else
        {
            $strOrder = ' b.sorting, a.url';
        }

        if ($objParams->delirius_linkliste_template == '')
        {
            $objParams->delirius_linkliste_template = 'linkliste_standard';
        }
        $this->Template = new FrontendTemplate($objParams->delirius_linkliste_template);

        if ($objParams->delirius_linkliste_standardfavicon == '')
        {
            $this->Template->standardfavicon = 'system/modules/delirius_linkliste/html/icon.png';
        } else
        {
            $this->Template->standardfavicon = $objParams->delirius_linkliste_standardfavicon;
        }

        $arrLinks = array();

        $query = ' SELECT a.*, b.title AS categorietitle FROM tl_link_data a, tl_link_category b WHERE a.pid=b.id '.$strAnd.' AND b.published = "1" AND a.published = "1" ORDER BY '.$strOrder;

        $objData = $this->Database->execute($query);
        while ($objData->next())
        {

            $arrNew = array
                    (
                    'categorietitle' => trim($objData->categorietitle),
                    'url_protocol' => trim($objData->url_protocol),
                    'url' => trim($objData->url),
                    'url_text' => trim($objData->url_text),
                    'description' => trim($objData->description),
            );
            if(strlen($objData->url_text) == 0)
            {
                $arrNew['url_text'] = $arrNew['url'];
            }

            if(strlen($objData->image) == 0)
            {
                $arrNew['image'] = '';
            }
            else
            {
                $arrNew['image'] = $this->getImage($objData->image, '16', '16', 'box');
            }


            $arrLinks[$objData->categorietitle][] = $arrNew;
        }
        $this->Template->linkliste = $arrLinks;
        $this->Template->favicon = $objParams->delirius_linkliste_favicon;


        /* Add JS in HTML head */
        $GLOBALS['TL_HEAD'][] = "<script type=\"text/javascript\">
<!--//--><![CDATA[//><!--
window.addEvent('load', function() {\$('favicon').getFavicons('');});
//--><!]]>
</script>";




    }
}

?>