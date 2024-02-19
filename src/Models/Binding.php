<?php

namespace Pantheon\Terminus\Models;

/**
 * Class Binding
 *
 * @package Pantheon\Terminus\Models
 */
class Binding extends TerminusModel
{
    public const PRETTY_NAME = 'binding';

    /**
     * Used for connecting to a binding. It returns the legacy_username
     * attribute if available and the username attribute if not.
     *
     * @return string|null
     */
    public function getUsername()
    {
        return $this->has('legacy_username') ? $this->get(
            'legacy_username'
        ) : $this->get('username');
    }
}
