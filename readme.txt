=== Native Blocks Carousel ===
Contributors: weblazer
Donate link: https://weblazer.github.io/
Tags: carousel, gutenberg, query-loop, woocommerce, css-only
Requires at least: 6.0
Tested up to: 6.8
Stable tag: 1.0.1
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Transform any WordPress block into a responsive Gutenberg carousel with pure CSS. Works with Query Loop, Gallery, WooCommerce Products, and custom blocks. Zero JavaScript, maximum performance.

== Description ==

**Native Blocks Carousel** instantly converts any native WordPress block (Gallery, Group, Grid, Query Loop, Post Template, WooCommerce Products, etc.) into a responsive carousel without adding a dedicated block or loading a JavaScript library. Simply enable the "Carousel" toggle in the editor: your content stays 100% native, your DOM stays lightweight, and your Lighthouse performance scores remain intact.

Unlike all-in-one carousel blocks like **Carousel Slider v2** that require you to add a "Carousel" block and manually recreate each slide ([see official listing](https://wordpress.org/plugins/carousel-block/)), **Native Blocks Carousel** hooks directly into the blocks you're already using. Result: a WordPress loop, image gallery, or product grid can become a slider in one click, without content duplication or extra maintenance.

= Why Native Blocks Carousel instead of a dedicated carousel block? =

* **WordPress loops without friction** – Transform Query Loop and Post Template blocks into a "loop slider" without creating a block per slide.
* **Familiar editorial experience** – Content editors keep the Gutenberg interface they know (patterns, global styles, alignments, inner blocks).
* **Zero JavaScript on the frontend** – Native scroll, `scroll-snap`, GPU-friendly, no Swiper/Slick bundle to load.
* **Full compatibility** – Works with classic themes (including Uncode) and block themes, plus WooCommerce, ACF Blocks, custom CPTs.
* **Accessibility + SEO** – Keyboard navigation, respects `prefers-reduced-motion` preferences, clean DOM for crawling.

= What you can do in 30 seconds =

* **Blog / Magazine**: Display your latest posts in a Query Loop carousel with native filters and badges.
* **Portfolios & testimonials**: Keep your Group, Cover, Media & Text blocks and make them scrollable without rebuilding anything.
* **WooCommerce**: Transform the Products block into a responsive product carousel (promotions, best-sellers, cross-sell).
* **Landing pages**: Chain complex sections (image, title, button, Lottie) within the same slider thanks to full inner blocks compatibility.
* **ACF Blocks / CPT**: If your custom block produces a grid, a simple toggle is enough to offer a carousel version.

= Quick comparison =

| Feature | Native Blocks Carousel | Classic carousel blocks |
| --- | --- | --- |
| Activation | Toggle on existing block | Add separate carousel block |
| WordPress loop | ✅ Query Loop, Post Template, CPT, products | ❌ Requires a block per slide or custom code |
| Frontend JavaScript | ❌ None | ✅ Swiper/Slick + custom scripts |
| Performance | Native CSS, no dependencies | Scripts, reflow, additional files |
| Content maintenance | Single source block | Content duplication in carousel block |
| Security | No third-party dependencies to update | Dependent library (Swiper/Slick) |

= Key features =

* **100% CSS** – Smooth carousel with `scroll-snap`, `::scroll-button`, and `::scroll-marker`. No script to bundle.
* **Smart responsive** – Automatically handles visible columns, spacing, and control sizes according to WordPress breakpoints (1280, 1024, 782, 600, 480, 375).
* **Two width modes** – Manual mode (fixed column count) and Auto mode (fixed width like 320px) with automatic detection.
* **Block spacing detection** – Respects `gap` and `padding` values defined in the editor, including presets.
* **Theme colors** – Buttons automatically inherit your theme's colors and radii (via CSS variables).
* **Intact semantics** – Your block's tags and classes remain unchanged: perfect for SEO, schemas, and E2E testing.

= Native WordPress workflow =

1. Add or edit a supported block (Gallery, Group, Columns, Query Loop/Post Template, WooCommerce Products, arranged patterns).
2. Enable the **Carousel** option in the sidebar panel (Layout or Block section depending on the block).
3. Adjust your usual settings (column count, minimum width, spacing, alignment).
4. Save: your block becomes a touch-friendly, accessible, and SEO-friendly carousel.

= Advanced customization =

* **Manual mode (fixed columns)** – Ideal for article sliders: 1 to 6 columns depending on screen sizes.
* **Auto mode (fixed width)** – Perfect for product carousels: 280px, 320px, or 360px respected pixel-perfect.
* **Padding and gaps** – Automatic management via CSS vars `--carousel-padding-*`, `--wp--style--block-gap`.
* **Themes & `theme.json`** – Override variables to align controls with your design system.
* **Graceful degradation** – If a browser doesn't support `::scroll-button`, users keep touch and mouse scrolling.

= Technical architecture =

* `render_block` hook to inject variables based on context (block type, columns, gaps).
* Dedicated service for translating labels and help messages.
* Separate editor/frontend styles for a transparent Gutenberg experience.
* Code organized by PSR-4 services (see `ARCHITECTURE.md` for details).

== Installation ==

= Automatic installation =

1. Go to "Plugins" → "Add New".
2. Search for **Native Blocks Carousel**.
3. Click "Install Now" then "Activate".

= Manual installation =

1. Download the plugin archive.
2. Upload the folder to `/wp-content/plugins/`.
3. Activate it from the "Plugins" menu.

= Usage =

1. Open a page, post, or template.
2. Select a compatible block (Gallery, Group, Columns, Query Loop, WooCommerce Products, ACF block…).
3. Enable the **Carousel** button in the settings.
4. Adjust your columns, minimum width, or spacing.
5. Publish or update: the carousel is operational.

== Frequently Asked Questions ==

= How does Native Blocks Carousel compare to Carousel Slider v2? =

Unlike Carousel Slider v2 which requires adding a dedicated "Carousel" block and manually creating each slide, Native Blocks Carousel transforms your existing blocks (Query Loop, Gallery, Products) with a simple toggle. For Query Loops specifically, Carousel Slider v2 would require creating a carousel block, then adding a Query Loop with only 1 post per slide—very impractical. Native Blocks Carousel handles this natively: one toggle, zero duplication, maximum performance.

= Is it compatible with all themes (block themes, FSE)? =

Yes. The plugin reads style variables generated by your theme (classic or full site editing) and applies the carousel without breaking the initial grid.

= Does it require JavaScript on the frontend? =

No. Everything relies on native CSS. Only a few lines of JavaScript executed in the editor handle the toggle interface. This means zero JavaScript bundle to load (unlike plugins using Swiper.js or Slick), resulting in better Lighthouse scores and Core Web Vitals.

= How do I transform a Query Loop into a carousel? =

Enable the Query Loop block (or Post Template), configure your filters and rendering, then check **Carousel**. Posts are automatically aligned on a scrollable line with snap and CSS arrows. This is the main advantage over traditional carousel plugins that don't support Query Loops natively.

= Can I mix images, titles, buttons, and forms in the same carousel? =

Yes. The plugin respects existing inner blocks. A Group block containing image + text + button (or a custom ACF block) is transformed as-is.

= WooCommerce compatible? =

The **Products** block (List, Hand-picked Products, On Sale, etc.) works immediately. Add to cart buttons remain interactive.

= Is there an autoplay mode, infinite loop, or custom arrows? =

The plugin focuses on native scroll and performance. You can add a light custom script if you want autoplay, but most sites get a better Core Web Vitals score by keeping native behavior.

= Can I have multiple carousels on the same page? =

Yes, without limit. Each block manages its own CSS variables.

= How do I adjust buttons or position markers? =

In your theme or via a CSS snippets plugin, override the variables:

```css
.wp-block-group.is-carousel {
    --carousel-button-bg: var(--wp--preset--color--primary);
    --carousel-marker-size: 0.8rem;
}
```

= What happens if the browser doesn't support `::scroll-button`? =

Visual arrows remain visible (disabled state) and users navigate via touch scroll or mouse wheel. The experience remains responsive.

== Screenshots ==

1. "Carousel" option in the Gutenberg sidebar panel.
2. Query Loop carousel displaying latest posts.
3. WooCommerce products carousel 100% CSS.
4. Mixed carousel (image + testimonial + button).
5. Custom CSS variables to adapt the design.

== Changelog ==

= 1.0.1 - 2025-01-24 =
* ✨ Added Auto mode (fixed width) for Grid, Post Template, and WooCommerce Products.
* ✨ Smart mode selection based on Gutenberg settings.
* 🎨 Complete horizontal/vertical padding management via CSS variables.
* 🎨 Buttons and markers automatically adapt to custom spacing.
* 📱 Fixed width respected even on mobile thanks to `min()` and `clamp()`.
* 💬 Enhanced contextual messages in the editor to guide mode selection.
* 🚀 Optimized editor JavaScript service to limit memory footprint.
* 🐛 Fixed control positioning with asymmetric padding.
* 🛠️ Internal refactor: PSR-4 autoload, modular services, front/editor separation.

= 1.0.0 - 2025-01-10 =
* 🎉 Initial version available on WordPress.org.
* ✅ Support for Gallery, Group, Grid, Columns, Query Loop/Post Template, WooCommerce Products blocks.
* 🎯 Automatic column and block spacing detection.
* 📱 WordPress standard breakpoints integrated (1280 → 375).
* 🎨 Responsive buttons and markers (3rem → 1.75rem, 0.66rem → 0.35rem).
* 🚀 No JavaScript dependencies on frontend (100% native CSS).
* ♿ Keyboard navigation, respects `prefers-reduced-motion`.
* 🔄 Multi-carousel compatibility on the same page.

== Upgrade Notice ==

= 1.0.1 =
Recommended update: Auto mode, advanced padding management, alignment fixes, and improved editor performance.

== Developer Notes ==

= GitHub Repository =

Source code is available on GitHub: [https://github.com/WEBLAZER/native-blocks-carousel](https://github.com/WEBLAZER/native-blocks-carousel)

= Contributions =

Contributions are welcome! You can:
* Open a GitHub ticket to report a bug or suggest an improvement.
* Propose a Pull Request.
* Help with translation (`.po` files available in `languages/`).

= Available hooks =

The plugin uses the `render_block` hook to dynamically inject CSS variables based on the current block.

= Main CSS Variables =

**Layout & Spacing:**
* `--wp--style--block-gap` – Spacing between elements (responsive).
* `--carousel-min-width` – Minimum width for grids in Auto mode.
* `--carousel-grid-item-width` – Item width in Manual mode.
* `--carousel-padding-left`, `--carousel-padding-right`, `--carousel-padding-top`, `--carousel-padding-bottom` – Detected padding.

**Navigation buttons:**
* `--carousel-button-bg`, `--carousel-button-color` – Colors auto-detected from theme.
* `--carousel-button-size` – Button size (3rem → 1.75rem).
* `--carousel-button-offset` – Lateral offset based on container width.
* `--carousel-shadow` – Shadow applied to controls.

**Markers (dots):**
* `--carousel-marker-size` – Marker size.
* `--carousel-marker-gap` – Horizontal spacing.
* `--carousel-marker-bottom-offset` – Vertical position.

**Miscellaneous:**
* `--carousel-z-index` – Display priority (default 999999).
* `--carousel-transition-duration`, `--carousel-transition-easing` – Animation smoothness.

== Credits ==

Developed with ❤️ by [Arthur Ballan (WEBLAZER)](https://weblazer.github.io/)
