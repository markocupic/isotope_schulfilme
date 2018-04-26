<?php

/**
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2009-2016 terminal42 gmbh & Isotope eCommerce Workgroup
 *
 * @link       https://isotopeecommerce.org
 * @license    https://opensource.org/licenses/lgpl-3.0.html
 */

namespace Markocupic\Isotope\Model\Attribute;

use Isotope\Model\Attribute;

/**
 * Attribute to implement frontend uploads
 *
 * @copyright  Isotope eCommerce Workgroup 2009-2012
 * @author     Andreas Schempp <andreas.schempp@terminal42.ch>
 */
class DocumentUpload extends Attribute
{

    /**
     * @inheritdoc
     */
    public function saveToDCA(array &$arrData)
    {
        parent::saveToDCA($arrData);
        $maxlength = (int) $this->maxlength ?: 255;
        $arrData['fields'][$this->field_name]['sql'] = "varchar($maxlength) NOT NULL default ''";
    }

}