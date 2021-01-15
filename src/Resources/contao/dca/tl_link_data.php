<?php
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
            'default' => 'https://www.',
            'eval' => array('mandatory' => true, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'fieldType' => 'radio', 'tl_class' => 'w50 wizard'),
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
            'eval' => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'clr'),
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
        \Input::setGet('id', $intId);
        \Input::setGet('act', 'toggle');



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
        \Database::getInstance()->prepare("UPDATE tl_link_data SET published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
                ->execute($intId);
    }

    public function checkLink($linkliste_id, $linkliste_url = '')
    {

        if ($linkliste_url == '')
        {
            $objData = \Database::getInstance()->prepare("SELECT pid,url FROM tl_link_data WHERE id = ?")->execute($linkliste_id);
            $linkliste_url = $objData->url;
            $linkliste_pid = $objData->pid;
        }
        if ($linkliste_url == '')
        {
            return false;
        }
        \Database::getInstance()->prepare("UPDATE tl_link_data SET be_error = 0, be_warning = 0, be_text = '' WHERE id = ?")->execute($linkliste_id);

        $linkliste_url = html_entity_decode($linkliste_url); // Anchor



        /* Link intern/extern */
        if (strstr($linkliste_url, 'link_url')) {
            // Link intern


            // $linkliste_url = '{{env::url}}/' . $linkliste_url;
            // $linkliste_url = $this->replaceInsertTags($linkliste_url);
            $error = '';
            preg_match("|\d+|", $linkliste_url, $arrId);

            if (NULL !== $arrId[0]) {
            $objIntern = \Database::getInstance()->prepare("SELECT pid, type, published FROM tl_page WHERE id = ?")->execute($arrId[0]);

            if ($objIntern->numRows) {
                // id existiert
                if ($objIntern->published != 1) {
                    $error = 'Page not published';
                } else {
                    $sql_parent = 'select t.id as id, published, @pv:=t.pid as parent from (select * from tl_page order by id desc) t join (select @pv:='.$objIntern->pid.')tmp where t.id=@pv;';
                    $objInternParent = \Database::getInstance()->prepare($sql_parent)->execute();
                    while ($objInternParent->next()) {
                        // $arrP[] = $objInternParent->id.' '.$objInternParent->published;
                        if ($objInternParent->published != 1) {
                            $error = 'Parent page ('.$objInternParent->id.') not published';
                        }
                    }
                }
                if ($objIntern->type == 'forward') {
                    $error = 'Page is redirected';
                }

            } else {
                $error = 'Page (ID) not exist';
            }

            /* Update status */
            if ($error != '') {
                \Database::getInstance()->prepare("UPDATE tl_link_data SET be_error = 1, be_text = ? WHERE id=?")->execute($error, $linkliste_id);
            }
        }

    } else {
        // Link extern


        $objRequest = new \Request();
        $objRequest->send($linkliste_url);

        if (false):
            echo '<pre>';
            print_r($objRequest);
            echo '</pre>';
        endif;

        $error = '';

        if ($objRequest->code == 0)
        {
            \Database::getInstance()->prepare("UPDATE tl_link_data SET be_error = 1 WHERE id=?")->execute($linkliste_id);
            if (strstr($objRequest->error, 'Name or service not known'))
            {
                $error = 'Name or service not known';
            } else
            {
                $error = $objRequest->error;
            }
        } elseif ($objRequest->code >= 400)
        {
            \Database::getInstance()->prepare("UPDATE tl_link_data SET be_error = 1 WHERE id=?")->execute($linkliste_id);
            $error = $objRequest->error;
        } elseif ($objRequest->code >= 300)
        {
            \Database::getInstance()->prepare("UPDATE tl_link_data SET be_warning = 1 WHERE id=?")->execute($linkliste_id);
            if ($objRequest->code == 301) {
                $error = 'Moved Permanently';
            } elseif ($objRequest->code == 302) {
                $error = 'Found (with redirect)';
            } elseif ($objRequest->code == 307) {
            $error = 'Temporary Redirect';
        } else {
                $error = $objRequest->error;
            }
        }

        if ($error != '' || $objRequest->code > 0)
        {
            \Database::getInstance()->prepare("UPDATE tl_link_data SET be_text = ? WHERE id=?")->execute($objRequest->code . ' ' . $error, $linkliste_id);
            //$objRequest->response
        }

        /* duplicates */
        $objData = \Database::getInstance()->prepare("SELECT id,be_text FROM tl_link_data WHERE pid = ? AND url LIKE ?")->execute($linkliste_pid, '%%' . $linkliste_url . '%%');
        if ($objData->numRows > 1)
        {
            while ($objData->next())
            {
                \Database::getInstance()->prepare("UPDATE tl_link_data SET be_warning = 1 , be_text = ? WHERE id=?")->execute('Duplicate entrys ', $objData->id);
            }
        }
    } // end link intern/extern

    }

    public function listLinks($arrRow)
    {
        if (\Input::get('key') == 'checklink' && \Input::get('id') != '')
        {

            $objData = \Database::getInstance()->prepare("SELECT url,id FROM tl_link_data WHERE pid = ?")->execute(\Input::get('id'));
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
        $objData = \Database::getInstance()->prepare($query)->execute($arrRow['id']);

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

        if ($arrRow['description'])
        {
            $slen = 120;
            if ( strlen($arrRow['description']) >= $slen)
            {
                $desc = \StringUtil::substr($arrRow['description'],$slen);
            } else {
                $desc = $arrRow['description'];
            }
        }


        $line = '';
        $line .= '<div>';
        $line .= $image;
        $line .= '<a href="' . $arrRow['url'] . '" title="' . $arrRow['url'] . '"' . LINK_NEW_WINDOW . '>' . ($arrRow['url_text'] != '' ? $arrRow['url_text'] : $arrRow['url']) . '</a>' . $warning . $error;
        $line .= "</div>";
        $line .= "<div>";
        if ($arrRow['url_title']) {
            $line .= '<strong>'.$arrRow['url_title'].'</strong><br>';
        }
        $line .= $desc;
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

        $image = '<img src="bundles/deliriuslinkliste/check.svg" width="16" height="16">';


        return '<a class="be_button" href="/contao/main.php?do=delirius_linkliste&amp;table=tl_link_data&amp;checklink=' . $row['id'] . '" title="' . $GLOBALS['TL_LANG']['MSC']['checklink'] . '"' . $attributes . '>' . $warning . $error . '&nbsp;' . $image . '</a>&nbsp;&nbsp;';
    }

    public function pagePicker(DataContainer $dc)
    {
        return ' <a href="contao/page.php?do=' . Input::get('do') . '&amp;table=' . $dc->table . '&amp;field=' . $dc->field . '&amp;value=' . str_replace(array('{{link_url::', '}}'), '', $dc->value) . '" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']) . '" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':765,\'title\':\'' . specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])) . '\',\'url\':this.href,\'id\':\'' . $dc->field . '\',\'tag\':\'ctrl_' . $dc->field . ((Input::get('act') == 'editAll') ? '_' . $dc->id : '') . '\',\'self\':this});return false">' . Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
    }

}

// class
?>
