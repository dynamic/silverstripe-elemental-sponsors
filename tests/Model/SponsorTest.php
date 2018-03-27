<?php

namespace Dynamic\Elements\Tests\Model;

use Dynamic\Elements\Model\Sponsor;
use Sheadawson\Linkable\Forms\LinkField;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Security\Member;

/**
 * Class SponsorTest
 * @package Dynamic\Elements\Tests\Model
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
        $sponsor = Sponsor::singleton();
        $this->assertInstanceOf(LinkField::class, $sponsor->getCMSFields()->dataFieldByName('LinkID'));
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture(Sponsor::class, 'one');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canView($admin));

        $siteowner = $this->objFromFixture(Member::class, 'site-owner');
        $this->assertTrue($object->canView($siteowner));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertNull($object->canView($member));
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $object = $this->objFromFixture(Sponsor::class, 'one');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canEdit($admin));

        $siteowner = $this->objFromFixture(Member::class, 'site-owner');
        $this->assertTrue($object->canEdit($siteowner));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertNull($object->canEdit($member));
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = $this->objFromFixture(Sponsor::class, 'one');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canDelete($admin));

        $siteowner = $this->objFromFixture(Member::class, 'site-owner');
        $this->assertTrue($object->canDelete($siteowner));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertNull($object->canDelete($member));
    }

    /**
     *
     */
    public function testCanCreate()
    {
        $object = $this->objFromFixture(Sponsor::class, 'one');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canCreate($admin));

        $siteowner = $this->objFromFixture(Member::class, 'site-owner');
        $this->assertTrue($object->canCreate($siteowner));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertNull($object->canCreate($member));
    }
}
