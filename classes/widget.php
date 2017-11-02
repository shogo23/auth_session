<?php

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class AS_Widget extends WP_Widget {
  
  public function __construct() {
    $opt = [
      'classname' => 'Auth_Session',
      'description' => 'No description for now.'
    ];

    parent::__construct( 'auth-session', 'Auth Session', $opt );
  }

  public function form( $instance ) {
    if ( $instance ) {
      $title = esc_attr( $instance['title'] );
    } else {
      $title = '';
    }
    ?>

    <label for="<?= $this->get_field_id( 'title' ) ?>" class="AS_Widget_title"><?= _e( 'Title:' ) ?></label>
    <input type="text" name="<?= $this->get_field_name( 'title' ) ?>" id="<?= $this->get_field_name( 'title' ) ?>" class="widefat widget_input_title AS_widget_title" value="<?= $title ?>" />
    <?php
  }

  public function widget( $args, $instance ) {
    extract( $args );

    $title = apply_filters( 'Widget_title', $instance['title'] );

    ob_start();
    echo $before_widget;

    if ( $title ) {
			echo $before_title . $title . $after_title;
		}

    require AS_PATH . 'includes/widget_content/widget_content.php';

    echo $after_widget;
    echo ob_get_clean();
  }



  public function update( $new_instance, $old_instance ) {
    //Get Old Intance.
		$instance = $old_instance;

		//Replace Title from the $instance if there is a new.
		$instance['title'] = strip_tags ($new_instance['title'] );

		return $instance;
  }
}
