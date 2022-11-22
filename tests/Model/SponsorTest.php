<?php

namespace Dynamic\Elements\Sponsors\Tests\Model;

use Dynamic\Elements\Sponsors\Model\Sponsor;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ValidationResult;

/**
 * Class SponsorTest
 * @package Dynamic\Elements\Sponsors\Tests\Model
 */
class SponsorTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $sponsor = $this->objFromFixture(Sponsor::class, 'one');
        $this->assertInstanceOf(FieldList::class, $sponsor->getCMSFields());
    }

    /**
     *
     */
    public function testValidate()
    {
        $sponsor = $this->objFromFixture(Sponsor::class, 'three');
        $result = $sponsor->validate();
        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertFalse($result->isValid());
        $this->assertContains([
            'message' => 'A title is required before you can save',
            'fieldName' => null,
            'messageType' => 'error',
            'messageCast' => 'text',

        ], $result->getMessages());

        $sponsor = $this->objFromFixture(Sponsor::class, 'five');
        $result = $sponsor->validate();
        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertTrue($result->isValid());
    }
}
