<?php
/**
  Widget Class
 
  This class is reponsible for displaying and updating the widget(s) added via Appearance>Widgets. 
  The constructor also adds javascript to the header of the page that is used to display 
  the quotes.  
 
 
 */
class flexi_quote_plus_widget extends WP_Widget {
 
    /** constructor  */
    function flexi_quote_plus_widget() {
        parent::WP_Widget(false, $name = 'Flexi Quote Plus Widget');	
    }
 
    /** @see WP_Widget::widget -- get  form values and create javascript code */
    function widget($args, $instance) {	
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        $delay  	= $instance['delay'];
        $fade	  	= $instance['fade'];
        $fadeout 	= $instance['fadeout'];
        $fontsize  	= $instance['fontsize'];
        $fontunit  	= $instance['unit'];
        $height  	= $instance['height'];
        $width  	= $instance['width'];
        $textcolor  	= $instance['textcolor'];
        $random  	= $instance['random'];
        $title          = $instance['title'];
        $category       = $instance['category'];
        $openquote 	= $instance['openquote'];
        $closequote 	= $instance['closequote'];
        ?>
        
  <?php
   	global $wpdb;
  	
   	$widgetid = $args['widget_id'];
   	
   	//  the - caused  a  javacript  error
   	$widgetid = str_replace("-", "_", "$widgetid");
      	
    	$this->tableName = $wpdb->prefix . 'QuoteRotator_Plus';
 
     	
    	if ($delay <= 0) {
   	   $delay = 5;
   	}
   	
     	
    	if ($fade <= 0) {
   	   $fade = 2;
   	}
    	
   	if ($fadeout <= 0) {
   	   $fadeout = 2;
   	}
    	 	
    	if ($fadesize <= 0) {
   	   $fadesize = 2;
   	}
  	
   	if ($fontunit == "") {
   	   $fontunit = px;
   	}
    	
    	if ($height <= 0) {
   	   $height = 100;
   	}
    	
    	if ($width <= 0) {
   	   $width = 300;
   	}
     	
   	if ($textcolor == "") {
   	   $textcolor = "black";
   	}
     	
    	if ($random == "") {
   	   $random = "No";
   	}
   	
   	$randomq = "'"  .  $random   .   "'";

   	$openquote = get_option('fqr_openquote');
	
	if (!isset($openquote) || $openquote == "") {
            $openquote = "";
        } else {
           $openquote = "<span id='openquote' class='quotemark'>" . $openquote . '</span>';
         }
	  	$closequote = get_option('fqr_closequote');
	    	if (!isset($closequote) || $closequote == "") {
            $closequote = "";
         } else {
           $closequote = "<span id='closequote' class='quotemark'>" . $closequote . '</span>';
        }
        
       	$txtquoterotator  = "quoterotator" . $widgetid;
	$txtquoterotate = "quoterotate" . $widgetid;
	$txtquoterotatefunc = "quoteRotate" . $widgetid;
	$txtquotearea = "quotearea" . $widgetid;
	$txtquotesinit  = "quotesInit"  .  $widgetid;
	$txtcategory  = "quoteinit"  .  $widgetid;

        // build an  sql statement  to  get records
       
        $categorysql = "'"  . $category . "'";
 	
	if ($category == "")  { 
	$sql = "SELECT * FROM " . $this->tableName . " ORDER BY id";
	}
	else { 
	$sql = "SELECT * FROM " . $this->tableName . " WHERE category = $categorysql ORDER BY id";
	}
	
	$results = $wpdb->get_results($sql);

	$stylesdir = 'wp-content/plugins/flexible-quote-rotator-plus/styles/';

// wide-plain will  be the default ccs file
    	if ($cssfile == "") {
   	   $cssfile = "default.css";
    	}
   	
        if (file_exists(ABSPATH . $stylesdir . $cssfile))
	  echo "
	  <link rel=\"stylesheet\" href=\"" . get_option('siteurl') . '/' . $stylesdir . $cssfile ."\" type=\"text/css\" media=\"screen\" />";
	
   	echo "	<script type='text/javascript'>
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
		random: ".$randomq.",
		
				
		$txtquotesinit: function(){
			if (this.numQuotes < 1){
         			document.getElementById('$txtquoterotator').innerHTML=\"No Quotes Found\";
			} else {
				this.$txtquoterotatefunc(); 
				setInterval('$txtquoterotator.$txtquoterotatefunc()',(this.fadeDuration + this.fadeoutDuration + this.delay) * 1000);
						}
			},
			$txtquoterotatefunc:  function(){
			jQuery('#$txtquoterotator').hide().html(this.quotes[this.i - 1]).fadeIn(this.fadeDuration * 1000).css('filter','').delay(this.delay * 1000).fadeOut(this.fadeoutDuration * 1000);
				if (this.random == 'No') {
				    this.i = this.i % (this.numQuotes) + 1;
				//     document.write(5+5);
				} else  {
				  this.i = this.i  + 1;
				//  document.write(this.i);
			//	  if (this.i >  this.numQuotes) {this.i = 1;};
				  this.i = Math.floor((Math.random() * this.numQuotes) + 1);
				  }
			}
	
			}
			</script>";

