<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    # -- standard errors --
    'errors.header' => '<UL>',
    'errors.prefix' => '<LI>',
    'errors.suffix' => '</LI>',
    'errors.footer' => '</UL>',
# -- validator --
    'errors.invalid' => '{0} is invalid.',
    'errors.maxlength' => '{0} can not be greater than {1} characters.',
    'errors.minlength' => '{0} can not be less than {1} characters.',
    'errors.range' => '{0} is not in the range {1} through {2}.',
    'errors.required' => '{0} is required.',
    'errors.byte' => '{0} must be an byte.',
    'errors.date' => '{0} is not a date.',
    'errors.double' => '{0} must be an double.',
    'errors.float' => '{0} must be an float.',
    'errors.integer' => '{0} must be an integer.',
    'errors.long' => '{0} must be an long.',
    'errors.short' => '{0} must be an short.',
    'errors.creditcard' => '{0} is not a valid credit card number.',
    'errors.email' => '{0} is an invalid e-mail address.',
# -- other --
    'errors.cancel' => 'Operation cancelled.',
    'errors.detail' => '{0}',
    'errors.general' => 'The process did not complete. Details should follow.',
    'errors.token' => 'Request could not be completed. Operation is not in sequence.',
# -- welcome --
    'welcome.title' => 'Struts Application',
    'welcome.heading' => 'Struts Applications in Netbeans!',
    'welcome.message' => "It's easy to create Struts applications with NetBeans.",
# -- Menu --
    'menu.sesion' => 'Login',
    'menu.busqueda' => 'RECHERCHE',
    'menu.historial' => 'DOSSIER',
    'menu.colaboradores' => 'COLABORATEURS',
    'menu.ayuda' => 'AIDE',
    'menu.agradecimientos' => 'REMERCIEMENTS',
    'menu.condiciones' => "TERMES D'UTILISATION",
# -- Submenu --
    'submenu.nombre' => 'Nom',
    'submenu.estructura' => 'Structure',
    'submenu.subestructura' => 'Sous-structure',
    'submenu.desplazamiento' => 'Déplacement',
    'submenu.tipocarbono' => 'Type de carbone',
# -- SubSubMenu --
    'subsub.sinposicion' => 'Sans Position',
    'subsub.conposicion' => 'Avec Position',
    'subsub.iterativa' => 'Itératif',
    'subsub.vecindad' => 'Proximité',
# -- Inicio --
    'sesion.tituloc' => 'Base de données du carbone 13 des produits naturels',
    'sesion.subtituloc' => "Cette application fournit différents outils de recherche permettant de trouver la structure d'un composé par la recherche de différents paramètres chimiques",
# -- Historial --
    'historial.historial' => 'Dossier',
    'historial.numbusqueda' => 'Recherche nom.',
    'historial.codbusqueda' => 'Code de recherche',
    'historial.numcompuestos' => 'Nombre de résultats',
    'historial.critbusqueda' => 'Critères de recherche',
    'historial.ver' => 'Voir résulte',
    'historial.combinar' => 'Combiner',
    'historial.eliminar' => 'Effacer',
# -- Formulario --
    'form.busquedas.nombre' => 'Recherche par le nom',
    'form.familia' => 'Famille',
    'form.tipo' => 'Type',
    'form.grupo' => 'Groupe',
    'form.formulamol' => 'Formule moléculaire',
    'form.heteroatomo' => 'Hétéroatome',
    'form.pesomol' => 'Poids Moléculaire',
    'form.nombretri' => 'Nom',
    'form.nombresemi' => 'Nom semi-systématique',
    'form.biblio' => 'Bibliographie',
    'form.autores' => 'Auteurs',
    'form.revista' => 'Journal',
    'form.anio' => 'Année',
    'form.vol' => 'Volume',
    'form.pag' => 'Pages',
    'form.buscar' => 'RECHERCHER',
