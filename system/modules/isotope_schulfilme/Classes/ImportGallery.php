<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 27.04.2018
 * Time: 19:54
 */

namespace Markocupic\Isotope\Classes;

/**
 * Class ImportGallery
 * @package Markocupic\Isotope\Classes
 */
class ImportGallery
{

    /**
     * Was used during developpment
     * no more usage
     */
    public static function importGallery()
    {

        $objFilm = Database::getInstance()->prepare('SELECT * FROM  tl_iso_product')->execute();
        while ($objFilm->next())
        {

            $arrFiles = array();
            //echo print_r($arrFiles,true);
            if (is_file(TL_ROOT . '/files/client/images/' . $objFilm->id . '.jpg'))
            {
                //Files::getInstance()->delete('isotope/i/' . $objFilm->id . '.jpg');
                Files::getInstance()->copy('files/client/images/' . $objFilm->id . '.jpg', 'isotope/i/id-' . $objFilm->id . '.jpg');
                $arrFiles[] = array(
                    'src'  => 'id-' . $objFilm->id . '.jpg',
                    'alt'  => '',
                    'link' => '',
                    'desc' => '',
                    //'translate' => 'none',
                );
                Database::getInstance()->prepare('UPDATE tl_iso_product SET images = ? WHERE id=?')->execute(serialize($arrFiles), $objFilm->id);
            }
        }
    }
}