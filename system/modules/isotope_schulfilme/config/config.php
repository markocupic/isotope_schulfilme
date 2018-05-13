<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 07.02.2018
 * Time: 21:03
 */

/**
 * Backend form fields
 */
$GLOBALS['BE_FFL']['documentUpload'] = 'Markocupic\Isotope\Widget\DocumentUpload';

/**
 * Attributes
 */
\Isotope\Model\Attribute::registerModelType('documentUpload', 'Markocupic\Isotope\Model\Attribute\DocumentUpload');

// Set the movie path
Contao\Config::set('moviePath', 'files/client/movies/%s.mp4');

// Set the trailer path
Contao\Config::set('trailerPath', 'files/client/trailer/t%s.mp4');

// Parse template Hook
$GLOBALS['TL_HOOKS']['generatePage'][] = array('Markocupic\Isotope\Classes\MovieHelper', 'streamMovie');
$GLOBALS['TL_HOOKS']['generatePage'][] = array('Markocupic\Isotope\Classes\MovieHelper', 'downloadMovie');
$GLOBALS['TL_HOOKS']['generatePage'][] = array('Markocupic\Isotope\Classes\NotifyCustomer', 'notifyCustomerBeforeContractExpiration');


// notification_center_config.php
$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['schulfilme'] = array
(
    // Type
    'remindCustmOnContractExpiration' => array
    (
        // Field in tl_nc_language
        'email_sender_name'    => array(),
        'email_sender_address' => array(),
        'recipients'           => array('customer_email'),
        'email_replyTo'        => array(),
        'email_recipient_cc'   => array(),
        'email_subject'        => array('customer_id', 'customer_firstname', 'customer_lastname', 'customer_street', 'customer_postal', 'customer_city', 'customer_expiration_date'),
        'email_text'           => array('customer_id', 'customer_firstname', 'customer_lastname', 'customer_street', 'customer_postal', 'customer_city', 'customer_expiration_date'),
        'email_html'           => array('customer_firstname', 'customer_lastname', 'customer_street', 'customer_postal', 'customer_city', 'customer_expiration_date'),
    ),

    // Type
    'remindAdminOnContractExpiration' => array
    (
        // Field in tl_nc_language
        'email_sender_name'    => array(),
        'email_sender_address' => array(),
        'recipients'           => array('customer_email'),
        'email_replyTo'        => array(),
        'email_recipient_cc'   => array(),
        'email_subject'        => array('customer_id', 'customer_firstname', 'customer_lastname', 'customer_street', 'customer_postal', 'customer_city', 'customer_expiration_date'),
        'email_text'           => array('customer_id', 'customer_firstname', 'customer_lastname', 'customer_street', 'customer_postal', 'customer_city', 'customer_expiration_date'),
        'email_html'           => array('customer_firstname', 'customer_lastname', 'customer_street', 'customer_postal', 'customer_city', 'customer_expiration_date'),
    ),
);

// Front end modules
$GLOBALS['FE_MOD']['iso_schulfilme'] = array
(
    'productListFilterDisplay' => 'Markocupic\Isotope\Modules\IsoProductListFilterDisplay',
);
