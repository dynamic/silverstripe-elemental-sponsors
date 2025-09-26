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
     * Test that validation behaves correctly for required Title field
     */
    public function testValidate()
    {
        // Test that empty title fails validation
        $sponsor = $this->objFromFixture(Sponsor::class, 'three');
        $result = $sponsor->validate();
        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertFalse($result->isValid(), 'Sponsor with empty title should fail validation');
        $this->assertNotEmpty($result->getMessages(), 'Validation should return error messages');

        // Verify the error message contains expected text
        $messages = $result->getMessages();
        $errorFound = false;
        foreach ($messages as $message) {
            if (is_array($message) && isset($message['message'])) {
                if (strpos($message['message'], 'title is required') !== false) {
                    $errorFound = true;
                    break;
                }
            } elseif (is_string($message) && strpos($message, 'title is required') !== false) {
                $errorFound = true;
                break;
            }
        }
        $this->assertTrue($errorFound, 'Validation error should mention required title');

        // Test that valid title passes validation
        $sponsor = $this->objFromFixture(Sponsor::class, 'five');
        $result = $sponsor->validate();
        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertTrue($result->isValid(), 'Sponsor with valid title should pass validation');
    }
}
