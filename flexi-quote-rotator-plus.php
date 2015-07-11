<?php
/*
Plugin Name: Flexi Quote Rotator Plus
Plugin URI: https://wordpress.org/plugins/flexible-quote-rotator-plus/
Description: Flexible Quote Rotator Plus allows you to add quotations/testimonies to your site using a shortcode or as a widget.
Version: 0.1.0
Author:  Steve Lescure
Author URI: http://www.stevelescure.net

---------------------------------e------------------------------------
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
---------------------------------------------------------------------
*/

require_once('classes/quote-rotator-plus.class.php');
require_once('classes/quote-rotator-plus-management.class.php');
require_once('classes/quote-rotator-plus-widget.class.php');


if( class_exists('QuoteRotator') && class_exists('QuoteRotatorManagement') ) :

$quoteRotator = new QuoteRotator();
$management = new QuoteRotatorManagement();
if( isset($quoteRotator) && isset($management) )
{

function process_post() {
	global $quoteRotator, $management;
	$action = (isset($_GET['action']) ? $_GET['action'] : null);
	$addQuote = (isset($_POST['addQuote']) ? $_POST['addQuote'] : null);
	$editQuote = (isset($_POST['editQuote']) ? $_POST['editQuote'] : null);
		
      if($action=="delete-quote" && check_admin_referer('fqr-nonce'))
   	{
      	  $management->deleteQuote($_GET['id']);
   	}
   
   	if($addQuote == 1 && check_admin_referer('fqr-nonce'))
   	{
 	  $management->addQuote($_POST['quote'], $_POST['author'], $_POST['category']);
   	}
   	
   	if($editQuote == 1 && check_admin_referer('fqr-nonce'))
   	{
    	  $management->editQuote($_POST['quote'], $_POST['author'], $_POST['category'], $_POST['id']);
   	}
	}
   
function widgetInit()
	{
	global $quoteRotator, $management;
		
	if( !function_exists('wp_register_sidebar_widget') )
	{
	  return;
	}
		
	//	wp_register_sidebar_widget('flexi-quote-rotator-plus','Flexi Quote Rotator Plus', array(&$quoteRotator, 'displayWidget'));
	//	wp_register_widget_control('flexi-quote-rotator','Flexi Quote Rotator', array(&$management, 'displayWidgetControl'));
	}
	
function managementInit()
	{
	global $management;
		
	//  wp_enqueue_script( 'listman' ); commented  out on 6/18  - doesn't seem necessary
	add_management_page('Flexi Quote Plus', 'Flexi Quote Plus', 5, basename(__FILE__), array(&$management, 'displayManagementPage'));
        add_options_page('Flexi Quote Plus Options', 'Flexi Quote Plus Options', 10, basename(__FILE__), array(&$management, 'displayOptionsPage'));
	}

function includejquery()
   {
      wp_enqueue_script('jquery');   
}
   	
   // [quoteRotator [title=""] [delay=""] [fade=""]]
function quoteRotator_func($atts) {
      global $quoteRotator;
      global $wpdb;

      extract( shortcode_atts( array(
          'title' => '',
          'delay' => '',
          'fade' => '',
          'fadeout' => '',
          'random' =>  '',
          'category' => '',
          'height' => '',
          'width' => '',
          'unit' => '',
          'fontsize' => '',
          'textcolor' => '',
          'openquote' => '',
          'closequote' => '',
         ), $atts ) );
 
 // used in select statement so need "tick" marks  
       $randomq = "'" . $random  . "'";
 
 // used to  count the number of shortcodes enterred  on a page      
       global $shortcodecnt;
       $shortcodecnt = $shortcodecnt + 1;
 
 //  set parms to the default if not set in shortcode
   
      	if ($title == "")  {
   	   $title = get_option('fqr_title');
   	} 
   	
       	if ($delay <= 0)  {
   	   $delay = get_option('fqr_delay');
   	} 
   	// delay can't  be zero so set  it to 5
    	if ($delay <= 0) {
   	   $delay = 10;
   	}
   	
   	if ($fade <= 0)  {
   	   $fade  = get_option('fqr_fade');
   	} 
   	
    	if ($fade <= 0) {
   	   $fade = 2;
   	}
   	
     	if ($fadeout <= 0)  {
   	   $fadeout  = get_option('fqr_fadeout');
   	} 
   	
   	if ($fadeout <= 0) {
   	   $fadeout = 2;
   	}
   	
  	if ($height <= 0)  {
   	   $height  = get_option('fqr_height');
   	} 
   	
   	if ($height <= 0) {
   	   $height = 100;
   	}
   	
   	if ($width <= 0)  {
   	   $width  = get_option('fqr_width');
   	} 
   	
   	if ($width <= 0) {
   	   $width = 250;
   	}
   	
 	if ($fontsize <= 0)  {
   	   $fontsize  = get_option('fqr_fontsize');
   	} 
   	
    	if ($fontsize <= 0) {
   	   $fontsize = 20;
   	} 
   	
       	if ($textcolor == "")  {
   	   $textcolor = get_option('fqr_textcolor');
   	} 
   	
       	if ($textcolor == "")  {
   	   $textcolor = get_option('textcolor');
   	}  	
   	
   	if ($unit == "")  {
  	   $unit  = get_option('fqr_unit');
   	} 
 
   	if ($unit == "") {
   	   $unit = "px";
   	}
   	
     	if ($random == "")  {
   	   $random  = get_option('fqr_random');
   	} 
 
   	if ($random == "") {
   	   $random = "No";
   	}
   	
   	$randomq = "'"  .  $random   .   "'";

  	
    	if ($category == "")  {
   	   $category  = get_option('fqr_category');
   	} 
   	
       	if ($title == "")  {
   	   $title = get_option('title');
   	} 
   	
   	if ($openquote == "")  {
   	   $openquote = get_option('fqr_openquote');
   	} 
    	  	
   	if ($closequote == "")  {
   	   $closequote = get_option('fqr_closequote');
   	} 
  	
 	if (!isset($openquote) || $openquote == "") {
            $openquote = "";
        } else {
           $openquote = "<span id='openquote' class='quotemark'>" . $openquote . '</span>';
         }

 	if (!isset($closequote) || $closequote == "") {
            $closequote = "";
         } else {
           $closequote = "<span id='closequote' class='quotemark'>" . $closequote . '</span>';
        }
        
    
    $tableName = $wpdb->prefix . 'QuoteRotator_Plus';
     
    $categorysql  =   "'" .   $category . "'";
    
     if ($category == "")  {
	$sql = "SELECT * FROM " . $tableName . " ORDER BY id";
	}
	else {
	$sql = "SELECT * FROM " . $tableName . " WHERE category = $categorysql ORDER BY id";
	}
	
// these  variables are used in the javascript code - used  to give unique  names to functions/div  etc
	      
    $txtquoterotator  = "quoterotator" . $shortcodecnt;
    $txtquoterotate = "quoterotate" . $shortcodecnt;
    $txtquoterotatefunc = "quoteRotate" . $shortcodecnt;
    $txtquotearea = "quotearea" . $shortcodecnt;
    $txtquotesinit  = "quotesInit" . $shortcodecnt;
		
    $results = $wpdb->get_results($sql);
    
    $stylesdir = 'wp-content/plugins/flexible-quote-rotator-plus/styles/';
 	
    if (file_exists(ABSPATH . $stylesdir . $cssfile))
      echo "<link rel=\"stylesheet\" href=\"" . get_option('siteurl') . '/' . $stylesdir . "default.css" ."\" type=\"text/css\" media=\"screen\" />";
     
     echo "<script type='text/javascript'>
     $txtquoterotator = {
       i: 1,
	quotes: [";
      	$i=0;
     	foreach($results as $result){
       	echo "\"$openquote<span id='quote'>$result->quote</span>$closequote";
      	if($result->author != '')
  	echo " <span id='quoteauthor'>$result->author</span>";
	echo "\",\n";
	$i++;
	}
	echo "
	 ],
	 numQuotes: ".$i.",
	 fadeDuration: ".$fade.",
	 fadeoutDuration: ".$fadeout.",
	 delay: ".$delay.",
	 random:".$randomq.",
		
	 $txtquotesinit: function(){
	 if (this.numQuotes < 1){
	   document.getElementById('$txtquoterotator').innerHTML=\"No Quotes Found\";
	 } else {
             this. $txtquoterotate();
	     setInterval('$txtquoterotator.$txtquoterotate()', (this.fadeDuration + this.fadeoutDuration + this.delay) * 1000);
	   }
	 },
	$txtquoterotate: function(){
	  jQuery('#$txtquoterotator').hide().html(this.quotes[this.i - 1]).fadeIn(this.fadeDuration * 1000).css('filter','').delay(this.delay * 1000).fadeOut(this.fadeoutDuration * 1000);
          if (this.random == 'No') {
             this.i = this.i % (this.numQuotes) + 1;
          }  else  {
              this.i = this.i  + 1;
              this.i = Math.floor((Math.random() * this.numQuotes) + 1);
             }
        }
       }
      </script>";
    return $quoteRotator->getQuoteCode($title, $delay, $fade, $fadeout, $randomq, $height, $unit, $fontsize, $textcolor, $width);
 }
 
add_shortcode('QuoteRotatorPlus', 'quoteRotator_func');
   
  // commented out this function on 6/18 - doesn't   seem  to  be used 
// function quoteRotator($title=null, $delay=null, $fadeDuration=null, $fadeoutDuration=null,$random=null,$height=null,$unit=null,$fontsize=null,$textcolor=null,$width=null) {
//       echo "does this  ever  happen?";
//       global $quoteRotator;
//       echo $quoteRotator->getQuoteCode($title, $delay, $fadeDuration, $fadeoutDuration, $random, $height, $unit, $fontsize, $textcolor, $width);
//   }
   
	add_action('activate_flexible-quote-rotator-plus/flexi-quote-rotator-plus.php', array(&$quoteRotator, 'createDatabaseTable'));
	add_action('deactivate_flexible-quote-rotator-plus/flexi-quote-rotator-plus.php', array(&$quoteRotator, 'deleteDatabaseTable'));
	add_action('init', 'includejquery');
  	add_action('init', 'process_post');
 //  	add_action('wp_head', array(&$quoteRotator, 'addHeaderContent'));  removed - no need to add  to every page loaded  site sl:
	add_action('admin_menu', 'managementInit');
	add_action('plugins_loaded', 'widgetInit');
}

endif;
?>