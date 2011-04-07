<?php

namespace Ltc\DocBundle;

use Ltc\DocBundle\Document\Doc;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Dead simple ACL
 */
class Security
{
    /**
     * @var SecurityContext
     */
    protected $securityContext = null;

    /**
     * @param SecurityContext securityContext
     */
    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * Tells whether the current authenticated user can see this doc
     *
     * @return bool
     **/
    public function canSee(Doc $doc)
    {
        if ($doc->isPublished()) {
            return true;
        }

        return $this->securityContext->isGranted('ROLE_BACKEND');
    }
}