# -- Colaboradores --
    'colab.colaboradores' => 'Colaborateurs',
    'colab.autor' => 'Auteur',
    'colab.email' => 'eMail',
    'colab.organismo' => 'Institution',
    'colab.pais' => 'Pays',
    'colab.numcompuestos' => 'Nombre de composés',

    # -- Ayuda --
    'ayuda.menu.ayuda' => 'AIDE',
    'ayuda.menu.busqueda' => 'RECHERCHES',
    'ayuda.menu.nombre' => 'NOM',
    'ayuda.menu.subestructura' => 'SOUS-STRUCTURE',
    'ayuda.menu.iterativa' => 'ITERATIVA',
    'ayuda.menu.tipos' => 'TYPE D\'ATOME',
    'ayuda.menu.historial' => 'HISTORIQUE',
    'ayuda.menu.resultados' => 'RÉSULTATS',
    'ayuda.menu.editor' => 'EDITOR',

    'ayuda.busnombre.p0' => 'NOM',
    'ayuda.busnombre.p1' => 'Ouvrir la liste des familles disponibles dans la base de données et sélectionner l\'une d\'elle. Une fois sélectionné, apparaissent les différents types disponibles pour cette famille. Si vous sélectionnez un type déterminé, apparaissent alors tous les groupes appartenant a ce type.',
    'ayuda.busnombre.p2' => "<strong>Exemple de famille:</strong> Terpénoïde<br><strong>Exemple de type :</strong> Triterpenoïde<br><strong>Exemple de groupe :</strong> Oléane",
    'ayuda.busnombre.p3' => 'Vous pouvez ajouter la formule moléculaire complète en ajoutant un numéro derrière chaque symbole atomique ou seulement les symboles anatomiques portant un astérisque dans le coin de la case.',
    'ayuda.busnombre.p4' => 'Ecrivez le nom vulgaire ou semi-systématique dans la case correspondante. Vous pouvez l\'écrire de forme partielle, en ajoutant un astérisque (*) ou un point d\'interrogation (?) dans n\'importe quelle partie du nom. Un astérisque représente plusieurs numéros de caractères, alors qu\'un point d\'interrogation représente seulement un caractère.',
    'ayuda.busnombre.p5' => 'Vous pouvez remplir ou laisser en blanc les champs que vous désirez.',

    'ayuda.bussubestructura.p0' => 'SOUS-STRUCTURE',
    'ayuda.bussubestructura.p1' => 'Dessinez la structure ou la sous structure que vous désirez chercher dans L\'ÉDITEUR DE MOLÉCULE.',
    'ayuda.bussubestructura.p2' => 'Pour faciliter le dessin des structures, vous disposez d\'une palette supérieure avec des groupements déjà définis. Pousser le bouton de l\'un d\'eux puis cliquer à l\'intérieur de l\'éditeur',
    'ayuda.bussubestructura.p3' => 'Dans la palette de gauche, vous disposer d\'un bouton pour indiquer la stéréochimie et les symboles atomiques. La stéréochimie initiale est toujours continue, si vous en désirez une à rayure, dessiner tout d\'abord une ligne continue puis cliquer sur celle ci. Alternativement, elle se changera d\'un type à l\'autre.',
    'ayuda.bussubestructura.p4' => 'Les symboles atomiques représentés sont les plus fréquents. Le X est un joker. Il représente automatiquement un hétérogène mais si vous désirez le changer pour un autre symbole vous pouvez l\'indiquer dans la case de dialogue qui apparaît. ',
    'ayuda.bussubestructura.p5' => 'Vous pouvez limiter la recherche à une famille, un type ou un groupe de produits naturels.',

    'ayuda.example' => 'EXEMPLE:',

    'ayuda.busiterativa.p0' => 'ITERATIVA',
    'ayuda.busiterativa.p1' => 'Il est possible de réaliser des recherches par déplacements chimiques en indiquant le type de carbone.',
    'ayuda.busiterativa.p2' => 'Par défaut la tolérance dans la recherche est 1 ; mais on peut en introduire d\'autres différentes pour chaque carbones introduits.',
    'ayuda.busiterativa.p3' => 'Pour introduire des déplacements additionnels, pousser le bouton "nouveau déplacement" et il apparaitra d\'autres lignes de champs vide. Tant que la ligne ne s\'est pas complètement remplie, il n\'est pas possible d\'obtenir une nouvelle. Cette opération peut se répéter autant de fois que vous désirez de déplacements chimiques.',
    'ayuda.busiterativa.p4' => 'Addicionellement nous pourrons délimiter la recherche si nous connaissons le type de composé problème, en spécifiant la famille, le type ou le groupe. ',
    'ayuda.busiterativa.p5' => 'A l\'aide de cette recherche, vous rencontrerez quelques composés qui possèdent un numéro maximum de déplacements similaires aux recherches selon la tolérance qui leur est spécifique. Par exemple, vous pourriez introduire 20 déplacements chimiques et obtenir des composés qui présentent 12 déplacements communs aux déplacements établis dans la recherche.',
    'ayuda.busiterativa.p6' => 'Les composés rencontrés dans la recherche apparaissent ordonnés selon la similitude de leurs déplacements conforme à ceux introduit dans la recherche.',
    'ayuda.busiterativa.p7' => '<strong>Type de carbone:</strong> CH, <strong>Déplacement:</strong> 75, <strong>Tolérance:</strong> 3<br/><strong>Type de carbone:</strong> CH2, <strong>Déplacement:</strong> 101, <strong>Tolérance:</strong> 4<br/><strong>Type de carbone:</strong> CH3, <strong>Déplacement:</strong> 26, <strong>Tolérance:</strong> 1',
    'ayuda.busiterativa.p8' => 'Vous pourrez trouver des composés qui possèdent un CH à 72 ppm et 1 CH3 à 25 ppm et il pourra manquer un CH2 entre 97-105 ppm.',

    'ayuda.bustipcarb.p0' => 'TYPE D\'ATOME',
    'ayuda.bustipcarb.p1' => 'Il est permit à l\'utilisateur de rechercher des composés selon le nombre de différents types de carbone (C, CH, CH2, CH3) qu\'ils possèdent. Vous pouvez aussi établir dans la recherche le nombre de carbone unis à l\'oxygène et à l\'azote, ainsi que le nombre d\'hétéroatome. ',
    'ayuda.bustipcarb.p2' => 'L\'utilisateur peut établir un nombre concret pour chaque type d\'atome ou établir un intervalle. Vous disposez d\'un système de barre avec deux curseurs pour établir un intervalle de forme rapide et simple.',
    'ayuda.bustipcarb.p3' => 'La recherche est complètement configurable. Il suffit de poussez le bouton "configurer". Il apparaît une fenêtre dans laquelle on demande l\'insertion du numéro de barre pour lesquelles vous définirez le type d\'atome pour lesquels vous désirez réalisez la recherche. Ce numéro établi, il apparaît une autre fenêtre pour établir le type de carbone et les hétéroatomes pour lesquels vous désirez réaliser la recherche. Cette option peut s\'établir seulement pour le squelette du composé ou pour toute la structure du composé.',
    'ayuda.bustipcarb.p4' => '<strong>SQUELETTE:</strong> C*, CH*, CH2*, CH3*, C-O*, CH-O*, CH2-O* y CH3-O*',
    'ayuda.bustipcarb.p5' => '<strong>STRUCTURE TOTAL:</strong> C, CH, CH2, CH3, C-O, CH-O, CH2-O, CH3-O, Br, Cl, F, H, I, N, O, P and S',
    'ayuda.bustipcarb.p6' => '<strong>Type d\'atome:</strong> C* <strong>Intervalle:</strong> 0-5<br/><strong>Type d\'atome:</strong> CH* <strong>Intervalle:</strong> 4-4',

    'ayuda.historial.p0' => 'HISTORIQUE',
    'ayuda.historial.p1' => 'Quand vous poussez le bouton "chercher" dans n\'importe quelle recherche, il apparait une page avec l\'historique des recherches réalisées. Chacune des recherches réalisées son présentées en une ligne et son ordonnées de manière corrélative.
