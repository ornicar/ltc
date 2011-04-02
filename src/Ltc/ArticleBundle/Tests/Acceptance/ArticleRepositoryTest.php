<?php

namespace Ltc\ArticleBundle\Tests\Acceptance;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleRepositoryTest extends WebTestCase
{
    public function testRelated()
    {
        $container = $this->createClient()->getContainer();
        $articleRepository = $container->get('ltc_article.repository.article');
        $categoryRepository = $container->get('ltc_article.repository.category');

        $category = $categoryRepository->findOneBySlug('outils');
        $article = $articleRepository->findOneByCategoryAndSlug($category, 'la-fiche-concept');

        $expectedSlugs = array(
            'la-cartographie-conceptuelle-au-service-de-la-didactique-de-l-information',
            'curriculum-informationnel-et-didactique-documentaire',
            'apports-epistemologiques-a-la-didactique-de-l-information-documentation',
            'apports-des-didactiques-des-disciplines-a-l-expertise-pedagogique-de-l-enseignant-documentaliste',
            'comment-evaluer-les-notions-info-documentaires',
            'banque-d-enonces-langagiers-d-eleves-de-la-6eme-a-la-terminale',
            'petit-dictionnaire-des-concepts-info-documentaires',
            'construire-le-concept-source-en-terminale-stg-une-sequence-didactique-de-noel-uguen',
            'la-fiche-concept-en-didactique-de-l-information-documentation',
        );
        $relatedDocs = $articleRepository->findRelated($article);
        $relatedSlugs = array_values(array_map(function($doc) { return $doc->getSlug(); }, $relatedDocs));
        $relatedSlugs = array_slice($relatedSlugs, 0, 3);
        $expectedSlugs = array_slice($expectedSlugs, 0, 3);

        $this->assertSame($expectedSlugs, $relatedSlugs);
    }
}
