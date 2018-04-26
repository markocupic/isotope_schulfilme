<?php
// Add legend
$GLOBALS['TL_DCA']['tl_iso_attribute']['fields']['legend']['options'][] = 'document_legend';

// Palettes
$GLOBALS['TL_DCA']['tl_iso_attribute']['palettes']['documentUpload'] = '{attribute_legend},name,field_name,type,legend;{description_legend:hide},description;{config_legend},documentUploadType,path,extensions,maxlength';

// Add field
$GLOBALS['TL_DCA']['tl_iso_attribute']['fields']['documentUploadType'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_iso_attribute']['documentUploadType'],
    'exclude'   => true,
    'inputType' => 'select',
    'options'   => array('drehbuchvorlage', 'drehbuchkorrektur', 'drehbuchfinal', 'uebersetzungsvorlage', 'untertitel'),
    'reference' => &$GLOBALS['TL_LANG']['ATTR'],
    'eval'      => array('mandatory' => true, 'submitOnChange' => true, 'tl_class' => 'w50'),
    'sql'       => "varchar(64) NOT NULL default ''",
);
