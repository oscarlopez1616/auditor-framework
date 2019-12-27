<?php

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Symfony\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;

class CustomFirewallRequestMatcher implements RequestMatcherInterface
{

    /**
     * Decides whether the rule(s) implemented by the strategy matches the supplied request.
     *
     * @param Request $request
     * @return bool true if the request matches, false otherwise
     */
    public function matches(Request $request): bool
    {
        $data = json_decode($request->getContent(), true);
        if (!$data || !array_key_exists('op', $data)) {
            return false;
        }
        return preg_match('^\/api\/security_and_acl\/user^', $request->getPathInfo()) &&
            (json_decode($request->getContent())->op === 'processPatchForgotPasswordCreateAndSendPasswordRecovery') ||
            (json_decode($request->getContent())->op === 'processPatchForgotPasswordChangePassword');
    }
}
