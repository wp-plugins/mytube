=== MyTube PlayList ===
Contributors: tes-india
Donate link: http://tes-india.com/
Tags: Wordpress YouTube plugin, mytube, playlist, youtube, videolist
Requires at least: 3.0
Tested up to: 4.2.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Displays awesome YouTube Videos in your posts, pages, and widgets. YouTube Embed plugin is an convenient tool for adding video to your website. Create your own playlist on MyTube PlayList using channel id and also video id. You can apply your style like font-color, font-size, view-count background color and font color, border color, pagination color, etc.

== Description ==

Displays awesome YouTube Videos in your posts, pages, and widgets. YouTube Embed plugin is an convenient tool for adding video to your website. Create your own playlist on MyTube PlayList using channel id and also video id. You can apply your style like font-color, font-size, view-count background color and font color, border color, pagination color, etc.

* Light weight Plugin for displaying your PlayList Video
* Responsive design
* Using Shortcode display data in POST, PAGE, Widget, and also in your php file.
* Override facilty

= Override Method =

* To override MyTube plugin, Copy "mytube override" folder from mytube plugin folder and Paste it your theme folder and then change on it with your requirement.

= Short Code List =

1. 	[mytube]    //get default videos based on youtube playlist id from backend global settings.
2. 	[mytube playlistid="xxxxxxxxxx"]    //get videos from selected youtube playlist id.
3.	[mytube playlistid="xxxxxxxxxx" maxrecord="3"]   //get maximum 3( here 1 to 50) videos from selected youtube playlist id.
4.	[mytube playlistid="xxxxxxxxxx" maxrecord="3" columns="3"]    //get maximum 3( here 1 to 50) videos from selected youtube playlist id and displayed with 3( here 2 or 3 or 4 only) columns.
5.	[mytube playlistid="xxxxxxxxxx" latestvideos="3"]    //get latest 3( here 1 to 50) videos from selected youtube playlist id. latestvideos will work with only playlistid.
6.	[mytube channelid="xxxxxxxxxx"]      // get playlist from channel id
7.	[mytube channelid="xxxxxxxxxx" pageid="001"]     // get playlist from channel id and set playlist video display page id using pageid.
8.	[myvimeo]   //get vimeo videos based on vimeo channel id from backend global settings
9.	[myvimeo channelid="xxxxxxxxx"]    //set channel id and get videos
10. [myvimeo channelid="xxxxxxxxx" columns="3"]    //set channel id and 3( here 2 or 3 or 4 only) columns.


== Features ==

* Light weight Plugin for displaying your PlayList Video
* Responsive design
* Using Shortcode display data in POST, PAGE, Widget, and also in your php file.
* Override facilty

== Installation ==

= Step-by-step installation documents =
After downloading the plugin, you will find MyTube PlayList under Plugins.
Activate your plugin in Wordpress by clicking on "Activate".

= Override MyTube plugin =
To override MyTube plugin, Copy "mytube override" folder from mytube plugin folder and Paste it your theme folder and then change on it with your requirement.

= Configuring Plugin =

1. After activating the MyTube PlayList plugin, you'll notice a menu located on the Admin menu called MyTube. Click on it to open the plugin Global Settings.
2. Enter Your Google API KEY on this text box. And if you wish to set Global Playlist Set YouTube PlayList ID on your Global Setting Page.
3. Click on Save Changes.
4. Use Shortcode in POST and PAGE and using do_shortcode in files for listing your PlayList.
5. [mytube playlistid="Enter Your PlayListID" maxrecord="Set 0-50 for display number of record. This is optional." columns="Set 2,3 or 4 for display videos in a row."]

NOTE : Click on "Restore to Default" for set all settings to default exclude Google Api Key?


= Short Code List =

1. 	[mytube]    //get default videos based on youtube playlist id from backend global settings.
2. 	[mytube playlistid="xxxxxxxxxx"]    //get videos from selected youtube playlist id.
3.	[mytube playlistid="xxxxxxxxxx" maxrecord="3"]   //get maximum 3( here 1 to 50) videos from selected youtube playlist id.
4.	[mytube playlistid="xxxxxxxxxx" maxrecord="3" columns="3"]    //get maximum 3( here 1 to 50) videos from selected youtube playlist id and displayed with 3( here 2 or 3 or 4 only) columns.
5.	[mytube playlistid="xxxxxxxxxx" latestvideos="3"]    //get latest 3( here 1 to 50) videos from selected youtube playlist id. latestvideos will work with only playlistid.
6.	[mytube channelid="xxxxxxxxxx"]      // get playlist from channel id
7.	[mytube channelid="xxxxxxxxxx" pageid="001"]     // get playlist from channel id and set playlist video display page id using pageid.
8.	[myvimeo]   //get vimeo videos based on vimeo channel id from backend global settings
9.	[myvimeo channelid="xxxxxxxxx"]    //set channel id and get videos
10. [myvimeo channelid="xxxxxxxxx" columns="3"]    //set channel id and 3( here 2 or 3 or 4 only) columns.

== Example ==
1. Using Page or Post ::
		a.	[mytube playlistid="PLOJrc9IhPiwUWT8hH1Kjn-WEnDg3zfu-A"]
		b.	[mytube playlistid="PLOJrc9IhPiwUWT8hH1Kjn-WEnDg3zfu-A" maxrecord="3"]    // maxrecord is optional, default is 18, you can set 1 to 50
        c.	[mytube playlistid="PLOJrc9IhPiwUWT8hH1Kjn-WEnDg3zfu-A" maxrecord="3" columns="4"]    // columns is optional, default is 3, you can set 2, 3 and 4.

2. Using do_shortcode ::
		a.	echo do_shortcode('[mytube playlistid="PLOJrc9IhPiwUWT8hH1Kjn-WEnDg3zfu-A"]');
		b.	echo do_shortcode('[mytube playlistid="PLOJrc9IhPiwUWT8hH1Kjn-WEnDg3zfu-A" maxrecord="3"]');     // maxrecord is optional, default is 18, you can set 1 to 50
        c.	echo do_shortcode('[mytube playlistid="PLOJrc9IhPiwUWT8hH1Kjn-WEnDg3zfu-A" maxrecord="3" columns="4"]');     // columns is optional, default is 3, you can set 2, 3 and 4.

3. Using Widget ::
		You can use this shortcode in your Widget text field, But you have permission to use shortcode on Widget if you have not, please add " add_filter('widget_text', 'do_shortcode'); " into functions.php of your theme. and then do same like step 1.
		
== Frequently Asked Questions ==
If have you any doubt then send mail frequently on raghu@tes-india.com

== Screenshots ==

1. This screen shot description corresponds to Global Settings.
2. This screen shot description corresponds to Create Playlist by channel ID or video ID.
3. This screen shot description corresponds to List of Playlist created by you.
4. This screen shot description corresponds to Edit your playlist.
5. This screen shot description corresponds to user view with 2 colums.


== Changelog ==
= 1.0.1 =
 Initial Version
= 1.0.2 =
 Resolve Pagination Issue
= 2.0.1 =
 Major Changes. Add More Functionality
= 2.0.2 =
 Changes on activation and deactivation data
= 2.0.3 =
 Add Functionality for overriding

== Upgrade Notice ==
= 1.0.1 =
 This version is initial version. 
= 1.0.2 =
 Updated version with pagination issue.
= 2.0.1 =
 Updated version with more functionality.
= 2.0.2 =
 Update activation and deactivation code.
= 2.0.3 =
 Add Functionality for overriding MyTube front end listing data.


* Initial release