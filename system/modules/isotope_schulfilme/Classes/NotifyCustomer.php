<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 22.03.2018
 * Time: 19:26
 */

namespace Markocupic\Isotope\Classes;


use Contao\Config;
use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\Database;
use Contao\Date;
use Contao\System;
use NotificationCenter\Model\Notification;
use Psr\Log\LogLevel;

/**
 * Class NotifyCustomer
 * @package Markocupic\Isotope\Classes
 */
class NotifyCustomer
{


    /**
     * Notify customer before contract expires
     */
    public static function notifyCustomerBeforeContractExpiration()
    {
        $limit = Config::get('sendNotificationXDaysBeforeContractExpiration') * 24 * 3600;

        // Restore erinnerungsnachrichtVersandt
        if ($limit > 0)
        {
            Database::getInstance()->prepare('UPDATE tl_member SET erinnerungsnachrichtVersandt = ? WHERE erinnerungsnachrichtVersandt = ? AND vertragsendeAm > ?')->execute('', '1', time() + $limit);
        }


        if (!Config::get('sendNotificationXDaysBeforeContractExpiration') > 0)
        {
            return;
        }


        // Use terminal42/notification_center
        $objNotificationCustomer = Notification::findByPk(Config::get('notificationTypeContractExpirationCustomer'));
        $objNotificationAdmin = Notification::findByPk(Config::get('notificationTypeContractExpirationAdmin'));

        if ($objNotificationCustomer === null)
        {
            return;
        }

        $objMember = Database::getInstance()->prepare('SELECT * FROM tl_member WHERE erinnerungsnachrichtVersandt = ? AND vertragsendeAm > ? AND vertragsendeAm < ?')->execute('', time(), time() + $limit);
        while ($objMember->next())
        {
            // Set token array
            $arrTokens = array(
                'customer_email'           => $objMember->email,
                'customer_firstname'       => html_entity_decode($objMember->firstname),
                'customer_lastname'        => html_entity_decode($objMember->lastname),
                'customer_street'          => html_entity_decode($objMember->street),
                'customer_postal'          => html_entity_decode($objMember->postal),
                'customer_city'            => html_entity_decode($objMember->city),
                'customer_country'         => html_entity_decode($objMember->country),
                'customer_expiration_date' => Date::parse('d.m.Y', $objMember->vertragsendeAm),
                'customer_id'              => $objMember->id,
            );

            // Notify admin
            if ($objNotificationAdmin !== null)
            {
                $objNotificationAdmin->send($arrTokens, 'de');
            }

            // Notify customer
            $lang = $objMember->language == '' ? 'de' : $objMember->language;
            $objNotificationCustomer->send($arrTokens, $lang);
            Database::getInstance()->prepare('UPDATE tl_member SET erinnerungsnachrichtVersandt=? WHERE id=?')->execute('1', $objMember->id);


            // Log
            $level = LogLevel::INFO;
            $logger = System::getContainer()->get('monolog.logger.contao');
            $strText = sprintf('Member %s %s (ID: %s) was notified about its contract expiration on %s.', $objMember->firstname, $objMember->lastname, $objMember->id, Date::parse('d.m.Y', $objMember->vertragsendeAm));;
            $logger->log($level, $strText, array('contao' => new ContaoContext(__METHOD__, 'Contract expiration warning')));
        }


    }


}