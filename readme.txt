=== MyTube PlayList ===
Contributors: TechnoEmpire System
Donate link: 
Tags: Wordpress plugin, MyTube, PlayList, YouTube
Requires at least: 3.0
Tested up to: 4.2.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Displays awesome YouTube Videos in your posts, pages, and widgets. YouTube Embed plugin is an convenient tool for adding video to your website.

== Description ==

Displays awesome YouTube Videos in your posts, pages, and widgets. YouTube Embed plugin is an convenient tool for adding video to your website.

== Features ==

* Light weight Plugin for displaying your PlayList Video
* Responsive design
* Using Shortcode display data in POST, PAGE, Widget, and also in your php file.

== Installation ==

= Step-by-step installation documents =
After downloading the plugin, you will find MyTube PlayList under Plugins.
Activate your plugin in Wordpress by clicking on "Activate".

= Configuring Plugin =

1. After activating the MyTube PlayList plugin, you'll notice a menu located on the Admin menu called MyTube. Click on it to open the plugin Global Settings.
2. Enter Your Google API KEY on this text box. And if you wish to set Global Playlist Set YouTube PlayList ID on your Global Setting Page.
3. Click on Save Changes.
4. Use Shortcode in POST and PAGE and using do_shortcode in files for listing your PlayList.
5. [mytube playlistid="Enter Your PlayListID" maxrecord="Set 0-50 for display number of record. This is optional." columns="Set 2,3 or 4 for display videos in a row."]

NOTE : Click on "Restore to Default" for set all settings to default exclude Google Api Key?

== Example ==
1. Using Page or Post ::
		a.	[mytube playlistid="PLOJrc9IhPiwUWT8hH1Kjn-WEnDg3zfu-A"]
		b.	[mytube playlistid="PLOJrc9IhPiwUWT8hH1Kjn-WEnDg3zfu-A" maxrecord="3"]    // maxrecord is optional, default is 18, you can set 1 to 50
        c.	[mytube playlistid="PLOJrc9IhPiwUWT8hH1Kjn-WEnDg3zfu-A" maxrecord="3" columns="4"]    // columns is optional, default is 3, you can set 2, 3 and 4.

2. Using do_shortcode ::
		a.	<?php echo do_shortcode('[mytube playlistid="PLOJrc9IhPiwUWT8hH1Kjn-WEnDg3zfu-A"]'); ?>
		b.	<?php echo do_shortcode('[mytube playlistid="PLOJrc9IhPiwUWT8hH1Kjn-WEnDg3zfu-A" maxrecord="3"]'); ?>    // maxrecord is optional, default is 18, you can set 1 to 50
        c.	<?php echo do_shortcode('[mytube playlistid="PLOJrc9IhPiwUWT8hH1Kjn-WEnDg3zfu-A" maxrecord="3" columns="4"]'); ?>    // columns is optional, default is 3, you can set 2, 3 and 4.

3. Using Widget ::
		You can use this shortcode in your Widget text field, But you have permission to use shortcode on Widget if you have not, please add " add_filter('widget_text', 'do_shortcode'); " into functions.php of your theme. and then do same like step 1.
		
== Frequently Asked Questions ==
If have you any doubt then send mail frequently on raghu@tes-india.com

== Screenshots ==
 1. This screen shot description corresponds to Back-End.
 2. This screen shot description corresponds to Front-End.

== Changelog ==
= 1.0.1 =

== Upgrade Notice ==
 = 1.0.1 =
 This version is initial version. 

* Initial release