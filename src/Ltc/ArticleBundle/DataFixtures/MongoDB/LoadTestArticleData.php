<?php

namespace Ltc\ArticleBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Ltc\ArticleBundle\Document\Article;
use Ltc\ImageBundle\Document\Image;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

class LoadTestArticleData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    protected $categoryRepository;
    protected $articleRepository;

    public function getOrder()
    {
        return 9;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->categoryRepository = $container->get('ltc_article.repository.category');
        $this->articleRepository  = $container->get('ltc_article.repository.article');
    }

    public function load($manager)
    {
        return;

        $category = $this->categoryRepository->findOneBySlug('outils');
        $o = new Article();
        $o->setCategory($category);
        $o->setReadMore(<<<EOF
* [Voir la page](http://lichess.org)
* [Un ficher a telecharger.odt](http://lichess.org)
EOF
    );
        $o->setCreatedAt(new DateTime());
        $o->setUpdatedAt(new DateTime());
        $o->setSummary(<<<EOF
Test de resume... Avec **du strong** et *du em* et [un lien](http://lichess.org)
EOF
    );
        $o->setBody(<<<EOF
## Titre de second niveau

### Titre de troisieme niveau

#### Titre de quatrieme niveau

Test de body... Avec **du strong** et *du em* et [un lien](http://lichess.org)

## Titre de second niveau

- Ceci est une liste
- la définition des concepts[^1]
- la structuration interne du champ[^2]

## Titre de second niveau

1. Liste
2. ordonnee
3. Discussion

---

## Titre de second niveau

### Titre de troisieme niveau

Paragraphe : La principale critique à adresser à la fiche concept est de centrer sur une approche conceptuelle de l’apprentissage. Cela est vrai si on la réduit à sa composante structurelle, mais cela est infirmé si l’enseignant développe au contraire les deux autres composantes, et notamment celle relative à la contextualisation du concept, à sa réception dans les pratiques sociales de l’information et à la réflexion critique qu’elle ouvre sur les enjeux économiques, sociaux ou éthiques.

Paragraphe : La principale critique à adresser à la fiche concept est de centrer sur une approche conceptuelle de l’apprentissage. Cela est vrai si on la réduit à sa composante structurelle, mais cela est infirmé si l’enseignant développe au contraire les deux autres composantes, et notamment celle relative à la contextualisation du concept, à sa réception dans les pratiques sociales de l’information et à la réflexion critique qu’elle ouvre sur les enjeux économiques, sociaux ou éthiques.

### Titre de troisieme niveau

Paragraphe : La principale critique à adresser à la fiche concept est de centrer sur une approche conceptuelle de l’apprentissage. Cela est vrai si on la réduit à sa composante structurelle, mais cela est infirmé si l’enseignant développe au contraire les deux autres composantes, et notamment celle relative à la contextualisation du concept, à sa réception dans les pratiques sociales de l’information et à la réflexion critique qu’elle ouvre sur les enjeux économiques, sociaux ou éthiques.

---

### Bibliographie

- Ballarini-Santonocito Ivana. Un exemple de mise en œuvre : construire la notion de Document en classe de 6ème [en ligne]. In *Les savoirs scolaires en information documentation : des outils didactiques pour la mise en œuvre des apprentissages en Documentation*. Nantes, Académie de Nantes, 2007. p. 16-19. http://www.pedagogie.ac-nantes.fr/1194018284375/0/fiche___ressourcepedagogique/&RH=1204811512203
- Casaert Sigrid et Stalder Angèle,  « Référentiel information documentation BEP » [en ligne]. Rouen, *Formdoc*, 2008. http://formdoc.rouen.iufm.fr/spip.php?article559

[^1]: Académie de Rouen, 2007 ; Duplessis et Ballarini-Santonocito, 2007 ; FADBEN, 2007 ; Duplessis, 2008-c
[^2]: Clouet et Montaigne, 2006 ; Duplessis et al., 2006 ; FADBEN, 2007
EOF
    );
        $o->setTitle('Article Test');
        $o->setIsPublished(true);
        $o->setPublishedAt($o->getCreatedAt());
        $manager->persist($o);

        $manager->flush();
    }
}
