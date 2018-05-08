<?php

namespace Dynamic\Elements\Sponsors\Tests\Elements;

use Dynamic\Elements\Sponsors\Elements\ElementSponsor;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\NumericField;

/**
 * Class ElementSponsorTest
 * @package Dynamic\Elements\Sponsors\Tests\Elements
 */
class ElementSponsorTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     *
     */
    public function testElementSummary()
    {
        $element = $this->objFromFixture(ElementSponsor::class, 'one');
        $this->assertEquals($element->dbObject('Content')->Summary(20), $element->ElementSummary());
    }

    /**
     *
     */
    public function testGetType()
    {
        $this->assertEquals('Sponsors', ElementSponsor::singleton()->getType());
    }

    /**
     *
     */
    public function testGetCMSFields()
    {
        $newElement = ElementSponsor::create();
        $fields = $newElement->getCMSFields();

        $this->assertNull($fields->dataFieldByName('Sponsors'));
        $this->assertInstanceOf(HTMLEditorField::class, $fields->dataFieldByName('Content'));
        $this->assertInstanceOf(NumericField::class, $fields->dataFieldByName('Limit'));

        $element = $this->objFromFixture(ElementSponsor::class, 'one');
        $existingFields = $element->getCMSFields();

        $this->assertInstanceOf(GridField::class, $existingFields->dataFieldByName('Sponsors'));
    }

    /**
     *
     */
    public function testGetSponsorsList()
    {
        $limitedElement = $this->objFromFixture(ElementSponsor::class, 'one');
        $unlimitedElement = $this->objFromFixture(ElementSponsor::class, 'two');

        $this->assertEquals(2, $limitedElement->getSponsorsList()->count());
        $this->assertEquals(5, $unlimitedElement->getSponsorsList()->count());
    }
}
