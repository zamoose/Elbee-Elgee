## Elbee Elgee Parent Theme ##
[Project Homepage](<http://literalbarrage.org/blog/code/elbee-elgee>)

[Demo Site](<http://lblg.zamoose.org>)

### LICENSE ###
GNU Public License version 2 ([GPLv2](<http://www.gnu.org/licenses/gpl-2.0.html>))

### DESCRIPTION ###
Elbee Elgee (LBLG) is a parent theme with multiple layouts, including 1, 2 and 3 column fluid *and* fixed size designs. Its original inspiration was the [Layout Gala](<http://blog.html.it/layoutgala/>) (the "LG" in "Elgee"), whose extensive use of negative margins and creative use of floats gave 40 total layouts using a single HTML structure. I have pared down the options a bit, as WordPress' dynamic sidebars have negated the need for several of the "mirror image" designs originally provided by Layout Gala.

It supports most advanced WordPress features, such as Featured Images, widgetized sidebars, custom header images, and custom backgrounds. It also features templates for BuddyPress and a custom BuddyPress menu widget, allowing BP admins greater flexibility in choosing a site design.

It also separates layouts and styles into two separate folders, `layouts/` and `styles/` and auto-loads theme options (by default) from `includes/parent-options.php`. If a child theme is active, it will also attempt to auto-load options supplied in `[child theme]/includes/child-options.php` and can supplement, replace, or entirely negate the parent theme's options, allowing for greater child theme flexibility. (See documentation in `includes/parent-options.php` for further details.)

Additional layouts and styles can be added by simply placing new .css files in the `layouts/` and `styles/` subdirectories, respectively.

### INSTALLATION ###
#### Via S/FTP ####
1. Upload the `lblg/` folder to your site's `wp-content/themes/` directory.
2. Navigate to your WordPress Dashboard and go to Appearance -> Themes.
3. Activate Elbee Elgee.
4. Go to Appearance -> Elbee Elgee Settings.
5. Configure settings to your liking.
6. Click "Save changes".

#### Via Mercurial (Hg) ####
1. Clone the repository from http://bitbucket.org/zamoose/lblg into your site's `wp-content/themes/` directory, e.g. `hg clone http://bitbucket.org/zamoose/lblg`.
2. Navigate to your WordPress Dashboard and go to Appearance -> Themes.
3. Activate Elbee Elgee.
4. Go to Appearance -> Elbee Elgee Settings.
5. Configure settings to your liking.
6. Click "Save changes".

#### Via Subversion (SVN) ####
1. Check out the repository from http://bitbucket.org/zamoose/lblg/trunk into your site's `wp-content/themes/` directory, e.g. `svn cp http://bitbucket.org/zamoose/lblg/trunk lblg`
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

Elbee Elgee supports basic use of the [BuddyPress](<http://buddypress.org>) social media framework out of the box. Once BuddyPress version 1.3 is released, I hope to increase this support dramatically. At the very least, the basic Activity, Registration, Member, Forum and Blogs templates are supported.

**Note:** This theme has preliminary support for using a BuddyPress activity stream as the front page, however, it is buggy and therefore disabled in the code for the time being. I hope to correct this as soon as BuddyPress 1.3 ships.

#### Theme Options Page ####
I have planned Elbee Elgee to be a flexible parent theme from the very early stages. One of the coolest features (in my opinion) is its ability to auto-load theme options from either the parent theme *or* child themes. This primarily takes place in `includes/functions/options.php` and allows for an arbitrary number of theme options to be set and configured by end users.

This effectively creates a parent/child relationship *for theme options*. Child themes of Elbee Elgee can either default back to the options provided by the parent theme, they can extend said options, they can override them entirely, or they can disable all theme options.

#### bbPress version 2.0 (aka "The Plugin") Support ####
*Based on the bbp_twentyten parent theme provided as a part of the default bbPress plugin install*

Elbee Elgee has preliminary support for the "plugin-ized" version 2.0 of [bbPress](http://bbpress.org) (the WordPress-based forum solution). Templating functionality should not change between bbPress 2.0 beta 3 (the most recent version of bbP as of this writing) and the final release of bbPress version 2.0, so forums should continue to work during that transition period.

**Note:** BuddyPress and the plugin version of bbPress do not currently play well together. The combination of the two is not tested under this theme and is in no way recommended, nor will I support it until BuddyPress and bbPress come to an understanding regarding mutual support. *I.e., if you're thinking of running BuddyPress 1.2.x and bbPress 2.0, DON'T.*

#### Multiple Layouts ####
The HTML markup, combined with different CSS layout files, offers Elbee Elgee around 30 possible layout configurations right out of the gate. You can choose between 1, 2 and 3 column layouts, each of which offers static width, percentage-based and fluid width variants.

As of version 1.0 of Elbee Elgee, selecting a layout can be a bit confusing. Essentially, the CSS layout files are named in the following format:

`[number of columns]-[fixed/fluid/percentage-based]-[sidebar locations].css`

So, for example, `1-column-fixed.css` is a single column layout with fixed width (960px by default), while `3-columns-fluid-sb-fixed-both.css` is a 3 column fluid width design with fixed size sidebars on either side of the content area.

In successive versions of the theme I hope to implement a graphical layout-picker in order to make the layout selection process a bit more user-friendly.

#### Hooks ####
Elbee Elgee has a few notable hooks, with many more planned. I welcome your suggestions.

* `lblg_title()`: Outputs the blog title at the top of each page
* `lblg_menu()`: Outputs the navigation menu
* `lblg_the_postimage()`: Displays the Featured Image for posts, pages and custom post types that support it
* `lblg_sidebar_header()`: Hooks into top of sidebar.php
* `lblg_sidebar_footer()`: Hooks into bottom of sidebar.php

### AREAS FOR IMPROVEMENT ###
* SEO optimization is a work in progress.
* More theme hooks.
* General code clean-up/optimization.
* Better documentation.
* Fully-integrated bbPress support.

### ONGOING DEVELOPMENT ###
I have switched my development workflow from Subversion to [Mercurial](<http://mercurial.selenic.com>) (I spend a great deal of time on the train and Hg's distributed nature is *ideal* for such disconnected development) and, as such, host my code at <http://bitbucket.org/zamoose/lblg>. Please submit feature requests and bug reports using the issue tracker available at BitBucket.

If you are interested in learning more about Mercurial, [HG Init](<http://hginit.com>) is an *excellent* starters' resource (and it's even pretty good for moderately-skilled Hg users, too!)

### VERSION HISTORY ###

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