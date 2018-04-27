<?php

/**
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2009-2016 terminal42 gmbh & Isotope eCommerce Workgroup
 *
 * @link       https://isotopeecommerce.org
 * @license    https://opensource.org/licenses/lgpl-3.0.html
 */

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    'Markocupic\Isotope\Widget\DocumentUpload'          => 'system/modules/isotope_schulfilme/widgets/DocumentUpload.php',
    'Markocupic\Isotope\Model\Attribute\DocumentUpload' => 'system/modules/isotope_schulfilme/models/Attribute/DocumentUpload.php',
    // MovieHelper
    'Markocupic\Isotope\Classes\MovieHelper'            => 'system/modules/isotope_schulfilme/Classes/MovieHelper.php',
    // NotifyCustomer
    'Markocupic\Isotope\Classes\NotifyCustomer'         => 'system/modules/isotope_schulfilme/Classes/NotifyCustomer.php',
    // VideoStream
    'Markocupic\Isotope\Classes\VideoStream'            => 'system/modules/isotope_schulfilme/Classes/VideoStream.php',
    // ImportGallery
    'Markocupic\Isotope\Classes\ImportGallery'            => 'system/modules/isotope_schulfilme/Classes/ImportGallery.php',
    //Dca
    'Markocupic\Isotope\Classes\Dca\tl_member'          => 'system/modules/isotope_schulfilme/Classes/Dca/tl_member.php',
    'Markocupic\Isotope\Classes\Dca\tl_settings'        => 'system/modules/isotope_schulfilme/Classes/Dca/tl_settings.php',
));

