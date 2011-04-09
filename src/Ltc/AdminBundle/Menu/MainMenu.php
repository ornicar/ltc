<?php

namespace Ltc\AdminBundle\Menu;

use Knplabs\Bundle\MenuBundle\Menu;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Ltc\ArticleBundle\Provider;

class MainMenu extends Menu
{
    public function __construct(Request $request, Router $router, Provider $provider)
    {
        parent::__construct();

        $this->setCurrentUri($request->getRequestUri());
        $this->setAttribute('id', 'main_nav');

        $this->addChild('Admin', $router->generate('ltc_admin_dashboard'));
        $this->addChild('Table ronde', $router->generate('ltc_blog_admin_entry_list'));

        foreach ($provider->getCategoriesInfos() as $slug => $title) {
            $this->addChild($title, $router->generate('ltc_article_admin_category_view', array('slug' => $slug)));
        }

        $this->addChild('Actus', $router->generate('ltc_story_admin_story_list'));
        $this->addChild('Tags', $router->generate('ltc_tag_admin_index'));
        $this->addChild('Config', $router->generate('ltc_config_admin_index'));
        $this->addChild('Fichiers', $router->generate('ltc_admin_manager'));
    }
}