       ?>
    
      
    
      <?php echo $before_widget; 
  
         $style = "";
         if ($fontsize != "") $style .= "font-size:".$fontsize.$fontunit.";";
         if ($height != "") $style .= "height:".$height."px".";";
         if ($width != "") $style .= "width:".$width."px".";";
         if ($textcolor != "") $style .= "color:".$textcolor.";";
         if ($style != "") $style = " style='".$style."'";
         
           
//	echo $before_widget . $before_title . $title . $after_title;
       echo $before_widget . $before_title;
	
     if ($textcolor != "") $titlestyle .= "color:".$textcolor.";";
     if ($width != "") $titlestyle .= "width:".$width."px".";";
     if ($titlestyle != "") $titlestyle = " style='".$titlestyle."'";  

     $h4widgetclass  = $widgetid;
       
     if (isset($title) && $title != "") {  
        echo "<"  . "h4"  . " "  . "class=" . '"'  . $h4widgetclass  . '"' .  $titlestyle.  ">" . $title . "</h4>";
  
	} else {
           $title_from_settings = get_option('fqr_title');
           if (isset($title_from_settings) && $title_from_settings != "") {
        	   echo "<"  . "h4"  . " "   .  "class=" . '"'  . $h4widgetclass  . '"' .  $titlestyle . ">" .  $title . "</h4>";
  
   	   }
        } 
        
     echo $after_title;
     echo  "<br/>";

