<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 13.05.2018
 * Time: 19:02
 */

namespace Markocupic\Isotope\Modules;

use Contao\BackendTemplate;
use Contao\Database;
use Contao\Module;
use Isotope\Isotope;
use Patchwork\Utf8;

/**
 * Class IsoProductListFilterDisplay
 * @package Markocupic\Isotope\Modules
 */
class IsoProductListFilterDisplay extends Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_iso_product_list_display';

    /**
     * Display a wildcard in the back end
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['productListFilterDisplay'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }


        return parent::generate();
    }


    /**
     * Generate the module
     */
    protected function compile()
    {

        $objRequestCache = Isotope::getRequestCache();
        $arrFilters = $objRequestCache->getFilters();
        // Var 1
        $aFilter = array();
        // Var 2
        $aFilter2 = array();

        if (!empty($arrFilters) && is_array($arrFilters))
        {
            foreach ($arrFilters as $k => $v)
            {
                foreach ($arrFilters as $kk => $vv)
                {
                    foreach ($vv as $kkk => $vvv)
                    {
                        $arrFilter = explode('=', $kkk);
                        $objAttributeOption = Database::getInstance()->prepare('SELECT * FROM tl_iso_attribute_option WHERE id=?')->limit(1)->execute($arrFilter[1]);
                        if ($objAttributeOption->numRows)
                        {
                            $objAttribute = Database::getInstance()->prepare('SELECT * FROM tl_iso_attribute WHERE field_name=?')->limit(1)->execute($arrFilter[0]);
                            if (!isset($aFilter[$objAttribute->name]))
                            {
                                $aFilter[$objAttribute->name] = array();
                            }
                            $aFilter[$objAttribute->name][] = $objAttributeOption->label;
                            $aFilter2[] = sprintf('<span class="filterItem">%s</span>', $objAttributeOption->label);
                        }
                    }
                }
            }
        }

        if (!empty($aFilter))
        {
            $this->Template->hasFilter = true;
            $this->Template->filters = $aFilter;
        }
        if (!empty($aFilter2))
        {
            $this->Template->hasFilter = true;
            $this->Template->filters2 = implode(' <span class="filter+">+</span> ', $aFilter2);
        }

    }
}