<?php

namespace Dynamic\Elements\Sponsors\Model;

use Dynamic\BaseObject\Model\BaseElementObject;
use Dynamic\Elements\Sponsors\Elements\ElementSponsor;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Director;
use SilverStripe\Forms\FieldList;

/**
 * Class Sponsor
 * @package Dynamic\Elements\Sponsors\Model
 *
 * @method \SilverStripe\ORM\ManyManyList SponsorsElements()
 */
class Sponsor extends BaseElementObject
{
    /**
     * @var string
     */
    private static $singular_name = 'Sponsor';

    /**
     * @var string
     */
    private static $plural_name = 'Sponsors';

    /**
     * @var string
     */
    private static $table_name = 'Sponsor';

    /**
     * @var array
     */
    private static $belongs_many_many = [
        'SponsorsElements' => ElementSponsor::class,
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->dataFieldByName('Image')
            ->setTitle('Logo')
            ->setFolderName('Uploads/Sponsors')
            ->setDescription('The logo to display for the sponsor');

        return $fields;
    }

    /**
     * @return \SilverStripe\ORM\ValidationResult
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->Title) {
            $result->addError('A title is required before you can save');
        }

        return $result;
    }
}
