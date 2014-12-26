<?php

/*
 * $this->Database->tableExists('tl_galerie_pictures')
 * $this->Database->fieldExists('banner_template', 'tl_banner_category')
 *
 * $this->Database->listFields('tl_module')
 *
 * Database\Updater::convertSingleField('tl_galerie_pictures', 'fullscreenSingleSRC');
 * Database\Updater::convertMultiField('tl_content', 'imagesFolder');
 *
 */

class linklisteRunonce extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->import('Database');
    }

    public function run()
    {


        if (version_compare(VERSION, '3.0', '>=') && $this->Database->tableExists('tl_files') && $this->Database->fieldExists('image', 'tl_link_data'))
        {
            $objData = $this->Database->prepare("SELECT id,image FROM tl_link_data WHERE 1")->execute();

            if ($objData->numRows)
            {
                while ($objData->next())
                {
                    $objImage = $this->Database->prepare("SELECT id FROM tl_files WHERE path = ?")->execute($objData->image);
                    if ($objImage->id > 0)
                    {
                        $this->log("UPDATE tl_link_data SET image = " . $objImage->id . " WHERE id = " . $objData->id . " ", 'SQL Update 2.x to 3.x', TL_GENERAL);
                        $this->Database->prepare("UPDATE tl_link_data SET image = ? WHERE id = ? ")->execute($objImage->id, $objData->id);
                    }
                }
            }
        }

        if (version_compare(VERSION, '3.2', '>=') && $this->Database->tableExists('tl_link_data'))
        {
            $arrFields = $this->Database->listFields('tl_link_data');

            foreach ($arrFields as $arrField)
            {
                if ($arrField['name'] == 'image' && $arrField['type'] != 'binary')
                {
                    Database\Updater::convertSingleField('tl_link_data', 'image');
                }
            }
        }
        
        /* remove protocol */
        $this->Database->prepare("UPDATE `tl_link_data` SET `url` = CONCAT(`url_protocol`, `url`), url_protocol = ''")->execute();
        
        
         if (version_compare(VERSION, '3.2', '>=') )
        {
            $strFile = 'system/modules/delirius_linkliste/config/database.sql';
            if (\Files::getInstance()->is_writeable($strFile))
            {
                \Files::getInstance()->delete($strFile);
            }
        }
        
    }

}

$objlinklisteRunonce = new linklisteRunonce();
$objlinklisteRunonce->run();
?>