<?php

/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['delirius_linkliste'] = '{title_legend},name,type;{option_legend},delirius_linkliste_categories,delirius_linkliste_fesort,delirius_linkliste_template;{image_legend},delirius_linkliste_showimage,imgSize,delirius_linkliste_standardfavicon;{expert_legend:hide},cssID,space;style';




/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['delirius_linkliste_categories'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_categories'],
    'exclude' => true,
    'inputType' => 'checkboxWizard',
    'foreignKey' => 'tl_link_category.title',
    'eval' => array('multiple' => true, 'mandatory' => false, 'tl_class' => 'm12'),
    'sql' => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['delirius_linkliste_fesort'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_fesort'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => array('random', 'order', 'title', 'url'),
    'reference' => &$GLOBALS['TL_LANG']['tl_module']['fesort_option'],
    'eval' => array('mandatory' => true, 'tl_class' => 'w50'),
    'sql' => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['delirius_linkliste_template'] = array
(
'label' => &$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_template'],
 'default' => 'linkliste_standard',
 'exclude' => true,
 'inputType' => 'select',
 'options_callback' => array('tl_module_linkliste', 'getTemplates'),
 'eval' => array('includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'),
 'sql' => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['delirius_linkliste_showimage'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_showimage'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('mandatory' => false, 'tl_class' => 'clr'),
    'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['delirius_linkliste_standardfavicon'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_standardfavicon'],
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => array('files' => true, 'fieldType' => 'radio', 'filesOnly' => true, 'extensions' => 'jpg,jpeg,png,gif,ico', 'tl_class' => 'clr'),
    'sql' => "blob NULL"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['delirius_linkliste_imagesize'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['delirius_linkliste_imagesize'],
    'exclude' => true,
    'inputType' => 'imageSize',
    'options' => $GLOBALS['TL_CROP'],
    'reference' => &$GLOBALS['TL_LANG']['MSC'],
    'eval' => array('rgxp' => 'digit', 'nospace' => true, 'helpwizard' => true, 'tl_class' => 'clr'),
    'sql' => "varchar(64) NOT NULL default ''"
);

class tl_module_linkliste extends Backend
{

    /**
     * Return all event templates as array
     * @param object
     * @return array
     */
    public function getTemplates(DataContainer $dc)
    {
        return Controller::getTemplateGroup('linkliste_');
    }

}

?>
