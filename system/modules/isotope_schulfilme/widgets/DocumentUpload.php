<?php

/**
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2009-2016 terminal42 gmbh & Isotope eCommerce Workgroup
 *
 * @link       https://isotopeecommerce.org
 * @license    https://opensource.org/licenses/lgpl-3.0.html
 */

namespace Markocupic\Isotope\Widget;

use Contao\Config;
use Contao\Message;
use Contao\StringUtil;
use Contao\Widget;


class DocumentUpload extends Widget implements \uploadable
{

    /**
     * Submit user input
     * @var boolean
     */
    protected $blnSubmitInput = true;

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'be_widget';

    /**
     * Temporary folder for uploads
     * @var string
     */
    protected $strTempFolder = 'assets/images';


    /**
     * Initialize the FileUpload object
     *
     * @param array $arrAttributes
     */
    public function __construct($arrAttributes = null)
    {

        $this->addAttribute('multiple', false);
        $arrAttributes['multiple'] = 'false';
        parent::__construct($arrAttributes);

        $this->objUploader = new \FileUpload();
        $this->objUploader->setName($this->strName);

        // Do not save anything in the db
        $this->blnSubmitInput = false;
    }


    /**
     * Add specific attributes
     *
     * @param string $strKey
     * @param mixed $varValue
     */
    public function __set($strKey, $varValue)
    {
        switch ($strKey)
        {
            case 'mandatory':
                $this->arrConfiguration['mandatory'] = $varValue ? true : false;
                break;

            case 'value':
                $this->varValue = deserialize($varValue);
                break;

            default:
                parent::__set($strKey, $varValue);
                break;
        }
    }


    /**
     * @param mixed $varInput
     * @return array|bool
     */
    public function validator($varInput)
    {
        $uploadIndex = 0;
        if (!empty($_FILES[$this->strName]['name'][$uploadIndex]) && !empty($this->arrConfiguration['documentUploadType']))
        {
            // Do not allow multifileupload
            if (isset($_FILES[$this->strName]['name'][1]))
            {
                $this->addError($GLOBALS['TL_LANG']['ERR']['doNotAllowMultifileupload']);
                return false;
            }


            // Check for allowed extensions (Attribute settings)
            $arrAllowed = array();
            if ($this->arrConfiguration['extensions'] != '')
            {
                $arrAllowed = explode(',', strtolower($this->arrConfiguration['extensions']));
            }
            $strExtension = strtolower(pathinfo($_FILES[$this->strName]['name'][$uploadIndex], PATHINFO_EXTENSION));
            if (count($arrAllowed) > 0 && !in_array($strExtension, $arrAllowed))
            {
                Message::addError(sprintf($GLOBALS['TL_LANG']['ERR']['filetype'], $strExtension));
                $this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['filetype'], $strExtension));
                return false;
            }


            // Check for allowed extensions (Backend Settings)
            if (!\in_array($strExtension, StringUtil::trimsplit(',', strtolower(Config::get('uploadTypes')))))
            {
                $this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['filetype'], $strExtension));
                Message::addError(sprintf($GLOBALS['TL_LANG']['ERR']['filetype'], $strExtension));
                return false;
            }


            // Customize filename
            $name = $this->Input->get('id') . '-' . $this->arrConfiguration['documentUploadType'] . '.' . $strExtension;
            $_FILES[$this->strName]['name'][$uploadIndex] = $name;


            // Specify the target folder in the DCA (eval)
            $strUploadTo = $this->strTempFolder;
            if (isset($this->arrConfiguration['path']))
            {
                $strUploadTo = $this->arrConfiguration['path'];
            }

            $arrInput = $this->objUploader->uploadTo($strUploadTo);
            if(count($arrInput) > 0)
            {
                foreach($arrInput as $strFile)
                {
                    Message::addInfo(sprintf($GLOBALS['TL_LANG']['MSC']['newFileUpload'], $strFile), 'BE');
                }
            }
            return $arrInput;
        }

    }


    /**
     * Generate the markup for the default uploader
     *
     * @return string
     */
    public function generate()
    {
        // Allow only accepted extensions
        $accepted = '';
        if (!empty($this->arrConfiguration['extensions']))
        {
            $arrExtensions = StringUtil::trimsplit(',', $this->arrConfiguration['extensions']);
            $arrExtensions = array_map(function ($el) {
                return '.' . $el;
            }, $arrExtensions);
            $accepted = sprintf('accept="%s" ', implode(',', $arrExtensions));
        }

        // Generate the file input field
        $return = sprintf('<div><input type="file" name="%s[]" class="tl_upload_field" %sonfocus="Backend.getScrollOffset()"></div>', $this->strName, $accepted);

        // Generate tip
        if (isset($GLOBALS['TL_LANG']['tl_files']['fileupload'][1]))
        {
            $tip = sprintf($GLOBALS['TL_LANG']['tl_files']['fileupload'][1], \System::getReadableSize($this->getMaximumUploadSize()), \Config::get('gdMaxImgWidth') . 'x' . \Config::get('gdMaxImgHeight'));
            $return .= '<p class="tl_help tl_tip">' . $tip . '</p>';
        }

        $strLink = $this->listUploadedFiles();
        $return .= '<div class="document-upload-links"><br>' . $strLink . '</div>';

        return ltrim($return);
    }



    /**
     * @return string
     */
    protected function listUploadedFiles()
    {

        $strLink = '';

        $arrFiles = array();
        if (isset($this->arrConfiguration['path']) && isset($this->arrConfiguration['documentUploadType']) && $this->Input->get('id') > 0)
        {
            $strUploadTo = $this->arrConfiguration['path'];
            foreach (scan(TL_ROOT . '/' . $strUploadTo) as $strFile)
            {
                $pattern = sprintf('%s-%s.', $this->Input->get('id'), $this->arrConfiguration['documentUploadType']);
                if (strpos($strFile, $pattern) !== false)
                {
                    $arrFiles[] = $strUploadTo . '/' . $strFile;
                }
            }
        }

        foreach ($arrFiles as $strFile)
        {
            $strLink .= '<p class="tl_tip"><a href="contao/popup?download=true&src=' . base64_encode($strFile) . '">' . $strFile . '</a></p>';
        }

        return $strLink;
    }
}