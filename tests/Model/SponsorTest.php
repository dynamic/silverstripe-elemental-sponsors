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
        $this->assertTrue(
            $this->hasValidationMessage($result->getMessages(), 'title is required'),
            'Validation error should mention required title'
        );

        // Test that valid title passes validation
        $sponsor = $this->objFromFixture(Sponsor::class, 'five');
        $result = $sponsor->validate();
        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertTrue($result->isValid(), 'Sponsor with valid title should pass validation');
    }

    /**
     * Helper method to check if validation messages contain expected text
     * Reduces code duplication when checking validation message content
     *
     * @param array $messages ValidationResult messages
     * @param string $expectedText Text to search for (case-insensitive)
     * @return bool
     */
    private function hasValidationMessage(array $messages, string $expectedText): bool
    {
        foreach ($messages as $message) {
            $messageText = '';

            if (is_array($message) && isset($message['message'])) {
                $messageText = $message['message'];
            } elseif (is_string($message)) {
                $messageText = $message;
            }

            if (stripos($messageText, $expectedText) !== false) {
                return true;
            }
        }

        return false;
    }
}