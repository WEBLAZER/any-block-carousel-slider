# 🎠 Carousel for Gutenberg

[![WordPress Plugin Version](https://img.shields.io/badge/WordPress-6.0%2B-blue)](https://wordpress.org/)
[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-purple)](https://www.php.net/)
[![License](https://img.shields.io/badge/License-GPLv2-green)](LICENSE)

> Transformez n'importe quel bloc Gutenberg en carousel responsive avec du **CSS pur**. Zéro JavaScript, performance maximale.

## ✨ Caractéristiques

- **🚀 100% CSS** - Carousel entièrement en CSS (zéro JavaScript côté public)
- **🧩 Blocs natifs** - Fonctionne avec Gallery, Grid, Group et Post Template
- **🤖 Détection automatique** - Reconnaissance automatique des colonnes pour les layouts Grid
- **🎨 Intégration thème** - Détection automatique des couleurs de boutons du thème
- **♿ Accessibilité** - Navigation au clavier native
- **📱 Mobile-friendly** - Défilement tactile optimisé
- **⚡ Performance** - Aucun impact sur les performances

## 📦 Installation

### Via WordPress Admin (recommandé)

1. Allez dans **Extensions > Ajouter**
2. Recherchez "Carousel for Gutenberg"
3. Cliquez sur **Installer** puis **Activer**

### Installation manuelle

```bash
cd wp-content/plugins/
git clone https://github.com/WEBLAZER/carousel-for-gutenberg.git
```

Puis activez le plugin via l'admin WordPress.

## 🎯 Utilisation

1. **Créez un bloc supporté** (Gallery, Grid, Group, Post Template)
2. **Activez le toggle "Carousel"** dans le panneau latéral
3. **Configurez** (optionnel) :
   - Nombre de colonnes (pour Grid)
   - Largeur minimale (pour Grid fluide)
   - Espacement entre éléments
4. **Publiez** ! 🎉

## 🧱 Blocs supportés

| Bloc | Support | Options disponibles |
|------|---------|---------------------|
| **Gallery** | ✅ | Espacement horizontal/vertical |
| **Grid** (Group) | ✅ | Colonnes (1-6), Largeur min, Espacement |
| **Post Template** | ✅ | Colonnes (1-6), Largeur min, Espacement |
| **Group** | ✅ | Espacement |

## 🎨 Personnalisation

### Couleurs

Le plugin détecte automatiquement les couleurs de boutons de votre thème. Pour personnaliser :

**Via theme.json :**
```json
{
  "styles": {
    "elements": {
      "button": {
        "color": {
          "background": "#007cba",
          "text": "#ffffff"
        }
      }
    }
  }
}
```

**Via CSS personnalisé :**
```css
.cfg-carousel {
  --carousel-button-bg: #your-color;
  --carousel-button-color: #your-text-color;
}
```

### Variables CSS disponibles

```css
--wp--style--block-gap: 1rem;           /* Espacement entre éléments */
--carousel-min-width: 200px;            /* Largeur minimale (Grid fluide) */
--carousel-button-bg: #007cba;          /* Couleur fond boutons */
--carousel-button-color: #fff;          /* Couleur texte boutons */
--carousel-button-size: 2.5rem;         /* Taille des boutons */
--carousel-marker-size: 0.66rem;        /* Taille des indicateurs */
```

## 🔧 Développement

### Prérequis

- WordPress 6.0+
- PHP 7.4+
- Git

### Setup local

```bash
# Cloner le repo
git clone https://github.com/WEBLAZER/carousel-for-gutenberg.git
cd carousel-for-gutenberg

# Créer une branche de développement
git checkout -b develop
```

### Structure du projet

```
carousel-for-gutenberg/
├── assets/
│   ├── css/
│   │   └── carousel.css          # Styles du carousel
│   └── js/
│       └── carousel-button.js    # Toggle Gutenberg
├── carousel-for-gutenberg.php    # Fichier principal
├── README.md                      # Documentation GitHub
├── readme.txt                     # Documentation WordPress.org
└── LICENSE                        # Licence GPL v2
```

### Guidelines de contribution

1. **Fork** le projet
2. Créez une **feature branch** (`git checkout -b feature/amazing-feature`)
3. **Committez** vos changements (`git commit -m 'Add amazing feature'`)
4. **Push** vers la branche (`git push origin feature/amazing-feature`)
5. Ouvrez une **Pull Request**

### Standards de code

- Suivre [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- Tester avec [WordPress Playground](https://playground.wordpress.net/)
- Valider avec PHPCS : `phpcs --standard=WordPress`

## 🐛 Bugs & Support

- **Issues GitHub** : [Signaler un bug](https://github.com/WEBLAZER/carousel-for-gutenberg/issues)
- **Forum WordPress** : [Support communautaire](https://wordpress.org/support/plugin/carousel-for-gutenberg/)

## 📋 Roadmap

- [ ] Support du bloc Columns
- [ ] Options d'autoplay (optionnel, JS)
- [ ] Transitions personnalisées
- [ ] Mode infinite loop
- [ ] Block variations pour templates prédéfinis

## 🧪 Compatibilité navigateurs

| Fonctionnalité | Chrome | Firefox | Safari | Edge |
|----------------|--------|---------|--------|------|
| Carousel (scroll-snap) | ✅ | ✅ | ✅ | ✅ |
| Boutons navigation | 🧪 | 🧪 | 🧪 | 🧪 |
| Indicateurs | 🧪 | 🧪 | 🧪 | 🧪 |

🧪 = Fonctionnalité expérimentale (CSS `::scroll-button`, `::scroll-marker`)

**Note** : Le carousel reste pleinement fonctionnel sur tous les navigateurs modernes. Les boutons/indicateurs utilisent des fonctionnalités CSS expérimentales et peuvent ne pas apparaître partout, mais le défilement tactile/souris fonctionne toujours.

## 📜 Licence

Ce projet est sous licence GPL v2 ou supérieure - voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 👤 Auteur

**Arthur Ballan (WEBLAZER)**
- Website: [weblazer.github.io](https://weblazer.github.io/)
- GitHub: [@WEBLAZER](https://github.com/WEBLAZER)

## 🙏 Remerciements

- L'équipe WordPress pour Gutenberg
- La communauté open source

---

⭐ Si ce plugin vous est utile, n'hésitez pas à lui donner une étoile sur GitHub !
