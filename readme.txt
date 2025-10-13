=== Block Carousel ===
Contributors: weblazer
Donate link: https://weblazer.github.io/
Tags: carousel, blocks, gallery, slider, css
Requires at least: 6.0
Tested up to: 6.8
Stable tag: 1.0.1
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Transform any WordPress block into a responsive carousel with pure CSS. Zero JavaScript, maximum performance.

== Description ==

**Block Carousel** is a lightweight plugin that adds carousel functionality to native WordPress blocks without creating custom blocks or adding unnecessary JavaScript.

= Caractéristiques principales =

* **100% CSS** - Carousel entièrement en CSS (zéro JavaScript côté public)
* **Responsive complet** - Adaptation automatique du nombre de colonnes selon la taille d'écran
* **Blocs natifs** - Fonctionne avec Gallery, Grid, Group et Post Template
* **Détection automatique** - Reconnaissance automatique des colonnes pour les layouts Grid
* **Presets WordPress** - Support complet des espacements WordPress (Small, Medium, Large, etc.)
* **Intégration thème** - Détection automatique des couleurs de boutons du thème
* **Accessibilité** - Navigation au clavier native et respect des préférences utilisateur
* **Mobile-friendly** - Défilement tactile optimisé, boutons adaptés aux écrans tactiles
* **Performance** - Aucun impact sur les performances (CSS natif du navigateur, GPU accelerated)

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
2. Search for "Block Carousel"
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

Oui, complètement ! Le carousel s'adapte automatiquement à toutes les tailles d'écran avec un système responsive intelligent :

**Desktop (> 1280px)** : jusqu'à 6 colonnes
**Desktop Standard (< 1280px)** : jusqu'à 5 colonnes
**Tablette Paysage (< 1024px)** : jusqu'à 4 colonnes
**Tablette Portrait (< 782px)** : jusqu'à 3 colonnes
**Mobile Paysage (< 600px)** : jusqu'à 2 colonnes
**Mobile Portrait (< 480px)** : 1 colonne

**Exemple** : Si vous créez un carousel avec 6 colonnes, il affichera automatiquement 4 colonnes sur tablette, 2 sur mobile paysage, et 1 sur mobile portrait. Aucune configuration nécessaire !

Le système adapte également automatiquement :
- La taille des boutons de navigation
- La taille des marqueurs (dots)
- L'espacement entre les éléments
- Les marges internes

= Comment personnaliser le comportement responsive ? =

Le système responsive est automatique, mais vous pouvez le personnaliser via CSS si nécessaire. Consultez la documentation complète sur GitHub pour plus de détails.

== Screenshots ==

1. Toggle "Carousel" dans les paramètres du bloc
2. Exemple de carousel avec Gallery
3. Carousel de Post Template (boucle de posts)
4. Carousel Grid avec colonnes personnalisées
5. Configuration du nombre de colonnes et espacement

== Changelog ==

= 1.0.1 - 2025-01-XX =
* 📱 **NOUVEAU** : Système responsive complet avec adaptation automatique des colonnes
* 📱 Breakpoints WordPress standards (1280px, 1024px, 782px, 600px, 480px, 375px)
* 📱 Adaptation progressive : 6 colonnes → 5 → 4 → 3 → 2 → 1 selon la taille d'écran
* 📱 Boutons de navigation responsive (48px → 32px sur mobile)
* 📱 Marqueurs responsive avec tailles adaptées
* 📱 Espacements adaptatifs selon la taille d'écran
* 📱 Support responsive pour galeries et layouts fluides
* 🎨 Optimisation GPU avec transform et contain
* ♿ Amélioration accessibilité avec respect des préférences utilisateur
* 📖 Documentation complète du système responsive (RESPONSIVE.md)

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

= 1.0.1 =
Système responsive complet ! Les carousels s'adaptent maintenant automatiquement à toutes les tailles d'écran avec des breakpoints WordPress standards. Mise à jour fortement recommandée pour une meilleure expérience mobile.

= 1.0.0 =
Version initiale du plugin. Transformez vos blocs Gutenberg en carrousels performants !

== Developer Notes ==

= GitHub Repository =

Le code source est disponible sur GitHub : [https://github.com/WEBLAZER/block-carousel](https://github.com/WEBLAZER/block-carousel)

= Contributions =

Les contributions sont les bienvenues ! N'hésitez pas à :
* Signaler des bugs via GitHub Issues
* Proposer des améliorations via Pull Requests
* Traduire le plugin dans votre langue

= Hooks disponibles =

Le plugin utilise le hook `render_block` pour injecter les variables CSS dynamiques.

= CSS Variables =

Le plugin utilise les variables CSS suivantes (personnalisables via CSS) :

**Layout & Spacing :**
* `--wp--style--block-gap` - Espacement entre les éléments (adaptatif responsive)
* `--carousel-min-width` - Largeur minimale pour les Grids en mode fluide
* `--carousel-grid-item-width` - Largeur des items dans les grilles (adaptatif responsive)

**Boutons de Navigation :**
* `--carousel-button-bg` - Couleur de fond des boutons (auto-détectée depuis le thème)
* `--carousel-button-color` - Couleur du texte des boutons (auto-détectée depuis le thème)
* `--carousel-button-size` - Taille des boutons (responsive : 3rem → 1.75rem)
* `--carousel-button-offset` - Décalage des boutons par rapport aux bords (responsive)
* `--carousel-shadow` - Ombre des boutons et marqueurs

**Marqueurs (Dots) :**
* `--carousel-marker-size` - Taille des marqueurs (responsive : 0.66rem → 0.35rem)
* `--carousel-marker-gap` - Espacement entre les marqueurs (responsive)
* `--carousel-marker-bottom-offset` - Position verticale des marqueurs (responsive)

**Autres :**
* `--carousel-z-index` - Z-index des contrôles (défaut : 999999)
* `--carousel-transition-duration` - Durée des transitions (défaut : 0.3s)
* `--carousel-transition-easing` - Courbe d'animation (défaut : cubic-bezier)

Toutes les variables marquées "responsive" s'adaptent automatiquement selon les breakpoints définis dans le CSS.

== Credits ==

Développé avec ❤️ par [Arthur Ballan (WEBLAZER)](https://weblazer.github.io/)

