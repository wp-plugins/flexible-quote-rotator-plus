<?php

/*
This class create the database tables when the plugin is initiated, and deletes the options when deactivated.  It also builds javascript code to display quotes (should be moved to the main program at some point, no need to be
located here anymore. 

*/

if( !class_exists('QuoteRotator') ) :

class QuoteRotator
{
	var $tableName;
	var $pluginPath;
	var $currentVersion;
	
	function QuoteRotator()
	{
		global $wpdb;
		$this->currentVersion = '0.1';
		$this->tableName = $wpdb->prefix . 'QuoteRotator_Plus';
		//   07/05/15 - changed  to new  style to  get plugin path
		//  $this->pluginPath = get_option('siteurl') . '/wp-content/plugins/flexible-quote-rotator-plus/';\
	        $this->pluginPath = plugin_dir_path( __FILE__ );
		$options = get_option('widgetQuoteRotator');
		$options['version'] = $this->currentVersion;
		update_option('widgetQuoteRotator', $options);
	}
	
	function createDatabaseTable()
	{
		global $wpdb;
		
		$options = array();
		$options['title'] = 'Quote Rotator Plus';
		$options['delay'] = 10;
		$options['fade'] = 2;
		$options['fontsize'] = 20;
		$options['fontunit'] = 'px';
		
		if( !get_option('widgetQuoteRotatorPlus') )
		{
			add_option('widgetQuoteRotatorPlus', $options);
		}
		
		if( $wpdb->get_var("SHOW TABLES LIKE `" . $this->tableName . "`") != $this->tableName)
		{
		$sql = "CREATE TABLE `" . $wpdb->prefix . "QuoteRotator_Plus` (`id` MEDIUMINT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY, `quote` TEXT NULL);";
		 //$sql = "CREATE TABLE `" . $this->tableName . "` (`id` MEDIUMINT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY, `quote` TEXT NULL);";
		
		  require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
		 dbDelta($sql);
		
		  $options['version'] = $this->currentVersion;
		}
		$sql = "ALTER TABLE `" . $this->tableName . "` ADD `author` VARCHAR(255) NOT NULL AFTER `quote`;";
		$wpdb->query($sql);

		$sql = "ALTER TABLE `" . $this->tableName . "` ADD `category` VARCHAR(255) NOT NULL AFTER `quote`;";
		$wpdb->query($sql);
		
		$sql = "RENAME TABLE `wp_QuoteRotator` TO `$this->tableName`;";
		$wpdb->query($sql);
		
		$sql = "ALTER TABLE `" . $this->tableName . "` CHANGE `quote` `quote` TEXT NULL;";
		$wpdb->query($sql);
		
		$sql = "ALTER TABLE `" . $this->tableName . "` CHANGE `category` `category` TEXT NULL;";
		$wpdb->query($sql);
		
		update_option('widgetQuoteRotator', $options);
		delete_option('widgetizeQuoteRotator');		
	}
	
	function deleteDatabaseTable()
	{       
		delete_option('widgetQuoteRotator');
		//global $wpdb;
		
		//$sql = "DROP TABLE IF EXISTS " . $this->tableName . ";";	
		//$wpdb->query($sql);
	}
	
   function getQuoteCode($title=null, $delay=null, $fadeDuration=null, $fadeoutDuration=null, $random=null, $height=null, $unit=null, $fontsize=null, $textcolor=null, $width=null)
	{
      $output =  "";
     global $shortcodecnt;
       
     $txtquoterotator = "quoterotator"  . $shortcodecnt;
     $txtquoteinit = "quotesInit"  . $shortcodecnt;
     
     $id = get_the_ID(); 
    
     $fqr_h4class = "class="  .  '"'  .   "title" . $id  . $shortcodecnt  . '"';
     
     if ($height > 0) $style .= "height:".$height."px;";
     if ($unit != "" and $fontsize > 0) $style .= "font-size:".$fontsize.$unit.";";
     if ($textcolor != "") $style .= "color:".$textcolor.";";
     if ($width > 0) $style .= "width:".$width."px;";
     if ($style != "") $style = " style='".$style."'";
     
     if ($textcolor != "") $titlestyle .= "color:".$textcolor.";";
     if ($titlestyle != "") $titlestyle = " style='".$titlestyle."'";
      
     if (isset($title) && $title != "") {
        $output .=  "<h4 " . $fqr_h4class  . " " . $titlestyle. ">" . $title . "</h2>";
	} else {
           $title_from_settings = get_option('fqr_title');
           if (isset($title_from_settings) && $title_from_settings != "") {
        	  $output .=  "<h4  "  . $fqr_h4class .  " "  .  $titlestyle. ">" . $title_from_settings . "</h2>";
   	   }
        } 
     
    $temp = "<div id="  . "'" . "quotearea"  .  "_"  . $id  . "_"  .  $shortcodecnt . "'"; 
    $quoteareastyle = $style . ">" . '<div id=' .  '"' . $txtquoterotator . '"' . ">" . "\n";
    $output .= $temp  . $quoteareastyle;
  //   $output .= "<div id=\"quotearea\"$style><div id=\"$txtquoterotator\">\n";
     $output .= "Loading Quotes...\n";
     $output .= "</div></div>\n";
     $output .= "<script type=\"text/javascript\">";
	 
      if (isset($delay) && $delay != "") {
   		$output .=  "$txtquoterotator.delay=".$delay.";";
		}
		
      if (isset($fadeDuration) && $fadeDuration != "") {
   		$output .=  "$txtquoterotator.fadeDuration=".$fadeDuration.";";
		}
		
      if (isset($fadeoutDuration) && $fadeoutDuration != "") {
   		$output .=  "$txtquoterotator.fadeoutDuration=".$fadeoutDuration.";";
		}

      if (isset($random) && $random != "") {
    	 $output .=  "$txtquoterotator.random=".$random.";";
		}		
      $output .= "$txtquoterotator" . "." . "$txtquoteinit" . "()" . "</script>\n";
		return $output;
	}
}

endif;
?>