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

    protected function import()
    {
        //echo "25062;e.simmchen@icloud.com;XXX_e.simmchen@icloud.com<br>25060;hannes.langhammer@gmx.de;XXX_hannes.langhammer@gmx.de<br>25029;carla.weinmayr@gmshorgenzell.de;XXX_carla.weinmayr@gmshorgenzell.de<br>24942;carola.ahner@web.de;XXX_carola.ahner@web.de<br>24921;carmen.nischik@t-online.de;XXX_carmen.nischik@t-online.de<br>24895;e.dobrita@icloud.com;XXX_e.dobrita@icloud.com<br>24893;Denizgenc@gmx.de;XXX_Denizgenc@gmx.de<br>24889;Kern.Petra@t-online.de;XXX_Kern.Petra@t-online.de<br>24881;sergio.brambila@liu.se;XXX_sergio.brambila@liu.se<br>24866;konstanze.heinemann@gmx.de;XXX_konstanze.heinemann@gmx.de<br>24863;juliane.sander@gmx.de;XXX_juliane.sander@gmx.de<br>24843;kerstinlanghammer@gmx.de;XXX_kerstinlanghammer@gmx.de<br>24841;u.hasselmann@panketal.de;XXX_u.hasselmann@panketal.de<br>24779;stroh.stefanie@gmail.com;XXX_stroh.stefanie@gmail.com<br>24777;glcoaching@bluewin.ch;XXX_glcoaching@bluewin.ch<br>24760;a.rossignol@ecolemoser.ch;XXX_a.rossignol@ecolemoser.ch<br>24756;info@bettinahoffmann.de;XXX_info@bettinahoffmann.de<br>24752;petra.knupfer@t-online.de;XXX_petra.knupfer@t-online.de<br>24750;jana.holzaepfel@gmail.com;XXX_jana.holzaepfel@gmail.com<br>24746;kerstin-schreeck@web.de;XXX_kerstin-schreeck@web.de<br>24740;christina_ebel@web.de;XXX_christina_ebel@web.de<br>24730;sickingerstefanie@web.de;XXX_sickingerstefanie@web.de<br>24719;schulleitung@vs-emmering.de;XXX_schulleitung@vs-emmering.de<br>24702;scoula_scuol@gmx.ch;XXX_scoula_scuol@gmx.ch<br>24691;grosset.mhl@t-online.de;XXX_grosset.mhl@t-online.de<br>24684;monikakosack@t-online.de;XXX_monikakosack@t-online.de<br>24649;ulrike.ruckdeschel@stsbergedorf.de;XXX_ulrike.ruckdeschel@stsbergedorf.de<br>24455;toni.frei@schulegoldach.ch;XXX_toni.frei@schulegoldach.ch<br>24399;vschreiw@uni-bremen.de;XXX_vschreiw@uni-bremen.de<br>24397;mail@erikbender.com;XXX_mail@erikbender.com<br>24197;schulfilme@fes-dresden.de;XXX_schulfilme@fes-dresden.de<br>23933;petra.kuellmey@gmx.de;XXX_petra.kuellmey@gmx.de<br>23886;christiana.nemeth@web.de;XXX_christiana.nemeth@web.de<br>23185;fingerhuth@jpp.de;XXX_fingerhuth@jpp.de<br>22773;richterich@jpp.de;XXX_richterich@jpp.de<br>22568;semasahin@web.de;XXX_semasahin@web.de";
        //return;
        $objDB = Database::getInstance()->prepare('SELECT * FROM tl_member ORDER BY id DESC')->execute();
        while($objDB->next())
        {
            $objDB2 = Database::getInstance()->prepare('SELECT * FROM tl_member WHERE id!=? AND username=? ORDER BY id DESC')->limit(1)->execute($objDB->id,$objDB->username);
            if($objDB2->numRows)
            {
                $set = array(
                    'username' => 'XXX_' . $objDB->username,
                    'email' => 'XXX_' . $objDB->email,
                );
                Database::getInstance()->prepare('UPDATE tl_member %s WHERE id=?')->set($set)->execute($objDB->id);
                echo $objDB->id . ';' . $objDB->username . ';' . 'XXX_' . $objDB->username . "\r\n";

            }
        }
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