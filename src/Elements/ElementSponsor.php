<?php

namespace Dynamic\Elements\Sponsors\Elements;

use DNADesign\Elemental\Models\BaseElement;
use Dynamic\Elements\Sponsors\Model\Sponsor;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\ORM\FieldType\DBField;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class ElementSponsor
 * @package Dynamic\Elements\Sponsors\Elements
 *
 * @property int $Limit
 * @property string $Content
 * @method \SilverStripe\ORM\ManyManyList Sponsors()
 */
class ElementSponsor extends BaseElement
{
    /**
     * @var string
     */
    private static $icon = 'vendor/dnadesign/silverstripe-elemental/images/base.svg';

    /**
     * @var string
     */
    private static $singular_name = 'Sponsors Element';

    /**
     * @var string
     */
    private static $plural_name = 'Sponsors Elements';

    /**
     * @var string
     */
    private static $table_name = 'ElementSponsor';

    /**
     * @var array
     */
    private static $db = array(
        'Limit' => 'Int',
        'Content' => 'HTMLText',
    );

    /**
     * @var array
     */
    private static $many_many = [
        'Sponsors' => Sponsor::class,
    ];

    /**
     * @var array
     */
    private static $many_many_extraFields = [
        'Sponsors' => [
            // would be sort but issues arise when parent and child both have the same sort field names.
            'SponsorSort' => 'Int',
        ],
    ];

    /**
     * @var array
     */
    private static $defaults = array(
        'Limit' => 0,
    );

    /**
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     */
    public function ElementSummary()
    {
        return DBField::create_field('HTMLText', $this->Content)->Summary(20);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return _t(__CLASS__.'.BlockType', 'Sponsors');
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(
            function (FieldList $fields) {
                $fields->dataFieldByName('Content')
                    ->setRows(8);

                $fields->dataFieldByName('Limit')
                    ->setTitle('Sponsors to show')
                    ->setDescription('0 will show all sponsors');

                if ($this->exists()) {
                    $config = $fields->dataFieldByName('Sponsors')->getConfig();
                    $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
                    $config->addComponent(new GridFieldAddExistingSearchButton());
                    $config->addComponent(new GridFieldOrderableRows('SponsorSort'));
                }
            }
        );

        return parent::getCMSFields();
    }

    /**
     * @return mixed
     */
    public function getSponsorsList()
    {
        $list = $this->Sponsors()->sort('SponsorSort');

        if ($this->Limit > 0) {
            $list = $list->limit($this->Limit);
        }

        return $list;
    }
}
