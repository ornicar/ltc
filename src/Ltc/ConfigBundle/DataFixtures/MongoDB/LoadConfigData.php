<?php

namespace Ltc\ConfigBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Ltc\ImageBundle\Document\Image;

class LoadConfigData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    protected $configs;
    protected $documentRoot;

    public function getOrder()
    {
        return 1;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->configs = $container->get('ltc_config.manager')->getConfigs();
        $this->documentRoot = $container->getParameter('document_root');
    }

    public function load($manager)
    {
        foreach ($this->configs as $name => $config) {
            $document = $config->getDocument();
            $manager->persist($document);
            if ('author' == $name) {
                $this->loadAuthor($document);
            }
        }
        $manager->flush();
    }

    protected function loadAuthor($author)
    {
        $author->setTitle('Pascal Duplessis');

        $filename = 'pascal-duplessis.jpg';
        $fixturePath = __DIR__.'/../'.$filename;
        $webPath = '/uploads/image/'.$filename;
        $absPath = $this->documentRoot.$webPath;
        if (!file_exists($absPath)) {
            @mkdir(dirname($absPath));
            if (!@copy($fixturePath, $absPath)) {
                print 'Missing image '.$filename."\n";
                return false;
            }
        }
        $image = new Image();
        $image->setLegend('Pascal Duplessis');
        $image->setPath($webPath);
        $author->setImage($image);

        $author->setSummary(<<<EOF
Actuellement professeur-documentaliste et formateur à l'IUFM des Pays de la Loire, site d'Angers, je suis responsable des préparations aux CAPES interne et externe de Documentation.

Membre fondateur du Groupe de recherche sur la culture et la didactique de l'information (GRCDI) et membre de la Société de mythologie française (SMF).
EOF
    );
        $author->setBody(<<<EOF
## Projets de recherche

### 1- Quelles conceptions les élèves du secondaire se font-ils des savoirs info-documentaires ?

**Est-il vraiment concevable de construire une didactique de l'information-documentation sans commencer par identifier les représentations des élèves qui peuvent faire obstacle aux apprentissages ?**

Depuis 2008, un groupe de professeurs documentalistes de l'académie de Nantes rassemble et analyse les énoncés langagiers écrits par des élèves de la 6ème à la terminale afin de mieux connaître ces conceptions. Les premiers corpus, constitué en 2008, portaient sur les concepts de "Périodique", "Auteur", "Source d'information" et "Information". En 2009, de nouvelles enquêtes s'intéressent aux concepts de "Mot-clé", Document", Requête", Fiabilité de l'information" et "Web".

**Ce premier pas vers la connaissance des structures mentales des élèves devrait permettre de penser les situations-problèmes.**

### 2- Quels sont les savoirs scolaires enseignés actuellement par les professeurs-documentalistes ?

Un groupe de travail de Loire-Atlantique a entrepris l’analyse des traces que laisse sur le web la profession de son action de formation. Le but est de constituer et d’analyser un corpus de séquences dans le but de :

1. cerner le domaine conceptuel** qui est projeté par la profession, au travers des choix d’objectifs qui sont opérés et formalisés dans les séquences publiées ;
2. identifier les démarches pédagogiques** utilisées pour conduire ces séquences. Autrement dit, à quel(s) modèle(s) pédagogique se réfère la profession ?

### 3- Quelle didactique pour quel curriculum ?

Dans le cadre du Groupe de recherche sur la culture et la didactique de l'information (GRCDI), réfléchir au choix de l'entrée à préconiser pour le curriculum de l'information-documentation.

Il n'existe pas qu'un seul type de curriculum ! **L'arbitrage qui attend tôt ou tard l'institution l'engage à privilégier un rapport particulier au savoir, rapport que traduira le modèle pédagogique préconisé.** La question reste de savoir quelles sont les articulations possibles, ou à construire, entre la didactique de l'information-documentation, telle qu'elle prend aujourd'hui forme, et ce modèle.

### 4- Quel est le niveau de compétences info-documentaires des collégiens et des lycéens en France ?

Si des enquêtes ont été menées ces dernières années pour mieux connaître les compétences documentaires des primo-arrivants à l’université, bien peu de données sont en revanche disponibles concernant les élèves du secondaire.

**Quelles sont les principales lacunes de nos élèves en matière de conceptualisation des sujets, de stratégie de recherche ou encore d’évaluation de l’information ? Qui peut préciser quel ordre de grandeur donner à ces difficultés et dire à quel niveau du cursus de l’élève elles se manifestent particulièrement ?**

Ces informations sont cependant indispensables pour établir un état des lieux raisonné du niveau de maîtrise et des difficultés des élèves. Elles devraient ainsi notamment permettre de mieux harmoniser et de mieux orienter l’enseignement de l’info-documentation en France, tout en fournissant des  données objectives pour légitimer le mandat pédagogique du professeur-documentaliste. D’un point de vue scientifique, elles alimenteront en outre les constructions didactiques.

Un groupe de travail, réuni en mai 2009 sous l’égide de la FADBEN, a pour projet l’élaboration d’un test-diagnostic à l’échelle nationale.

### 5- La démarche de la situation-problème convient-elle à la pédagogie documentaire ?

Pour accompagner l'entrée des nouveaux savoirs scolaires dans l'enseignement info-documentaire, la pédagogie a besoin d'être renouvelée. Le modèle comportementaliste, s'il convenait pour l'apprentissage de la méthodologie documentaire, n'est pas valide pour le construction de connaissances déclaratives. Pour autant, l'approche transmissive est-elle acceptable par une profession héritière des démarches actives ?

Le modèle constructiviste des situations-problèmes ne constitue-t-il pas dès lors une alternative pertinente et souhaitable pour l'enseignement de l'informatio-documentation ?

Mais est-il aujourd'hui abordable pour la profession et à quelles conditions ?

Un groupe de recherche en action formation est actuellement en cours de constitution et devrait se mettre au travail à la rentrée 2010.
EOF
    );
        $author->setPublications(<<<EOF
## Dernières publications

- **Les médias d’information et leur didactisation dans le secondaire : fonctions, enjeux, contenus conceptuels**. *Médiadoc* n2, avril 2009. p. 12-15
- **Recherche des représentations des notions info-documentaires par les élèves du secondaire** [en ligne]. Académie de Nantes, 2009. Disponible sur Internet : http://www.pedagogie.ac-nantes.fr/37005884/0/fiche___ressourcepedagogique/&RH=DOC
- **Le CDI, figure de l’autrement de l’école ?** *Cahiers pédagogiques* n°470, 02-2009. p. 56-57
- **Introduction de la notion de curriculum en information-documentation** [en ligne]. *Savoirs CDI*, 2009.  http://www.savoirscdi.cndp.fr/index.php?id=484#c843
- **Evaluer, noter, publiciser : gestes professionnels et enjeu de professionnalisation pour les professeurs-documentalistes** [en ligne]. *Site DocspourDocs*, janvier 2009.  http://docsdocs.free.fr/spip.php?article398

## A paraître :

- **La fiche-concept en didactique de l’Information-documentation** : outil d’acculturation professionnelle, support pour la construction des connaissances ? Colloque international de l’ERTé, L’Education à la culture informationnelle, Lille, 16-17-18 octobre 2008}
EOF
    );
    }
}
