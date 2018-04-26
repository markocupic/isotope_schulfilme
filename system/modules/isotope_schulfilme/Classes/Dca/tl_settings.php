<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 22.03.2018
 * Time: 19:26
 */

namespace Markocupic\Isotope\Classes\Dca;


use Contao\Database;

class tl_settings
{

    /**
     * @return array
     */
    public function getNotifications()
    {
        $arrOptions = array();
        $objNotification = Database::getInstance()->execute('SELECT * FROM tl_nc_notification');
        while($objNotification->next())
        {
            $arrOptions[$objNotification->id] = $objNotification->title;
        }

        return $arrOptions;
    }

}