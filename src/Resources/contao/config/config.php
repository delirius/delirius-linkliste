<?php

/**
 * DCA
 */
$GLOBALS['BE_MOD']['content']['delirius_linkliste'] = array
        (
        'tables' => array('tl_link_category','tl_link_data'),
);

/**
 * CSS
 */
 if (\defined('TL_MODE') && TL_MODE == 'BE')
{
    $GLOBALS['TL_CSS'][] = 'bundles/deliriuslinkliste/be.css|static';
}


$GLOBALS['FE_MOD']['miscellaneous']['delirius_linkliste'] = '\Delirius\Linkliste\FrontendModule\LinkList';
