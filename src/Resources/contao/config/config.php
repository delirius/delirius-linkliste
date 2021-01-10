<?php


// array_insert($GLOBALS['BE_MOD']['categorie_spgo'], 4, array
//     (
//     'tl_literatur' => array
//         (
//             'tables' => array('tl_link_category','tl_link_data'),

//     )
// ));

$GLOBALS['BE_MOD']['content']['delirius_linkliste'] = array
        (
        'tables' => array('tl_link_category','tl_link_data'),
);

// Style sheet
if (defined('TL_MODE') && TL_MODE == 'BE')
{
    //$GLOBALS['TL_CSS'][] = 'system/modules/delirius_linkliste/html/be.css|static';
    //$GLOBALS['TL_CSS'][] = '/delirius/delirius_linkliste/src/Resources/public/be.css|static';
    $GLOBALS['TL_CSS'][] = '/delirius/delirius_linkliste/src/Resources/public/be.css|static';



}


$GLOBALS['FE_MOD']['miscellaneous']['delirius_linkliste'] = '\Delirius\Linkliste\linkList';


//$GLOBALS['TL_HOOKS']['activateAccount'][] = [Delirius\Importer\deliriusImporterClass::class, 'doImport'];
