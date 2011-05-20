## Elbee Elgee Parent Theme ##
<http://literalbarrage.org/blog/code/elbee-elgee>

### LICENSE ###
GNU Public License version 2 (GPLv2)

### DESCRIPTION ###
Elbee Elgee (LBLG) is a parent theme with multiple layouts, including 1, 2 and 3 column fluid *and* fixed size designs. Its original inspiration was the Layout Gala (<http://blog.html.it/layoutgala/>, the "LG" in "Elgee"), whose extensive use of negative margins and creative use of floats gave 40 total layouts using a single HTML structure. I have pared down the options a bit, as WordPress' dynamic sidebars have negated the need for several of the "mirror image" designs originally provided by Layout Gala.

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
Elbee Elgee supports basic use of the BuddyPress social media framework (<http://buddypress.org>) out of the box. Once BuddyPress version 1.3 is released, I hope to increase this support dramatically. At the very least, the basic Activity, Registration, Member, Forum and Blogs templates are supported.

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

### ONGOING DEVELOPMENT ###
I have switched my development workflow from Subversion to Mercurial (<http://mercurial.selenic.com>) (I spend a great deal of time on the train and Hg's distributed nature is *ideal* for such disconnected development) and, as such, host my code at <http://bitbucket.org/zamoose/lblg>. Please submit feature requests and bug reports using the issue tracker available at BitBucket.

If you are interested in learning more about Mercurial, <http://hginit.com> is an *excellent* starters' resource (and it's even pretty good for moderately-skilled Hg users, too!)

### INSPIRATION ###

* As noted in the introduction, Layout Gala (<http://blog.html.it/layoutgala/>) was the original inspiration for the layouts

* The Undersigned's original functions.php tutorial (<http://theundersigned.net/2006/06/wordpress-how-to-theme-options/>, now defunct) for the options.php code

* Chip Bennett's Oenology (<http://www.chipbennett.net/themes/oenology/>)

* Twenty Ten, the default WordPress theme prior to version 3.2, was the inspiration for the default dynamic header support