Dans chacune d\'elle il doit être spécifié le numéro de recherche, le numéro de composé encontré et le type de critère que vous avez utilisé dans la recherche.
Elles disposent d\'un cadre pour leur élimination et d\'un autre pour leur activation avec le but de réaliser de futures recherches booléennes avec "or" o "and" entre les différentes recherches.
Les structures rencontrées dans chacune des recherches peuvent être visualisées en poussant le bouton "voir".',

    'ayuda.resultados.p0' => 'RÉSULTATS',
    'ayuda.resultados.p1' => 'En poussant le bouton "voir" sur l\'écran de l\'historique, apparaissent les structures des composés résultants de la recherche.En dessous de chacune des structures apparaissent 2 liens pour accéder aux propriétés du composé et pour représenter son SPECTRE de forme graphique.',
    'ayuda.resultados.p2' => 'Dans la partie supérieure de la fenêtre on peut trouver les boutons suivants :',
    'ayuda.resultados.p3' => 'Aide : Accès à un système d\'aide.',
    'ayuda.resultados.p4' => 'Outil analytique : Accès à un outil analytique visuel.',
    'ayuda.resultados.p5' => 'Peaufiner la recherche : Retour a la page de la recherche réalisée.',
    'ayuda.resultados.p6' => '"δ(ppm) en tableau ": On peut voir un tableau avec les données des déplacements chimiques de chaque atomes de carbones du composé sélectionné.',
    'ayuda.resultados.p7' => '"δ(ppm) en structures ": On peut voir les déplacements chimiques sur chaque atomes de carbone de la structure.',

    'ayuda.editor.p0' => 'EDITOR',
    'ayuda.editor.p1' => 'CONTRÔLE:',
    'ayuda.editor.p2' => ': Présenter le code Smille de la structure dessinée.',
    'ayuda.editor.p3' => 'CLR: Effacer le contenu de la fenêtre d\'édition.',
    'ayuda.editor.p4' => 'NEW: Commencer une autre chaîne différente de celle qui était dessinée.',
    'ayuda.editor.p5' => 'DEL: Effacer l\'élément que vous désiré en le sélectionnant.',
    'ayuda.editor.p6' => '123: Cliqué dessus puis cliqué sur les carbones voulus afin de les numéroter',
    'ayuda.editor.p7' => 'D-R: Effacer le groupe fonctionnel que vous sélectionnerai par la suite',
    'ayuda.editor.p8' => 'QRY: Il est permit de réaliser des recherches booléennes complexes:',
    'ayuda.editor.p9' => 'Spécifier les différents types d\'atomes en n\'importe quelle position',
    'ayuda.editor.p10' => 'Spécifier le type de liaison, si elles font parties ou non d\'un anneau.',
    'ayuda.editor.p11' => 'De cette manière, les recherches sont considérablement renforcées.',
    'ayuda.editor.p12' => '+/-: Change les charges atomiques de façon raisonnable. ',
    'ayuda.editor.p13' => 'UDO: Défait les dernières étapes.',
    'ayuda.editor.p14' => 'JME: Nous montre l\'auteur et la version de l\'applet.',
    'ayuda.editor.p15' => 'FORME :',
    'ayuda.editor.p16' => 'Ces boutons permettent de créer des formes étendues et définies.',
    'ayuda.editor.p17' => 'LIAISONS :',
    'ayuda.editor.p18' => 'Ces contrôles permettent de choisir les différents types de liaisons qui forment la sous-structure.',
    'ayuda.editor.p19' => 'ATOMES :',
    'ayuda.editor.p20' => 'Ces boutons représentent les différents types d\'atomes qui peuvent être choisit pour la sur-structure.',
    'ayuda.editor.p21' => 'Ce sont les types d\'atomes les plus courants dans la chimie organique, mais si on a besoin d\'un autre qui n\'est pas dans la liste et que l\'on connaît son code smille, on peut le créer en cliquant sur le contrôle marqué par un X. il suffit d\'introduire son code smille dans le cadre de dialogue qui apparaîtra.',

    # -- About --
    'about.title'        => 'À propos de NAPROC-13',
    'about.whatisTitle'  => 'Qu\'est-ce que NAPROC-13 ?',
    'about.whatisText1'  => 'NAPROC-13 est une base de données spécialisée en RMN du <sup>13</sup>C de produits naturels, développée au Département des Sciences Pharmaceutiques de l\'Université de Salamanque. Son objectif est de mettre à disposition de la communauté scientifique un outil puissant et en libre accès pour l\'identification et la caractérisation structurale de composés d\'origine naturelle.',
    'about.whatisText2'  => 'Les produits naturels — composés produits par des organismes vivants comme les plantes, les champignons ou les bactéries — sont à l\'origine de certains des médicaments les plus importants de l\'histoire. Les identifier et les caractériser correctement est la première étape pour comprendre leur activité biologique et leur potentiel thérapeutique.',
    'about.stat1'        => 'Composés enregistrés',
    'about.stat2'        => 'Données spectroscopiques de carbone',
    'about.stat3'        => 'Université de Salamanque · 1218 ap. J.-C.',
    'about.nmrTitle'     => 'Qu\'est-ce que la RMN du <sup>13</sup>C ?',
    'about.nmrText1'     => 'La Résonance Magnétique Nucléaire du carbone-13 (RMN du <sup>13</sup>C) est une technique spectroscopique qui fournit des informations détaillées sur le squelette carboné d\'une molécule. Chaque atome de carbone dans un environnement chimique différent produit un signal caractéristique — appelé déplacement chimique — qui agit comme une empreinte digitale du composé.',
    'about.nmrText2'     => 'Contrairement à d\'autres techniques, la RMN du <sup>13</sup>C ne détruit pas l\'échantillon, est hautement reproductible et fournit des informations structurales uniques. NAPROC-13 rassemble des milliers de ces spectres sur une seule plateforme de recherche.',
    'about.toolsTitle'   => 'Outils de recherche',
    'about.tool1'        => 'Recherchez des composés directement par leur nom chimique complet ou partiel.',
    'about.tool2'        => 'Dessinez ou saisissez un fragment structural et trouvez tous les composés qui le contiennent.',
    'about.tool3'        => 'Introduisez les valeurs de déplacement chimique du <sup>13</sup>C de votre spectre et obtenez les composés les plus compatibles.',
    'about.tool4'        => 'Filtrez selon la multiplicité des carbones : C, CH, CH₂ ou CH₃.',
    'about.historyTitle' => 'Histoire du projet',
    'about.history1'     => 'Le groupe de Pharmacognosie du Département des Sciences Pharmaceutiques de l\'USAL commence à compiler des données de RMN du <sup>13</sup>C de produits naturels dans le but de créer une base de données spécialisée en accès libre.',
    'about.history2'     => 'NAPROC-13 devient un outil accessible via internet, permettant aux chercheurs du monde entier de consulter les données sans installation locale.',
    'about.history3'     => 'De nouveaux outils de recherche sont intégrés et la base de données dépasse les 8 000 composés enregistrés avec leurs données spectroscopiques.',
    'about.history4'     => 'La plateforme continue de croître avec de nouvelles molécules, le support multilingue et une interface rénovée.',
    'about.today'        => 'Aujourd\'hui',
    'about.citeTitle'    => 'Comment citer NAPROC-13',
    'about.citeText'     => 'Si vous utilisez NAPROC-13 dans vos recherches, veuillez citer la base de données pour nous aider à la maintenir et à l\'améliorer.',
    'about.citeCopy'     => 'Copier la référence',
    'about.citeCopied'   => 'Copié !',
    'about.cta'          => 'Commencer la recherche →',

    'menu.signUp'  => 'S\'inscrire',
    'menu.logout'  => 'Déconnexion',
    'menu.admin'   => 'Administration',
    'user.user'    => 'Utilisateur :',

    # -- Résultats --
    'result.results'      => 'Résultats',
    'result.compounds'    => 'Composés',
    'result.numeration'   => 'Avec numérotation',
    'result.noNumeration' => 'Sans numérotation',

    # -- Propriétés / Molécule --
    'properties.properties' => 'Propriétés',
    'molecule.spectrum'     => 'Spectre',
    'molecule.shift' => 'Déplacement (ppm)',

    # -- Formulaire --
    'form.compare'                 => 'Comparer la sélection',
    'form.busquedas.subestructura' => 'Recherche par sous-structure',
    'form.estereoquimica'          => 'Stéréochimie',
    'errors.requeridos'            => 'Veuillez remplir au moins un champ',
];
