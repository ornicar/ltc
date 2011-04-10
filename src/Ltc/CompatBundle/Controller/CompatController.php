<?php

namespace Ltc\CompatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CompatController extends Controller
{
    public function docAction($slug)
    {
        if($doc = $this->get('ltc_article.repository.article')->findOnePublishedBySlug($slug)) {
            $url = $this->get('router')->generate('ltc_article_article_view', array(
                'categorySlug' => $doc->getCategory()->getSlug(),
                'slug' => $doc->getSlug()
            ));
        } elseif ($doc = $this->get('ltc_blog.repository.entry')->findOnePublishedBySlug($slug)) {
            $url = $this->get('router')->generate('ltc_blog_entry_view', array(
                'slug' => $doc->getSlug()
            ));
        } else {
            throw new NotFoundHttpException('No compat doc found for slug "%s"', $slug);
        }

        return new RedirectResponse($url);
    }

    public function routeAction()
    {
        $route = $this->get('request')->attributes->get('redirect_route');

        return new RedirectResponse($this->get('router')->generate($route));
    }
}
