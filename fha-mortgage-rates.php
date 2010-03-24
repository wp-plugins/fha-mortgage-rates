<?php
/*
Plugin Name: FHA Mortgage Rates Widget
Plugin URI: http://www.freerateupdate.com/mortgage-rate-widget
Description: This plugin lets you embed a <a href="http://www.freerateupdate.com/mortgage-rate-widget"> FHA mortgage rates widget</a> onto your WordPress weblog. Free mortgage rate widget includes 30 year fixed Conforming, FHA and Jumbo mortgage rates. It's updated daily by <a href="http://www.freerateupdate.com/">FreeRateUpdate.com</a> who researches wholesale lender's rate sheets. The color is customizable to match your blog. 
Author: Mortgage Rates
Version: 1.6
Author URI: http://www.freerateupdate.com/
*/

function fha_mort_print_scripts() {
	wp_enqueue_script('jquery');
}

add_action('wp_print_scripts', 'fha_mort_print_scripts');

class FHAMortgageRateWidget extends WP_Widget {
    function FHAMortgageRateWidget() {
        parent::WP_Widget(false, 'FHA Mortgage Rates Widget');	
    }
    function widget($args, $instance) {
    	global $wp_query;
    	global $wpdb;
    	$upcoming_contests = get_posts(array(
    	    'meta_key' => '_contest_status',
    	    'meta_value' => 'pending'
    	));
    	
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $bgcolor = urlencode($instance['bgcolor']);
        $align = $instance['align'];
        ?>
              <?php echo $before_widget; ?>
              <div style=" padding:0; width: 180px;heigth: 135px;" id="fha_container">
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
<style type="text/css">#frufoot {font-family: arial,verdana,sans-serif;font-size: 10px; background:  none; color: #999999; width: 175px;text-align: center; line-height: 1.35em; style="padding: 0px;"}
#frufoot a { text-decoration: none; margin: 0; padding: 0;}
</style><!--[If IE]>
<iframe src="http://www.freerateupdate.com/widget/fha-mortgage-rates.php?bgcolor=<?php echo $bgcolor; ?>" height="102" width="175" frameborder="0" scrolling="no"></iframe>
<![endif]-->
<!--[if !IE]>--><iframe src="http://www.freerateupdate.com/widget/fha-mortgage-rates.php?bgcolor=<?php echo $bgcolor; ?>"  width="180" height="107"  frameborder="0" scrolling="no" class="free-mortgage-rate" style="margin-left: auto; margin-right: auto;"></iframe>
<!--<![endif]--><div id="frufoot">By <a href="http://www.freerateupdate.com/" >FHA Mortgage Rates</a> @ FRU.<br />
Get this <a href="http://www.freerateupdate.com/mortgage-rate-widget" > Mortgage Rate Widget</a>.</div>
<script type="text/javascript">
jQuery(function() {
	var align = "<?php echo $align; ?>";
	var $ = jQuery;
    if (jQuery.browser.opera) {
        jQuery(".free-mortgage-rate").height(110);
    }
    
    var $widgetContainer = $("#fha_container");
    //alert($widgetContainer.length);
    var $widgetLi = $widgetContainer.parent();
    var margin = ($widgetLi.width() - $widgetContainer.width());
    var marginLeft = 0;
    var marginRight  = 0;
    if ("left" == align) {
    	marginLeft = "0px";
    	marginRight = margin + "px";
    }
    else if ("right" == align) {
    	marginLeft = margin + "px";
    	marginRight = "0px";
    }
    else if ("center" == align) {
    	marginLeft = parseInt((margin / 2)) + "px";
    	marginRight = marginLeft;
    }
    
   
    $widgetContainer.css({"marginLeft": marginLeft, "marginRight": marginRight});
    $widgetLi.css({"paddingLeft": "0px", "paddingRight": "0px"});
    
    if (("left" == align) || ("right" == align)) {
    	$widgetContainer.css("float", align);
    }
    

   
});

</script>     
              </div>      
              <?php echo $after_widget; ?>
        <?php

    }
    
    
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'bgcolor' => '#669900'));
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['bgcolor'] = $new_instance['bgcolor'];
		$instance['align'] = $new_instance['align'];


		return $instance;
	}    
    
    
    function form($instance) {
        $title = esc_attr($instance['title']);
        $bgcolor = esc_attr($instance['bgcolor']);
        $align = $instance['align'];
        
        $aligns = array(
            'left' => 'Left',
            'center' => 'Center',
            'right' => 'Right'
        );
        
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?><br /> <input  id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            
 
            <p><label for="<?php echo $this->get_field_id('bgcolor'); ?>"><?php _e('Header background color:'); ?> <input  id="<?php echo $this->get_field_id('bgcolor'); ?>" name="<?php echo $this->get_field_name('bgcolor'); ?>" type="text" value="<?php echo $bgcolor; ?>" /></label></p>       
            <p class="description">For example, #FF0000</p>  
            
            <p>
              <label for="<?php echo $this->get_field_id('align'); ?>">Widget alignment:</label><br />
              <select name="<?php echo $this->get_field_name('align'); ?>" id="<?php echo $this->get_field_id('bgcolor'); ?>">
                <?php foreach ($aligns as $val => $text): ?>
                <option value="<?php echo $val; ?>" <?php selected($val, $align); ?>><?php echo $text; ?></option>
                <?php endforeach; ?>
              </select>
            </p> 
             
        <?php 

    }
}

add_action('widgets_init', create_function('', 'return register_widget("FHAMortgageRateWidget");'));
?>
