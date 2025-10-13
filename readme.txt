=== Carousel for Gutenberg ===
Contributors: weblazer
Donate link: https://weblazer.github.io/
Tags: carousel, gutenberg, blocks, gallery, slider, css
Requires at least: 6.0
Tested up to: 6.7
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Transformez n'importe quel bloc Gutenberg en carousel responsive avec du CSS pur. Zéro JavaScript, performance maximale.

== Description ==

**Carousel for Gutenberg** est un plugin léger qui ajoute une fonctionnalité de carousel aux blocs natifs de WordPress sans créer de blocs personnalisés ni ajouter de JavaScript superflu.

= Caractéristiques principales =

* **100% CSS** - Carousel entièrement en CSS (zéro JavaScript côté public)
* **Blocs natifs** - Fonctionne avec Gallery, Grid, Group et Post Template
* **Détection automatique** - Reconnaissance automatique des colonnes pour les layouts Grid
* **Presets WordPress** - Support complet des espacements WordPress (Small, Medium, Large, etc.)
* **Intégration thème** - Détection automatique des couleurs de boutons du thème
* **Accessibilité** - Navigation au clavier native
* **Mobile-friendly** - Défilement tactile optimisé
* **Performance** - Aucun impact sur les performances (CSS natif du navigateur)

= Blocs supportés =

* **Gallery** - Transformez vos galeries en carrousels élégants
* **Grid** - Blocs Group avec layout Grid
* **Post Template** - Boucles de posts en mode Grid
* **Group** - Blocs de groupe standards

= Comment ça marche ? =

1. Créez ou éditez un bloc supporté (Gallery, Grid, Group, Post Template)
2. Dans les paramètres du bloc, activez le toggle "Carousel"
3. C'est tout ! Votre bloc devient un carousel

= Personnalisation =

* **Colonnes** - Pour les Grids : définissez le nombre de colonnes visibles (1-6)
* **Largeur minimale** - Pour les Grids : utilisez "Minimum column width" pour un layout fluide
* **Espacement** - Utilisez "Block spacing" pour ajuster l'espace entre les éléments
* **Couleurs** - Les boutons héritent automatiquement des couleurs de votre thème

= Technique =

Le plugin utilise les technologies CSS modernes :
* `scroll-snap` pour le défilement fluide
* `::scroll-button` pour les boutons de navigation (expérimental)
* `::scroll-marker` pour les indicateurs de position (expérimental)
* CSS Variables pour la personnalisation automatique

**Note** : Les boutons de navigation utilisent des fonctionnalités CSS expérimentales. Sur les navigateurs non compatibles, le carousel reste fonctionnel avec le défilement tactile/souris, mais sans les boutons visuels.

== Installation ==

= Installation automatique =

1. Allez dans "Extensions" > "Ajouter"
2. Recherchez "Carousel for Gutenberg"
3. Cliquez sur "Installer" puis "Activer"

= Installation manuelle =

1. Téléchargez le plugin
2. Uploadez le dossier dans `/wp-content/plugins/`
3. Activez le plugin via le menu "Extensions"

= Utilisation =

1. Éditez une page ou un article
2. Ajoutez ou sélectionnez un bloc Gallery, Grid, Group ou Post Template
3. Dans le panneau latéral, activez l'option "Carousel"
4. Configurez les colonnes et l'espacement selon vos besoins
5. Publiez !

== Frequently Asked Questions ==

= Est-ce compatible avec tous les thèmes ? =

Oui ! Le plugin détecte automatiquement les couleurs de boutons de votre thème et s'adapte.

= Cela nécessite-t-il JavaScript ? =

Non. Aucun JavaScript n'est chargé côté public. L'éditeur utilise un minimum de JS uniquement pour le contrôle toggle.

= Quels navigateurs sont supportés ? =

Tous les navigateurs modernes avec support de `scroll-snap`. Les boutons de navigation utilisent des fonctionnalités expérimentales et peuvent ne pas apparaître sur certains navigateurs, mais le carousel reste fonctionnel.

= Puis-je personnaliser les couleurs des boutons ? =

Les boutons héritent automatiquement des couleurs définies dans votre thème (couleur de texte et arrière-plan des boutons). Vous pouvez les personnaliser via le Customizer ou le fichier theme.json de votre thème.

= Cela fonctionne-t-il avec les boucles de posts ? =

Oui ! Utilisez le bloc "Post Template" en mode Grid et activez le carousel. Parfait pour afficher vos derniers articles en carousel.

= Le plugin ralentit-il mon site ? =

Non ! Le carousel utilise uniquement du CSS natif du navigateur. Aucun JavaScript n'est chargé côté public, ce qui garantit des performances optimales.

= Puis-je avoir plusieurs carrousels sur la même page ? =

Absolument ! Vous pouvez ajouter autant de carrousels que vous le souhaitez sur une même page.

= Comment régler le nombre de colonnes visibles ? =

Pour les blocs Grid et Post Template :
- Utilisez l'option "Columns" pour un nombre fixe (1-6 colonnes)
- Utilisez "Minimum column width" pour un layout fluide qui s'adapte automatiquement

= Le carousel est-il responsive ? =

Oui, complètement ! Le carousel s'adapte automatiquement à toutes les tailles d'écran.

== Screenshots ==

1. Toggle "Carousel" dans les paramètres du bloc
2. Exemple de carousel avec Gallery
3. Carousel de Post Template (boucle de posts)
4. Carousel Grid avec colonnes personnalisées
5. Configuration du nombre de colonnes et espacement

== Changelog ==

= 1.0.0 - 2025-01-XX =
* 🎉 Version initiale
* Support des blocs Gallery, Grid, Group, Post Template
* Détection automatique des couleurs du thème
* Support des presets WordPress pour les espacements
* Gestion du Block Spacing (y compris gap horizontal/vertical pour Gallery)
* Détection automatique des colonnes pour Grid
* Support de "Minimum column width" pour layouts fluides
* 100% CSS, zéro JavaScript côté public
* Navigation accessible au clavier
* Compatible mobile avec défilement tactile

== Upgrade Notice ==

= 1.0.0 =
Version initiale du plugin. Transformez vos blocs Gutenberg en carrousels performants !

== Developer Notes ==

= GitHub Repository =

Le code source est disponible sur GitHub : [https://github.com/WEBLAZER/carousel-for-gutenberg](https://github.com/WEBLAZER/carousel-for-gutenberg)

= Contributions =

Les contributions sont les bienvenues ! N'hésitez pas à :
* Signaler des bugs via GitHub Issues
* Proposer des améliorations via Pull Requests
* Traduire le plugin dans votre langue

= Hooks disponibles =

Le plugin utilise le hook `render_block` pour injecter les variables CSS dynamiques.

= CSS Variables =

Le plugin utilise les variables CSS suivantes (personnalisables via CSS) :
* `--wp--style--block-gap` - Espacement entre les éléments
* `--carousel-min-width` - Largeur minimale pour les Grids en mode fluide
* `--carousel-button-bg` - Couleur de fond des boutons (auto-détectée)
* `--carousel-button-color` - Couleur du texte des boutons (auto-détectée)

== Credits ==

Développé avec ❤️ par [Arthur Ballan (WEBLAZER)](https://weblazer.github.io/)

