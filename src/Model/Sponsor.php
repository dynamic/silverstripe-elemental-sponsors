<?php

namespace Dynamic\Elements\Model;

use Dynamic\Elements\Elements\ElementSponsor;
use Sheadawson\Linkable\Forms\LinkField;
use Sheadawson\Linkable\Models\Link;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;

/**
 * Class Sponsor
 * @package Dynamic\Elements\Model
 *
 * @property string $Title
 * @property int $LogoID
 * @property int $LinkID
 */
class Sponsor extends DataObject
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
    private static $db = [
        'Title' => 'Varchar(255)',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Logo' => Image::class,
        'Link' => Link::class,
    ];

    /**
     * @var array
     */
    private static $belongs_many_many = [
        'SponsorsElements' => ElementSponsor::class,
    ];

    /**
     * @var array
     */
    private static $owns = [
        'Logo',
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'Title' => [
            'title' => 'Name',
        ],
        'Logo.CMSThumbnail' => [
            'title' => 'Logo',
        ],
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->replaceField(
            'LinkID',
            LinkField::create('LinkID')
                ->setTitle('Sponsor Link')
        );

        return $fields;
    }

    /**
     * @return null
     */
    public function getPage()
    {
        $page = null;

        if ($this->SponsorsElements()) {
            if ($this->SponsorsElements()->hasMethod('getPage')) {
                $page = $this->SponsorsElements()->first()->getPage();
            }
        }

        return $page;
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param Member $member
     * @return boolean
     */
    public function canView($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        if ($page = $this->getPage()) {
            return $page->canView($member);
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param Member $member
     *
     * @return boolean
     */
    public function canEdit($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        if ($page = $this->getPage()) {
            return $page->canEdit($member);
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * Uses archive not delete so that current stage is respected i.e if a
     * element is not published, then it can be deleted by someone who doesn't
     * have publishing permissions.
     *
     * @param Member $member
     *
     * @return boolean
     */
    public function canDelete($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        if ($page = $this->getPage()) {
            return $page->canArchive($member);
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param Member $member
     * @param array $context
     *
     * @return boolean
     */
    public function canCreate($member = null, $context = array())
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }
}
