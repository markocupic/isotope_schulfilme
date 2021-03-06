<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 22.03.2018
 * Time: 19:26
 */

namespace Markocupic\Isotope\Classes;


use Contao\Config;
use Contao\Database;
use Contao\Date;
use Contao\FrontendUser;
use Contao\Input;
use Contao\MemberModel;
use Contao\StringUtil;

/**
 * Class MovieHelper
 * @package Markocupic\Isotope\Classes
 */
class MovieHelper
{


    /**
     * @param $movieId
     * @return string
     */
    public static function getMovieName($movieId)
    {
        $objProduct = Database::getInstance()->prepare('SELECT * FROM tl_iso_product WHERE published=? AND id=?')->limit(1)->execute('1', $movieId);
        if (!$objProduct->numRows)
        {
            return '';
        }

        return $objProduct->name;
    }

    /**
     * @return string
     */
    public static function getTopicsAsJson()
    {
        $currentGroup = '';
        $objAttribute = Database::getInstance()->prepare('SELECT * FROM tl_iso_attribute_option WHERE pid=? AND published=? ORDER BY sorting')->execute(25, '1');
        while ($objAttribute->next())
        {
            if ($objAttribute->type === 'group')
            {
                $currentGroup = $objAttribute->label;
            }
            $arrAttribute[] = array(
                'type'      => $objAttribute->type,
                'label'     => $objAttribute->label,
                'belongsTo' => ($objAttribute->type === 'option') ? $currentGroup : '',
            );
        }

        $strJS = sprintf('<script>isoTopics = %s</script>', json_encode($arrAttribute));

        return $strJS;

    }

    /**
     * @param $id
     * @return bool
     */
    public static function trailerExists($id)
    {
        $path = sprintf(Config::get('trailerPath'), $id);
        if (is_file(TL_ROOT . '/' . $path))
        {
            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public static function movieExists($id)
    {
        $path = sprintf(Config::get('moviePath'), $id);
        if (is_file(TL_ROOT . '/' . $path))
        {
            return true;
        }

        return false;
    }

    /**
     * generatePage Hook
     * Stream movie
     */
    public function streamMovie()
    {
        if (Input::get('stream_movie'))
        {
            $movieId = Input::get('stream_movie');
            if (FE_USER_LOGGED_IN)
            {
                $objMember = FrontendUser::getInstance();
                if ($objMember !== null)
                {
                    if (static::isAllowed($movieId, $objMember->id))
                    {
                        $strPath = Config::get('moviePath');
                        $strPath = sprintf($strPath, $movieId);

                        static::sendToBrowser($strPath);
                        exit();
                    }
                }
            }

            // Show trailer
            $strPath = Config::get('trailerPath');
            $strPath = sprintf($strPath, $movieId);
            static::sendToBrowser($strPath);
            exit();

        }
    }

    /**
     * Check if logged in member is allowed to watch the full movie
     * @param null $movieId
     * @param null $userId
     * @return bool
     */
    public static function isAllowed($movieId = null, $userId = null)
    {

        $objProduct = Database::getInstance()->prepare('SELECT * FROM tl_iso_product WHERE published=? AND id=?')->limit(1)->execute('1', $movieId);
        if (!$objProduct->numRows)
        {
            return false;
        }

        // Product Faecher
        $arrProductFaecher = StringUtil::deserialize($objProduct->sekundarstufe, true);

        // Product Schulform
        $arrProductSchulform = StringUtil::deserialize($objProduct->schulform, true);

        // Product Inklusion
        $arrProductInklusion = StringUtil::deserialize($objProduct->inklusion, true);

        // Product Bilingualer Unterricht
        $arrProductBilingualerUnterricht = StringUtil::deserialize($objProduct->bilingualer_unterricht, true);


        // Get member object
        $objMember = MemberModel::findByPk($userId);
        if ($objMember === null)
        {
            return false;
        }

        // Check contract expiration
        if ($objMember->vertragsendeAm === '' || $objMember->vertragsendeAm < time())
        {
            return false;
        }

        // Get member settings
        $arrAllowedFaecher = StringUtil::deserialize($objMember->allowFaecher, true);
        $arrAllowedSchulform = StringUtil::deserialize($objMember->allowSchulform, true);
        $arrAllowedInklusion = StringUtil::deserialize($objMember->allowInklusion, true);
        $arrAllowedBilingualerUnterricht = StringUtil::deserialize($objMember->allowBilingualerUnterricht, true);


        if (count($arrAllowedFaecher) < 1 && count($arrAllowedSchulform) < 1 && count($arrAllowedInklusion) < 1 && count($arrAllowedBilingualerUnterricht) < 1)
        {
            return false;
        }

        if (count(array_intersect($arrProductFaecher, $arrAllowedFaecher)) > 0)
        {
            return true;
        }

        if (count(array_intersect($arrProductSchulform, $arrAllowedSchulform)) > 0)
        {
            return true;
        }

        if (count(array_intersect($arrProductInklusion, $arrAllowedInklusion)) > 0)
        {
            return true;
        }

        if (count(array_intersect($arrProductBilingualerUnterricht, $arrAllowedBilingualerUnterricht)) > 0)
        {
            return true;
        }

        return false;

    }

    /**
     * @param $path
     */
    private static function sendToBrowser($path)
    {
        if (is_file(TL_ROOT . '/' . $path))
        {

            $videoStream = new VideoStream(TL_ROOT . '/' . $path);
            $videoStream->start();
            exit();

        }
    }

    /**
     * generatePage Hook
     * Download movie
     */
    public function downloadMovie()
    {
        if (Input::get('download_movie'))
        {
            $movieId = Input::get('download_movie');
            if (FE_USER_LOGGED_IN)
            {
                $objMember = FrontendUser::getInstance();
                if ($objMember !== null)
                {
                    if (Input::get('download_token') === static::getDownloadToken($movieId) && $objMember->allowMovieDownload && static::isAllowed($movieId, $objMember->id))
                    {

                        $strPath = Config::get('moviePath');
                        $strPath = sprintf($strPath, $movieId);

                        header("Content-Type: video/mp4");
                        header("Content-Length: " . filesize(TL_ROOT . "/" . $strPath));
                        readfile(TL_ROOT . "/" . $strPath);
                    }
                }
            }
            exit();
        }

    }

    /**
     * @param $movieId
     * @return string
     */
    public static function getDownloadToken($movieId)
    {
        $objProduct = Database::getInstance()->prepare('SELECT * FROM tl_iso_product WHERE published=? AND id=?')->limit(1)->execute('1', $movieId);
        if (!$objProduct->numRows)
        {
            return '';
        }

        return md5(Date::parse('Y-m-d') . $objProduct->description);
    }


}