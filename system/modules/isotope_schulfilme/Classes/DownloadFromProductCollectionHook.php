<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 23.05.2018
 * Time: 18:07
 */

namespace Markocupic\Isotope\Classes;

/**
 * Class DownloadFromProductCollectionHook
 * @package Markocupic\Isotope\Classes
 */
class DownloadFromProductCollectionHook
{
    /**
     * Set the product alias as the download filename
     * @param $path
     * @param $objFileModel
     * @param $objDownload
     * @param $objProductCollectionDownload
     */
    public function downloadFromProductCollectionHook($path, $objFileModel, $objDownload, $objProductCollectionDownload)
    {

        $objProduct = \Isotope\Model\Product::findByPk($objDownload->pid);
        if ($objProduct !== null)
        {
            if ($objProduct->alias != '')
            {
                header("Content-Type: video/" . strtolower($objFileModel->extension));
                header("Content-Length: " . filesize(TL_ROOT . "/" . $path));
                header('Content-Disposition: attachment; filename="' . $objProduct->alias . '.' . strtolower($objFileModel->extension) . '"');
                readfile(TL_ROOT . "/" . $path);
                exit();
            }
        }
    }
}