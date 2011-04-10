<?php

namespace Ltc\TagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagController extends Controller
{
    public function smallCloudAction($numberOfTags)
    {
        $tags = $this->get('ltc_tag.repository.tag')->findMorePopularSortBySlug($numberOfTags);

        return $this->render('LtcTagBundle:Tag:smallCloud.html.twig', array(
            'tags' => $tags
        ));
    }

    public function cloudAction()
    {
        $tags = $this->get('ltc_tag.repository.tag')->findMorePopularSortBySlug(200);

        return $this->render('LtcTagBundle:Tag:cloud.html.twig', array(
            'tags' => $tags
        ));
    }

    public function viewAction($slug)
    {
        $tag = $this->get('ltc_tag.repository.tag')->findOneBySlug($slug);
        if (!$tag) {
            throw new NotFoundHttpException(sprintf('The tag with slug "%s" does not exist', $slug));
        }
        $docs = $this->get('ltc_core.tag_wizard')->findDocsBoundToTag($tag);

        return $this->render('LtcTagBundle:Tag:view.html.twig', array(
            'tag'  => $tag,
            'docs' => $docs
        ));
    }
}
