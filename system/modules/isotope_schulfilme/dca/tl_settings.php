<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 26.04.2018
 * Time: 14:02
 */

Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('schulfilme_legend', 'backend_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
    ->addField(array('sendNotificationXDaysBeforeContractExpiration','notificationTypeContractExpirationCustomer','notificationTypeContractExpirationAdmin'), 'schulfilme_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_settings');

$GLOBALS['TL_DCA']['tl_settings']['fields']['sendNotificationXDaysBeforeContractExpiration'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['sendNotificationXDaysBeforeContractExpiration'],
    'inputType' => 'text',
    'eval'      => array('mandatory' => true, 'rgxp' => 'natural', 'decodeEntities' => true, 'tl_class' => 'w50'),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['notificationTypeContractExpirationCustomer'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['notificationTypeContractExpirationCustomer'],
    'inputType' => 'select',
    'options_callback'   => array('Markocupic\Isotope\Classes\Dca\tl_settings', 'getNotifications'),
    'eval'      => array('multiple' => false, 'tl_class'=> 'clr'),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['notificationTypeContractExpirationAdmin'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['notificationTypeContractExpirationAdmin'],
    'inputType' => 'select',
    'options_callback'   => array('Markocupic\Isotope\Classes\Dca\tl_settings', 'getNotifications'),
    'eval'      => array('multiple' => false, 'tl_class'=> 'clr'),
);
