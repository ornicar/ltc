<?php

namespace Ltc\StoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StoryController extends Controller
{
    public function featuredAction()
    {
        //$story = $this->get('ltc_story.repository.story')->findOneFeatured();
        $story = $this->get('ltc_story.repository.story')->findOneRandom();

        return $this->render('LtcStory:Story:featured.html.twig', array(
            'story' => $story
        ));
    }
}
