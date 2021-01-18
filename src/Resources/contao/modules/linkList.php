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
        }
        elseif ($objParams->delirius_linkliste_fesort == 'order')
        {
            $strOrder = ' b.sorting, a.sorting';
        }
        elseif ($objParams->delirius_linkliste_fesort == 'text')
        {
            $strOrder = ' b.sorting, a.url_text';
        }
        elseif ($objParams->delirius_linkliste_fesort == 'title')
        {
            $strOrder = ' b.sorting, a.url_title';
        }
        else
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
            $this->Template->imagetype = 'image';
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



        $arrLinks = array();

        $query = ' SELECT a.*, b.id as catid, b.title AS categorietitle, b.title_publik AS categorietitlepublik, b.description AS categoriedescription, b.image AS categorieimage FROM tl_link_data a, tl_link_category b WHERE a.pid=b.id AND b.id IN (' . $strAnd . ') AND b.published = "1" AND a.published = "1" ORDER BY FIELD(b.id,' . $strAnd . '),' . $strOrder;
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
            /* title_publik */
            $ktitle = trim( ($objData->categorietitlepublik ? $objData->categorietitlepublik : $objData->categorietitle) );


            $arrNew = array
            (
                'class' => $class,
                'categorietitle' => $ktitle,
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
                $objFile = \FilesModel::findByUuid($objData->image);

                if (strlen($objData->image) == 0)
                {
                    $objData->image = ($objParams->delirius_linkliste_standardfavicon ? $objParams->delirius_linkliste_standardfavicon : '');
                }

                if ($this->Template->imagetype === 'picture')
                {
                    $arrNew['image'] = '{{picture::'.$objFile->path.'?'.$this->Template->imagesize.'&alt='.$arrNew['url_text'].'}}';
                }
                else
                {
                    $arrNew['image'] = '{{image::'.$objFile->path.'?'.$this->Template->imagesize.'&alt='.$arrNew['url_text'].'}}';
                }
                if (\defined('TL_MODE') && TL_MODE == 'BE')
                {
                    $arrNew['image'] = \Controller::replaceInsertTags('{{image::'.$objFile->path.'?width=70&height=70&mode=proportional&alt='.$arrNew['url_text'].'}}');
                }

                /* image_path */
                $arrNew['image_path'] = $objFile->path;
            }

            $arrNew['categorieimage'] = '';
            /*delirius_linkliste_showcategoryimage,delirius_linkliste_categoryimagesize,delirius_linkliste_categorystandardimage*/
            if (strlen($objData->categorieimage) != 0)
            {
                $objFile = \FilesModel::findById($objData->categorieimage);
                $arrNew['categorieimage'] = $objFile->path;
            }

            $arrLinks[$objData->catid][] = $arrNew;
        }
        $this->Template->linkliste = $arrLinks;
        $this->Template->showimage = $objParams->delirius_linkliste_showimage;
    }

}

?>
