## Elbee Elgee Parent Theme ##
[Project Homepage](http://literalbarrage.org/blog/code/elbee-elgee)

[Support Forums](http://literalbarrage.org/blog/forums/elbee-elgee)

[Demo Site](http://lblg.zamoose.org)

[FAQs](http://literalbarrage.org/blog/code/elbee-elgee/faq)

### LICENSE ###
All code (PHP, HTML, CSS and JavaScript) is licensed under the GNU Public License version 2 ([GPLv2](<http://www.gnu.org/licenses/gpl-2.0.html>)). All header images were taken by me and are also licensed under GPLv2. All icons are from the Icon Set for Bloggers by [StudioPress](http://studiopress.com).

### DESCRIPTION ###
Elbee Elgee (LBLG) is a parent theme with multiple layouts, including 1, 2 and 3 column fluid *and* fixed size designs. Its original inspiration was the [Layout Gala](<http://blog.html.it/layoutgala/>) (the "LG" in "Elgee"), whose extensive use of negative margins and creative use of floats gave 40 total layouts using a single HTML structure. I have pared down the options a bit, as WordPress' dynamic sidebars have negated the need for several of the "mirror image" designs originally provided by Layout Gala.

It supports most advanced WordPress features, such as Featured Images, widgetized sidebars, custom header images, and custom backgrounds. It also features templates for BuddyPress and a custom BuddyPress menu widget, allowing BP admins greater flexibility in choosing a site design.

It also separates layouts and styles into two separate folders, `layouts/` and `styles/` and auto-loads theme options (by default) from `includes/parent-options.php`. If a child theme is active, it will also attempt to auto-load options supplied in `[child theme]/includes/child-options.php` and can supplement, replace, or entirely negate the parent theme's options, allowing for greater child theme flexibility. (See documentation in `includes/parent-options.php` for further details.)

Additional layouts and styles can be added by simply placing new .css files in the `layouts/` and `styles/` subdirectories, respectively.

### INSTALLATION ###
#### Via S/FTP ####
1. Upload the `elbee-elgee/` folder to your site's `wp-content/themes/` directory.
2. Navigate to your WordPress Dashboard and go to Appearance -> Themes.
3. Activate Elbee Elgee.
4. Go to Appearance -> Elbee Elgee Settings.
5. Configure settings to your liking.
6. Click "Save changes".

#### Via Mercurial (Hg) ####
1. Clone the repository from [http://bitbucket.org/zamoose/elbee-elgee](http://bitbucket.org/zamoose/elbee-elgee) into your site's `wp-content/themes/` directory, e.g. `hg clone http://bitbucket.org/zamoose/elbee-elgee`.
2. Navigate to your WordPress Dashboard and go to Appearance -> Themes.
3. Activate Elbee Elgee.
4. Go to Appearance -> Elbee Elgee Settings.
5. Configure settings to your liking.
6. Click "Save changes".

#### Via Git (git) ####
1. Check out the repository from [https://github.com/zamoose/Elbee-Elgee](https://github.com/zamoose/Elbee-Elgee) into your site's `wp-content/themes/` directory, e.g. `git clone git://github.com/zamoose/Elbee-Elgee.git elbee-elgee`
2. Navigate to your WordPress Dashboard and go to Appearance -> Themes.
3. Activate Elbee Elgee.
4. Go to Appearance -> Elbee Elgee Settings.
5. Configure settings to your liking.
6. Click "Save changes".

#### Via Subversion (SVN) ####
1. Check out the repository from [http://bitbucket.org/zamoose/elbee-elgee/trunk](http://bitbucket.org/zamoose/elbee-elgee/trunk) into your site's `wp-content/themes/` directory, e.g. `svn co http://bitbucket.org/zamoose/elbee-elgee/trunk elbee-elgee`
2. Navigate to your WordPress Dashboard and go to Appearance -> Themes.
3. Activate Elbee Elgee.
4. Go to Appearance -> Elbee Elgee Settings.
5. Configure settings to your liking.
6. Click "Save changes".

### FEATURES ###
#### Sidebars ####
Elbee Elgee features four native sidebars/widget areas: Primary, Secondary, Bottom-Left and Bottom-Right. In most layouts, Primary will be placed either directly above (e.g. in 2 column layouts) or to the right of (in 1 or 3 column layouts) Secondary. Bottom-Left and Bottom-Right, as their names suggest, are located at the bottom of the design in the footer on the left and right, respectively.

#### Menus ####
Elbee Elgee supports one menu by default ("Front Page"). A second menu ("Elbee Elgee BuddyPress Menu") is activated when an active BuddyPress installation is detected. This menu will be automatically populated with the most commonly-used BuddyPress links. You may alter it as you see fit or choose not to use it at all.

#### BuddyPress Support ####
*Based in part on code provided by the [BuddyPress Template Pack plugin](http://wordpress.org/extend/plugins/bp-template-pack/)*

Elbee Elgee supports use of the [BuddyPress](<http://buddypress.org>) social media framework out of the box. Support for BP has gotten better with further testing from willing end-users. If you have a bug that you run into while using BuddyPress, *please* let me know so that I can correct it.

#### Theme Options Page ####
I have planned Elbee Elgee to be a flexible parent theme from the very early stages. One of the coolest features (in my opinion) is its ability to auto-load theme options from either the parent theme *or* child themes. This primarily takes place in `includes/functions/options.php` and allows for an arbitrary number of theme options to be set and configured by end users.

This effectively creates a parent/child relationship *for theme options*. Child themes of Elbee Elgee can either default back to the options provided by the parent theme, they can extend said options, they can override them entirely, or they can disable all theme options.

#### bbPress version 2.0 (aka "The Plugin") Support ####
*Based on the bbp_twentyten parent theme provided as a part of the default bbPress plugin install*

Elbee Elgee features support for the "plugin-ized" version 2.0 of [bbPress](http://bbpress.org) (the WordPress-based forum solution). If an active bbPress installation is detected, Elbee Elgee will populate the theme admin page with bbPress-appropriate options.

#### Multiple Layouts ####
The HTML markup, combined with different CSS layout files, offers Elbee Elgee around 30 possible layout configurations right out of the gate. You can choose between 1, 2 and 3 column layouts, each of which offers static width, percentage-based and fluid width variants.

As of version 1.0 of Elbee Elgee, selecting a layout can be a bit confusing. Essentially, the CSS layout files are named in the following format:

`[number of columns]-[fixed/fluid/percentage-based]-[sidebar locations].css`

So, for example, `1-column-fixed.css` is a single column layout with fixed width (960px by default), while `3-columns-fluid-sb-fixed-both.css` is a 3 column fluid width design with fixed size sidebars on either side of the content area.

In successive versions of the theme I hope to implement a graphical layout-picker in order to make the layout selection process a bit more user-friendly.

#### Demonstration Stylesheet ####
A stylesheet, `layoutgala.css`, is included with Elbee Elgee but is not intended for "production" use. Instead, it is intended as a learning tool. Due to the large number of layout stylesheets, the exact proportions and placement of the various theme elements can be a bit confusing (I mean, could *you* tell the difference between `2-columns-sb-right-under.css` and `2-columns-sb-right-under-full.css` just by looking at the name?). I have therefore included a styling scheme, based on the original Layout Gala markup, that nicely demonstrates the layout features.

#### Hooks ####
Elbee Elgee has a few notable hooks, with many more planned. I welcome your suggestions.

* `lblg_title()`: Outputs the blog title at the top of each page
* `lblg_menu()`: Outputs the navigation menu
* `lblg_the_postimage()`: Displays the Featured Image for posts, pages and custom post types that support it
* `lblg_sidebar_header()`: Hooks into top of sidebar.php
* `lblg_sidebar_footer()`: Hooks into bottom of sidebar.php
* `lblg_enqueue_styles()`: Enqueues CSS styles for output by WordPress
* `lblg_credits()`: Outputs the theme credit links in the footer
* `lblg_echo_copyright()`: Outputs the site's copyright statement in the footer

#### Settings API ####
I have tried to hew as closely as possible to the recommended best-practices in the form of the WordPress Settings API. Elbee Elgee should leave a minimal database footprint (at the moment, it is two options, soon to be only a single option). By supporting the Settings API, Elbee Elgee can gain some manner of future-proofing and it obtains security features at a minimal cost.

### AREAS FOR IMPROVEMENT ###
* SEO optimization is a work in progress.
* More theme hooks.
* General code clean-up/optimization.
* Better documentation.
* "Responsive" design
* <del>Fully-integrated bbPress support.</del> Added in 1.1.
* <del>Editor styling (particularly important after WP 3.2's addition of Distraction-Free Writing [DFW])</del> Added in 1.2.

### ONGOING DEVELOPMENT ###
I have switched my development workflow from Subversion to [Mercurial](<http://mercurial.selenic.com>) (I spend a great deal of time on the train and Hg's distributed nature is *ideal* for such disconnected development) and, as such, host my code at <http://bitbucket.org/zamoose/elbee-elgee>. Please submit feature requests and bug reports using the issue tracker available at BitBucket.

If you are interested in learning more about Mercurial, [HG Init](<http://hginit.com>) is an *excellent* starters' resource (and it's even pretty good for moderately-skilled Hg users, too!)

### VERSION HISTORY ###

* Version 1.3.9
	* **Issues Fixed**
		* Resolved options-saving bug that has been plaguing LBLG for ages, affecting primarily bbPress and BuddyPress
* Version 1.3.8
	* **Issues Fixed**
		* BuddyPress JavaScript has been fixed for BP version >= 1.6
* Version 1.3.7
	* **Issues Fixed**
		* Top-level drop-downs should now be styled correctly and consistently
		* Custom menus added as widgets should no longer get styling from top-level menus
* Version 1.3.6
	* **Features Added**
		* Greater CSS flexibility (selectors aren't as specific, allowing for easier child theming)
		* Support for Yoast's Breadcrumbs (part of his [WordPress SEO plugin](http://yoast.com/wordpress/seo/#utm_source=wpadmin&utm_medium=plugin&utm_campaign=wpseoplugin))
	* **Issues Fixed**
		* BuddyPress "Load More" link in Activity streams actually, you know, *loads more*.
		* bbPress support updated for all the proper bbP hooks, so certain plugins that weren't working before now **POOF** magically work again.
		* Default search results if nothing is found were... *blank*. D'oh! Fixed.
		* BuddyPress Groups widget AJAX now works to load groups on the fly.
* Version 1.3.5
	* **Issues Fixed**
		* Fixed error where selecting "Display Text: no" in theme header options would still display the 50% opacity #titltedesc div.
* Version 1.3.4
	* **Issues Fixed**
		* Fixed CSS selector specificity oversight that caused active menu items to appear "invisible" in default `ng.css` styling. 
* Version 1.3.3
	* **Issues Fixed**
		* Switched from `wp_print_styles()` to `wp_enqueue_scripts()` to enqueue/output CSS due to changes in WordPress 3.3 (see [here]( http://wpdevel.wordpress.com/2011/12/12/use-wp_enqueue_scripts-not-wp_print_styles-to-enqueue-scripts-and-styles-for-the-frontend/) for details).
* Version 1.3.2
	* **Issues Fixed**
		* Fallback `wp_list_pages()` output CSS corrected
* Version 1.3.1
	* **Issues Fixed**
		* bbPress 1 column layouts no longer site-wide
* Version 1.3
	* **Features Added**
		* Support for BuddyPress 1.5
		* Support for final bbPress 2.0
		* Tabbed admin support
		* CSS-only drop-down menu support for primary menu area
		* Partial PHPDoc documentation for included theme files
* Version 1.2.2
	* **Issues Fixed**
		* Proper support for BuddyPress 1.2.9 permalinks
* Version 1.2.1
	* **Issues Fixed**
		* Correctly styling single page title display to use H1
		* Single page view w/comments disabled no longer displaying comments closed message
		* Removed padding on `#lb-content dl.gallery-item` which corrects wonky float behavior in inline galleries
		* "Leave A Reply" H3 on single post/page views now correctly styled
		* 3 column/sidebar both overflow issue fixed
		* Pagination links now properly clear content
* Version 1.2
	* **Issues Fixed**
		* `wp_footer()` call moved to right before &lt;/body&gt;
		* Global variables properly prefixed
		* Search form use of `$_SERVER['PHP_SELF']` replaced with proper WordPress call
		* Post date changed to use permalink as well as post title to account for posts without a title
		* Images explicitly noted as GPLv2
		* Dual setting of `$content_width` removed
		* Theme options changed to use recommended `checked()` and `selected()` syntax
		* Required header, list and table formatting applied
		* Changed location of post meta information
		* Floated elements properly cleared in single post/page templates
		* Captioned images properly aligned
		* "Comments are closed" displayed when comments are disabled/closed
		* Switched options textareas from `esc_attr()` to `wp_kses_post()`
		* Calendar widget styling added
		* `text` and `textarea` options properly escaped before output by `esc_html()`
		* Comments styling fully fleshed-out
		* User-specified credits and copyright text displayed correctly
		* Added `add_editor_style()` functionality for more WYSIWYG-ish TinyMCE/DFW goodness
		* Added StudioPress Icon Set for Bloggers for visual flair
* Version 1.1.1
	* **Issues Fixed**
		* Updated to fix 'native' bug in upstream `bbp_twentyten` (ref. [rev. 3331](http://bbpress.trac.wordpress.org/changeset/3331))
* Version 1.1
	* **Features Added**
		* bbPress v.2.0 (plugin-based) support
		* Styling fixes for BuddyPress
		* Auto-styling of warning, notification and alert posts
	* **Issues Fixed**
		* BuddyPress Member/Group buttons now appearing
		* Question mark next to @ names in individual Member screens now styling correctly
		* "New Topic" & "Create Group" buttons styled correctly
		* Header images max width now 1024px.
* Version 1.0
	* Initial release

### KNOWN ISSUES ###
* Version 1.3.8
	* <del>Options for bbPress or BuddyPress don't save after enabling plugins</del>
* Version 1.3.7
	* <del>Italics/emphasis elements not styled correctly</del>
	* <del>AJAX requests for BuddyPress pages not working correctly</del>
* Version 1.3.6
	* <del>Drop-down primary menu CSS is overlapping incorrectly[*](https://bitbucket.org/zamoose/elbee-elgee/issue/5/drop-down-menus-not-aligning-correctly)</del>
	* <del>"Greedy" CSS selectors causing menus added as custom widgets to get incorrect styling[*](https://bitbucket.org/zamoose/elbee-elgee/issue/6/overly-greedy-css-causing-menus-in-widgets)</del>
* Version 1.3.5
	* [BP GTM System](http://ovirium.com/plugins/bp-gtm-system/) is incompatible with Elbee Elgee
	* <del>BuddyPress Groups widget AJAX doesn't work -- full page reload caused by clicks</del>
	* <del>Search results with 0 results eventuate in empty search page</del>
	* <del>bbPress support lags behind core bbPress Twenty Ten standards</del>
	* <del>"Load More" link in BuddyPress Activity screen doesn't work</del>
* Version 1.3.4
	* <del>Blanking header text via theme admin settings doesn't blank the 50% transparency div in the default style</del>
* Version 1.3.3
	* <del>Incorrect specificity in CSS selectors makes active menu item "invisible" in default `ng.css` styling</del>
* Version 1.3.2
	* <del>Improperly enqueuing front-end CSS stylesheets in admin backend as of WordPress 3.3.</del>
* Version 1.3.1
	* <del>WP installs not using custom nav menu (thus using fallback wp_list_pages() function) not seeing correct multi-level menu behavior</del>
* Version 1.3
	* <del>bbPress 1 column settings apply site-wide instead of just to bbPress pages due to a flaw in selection logic.</del>
* Version 1.2.1
	* <del>Proper BuddyPress 1.2.9 permalink support for single users.</del>
* Version 1.2
	* <del>Page titles incorrectly using unstyled H2 for title.</del>
	* <del>Pages with closed comments incorrectly displaying "Comments are closed".</del>
	* <del>3 column gallery view incorrectly bumping third image to next line.</del>
	* <del>"Reply" H3 incorrectly unstyled.</del>
	* <del>Content area overflows into right sidebar in 3 column/sidebars both layout.</del>
	* <del>Paginated posts' page navigation sections don't clear content correctly.</del>
* Version 1.1.1 aka "The Theme Review One" (taken from the [initial theme review](http://themes.trac.wordpress.org/ticket/4336#comment:3))
	* <del>Posts with no titles must still include a permalink to the single post view. The recommended practice is to place the permalink on the post date as well.</del>
	* <del>You must provide styling for heading elements (&lt;h2&gt; - &lt;h6&gt;), blockquotes, tables, definition lists, ordered lists and unordered lists.</del>
	* <del>Captioned images must be properly aligned.</del>
	* <del>Floated elements must be properly cleared.</del>
	* <del>Check your styling of comments, particularly nested comments.</del>
	* <del>Posts with closed comments are required to display some kind of "Comments are disabled" message. This does not apply to Pages.</del>
	* <del>Theme options using textareas that allow HTML should use `wp_kses_post()` when sanitizing form data.</del>
	* <del>Provide styling for the calendar widget.</del>
	* <del>Provide more whitespace between the post meta and post content.</del>
	* <del>Content entered in "Copyright Statement" and "Footer Credits" does not show up on the site.</del>
	* <del>wp_footer() must be placed directly before &lt;/body&gt;.</del>
	* <del>The use of `$_SERVER['PHP_SELF']` in forms is discouraged as it presents a security risk.</del>
	* <del>All custom functions and global variables must be prefixed with the theme slug or an appropriate variant.</del>
	* <del>All data must be sanitized and validated before saving to the database and properly escaped when outputting to forms.</del>
	* <del>Themes are required to use checked() and selected() for checkbox and select options in forms respectively.</del>
	* <del>`( ! isset( $content_width ) ) $content_width = '640';` entered twice in `includes/supports.php`.</del>
	* <del>Please note the license being used for your header images in the readme. They must be GPL-compatible.</del>
* Version 1.0
	* Specifying BuddyPress Activity as front page tosses 404 error
	* <del>Header images max width at 960px</del>
	* <del>"New Topic" & "Create Group" buttons styled incorrectly</del>
	* <del>Where's the "Add Friend" button?</del>
	* <del>Question mark JS anchor next to @ names doesn't place non-hidden text in the right place</del>

### INSPIRATION ###

* As noted in the introduction, [Layout Gala](<http://blog.html.it/layoutgala/>) was the original inspiration for the layouts

* The Undersigned's original functions.php [tutorial](<http://theundersigned.net/2006/06/wordpress-how-to-theme-options/>) (now defunct) and my [original tutorial](<http://literalbarrage.org/blog/archives/2007/05/03/a-theme-tip-for-wordpress-theme-authors/>) for the options.php code

* Chip Bennett's [Oenology](<http://www.chipbennett.net/themes/oenology/>)

* [Twenty Ten](http://2010dev.wordpress.com/), the default WordPress theme prior to version 3.2, was the inspiration for the default dynamic header support

* [BuddyPress Template Pack](<http://wordpress.org/extend/plugins/bp-template-pack/>) by Andy Peatling for a *ton* of the BuddyPress functionality and template work

* [StudioPress](http://studiopress.com)'s Icon Set for Bloggers iconography (Unfortunately, my preferred Mini2 icons are CC-Share-Alike or somesuch and therefore not WordPress Theme Repository-compatible)