<?php

namespace Ltc\MarkdownBundle;

class FixerTest extends \PHPUnit_Framework_TestCase
{
    public function testFixNoChange()
    {
        $text = <<<EOF
Elle se développe aujourd’hui au travers, notamment, de trois approches complémentaires :

## 1. Présentation de la fiche concept en Sciences économiques et sociales

La fiche-concept est apparue en 1993 dans la discipline des Sciences économiques et sociales (S.E.S.) où elle a été présentée comme un moteur de l’innovation. Un groupe national de travail sur les objectifs de référence en classe de Seconde, piloté alors par la direction des lycées et collèges, a fait une large part à ce nouvel outil didactique dans le cadre de ses préconisations [M.E.N., 1993].

1. l’inventaire des structures cognitives d’accueil des apprenants et des conceptions qui font obstacle au progrès de l’appropriation des connaissances,
2. l’élaboration de savoirs potentiellement enseignables à partir de l’analyse des domaines savants, professionnels et domestiques,
3. l’examen des stratégies d’interaction didactique les plus appropriées pour une mise en scène réussie des savoirs scolaires.
EOF;

        $this->assertEquals($text, $this->fix($text));
    }

    public function testFixDotList()
    {
        $text = <<<EOF
Depuis, de nombreuses publications (essais, manuels, articles, mutualisation d’enseignants) lui ont assuré un large écho, faisant de la fiche concept une marque des S.E.S. Ces objectifs de référence distinguent les connaissances procédurales (analyser des informations) des connaissances déclaratives (maîtriser des connaissances). La maîtrise des connaissances regroupe cinq items dont le premier, la maîtrise des concepts, s’appuie directement sur la fiche concept. Il se décompose de la sorte :

 . formuler une définition du concept
 . le distinguer d’un autre
 . le reconnaître dans un texte
 . l’utiliser à bon escient
 . le relier à d’autres concepts
 . le situer dans un ou plusieurs champs théoriques
 . le distinguer de son instrument de mesure

La fiche concept est définie comme « *une modalité de présentation des connaissances relatives à un concept. Elle réunit de façon organisée les différents éléments d’un savoir et aide à définir les objectifs à atteindre par les élèves dans un domaine précis* » [Id.].
EOF;
        $expected = <<<EOF
Depuis, de nombreuses publications (essais, manuels, articles, mutualisation d’enseignants) lui ont assuré un large écho, faisant de la fiche concept une marque des S.E.S. Ces objectifs de référence distinguent les connaissances procédurales (analyser des informations) des connaissances déclaratives (maîtriser des connaissances). La maîtrise des connaissances regroupe cinq items dont le premier, la maîtrise des concepts, s’appuie directement sur la fiche concept. Il se décompose de la sorte :

- formuler une définition du concept
- le distinguer d’un autre
- le reconnaître dans un texte
- l’utiliser à bon escient
- le relier à d’autres concepts
- le situer dans un ou plusieurs champs théoriques
- le distinguer de son instrument de mesure

La fiche concept est définie comme « *une modalité de présentation des connaissances relatives à un concept. Elle réunit de façon organisée les différents éléments d’un savoir et aide à définir les objectifs à atteindre par les élèves dans un domaine précis* » [Id.].
EOF;

        $this->assertEquals($expected, $this->fix($text));
    }

    public function testDotStartingLine()
    {
        $text = <<<EOF

. **la composante contextuelle** :

- contexte d’utilisation (P.S.R.)
- problématisation (intérêt, causalité et enjeux)

. **la composante didactique** :

- typologie des conceptions des élèves et des obstacles
- didactisation : choix des objectifs obstacles
EOF;
        $expected = <<<EOF

- **la composante contextuelle** :

- contexte d’utilisation (P.S.R.)
- problématisation (intérêt, causalité et enjeux)

- **la composante didactique** :

- typologie des conceptions des élèves et des obstacles
- didactisation : choix des objectifs obstacles
EOF;

        $this->assertEquals($expected, $this->fix($text));
    }

    public function testRealParagraph()
    {
        $text = <<<EOF
Les nombreuses productions disponibles dans la littérature montrent ainsi un découpage en moins de dix rubriques, dont les intentions varient peu : dénomination du concept, éléments constitutifs (les attributs), formulation synthétique, exemples et contre-exemples, sous-notions, notions liées, instruments de mesure, utilisation de la notion, autres éléments « à retenir ».
La fiche concept, en S.E.S., est présentée comme un outil essentiellement destiné à l’élève.
EN l’invitant ou bien à saisir ce qu’il comprend lors de la séquence, ou bien à récapituler l’essentiel du cours à l’issue de celui-ci. Dans le premier cas, c’est un support appréciable pour l’évaluation formative, dans le second, c’est un outil favorisant le travail de synthèse et de renforcement ;
L’enjeu éducatif de la fiche concept
EOF;
        $expected = <<<EOF
Les nombreuses productions disponibles dans la littérature montrent ainsi un découpage en moins de dix rubriques, dont les intentions varient peu : dénomination du concept, éléments constitutifs (les attributs), formulation synthétique, exemples et contre-exemples, sous-notions, notions liées, instruments de mesure, utilisation de la notion, autres éléments « à retenir ».

La fiche concept, en S.E.S., est présentée comme un outil essentiellement destiné à l’élève.

EN l’invitant ou bien à saisir ce qu’il comprend lors de la séquence, ou bien à récapituler l’essentiel du cours à l’issue de celui-ci. Dans le premier cas, c’est un support appréciable pour l’évaluation formative, dans le second, c’est un outil favorisant le travail de synthèse et de renforcement ;

L’enjeu éducatif de la fiche concept
EOF;

        $this->assertEquals($expected, $this->fix($text));
    }

    public function testTrimLine()
    {
        $text = "\ntext\n- list\n  - sublist \ntext   \nbla";
        $expected = "\ntext\n- list\n  - sublist\ntext\nbla";
        $this->assertEquals($expected, $this->fix($text));
    }

    public function testDotLine()
    {
        $text = <<<EOF
## 1. Présentation de la fiche concept en Sciences économiques et sociales
.
La fiche-concept est apparue en 1993 dans la discipline des Sciences économiques et sociales (S.E.S.) où elle a été présentée comme un moteur de l’innovation.
EOF;
        $expected = <<<EOF
## 1. Présentation de la fiche concept en Sciences économiques et sociales

La fiche-concept est apparue en 1993 dans la discipline des Sciences économiques et sociales (S.E.S.) où elle a été présentée comme un moteur de l’innovation.
EOF;

        $this->assertEquals($expected, $this->fix($text));
    }

    protected function fix($text)
    {
        $fixer = new Fixer();

        return $fixer->fix($text);
    }
}
