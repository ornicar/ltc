<?php

namespace Ltc\AdminBundle\Menu;

use Knplabs\Bundle\MenuBundle\Menu;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Ltc\ArticleBundle\Document\CategoryRepository;

class MainMenu extends Menu
{
    public function __construct(Request $request, Router $router, CategoryRepository $categoryRepository)
    {
        parent::__construct();

        $this->setCurrentUri($request->getRequestUri());
        $this->setAttribute('id', 'main_nav');

        $this->addChild('Admin', $router->generate('ltc_admin_dashboard'));
        //$this->addChild('Blog', $router->generate('ltc_admin_dashboard'));

        foreach ($categoryRepository->getTitlesAndSlugs() as $categoryArray) {
            $this->addChild($categoryArray['title'], $router->generate('ltc_article_admin_category_view', array(
                'slug' => $categoryArray['slug']
            )));
        }

        $this->addChild('Tags', $router->generate('ltc_tag_admin_index'));
    }
}
