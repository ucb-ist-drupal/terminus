<?php

namespace Pantheon\Terminus\Collections;

use Pantheon\Terminus\Models\Metric;
use Pantheon\Terminus\Site\SiteMetricsTrait;

/**
 * Class EnvironmentMetrics
 *
 * @package Pantheon\Terminus\Collections
 */
class EnvironmentMetrics extends EnvironmentOwnedCollection
{
    use SiteMetricsTrait;

    public const PRETTY_NAME = 'metrics';

    /**
     * @var string
     */
    protected $collected_class = Metric::class;

    /**
     * @var string base URL to fetch
     */
    protected $url =
        'sites/{site_id}/environments/{environment_id}/traffic?duration={duration}';

    /**
     * EnvironmentMetrics constructor
     */
    public function __constructor()
    {
    }
}
