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
        if ($objParams->delirius_linkliste_categories == '')
        {
            return;
        }
        $arrCat = deserialize($objParams->delirius_linkliste_categories);
        $strAnd = implode(',', $arrCat);

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

        /* imagesize */
        $imgSize = deserialize($this->delirius_linkliste_imagesize);
        $this->Template->delirius_linkliste_imagesize = $image_size;

        /* standard image */
        if ($objParams->delirius_linkliste_standardfavicon == '')
        {
            $this->Template->standardfavicon_path = 'system/modules/delirius_linkliste/html/icon.png';
        } else
        {

            $objFile = \FilesModel::findById($objParams->delirius_linkliste_standardfavicon);

            if ($objFile === null)
            {
                $this->Template->standardfavicon_path = 'system/modules/delirius_linkliste/html/icon.png';

                if (!\Validator::isUuid($objData->image))
                {
                    return '<p class="error">' . $GLOBALS['TL_LANG']['ERR']['version2format'] . '</p>';
                }
            } else
            {
                $this->Template->standardfavicon_path = $objFile->path;
            }
        }

        // Check for javascript framework
        if (TL_MODE == 'FE')
        {

            /** @type PageModel $objPage */
            global $objPage;
            $this->Template->jquery = false;
            $this->Template->mootools = false;
            if ($objPage->getRelated('layout')->addJQuery)
            {
                $this->Template->jquery = true;
            }
            if ($objPage->getRelated('layout')->addMooTools)
            {
                $this->Template->mootools = true;
            }
        }
        $arrLinks = array();

        $query = ' SELECT a.*, b.title AS categorietitle, b.description AS categoriedescription, b.image AS categorieimage FROM tl_link_data a, tl_link_category b WHERE a.pid=b.id AND b.id IN (' . $strAnd . ') AND b.published = "1" AND a.published = "1" ORDER BY FIELD(b.id,' . $strAnd . '),' . $strOrder;
        $objData = $this->Database->execute($query);

        $query_cc = ' SELECT a.pid, COUNT(a.id) as cc FROM tl_link_data a, tl_link_category b WHERE a.pid=b.id AND b.id IN (' . $strAnd . ') AND b.published = "1" AND a.published = "1" GROUP BY a.pid';
        $objCount = Database::getInstance()->prepare($query_cc)->execute();
        while ($objCount->next())
        {
            $arrCount[$objCount->pid] = $objCount->cc;
        }

        $j = 0;
        while ($objData->next())
        {
            $j++;
            $countcat = $arrCount[$objData->pid];
            $class = ((($j % 2) == 0) ? ' odd' : ' even') . (($j == 1) ? ' first' : '');
            if ($j == $countcat)
            {
                $class .= ' last';
                $j = 0;
            }

            /* replace URL {{url::*}} */
            if (strstr($objData->url, 'link_url'))
            {
                $objData->url = $this->replaceInsertTags($objData->url);
            }

            $arrNew = array
                (
                'class' => $class,
                'categorietitle' => trim($objData->categorietitle),
                'categoriedescription' => trim($objData->categoriedescription),
                'categorieimage' => trim($objData->categorieimage),
                'categoriecount' => $countcat,
                'url_protocol' => trim($objData->url_protocol),
                'url' => trim($objData->url),
                'target' => trim($objData->target),
                'url_text' => trim($objData->url_text),
                'url_title' => trim($objData->url_title),
                'description' => trim($objData->description),
            );
            if (strlen($arrNew['url_text']) == '')
            {
                $arrNew['url_text'] = $arrNew['url'];
            }

            if (strlen($objData->image) == 0)
            {
                $arrNew['image'] = '';
                $arrNew['image_path'] = $this->Template->standardfavicon_path;
                $this->Template->standardfavicon = \Image::getHtml(\Image::get($this->Template->standardfavicon_path, $imgSize[0], $imgSize[1], $imgSize[2]), $arrNew['url_text'], 'class="favicon-img"');
            } else
            {
                $objFile = \FilesModel::findById($objData->image);

                if ($objFile === null)
                {
                    $arrNew['image'] = '';
                    $arrNew['image_path'] = $this->Template->standardfavicon_path;
                    if (!\Validator::isUuid($objData->image))
                    {
                        return '<p class="error">' . $GLOBALS['TL_LANG']['ERR']['version2format'] . '</p>';
                    }
                } else
                {
                    $arrNew['image_path'] = \Image::get($objFile->path, $imgSize[0], $imgSize[1], $imgSize[2]);
                    $arrNew['image'] = \Image::getHtml($arrNew['image_path'], $arrNew['url_text'], 'class="favicon-img"');
                }
            }
            $arrNew['categorieimage'] = '';
            if (strlen($objData->categorieimage) != 0)
            {
                $objFile = \FilesModel::findById($objData->categorieimage);
                $arrNew['categorieimage'] = $objFile->path;
            }

            $arrLinks[$objData->categorietitle][] = $arrNew;
        }
        $this->Template->linkliste = $arrLinks;
        $this->Template->favicon = $objParams->delirius_linkliste_favicon;
        $this->Template->showimage = $objParams->delirius_linkliste_showimage;
    }

}

?>