     echo "<div id=\"$txtquotearea\"$style><div id=\"$txtquoterotator\">\n";
     echo "Loading Quotes...\n";
     echo "</div></div>\n";
     echo "<script type=\"text/javascript\">setTimeout(\"$txtquoterotator.$txtquotesinit()\", 2000)</script>\n";
     echo $after_widget; ?>
      <?php
 
  }  
    
    /** @see WP_Widget::update -- save data  from  widget form  */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		// $instance['message'] = strip_tags($new_instance['message']);
		$instance['delay'] = strip_tags($new_instance['delay']);
		$instance['fade'] = strip_tags($new_instance['fade']);
		$instance['fadeout'] = strip_tags($new_instance['fadeout']);
		$instance['fontsize'] = strip_tags($new_instance['fontsize']);
		$instance['fontunit'] = strip_tags($new_instance['fontunit']);
		$instance['height'] = strip_tags($new_instance['height']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['textcolor'] = strip_tags($new_instance['textcolor']);
		$instance['random'] = strip_tags($new_instance['random']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['openquote'] = strip_tags($new_instance['openquote']);
		$instance['closequote'] = strip_tags($new_instance['closequote']);
               return $instance;
    }
 
    /** @see WP_Widget::form -- display  widget  form */
    function form($instance) {	
 
        $title 		= esc_attr($instance['title']);
        $delay		= esc_attr($instance['delay']);
        $fade		= esc_attr($instance['fade']);
        $fadeout	= esc_attr($instance['fadeout']);
        $fontsize	= esc_attr($instance['fontsize']);
        $fontunit	= esc_attr($instance['fontunit']);
        $height 	= esc_attr($instance['height']);
        $width	 	= esc_attr($instance['width']);
        $textcolor 	= esc_attr($instance['textcolor']);
        $random 	= esc_attr($instance['random']);
        $category 	= esc_attr($instance['category']);
        $openquote 	= esc_attr($instance['openquote']);
        $closequote 	= esc_attr($instance['closequote']);
        
        ?>
          <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('delay'); ?>"><?php _e('Delay (Seconds):'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('delay'); ?>" name="<?php echo $this->get_field_name('delay'); ?>" type="text" value="<?php echo $delay; ?>" />
          <label for="<?php echo $this->get_field_id('fade'); ?>"><?php _e('Fade (Seconds):'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('fade'); ?>" name="<?php echo $this->get_field_name('fade'); ?>" type="text" value="<?php echo $fade; ?>" />
          <label for="<?php echo $this->get_field_id('fadeout'); ?>"><?php _e('Fade Out (Seconds):'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('fadeout'); ?>" name="<?php echo $this->get_field_name('fadeout'); ?>" type="text" value="<?php echo $fadeout; ?>" />
          <label for="<?php echo $this->get_field_id('fontsize'); ?>"><?php _e('Font Size:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('fontsize'); ?>" name="<?php echo $this->get_field_name('fontsize'); ?>" type="text" value="<?php echo $fontsize; ?>" />
          
          <label for="<?php echo $this->get_field_id('fontunit'); ?>">Font Unit: 
     	   <select class='widefat' id="<?php echo $this->get_field_id('fontunit'); ?>"
        	   name="<?php echo $this->get_field_name('fontunit'); ?>" type="text">
              <option value='px'<?php echo ($fontunit=='px')?'selected':''; ?>>
               px
              </option>
              <option value='em'<?php echo ($fontunit=='em')?'selected':''; ?>>
               em
              </option> 
              <option value='%'<?php echo ($fontunit=='%')?'selected':''; ?>>
               %
              </option> 
           </select>                
           </label>
           <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height:'); ?></label> 
           <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" />
           <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:'); ?></label> 
           <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" />
           <label for="<?php echo $this->get_field_id('textcolor'); ?>"><?php _e('Text Color:'); ?></label> 
           <input class="widefat" id="<?php echo $this->get_field_id('textcolor'); ?>" name="<?php echo $this->get_field_name('textcolor'); ?>" type="text" value="<?php echo $textcolor; ?>" />
           <label for="<?php echo $this->get_field_id('openquote'); ?>"><?php _e('Open Quote:'); ?></label> 
           <input class="widefat" id="<?php echo $this->get_field_id('openquote'); ?>" name="<?php echo $this->get_field_name('openquote'); ?>" type="text" value="<?php echo $openquote; ?>" />
           <label for="<?php echo $this->get_field_id('closequote'); ?>"><?php _e('Close Quote:'); ?></label> 
           <input class="widefat" id="<?php echo $this->get_field_id('closequote'); ?>" name="<?php echo $this->get_field_name('closequote'); ?>" type="text" value="<?php echo $closequote; ?>" />
           <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:'); ?></label> 
           <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo $category; ?>" />
           
           <label for="<?php echo $this->get_field_id('random'); ?>"><?php _e('Random:'); ?></label> <br/> 
     	   Yes <input class="widefat" type="radio" id="<?php echo $this->get_field_id('random'); ?>" name="<?php echo $this->get_field_name('random'); ?>" value="Yes"<?php if($random=="Yes") echo "checked";?> />&nbsp;&nbsp;&nbsp;
           No  <input class="widefat" type="radio" id="<?php echo $this->get_field_id('random'); ?>" name="<?php echo $this->get_field_name('random'); ?>" value="No"<?php if($random!="Yes") echo "checked";?> />  <br/> 
           
<!--          <label for="<?php echo $this->get_field_id('cssfile'); ?>"><?php _e('CSS File:'); ?></label> <br/>   -->
<!--          <select class='widefat' id="<?php echo $this->get_field_id('cssfile'); ?>"   -->
<!--        	   name="<?php echo $this->get_field_name('cssfile'); ?>" type="text">   -->
<!--             <option>none</option>  -->
         <?php
//            $style = get_option('fqr_stylesheet'); 
//            
//            $stylesdir	= ABSPATH . 'wp-content/plugins/flexible-quote-rotator-plus/styles/';
//            $allCSS = array();
//            $dir = opendir($stylesdir);
//            
//            while ( $dir && ($f = readdir($dir)) ) {
//            	if( eregi("\.css$",$f) && !eregi("calendar\.css$",$f) ){
//            		array_push($allCSS, $f);
//            	}
//            }
//            sort($allCSS);
//            foreach ( $allCSS as $f ) {
//            	if( $f==$style )
//            	    	echo '<option style="background:#fbd0d3" selected="selected" value="'.$f.'">'.$f.'</option>'."\n";
//            	else
//            			echo '<option value="'.$f.'">'.$f.'</option>';																		
//            }
       ?>
<!--         </select><br/>    -->
        </p>

        <?php
    }
 
} // end class flexi_quote_plus_widget
add_action('widgets_init', create_function('', 'return register_widget("flexi_quote_plus_widget");'));
?>