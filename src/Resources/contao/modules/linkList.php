<?php
namespace Delirius\Linkliste;
use Doctrine\DBAL\Driver\Connection;
use Patchwork\Utf8;


class linkList extends \Module
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

        $objParams = \Database::getInstance()->prepare("SELECT * FROM tl_module WHERE id=?")
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
        } elseif ($objParams->delirius_linkliste_fesort == 'title')
        {
            $strOrder = ' b.sorting, a.url_title';
        } else
        {
            $strOrder = ' b.sorting, a.url';
        }


        //Wenn nötig, dann neues Template aktivieren
        if (($objParams->delirius_linkliste_template != $this->strTemplate) && ($objParams->delirius_linkliste_template != ''))
        {
            $this->strTemplate = $objParams->delirius_linkliste_template;
            $this->Template = new \FrontendTemplate($this->strTemplate);
        }




        /* imagesize */

        $arrSize = \StringUtil::deserialize($this->imgSize);
        if ( $arrSize[0] > 0 || $arrSize[1] > 0 )
        {
            // {{image::58ca4a90?width=200&height=150&mode=center_center&alt=alt}}
            $arrSizeText = array();
            if ($arrSize[0] > 0) {
                $arrSizeText[] = 'width='.$arrSize[0];
            }
            if ($arrSize[1] > 0) {
                $arrSizeText[] = 'height='.$arrSize[1];
            }
            if ($arrSize[2] != '') {
                $arrSizeText[] = 'mode='.$arrSize[2];
            }

        }
        elseif ( is_numeric($arrSize[2]) )
        {
            // {{picture::58ca4a90?size=1&alt=alt}}
            $arrSizeText[] = 'size='.$arrSize[2];
            $this->Template->imagetype = 'picture';
        } else {
            $arrSizeText[] = 'width=100';
            $arrSizeText[] = 'mode=proportional';
        }


        $this->Template->imagesize = implode('&',$arrSizeText);


        /* standard image */
         if ($objParams->delirius_linkliste_standardfavicon != '')
         {
             $this->Template->standardimage = \StringUtil::binToUuid($objParams->delirius_linkliste_standardfavicon);

             /* image_path */
             $objFile = \FilesModel::findByUuid($objParams->delirius_linkliste_standardfavicon);
             $standardimagePath = $objFile->path;
         }

        $arrLinks = array();

        $query = ' SELECT a.*, b.title AS categorietitle, b.description AS categoriedescription, b.image AS categorieimage FROM tl_link_data a, tl_link_category b WHERE a.pid=b.id AND b.id IN (' . $strAnd . ') AND b.published = "1" AND a.published = "1" ORDER BY FIELD(b.id,' . $strAnd . '),' . $strOrder;
        $objData = \Database::getInstance()->execute($query);

        $query_cc = ' SELECT a.pid, COUNT(a.id) as cc FROM tl_link_data a, tl_link_category b WHERE a.pid=b.id AND b.id IN (' . $strAnd . ') AND b.published = "1" AND a.published = "1" GROUP BY a.pid';
        $objCount = \Database::getInstance()->prepare($query_cc)->execute();
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
                'title' => trim($objData->url_title),
                'description' => trim($objData->description),
            );
            if (strlen($arrNew['url_text']) == '')
            {
                $arrNew['url_text'] = $arrNew['url'];
            }

            /* Image */
            if ($objParams->delirius_linkliste_showimage)
            {
                if (strlen($objData->image) == 0)
                {
                    $arrNew['image'] = $this->Template->standardimage;
                }
                else
                {
                    $arrNew['image'] = \StringUtil::binToUuid($objData->image);
                }

                /* image_path Kompatibilität */
                if (strlen($objData->image) == 0)
                {
                    $arrNew['image_path'] = $standardimagePath;
                }
                else
                {
                    $objFile = \FilesModel::findByUuid($objData->image);
                    $arrNew['image_path'] = $objFile->path;
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
        $this->Template->showimage = $objParams->delirius_linkliste_showimage;
    }

}

?>
