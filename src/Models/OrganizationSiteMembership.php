<?php

namespace Pantheon\Terminus\Models;

use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use Pantheon\Terminus\Collections\Tags;
use Pantheon\Terminus\Friends\OrganizationInterface;
use Pantheon\Terminus\Friends\OrganizationTrait;
use Pantheon\Terminus\Friends\SiteJoinInterface;
use Pantheon\Terminus\Friends\SiteJoinTrait;

/**
 * Class OrganizationSiteMembership
 *
 * @package Pantheon\Terminus\Models
 */
class OrganizationSiteMembership extends TerminusModel implements
    ContainerAwareInterface,
    OrganizationInterface,
    SiteJoinInterface
{
    use ContainerAwareTrait;
    use OrganizationTrait;
    use SiteJoinTrait;

    public const PRETTY_NAME = 'organization-site membership';

    /**
     * @var Tags
     */
    private $tags;

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        $org = $this->getOrganization();
        return "{$org->id}: {$org->getName()}";
    }

    /**
     * Removes a site from this organization
     *
     * @return Workflow
     */
    public function delete()
    {
        return $this->getOrganization()->getWorkflows()->create(
            'remove_organization_site_membership',
            ['params' => ['site_id' => $this->getSite()->id,],]
        );
    }

    /**
     * @inheritdoc
     */
    public function getSite()
    {
        if (empty($this->site)) {
            $nickname = \uniqid(__FUNCTION__ . '-');
            $this->getContainer()->add($nickname, Site::class)
                ->addArgument($this->get('site'));
            $site = $this->getContainer()->get($nickname);
            $site->memberships = [$this];
            $site->tags = $this->getTags();
            $this->setSite($site);
        }
        return $this->site;
    }

    /**
     * @return Tags
     */
    public function getTags()
    {
        if (!$this->tags) {
            $nickname = \uniqid(__FUNCTION__ . '-');
            $this->getContainer()->add($nickname, Tags::class)
                ->addArgument(['org_site_membership' => $this]);
            $this->tags = $this->getContainer()->get($nickname);
            $this->tags->fetch((array)$this->get('tags'));
        }
        return $this->tags;
    }
}
