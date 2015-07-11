=== Flexible Quote Rotator Plus ===
Version 0.0.1
Contributors: slescure
Donate link: n/a
Tags: quotes, quotation, quote, quotations, testimony, testimonies, random quotes, random, rotating, quotation, plugin, shortcode, template, display
Requires at least: 3.0
Tested up to: 4.2
Stable tag: 0.0

== Description ==

The Flexible Quote Rotator Plus plugin allows you to add quotations/testimonies to your site using a shortcode(s) or a widget(s). Includes an administration settings page and provides styling flexibility. Provides the ability to add, edit, and delete quotes.  


== Change Log ==


Version 0.1  (July 4 2015)
>  Initial beta release based on Version 0.9.4 of Quote Rotator by acurran, which in turn was based on version 3.5.4 of Quote Rotator by Luke Howell.


== Installation ==

1. Upload 'flexible-quote-rotator-plus' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress


= Usage =

To enter quotations, go to Tools > Flexi Quotes Plus.

To display the quote rotator on a web page you have two options:

1) Add a shortcode, examples below, to a page (more than one is ok). All options are optional.

[QuoteRotatorPlus]
[QuoteRotatorPlus title="Vince Lombardi Quotes" delay="1" fade="1" fadeout="1" random="No" openquote=""" closequote=""" height="100" width="600" fontsize="12" unit="px" textcolor="blue" category="Vince Lombardi"]
[QuoteRotatorPlus title="Testimonials" delay="8" fade="4" fadeout="2"]
 

The shortcode options can also be edited at Settings > Quote Rotator Plus Options. If a shortcode does not included a short-code option, the default will be taken from the Options page.

2) Create a widget(s) got to Appearance > Widgets

> 3. Create a widget(s) (Appearance > Widgets)

* The settings can be edited at Settings > Quote Rotator Plus Options. Or, if you are using the widget they can be edited in the widget. Settings entered directly in shortcode or PHP override the settings saved in the administration settings.


== Frequently Asked Questions ==
- Where do I add my quotes? 
Hover over the “Tools” section of the Administration page, then click “Flexi Quotes Plus”.

- Can I select by category the quotes I want to display in a particular widget/shortcode? 
Yes.

- Can I include more than one shortcode on a page? 
Yes, the plugin is designed to handle more than one quote area on an individual page.

- Can I have more than one Flexible Quote Rotator Plus widget on my site? 
Yes.

- Can I put HTML code in the quote? 
Yes.

- Can Flexible Quote Rotator Plus make my quotes look exactly like I want them to? 
Maybe not. It’s likely you’ll want to add some CSS to your site to get it to look exactly the way you want. If you don’t know what CSS means, well, that’s going to be a problem. CSS is a bit confusing. Start here. I will try to help, but I’m not a CSS wizard either.

It IS possible to change the look of each widget component  (the quote area  and title) without affecting the  others on  the  page/sidebar.  Each  title/quotearea  created by a widget or short-code has a unique class associated with it. Therefore, it’s possible to use CSS to get the affect you want. Here are a couple examples to get you started.

To change the title area of a quote generated via a shortcode, add CSS like below. The “19031” bit (which is the Page-ID – 1903 – concatenated with the number of the shortcode on the page, in this case the first) will be unique to your site – use “inspect element” in your browser to find it.

h4.title19031 {
color: purple !important;
}

Similarly, you can change the title of a widget area (again, use “inspect element” to find the widget id (flexi_quote_plus_widget_2) used to create the class id:

h4.flexi_quote_plus_widget_2 {
color: purple !important;
}

== Screenshots ==
1. Example of how Flexible Quote Rotator Plus can be displayed on a web page
2. Settings panel in admin
3. Management panel in admin
