<?php
namespace Delirius\Literatur;
use Doctrine\DBAL\Driver\Connection;
use Patchwork\Utf8;


class literaturList extends \Module
{

    /**
    * Template
    * @var string
    */
    protected $strTemplate = 'literatur_list_default';


    /**
    * Display a wildcard in the back end
    *
    * @return string
    */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['literatur_list'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }


    /**
    * Compile the current element
    */
    protected function compile()
    {


        if (\Input::getInstance()->get('detail'))
        {
            return false;
        }

        $objParams = \Database::getInstance()
        ->prepare("SELECT * FROM tl_module WHERE id=?")
        ->limit(1)
        ->execute($this->id);

        //echo $query = ' SELECT d.id, d.title, d.alias FROM tl_categories_data d, tl_literatur_data a WHERE a.kategorie LIKE CONCAT("%%:\"",d.id,"\"%%") GROUP BY alias ORDER BY d.sorting';



        if ($objParams->literatur_archive === '')
        {
            return false;
        }
        $arrCat = deserialize($objParams->literatur_archive);
        $strAnd = implode(',', $arrCat);


        if ($objParams->literatur_per_page !== '')
        {
            $numberPerPage = $objParams->literatur_per_page;
        } else
        {
            $numberPerPage = 0;
        }

        if (\Input::get('pageStart') > 0)
        {
            $pageStart = \Input::get('pageStart') * $numberPerPage;
        } else
        {
            $pageStart = 0;
        }

        // $kategorieQuery = '';
        // if (\Input::getInstance()->get('kategorie'))
        // {
        //     $objKategorie = \Database::getInstance()->prepare("SELECT id FROM tl_categories_data WHERE alias=?")->limit(1)
        //     ->execute(\Input::getInstance()->get('kategorie'));
        //
        //     if ($objKategorie->numRows) {
        //         $kategorieQuery .= ' AND a.kategorie LIKE CONCAT("%%:\"",'.$objKategorie->id.',"\"%%")';
        //     }
        // }


        $kategorieQuery = '';
        if ($GLOBALS['objPage']->id) {
            $kategorieQuery .= ' AND a.kategorie = '. $GLOBALS['objPage']->id;
        }

        //Wenn nötig, dann neues Template aktivieren
        if (($objParams->literatur_template != $this->strTemplate) && ($objParams->literatur_template != ''))
        {
            $this->strTemplate = $objParams->literatur_template;
            $this->Template = new \FrontendTemplate($this->strTemplate);
        }

        //$objTemplate = new FrontendTemplate($objParams->literatur_template ?: $strTemplate);


        if (\Input::cookie('FE_PREVIEW')) {
            $fe_published = ' ';
        } else {
            $fe_published = ' AND a.published = "1" ';
        }

        //         'default' => '{title_legend},published,id_alt,title,alias,bild,bildlink,fotos,standort,bauherr,auftraggeber,gesamtleitung,planung,nutzung,leistungen,baukosten,zeitraum,beschrieb,anhang;'



        $arrreferenzenData = array();

        // $query = ' SELECT SQL_CALC_FOUND_ROWS a.*, b.title as arc_title, b.id as arc_id FROM tl_literatur_data a, tl_literatur b WHERE a.pid=b.id  ' . $fe_published . ' ORDER BY a.sorting';
        $query = ' SELECT a.* FROM tl_literatur_data a WHERE 1 AND a.pid IN (' . $strAnd . ') ' . $kategorieQuery . $fe_published . ' ORDER BY FIELD(a.pid,' . $strAnd . '),a.sorting';

        //echo $query; exit;

        $objData = \Database::getInstance()->prepare($query)->execute();



        $j = 0;
        while ($objData->next())
        {

            $j++;
            $class = ((($j % 2) == 0) ? ' even' : ' odd') . (($j == 1) ? ' first' : '');


            $arrNew = array
            (
                'id' => trim($objData->id),
                'title' => trim($objData->title),
                'autor' => trim($objData->autor),
                'text' => trim($objData->text),

            );

            $arrreferenzenData[] = $arrNew;



        }

        $this->Template->arrreferenzenData = $arrreferenzenData;

        if ($numberPerPage > 0) // on/off
        {

            /* pagination */
            $strPager = '';
            if ($objNum->num > $numberPerPage)
            {
                $fcc = $objNum->num / $numberPerPage;
                $cc = floor($fcc);
                if ($fcc > $cc)
                {
                    $cc++;
                }
                $strPager .= '<ul class="pagination">';

                for ($i = 0; $i < $cc; $i++)
                {
                    $page = $i + 1;
                    if (\Input::get('pageStart') == $i)
                    {
                        $strPager .= '<li>';
                        $strPager .= '<a class="link current" href="' . $this->addToUrl('pageStart=' . $i) . '">' . $page . '</a>';
                        $strPager .= '</li>';
                    } else
                    {
                        $strPager .= '<li>';
                        $strPager .= '<a  class="link" href="' . $this->addToUrl('pageStart=' . $i) . '">' . $page . '</a>';
                        $strPager .= '</li>';
                    }
                }
                $strPager .= '</ul>';
            }

            $this->Template->pagination = $strPager;
        } // on/off
    }

    // complile
}
