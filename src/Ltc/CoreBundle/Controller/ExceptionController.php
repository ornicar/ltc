<?php

namespace Ltc\CoreBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ExceptionController extends ContainerAware
{
    /**
     * Converts an Exception to a Response.
     *
     * @param FlattenException     $exception A FlattenException instance
     * @param DebugLoggerInterface $logger    A DebugLoggerInterface instance
     * @param string               $format    The format to use for rendering (html, xml, ...)
     *
     * @throws \InvalidArgumentException When the exception template does not exist
     */
    public function showAction(FlattenException $exception, DebugLoggerInterface $logger = null, $format = 'html')
    {
        $request = $this->container->get('request');
        $request->setRequestFormat($format);

        $code = $exception->getStatusCode();
        $templating = $this->container->get('templating');

        if(404 == $code) {
            if ($doc = $this->container->get('ltc_core.not_found_search')->findGoodMatch($request)) {
                $url = $this->container->get('ltc_core.doc_router')->getDocPath($doc);

                return new RedirectResponse($url);
            }
            $response = $templating->renderResponse('LtcCoreBundle:Exception:notFound.html.twig');
        } else {
            $response = $templating->renderResponse('LtcCoreBundle:Exception:error.html.twig');
        }
        $response->setStatusCode($code);
        $response->headers->replace($exception->getHeaders());

        return $response;
    }
}
