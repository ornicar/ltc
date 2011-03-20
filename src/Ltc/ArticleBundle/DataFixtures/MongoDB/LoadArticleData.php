<?php

namespace Ltc\ArticleBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Ltc\ArticleBundle\Document\Article;

class LoadArticleData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    protected $userManager;

    public function getOrder()
    {
        return 10;
    }

    public function setContainer(ContainerInterface $container = null)
    {
    }

    public function load($manager)
    {
        $article = new Article();
        $article->setAuthor($this->getReference('user-thibault'));
        $article->setCategory($this->getReference('category-textes'));
        $article->setTitle("La fiche-concept en didactique de l’Information-documentation : outil d’acculturation professionnelle, support pour la construction des connaissances ?");
        $article->setSummary($this->getText('1-summary'));
        $article->setBody($this->getText('1-body'));
        $article->setReference("Duplessis Pascal. « Frédéric Rabat, ou l’entrée dans la culture de l’information par ses objets » [en ligne]. *Les Trois couronnes*, 2009. Disponible sur http://esmeree.fr/lestroiscouronnes/idoc/blog/frederic-rabat-ou-l-entree-dans-la-culture-de-l-information-par-ses-objets");
        $manager->persist($article);

        $article = new Article();
        $article->setAuthor($this->getReference('user-pascal'));
        $article->setCategory($this->getReference('category-textes'));
        $article->setTitle("Les médias d’information et leur didactisation dans le secondaire : Fonctions, enjeux, contenus conceptuels");
        $article->setSummary($this->getText('2-summary'));
        $article->setBody($this->getText('2-body'));
        $article->setReference("Duplessis Pascal. Fiche de donnees didactiques sur Google [en ligne]. *Les Trois couronnes*, 2009. Disponible sur http://esmeree.fr/lestroiscouronnes/idoc/outils/fiche-de-donnees-didactiques-sur-google");
        $manager->persist($article);

        $article = new Article();
        $article->setAuthor($this->getReference('user-pascal'));
        $article->setCategory($this->getReference('category-textes'));
        $article->setTitle("Entrer dans la culture de l’information par les usages");
        $article->setSummary($this->getText('3-summary'));
        $article->setBody($this->getText('3-body'));
        $article->setReference("Duplessis Pascal. Entrer dans la culture de l’information par les usages [en ligne]. *Les Trois couronnes*, 2009. Disponible sur http://esmeree.fr/lestroiscouronnes/idoc/outils/entrer-dans-la-culture-de-l-information-par-les-usages");
        $manager->persist($article);

        $article = new Article();
        $article->setAuthor($this->getReference('user-pascal'));
        $article->setCategory($this->getReference('category-outils'));
        $article->setTitle("La démarche de réfutation");
        $article->setSummary($this->getText('4-summary'));
        $article->setBody($this->getText('4-body'));
        $article->setReference("Duplessis Pascal. La démarche de réfutation [en ligne]. *Les Trois couronnes*, 2009. Disponible sur : http://esmeree.fr/lestroiscouronnes/idoc/outils/la-demarche-de-refutation");
        $manager->persist($article);

        $manager->flush();
    }

    protected function getText($file)
    {
        return file_get_contents(__DIR__.'/../text/'.$file);
    }
}
