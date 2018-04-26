<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 22.03.2018
 * Time: 19:26
 */

namespace Markocupic\Isotope\Classes\Dca;


use Contao\Database;

class tl_member
{


    /**
     * @return array
     */
    public function optionsCallbackGetSchulform()
    {
        $arrOptions = array();
        $objAttribute = Database::getInstance()->prepare('SELECT * FROM tl_iso_attribute WHERE field_name=?')->limit(1)->execute('schulform');
        if ($objAttribute->numRows)
        {
            $objAttributeOptions = Database::getInstance()->prepare('SELECT * FROM tl_iso_attribute_option WHERE ptable=? AND type=? AND published=? AND pid=? ORDER BY sorting ASC')->execute('tl_iso_attribute', 'option', '1', $objAttribute->id);
            while ($objAttributeOptions->next())
            {
                $arrOptions[$objAttributeOptions->id] = $objAttributeOptions->label;
            }
        }
        return $arrOptions;
    }


    /**
     * @return array
     */
    public function optionsCallbackGetFaecher()
    {
        $arrOptions = array();
        $group = 'Allgemein';
        $objAttribute = Database::getInstance()->prepare('SELECT * FROM tl_iso_attribute WHERE field_name=?')->limit(1)->execute('sekundarstufe');
        if ($objAttribute->numRows)
        {
            $objAttributeOptions = Database::getInstance()->prepare('SELECT * FROM tl_iso_attribute_option WHERE ptable=? AND (type=? OR type=?) AND published=? AND pid=? ORDER BY sorting ASC')->execute('tl_iso_attribute', 'option', 'group', '1', $objAttribute->id);
            while ($objAttributeOptions->next())
            {
                if ($objAttributeOptions->type === 'group')
                {
                    $group = $objAttributeOptions->label;
                    $arrOptions[$group] = array();
                }
                else
                {
                    $arrOptions[$group][$objAttributeOptions->id] = $objAttributeOptions->label;
                }
            }
        }
        return $arrOptions;
    }
}