<?php

/**
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2009-2016 terminal42 gmbh & Isotope eCommerce Workgroup
 *
 * @link       https://isotopeecommerce.org
 * @license    https://opensource.org/licenses/lgpl-3.0.html
 */

\System::loadLanguageFile(\Isotope\Model\ProductType::getTable());

/**
 * Table tl_iso_product
 */

/**
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['movie_language'] = array(
    'label'                 => &$GLOBALS['TL_LANG']['tl_iso_product']['movie_language'],
    'exclude'               => true,
    'search'                => true,
    'sorting'               => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'tl_class'=>'clr long'),
    'attributes'            => array('legend'=>'general_legend', 'multilingual'=>true, 'fixed'=>true, 'fe_sorting'=>true, 'fe_search'=>true),
    'sql'                   => "varchar(24) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_product']['fields']['fields']['movie_length'] = array(
    'label'                 => &$GLOBALS['TL_LANG']['tl_iso_product']['movie_length'],
    'exclude'               => true,
    'search'                => true,
    'sorting'               => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'tl_class'=>'clr long'),
    'attributes'            => array('legend'=>'general_legend', 'multilingual'=>true, 'fixed'=>true, 'fe_sorting'=>true, 'fe_search'=>true),
    'sql'                   => "varchar(12) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_product']['fields']['drehbuchvorlage'] = array(
    'label'                 => &$GLOBALS['TL_LANG']['tl_iso_product']['drehbuchvorlage'],
    'exclude'               => true,
    'inputType'             => 'mediaManager',
    'explanation'           => 'mediaManager',
    'eval'                  => array('extensions'=>'doc,docx,pdf', 'helpwizard'=>true, 'tl_class'=>'clr'),
    'attributes'            => array('legend'=>'document_legend', 'fixed'=>true, 'multilingual'=>true, 'dynamic'=>true, 'systemColumn'=>true, 'fetch_fallback'=>true),
    'sql'                   => "blob NULL",
);

$GLOBALS['TL_DCA']['tl_iso_product']['fields']['movie_year'] = array(
    'label'                 => &$GLOBALS['TL_LANG']['tl_iso_product']['movie_year'],
    'exclude'               => true,
    'search'                => true,
    'sorting'               => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'tl_class'=>'clr long'),
    'attributes'            => array('legend'=>'general_legend', 'multilingual'=>true, 'fixed'=>true, 'fe_sorting'=>true, 'fe_search'=>true),
    'sql'                   => "varchar(4) NOT NULL default ''",
);
**/