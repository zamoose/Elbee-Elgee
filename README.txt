#Elbee Elgee Parent Theme#
http://literalbarrage.org/blog/code/elbee-elgee

##LICENSE##
GNU Public License version 2 (GPLv2)

##DESCRIPTION##
Elbee Elgee is a parent theme with multiple layouts, including 1, 2 and 3 column fluid *and* fixed size designs. It supports most advanced WordPress features, such as Featured Images, widgetized sidebars, custom header images, and custom backgrounds. It also features templates for BuddyPress and a custom BuddyPress menu widget, allowing BP admins greater flexibility in choosing a site design.

It also separates layouts and styles into two separate folders, `layouts/` and `styles/` and auto-loads theme options (by default) from `includes/parent-options.php`. If a child theme is active, it will also attempt to auto-load options supplied in `[child theme]/includes/child-options.php` and can supplement, replace, or entirely negate the parent theme's options, allowing for greater child theme flexibility. (See documentation in `includes/parent-options.php` for further details.)

Additional layouts and styles can be added by simply placing new .css files in the `layouts/` and `styles/` subdirectories, respectively.

##INSTALL##
###Via S/FTP###
1. Upload the `lblg/` folder to your site's `wp-content/themes/` directory.
2. Navigate to your WordPress Dashboard and go to Appearance -> Themes.
3. Activate Elbee Elgee.
4. Go to Appearance -> Elbee Elgee Settings.
5. Configure settings to your liking.
6. Click "Save changes".

###Via Mercurial###
1. Clone the repository from http://bitbucket.org/zamoose/lblg into your site's `wp-content/themes/` directory.
2. Navigate to your WordPress Dashboard and go to Appearance -> Themes.
3. Activate Elbee Elgee.
4. Go to Appearance -> Elbee Elgee Settings.
5. Configure settings to your liking.
6. Click "Save changes".

##SIDEBARS##
Elbee Elgee features four native sidebars/widget areas: Primary, Secondary, Bottom-Left and Bottom-Right. In most layouts, Primary will be placed either directly above (e.g. in 2 column layouts) or to the right of (in 1 or 3 column layouts)
 