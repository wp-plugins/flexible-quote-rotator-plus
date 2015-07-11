=== Flexi Quote Rotator Plus ===
Version 0.0.1
Contributors: Steve Lescure
Donate link: n/a
Tags: quotes, quotation, quote, quotations, testimony, testimonies, random quotes, random, rotating, quotation, plugin, shortcode, template, display
Requires at least: 3.0
Tested up to: 4.2
Stable tag: 0.0

A plugin for displaying quotes or testimonials or other rotating snippets of content. This plugin builds on the work done by acurran, who created Flexible Quote Rotator.  Flexible Quote Rotator Plus is a re-write of this original work. It now supports multiple widgets and more widget and shortcode options. It also allows users to enter a category for each quote, and use this category field in widgets and shortcodes to select the quotes to be displayed.     

== Description ==

The *flexi quote rotator* plugin allows you to add quotations/testimonies to your site using a shortcode(s) or a widget(s). Includes an administration settings page and provides styling flexibility.  Provides the ability to add, edit, and delete quotes.  


== Change Log ==


Version 0.1  (July 4 2015)
>  Initial beta release based on Version 0.9.4 of Quote Rotator by acurran, which in turn was based on version 3.5.4 of Quote Rotator by Luke Howell.


== Installation ==

1. Upload 'flexible-quote-rotator-plus' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress

= Updating Plugin =

* **If you had any custom stylesheet and related images, please make sure to save a copy of these before updating, you will need to replace these files.**
* You may have to enter the widget options after upgrading.

= Usage =

* To enter quotations, go to Tools > Quotes
* To display the quote rotator on a web page you have 3 options:

> 1. Add this shortcode to your page or post content (you CAN have more than one):  
>    `[[quoteRotator title="{optional title}" delay="{delay in seconds, optional}" fade="{fade-in duration in seconds, optional}" fadeout="{fade-out duration in seconds, optional}" random={"Yes" or "No" optional}" openquote="{optional} closequote="{optional}" height="{optional}" width="{optional}" fontsize="{optional}" unit="{px  em % optional}" textcolor="{optional}" category="{optional}" cssfile="{optional}"] </code><br />]`  
> e.g.1: `[quoteRotator]`  
> e.g.2: `[quoteRotator title="Testimonials" delay="8" fade="4" fadeout="2"]`  

> 3. Create a widget(s) (Appearance > Widgets)

* The settings can be edited at Settings > Quote Rotator Plus Options. Or, if you are using the widget they can be edited in the widget. Settings entered directly in shortcode or PHP override the settings saved in the administration settings.

Styling:

This plugin allows full styling flexibility using CSS to control how the quotes are displayed on your web site. A few example stylesheets are included in the styles folder (/wp-content/plugins/flexi-quote-rotator/styles/).  You can copy and modify one of these stylesheets to achieve the desired look. Then you save it in the styles folder and it will become an available for selection in the settings admin panel,  or set it in a shortcode parm. Alternatively you can select 'none' for stylesheet and add the styling to your main theme stylesheet. Photoshop source files are also provided if you want to modify the provided background images.

== Frequently Asked Questions ==
= Where do I add my quotes? =
Under the "Manage" tab of the admin page, there is a "Quotes" subpage.
= Can I have more than one quote areas on a page? =
Yes, this plugin is designed to handle more than one quote areas on an individual page.
= There appears to be more than one way of controlling the settings such as fade, delay, etc. Which takes precedence? =
It depends on the method used to display the quotes - if the original widget method if display is used, then the widget settings are used. If
the shortcode or PHP methods of display are used, the settings saved in Settings > Quote Rotator are used but these can be overidden by the optional attributes passed by shortcode.
= Can I put HTML code in the quote? =
Yes, you can put HTML code into the quote and also into the quote author field (which is useful if you want to link to the quote author's web site)

== Screenshots ==
1. Example of how Flexible Quote Rotator Plus can be displayed on a web page
2. Settings panel in admin
3. Management panel in admin
