<?php

/**
 * Extend the default palette
 */
Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('schulfilme_legend', 'groups_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
    ->addLegend('schulfilme_vertragsdetails_legend', 'schulfilme_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
    ->addField(array('allowSchulform', 'allowFaecher', 'allowMovieDownload'), 'schulfilme_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->addField(array('erinnerungsnachrichtVersandt', 'vertragsendeAm'), 'schulfilme_vertragsdetails_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_member');


$GLOBALS['TL_DCA']['tl_member']['fields']['vertragsendeAm'] =
    array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_member']['vertragsendeAm'],
        'exclude'   => true,
        'inputType' => 'text',
        'eval'      => array('rgxp' => 'date', 'datepicker' => true, 'tl_class' => 'w50 wizard'),
        'sql'       => "varchar(11) NOT NULL default ''",
    );

$GLOBALS['TL_DCA']['tl_member']['fields']['erinnerungsnachrichtVersandt'] =
    array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_member']['erinnerungsnachrichtVersandt'],
        'exclude'   => true,
        'filter'    => true,
        'inputType' => 'checkbox',
        'eval'      => array('submitOnChange' => true, 'tl_class' => 'clr'),
        'sql'       => "char(1) NOT NULL default ''",
    );

$GLOBALS['TL_DCA']['tl_member']['fields']['allowMovieDownload'] =
    array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_member']['allowMovieDownload'],
        'exclude'   => true,
        'filter'    => true,
        'inputType' => 'checkbox',
        'eval'      => array('submitOnChange' => false, 'tl_class' => 'clr m12'),
        'sql'       => "char(1) NOT NULL default ''",
    );


$GLOBALS['TL_DCA']['tl_member']['fields']['allowSchulform'] =
    array(
        'label'            => &$GLOBALS['TL_LANG']['tl_member']['allowSchulform'],
        'exclude'          => true,
        'filter'           => true,
        'inputType'        => 'checkbox',
        'options_callback' => array('Markocupic\Isotope\Classes\Dca\tl_member', 'optionsCallbackGetSchulform'),
        'eval'             => array('multiple' => true, 'feEditable' => false, 'feGroup' => 'schulfilme', 'tl_class' => 'clr'),
        'sql'              => "blob NULL",
    );


$GLOBALS['TL_DCA']['tl_member']['fields']['allowFaecher'] =
    array(
        'label'            => &$GLOBALS['TL_LANG']['tl_member']['allowFaecher'],
        'exclude'          => true,
        'filter'           => true,
        'inputType'        => 'checkbox',
        'options_callback' => array('Markocupic\Isotope\Classes\Dca\tl_member', 'optionsCallbackGetFaecher'),
        'eval'             => array('multiple' => true, 'feEditable' => false, 'feGroup' => 'schulfilme', 'tl_class' => 'clr'),
        'sql'              => "blob NULL",
    );