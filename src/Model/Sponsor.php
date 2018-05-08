<?php

namespace Dynamic\Elements\Sponsors\Model;

use Dynamic\BaseObject\Model\BaseElementObject;
use Dynamic\Elements\Sponsors\Elements\ElementSponsor;
use SilverStripe\Forms\FieldList;

/**
 * Class Sponsor
 * @package Dynamic\Elements\Sponsors\Model
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
            ->setDescription('The logo to display for the sponsor');

        return $fields;
    }

    /**
     * @return \SilverStripe\ORM\ValidationResult
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->ImageID) {
            $result->addError('A logo is required before you can save');
        }

        return $result;
    }
}
