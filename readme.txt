=== WP Social Invitations ===
Author: Damian Logghe
Contributors: timersys
Description: Allow your visitors to invite friends of their social networks such as Google, Yahoo, Hotmail and more.
Website: http://www.timersys.com
Stable Tag: 1.6.1
Tested up to: 4.0.1
Tags: Social Invitations, twitter, facebook, linkedin, hotmail, yahoo, foursquare, google, social invites, invitations, social, social inviter
License: http://codecanyon.net/licenses/regular

Allow your visitors to invite friends of their social networks into your Wordpress site. 

== Description ==

> <strong>Black Friday Plus!</strong><br>
> 
> Check our ([Black Friday Offer](https://wp.timersys.com/black-friday-plus/))
> 

Allow your visitors to invite friends of their social networks such as Facebbok, Twitter, Foursquare Google, Yahoo, Hotmail and more directly into your Wordpress site. This plugin works perfectly with Buddypress and Invite Anyone Plugin.

Check the [wsi demo](http://wp.timersys.com/wordpress-social-invitations/?utm_source=wsi-free&utm_medium=readme&utm_campaign=wsi)

Full documentation available in [our site](http://wp.timersys.com/wordpress-social-invitations/docs/?utm_source=wsi-free&utm_medium=readme&utm_campaign=wsi)

= Currently Supported Providers =

Facebook, Twitter, Linkedin, Foursquare, Yahoo, Live, Gmail

= Features =

* HTML emails
* Template system to edit visuals or add your branding
* Invitations Queue to handle the different API limits
* Sidebar widget for sidebars
* Predefined invitation messages
* Custom CSS
* Translation ready
* Documentation

> <strong>Premium version</strong><br>
> 
> * Content locker - Share you content only to users that invited their friends by using a simple shortcode
> * MyCRED & Cubepoints integration
> * Bypass registration lock- To use the plugin on private sites that works with invitation only
> * Facebook uses SEND DIALOG
> * Linkedin delivers private messages instead of posting into user status
> * Twitter delivers Private messages instead of posting a tweet
> * GMAIL & SMTP SUPPORT
> * Predefined invitations can't be edited by users
> * Redirect users after they send invitations
> * Change order of providers
> * Free Support
> 
Get the premium version on [http://wp.timersys.com/wordpress-social-invitations/](http://wp.timersys.com/wordpress-social-invitations/?utm_source=wsi-free&utm_medium=readme&utm_campaign=wsi)


= Translations Credits = 

* Spanish - Eruedados Colombia 
* Serbo/Croatian - Borisa Djuraskovic

= Install Multiple plugins at once with WpFavs  =

Bulk plugin installation tool, import WP favorites and create your own lists ([http://wordpress.org/extend/plugins/wpfavs/](http://wordpress.org/extend/plugins/wpfavs/))

= Wordpress Popups  =

Best popups plugin ever ([http://wp.timersys.com/popups/](http://wp.timersys.com/popups/?utm_source=wsi-free-plugin&utm_medium=readme))

= Increase your twitter followers  =

Increase your Twitter followers with Twitter likebox Plugin ([http://wordpress.org/extend/plugins/twitter-like-box-reloaded/](http://wordpress.org/extend/plugins/twitter-like-box-reloaded/))



== Installation ==

= 1. The super easy way =
1. In your Admin, go to menu Plugins > Add
1. Search for `Wordpress Social Invitations`
1. Click to install
1. Activate the plugin
1. A new menu `WP Social Invitations` will appear in your Admin

= 2. The easy way =
1. Download the plugin (.zip file) on the right column of this page
1. In your Admin, go to menu Plugins > Add
1. Select the tab "Upload"
1. Upload the .zip file you just downloaded
1. Activate the plugin
1. A new menu `WP Social Invitations` will appear in your Admins

Then read the [documentation](http://wp.timersys.com/wordpress-social-invitations/docs/)
and configure the desired providers. Note that docs are for premium version and may be different from what you see.

You're done!

== Frequently Asked Questions ==

Please read carefully the [documentation](http://wp.timersys.com/wordpress-social-invitations/docs/) and double check providers settings.

Check our [Common problems section](http://wp.timersys.com/wordpress-social-invitations/docs/common-problems/)

== Screenshots ==

1. Big widget.
2. Sidebar Widget.
3. Users selection.
4. Emails template

== Changelog ==

= 1.6.1 - Nov 26, 2014

* Added display name to live provider
* Updated for better buddypress compability

= 1.6 - Oct 23, 2014

* Added %%CUSTOMURL%% field in settings
* Better session handling 

= 1.5.7 - Sept 23, 2014

* Prefixed custom functions
* Update oAuth for imcompatibility problems

= 1.5.6 - Jul 26, 2014

* Changed CSS of widget for better compatibility

= 1.5.5 - Jul 17, 2014 =

* Fixed bug with facebook that randomly caused link error of share popup
* Fixed bug when redirection after facebook share

= 1.5.4 - Jun 25, 2014 =

* Improved error page
* Updated hybrid auth
* Updated Google providers for new api

= 1.5.3 - Jun 6, 2014 =

* Changed facebook to SHARE dialog. Thanks API 2.0 :\
* Removed content filters
* Css bugfixes in front and backend
* Updated language files

= 1.5.2 - Mar 29, 2014 =

* Updated Readme
* Updated some css errors
* Minor bugfixes

= 1.5.1 - Mar 29, 2014 =

* Updated hybridauth providers Yahoo, Foursquare, and Facebook
* Added filters to change bp slug
* Fixed bug with ie 10
* Fixed fontawesome collision in some sites

= 1.5 - Mar 5, 2014 =

* Added manual cron functions to override Wordpress cron system
* Changed style and icons with fonts for better customization
* Added the ability to add emails manually(mail provider)
* Improved debug tab
* Templates updated
* Updated language files
* Added new shortcode %%CURRENTTITLE%%
* Removed friend selector on providers that don’t need it
* Fixed chars left in Twitter and Linkedin messages

= 1.4.4.4 - Feb 4, 2014 =

* Added new filters to let users change messages programatically
* Fixed bug with popup in Internet Explorer
* Css fixes for Internet Explorer
* Updated spanish translation

= 1.4.4.3 - January 30, 2014 =

* Fixed small xss vulnerability in the test.php file

= 1.4.4.2 - December 28, 2013 =

* Fixed bug in cubepoints module

= 1.4.4.1 - December 16, 2013 =

* Current url undlecared property fixed
* Tested with wp 3.8

= 1.4.4 - December 12, 2013 =

* Added new placeholder %%CURRENTURL%%
* Added an extra check for cron in case is not setted up properly
* Fixed sidebar broken link
* Fixed bug in error template
* Removed all scripts and actions added by other plugins in the popup


= 1.4.3 - December 3, 2013 =

* Added an extra check for cron in case is not setted up properly
* Moved goo.gl function to Queue Class so it can be used globally now
* Added new error message in error template
* Fixed bug to remove extra html added by other plugins in the popup
* Fixed bug with editor height
* Better buddypress integration . "Send Social Invites" screen and menu options added

= 1.4.2.1 =

* Fixed bug Invite anyone Js not loading where no other widget where used on site

= 1.4.2 =

* Fixed incompatibly issue with s2Member Plugin
* Fixed bug with cron jobs that were not properly running in some cases
* Impreved Js for multiple widgets in the same page

= 1.4.1 =

* Fixed bug with Invite Anyone Integration that was allowing non html providers to appear
* Added separate field for linkedin default message
* Minor bugfixes

= 1.4.0.7 =
* Fixed problems with escaped strings

= 1.4.0.6 =
* Fixed encoding problem

= 1.4.0.5 =

* Previous versions numbers were omitted to fix suversion problem
* Fixed bug with facebook that was preventing the queue to continue when error
* Fixed bug with twitter that was preventing the queue to continue when error
* Fixed bug with Linkeding that was preventing the queue to continue when error
* Fixed bug with scopes on facebook

= 1.4.0.1 =

* Complete redesign of popup email collector 
* Fixed bug with queue system on server with different time than WP
* New template system for emails and visual aspects that let users change everything 
* Queue system to handle invitations and API limits using wp-cron 
* Gmail and SMTP Support 
* New default messages separate for each providers 
* Placeholders to use in messages 
* HTML Email Templates 
* Improved facebook chat system with fallback to wall post 
* Goo.gl for facebook and twitter to improve rates 
* New Online documentation 
* Improved PHP functions 
* CSS bugfixes

= 1.3.2 =
* Fixed js bug that was preventing the widget to work properly.
* Corrected changelog as it was using premium version

= 1.3.1 =
* Updated WP_Plugin_Base class for compatibility with my other plugins
* Added stats

= 1.3 =
* Plugin released, woohoo!