<?php
  use Shogo\Auth_Session\Classes\Actions;

  $action = new Actions();
  echo $action->as_option();
?>

<?php if ( !$_GET['edit'] ): ?>
  <div class="create_auth_container">
      <h1><?php _e( 'Add Authentication Session' ) ?></h1>
      <div class="form">
        <p>
          <label for="auth_name"><?php _e( 'Authentication Name:' ) ?></label>
          <input type="text" id="auth_name" />
        </p>
        <p>
          <label for="generate_auth_code"><?php _e( 'Generate Authication Code:' ) ?></label>
          <input type="number" id="auth_str_len" value="6" /><br />
          <input type="button" id="generate" value="Generate Auth Code" />
        </p>
        <p>
          <label for="auth_code"><?php _e( 'Authication Code:' ) ?></label>
          <input type="text" id="auth_code" />
        </p>
        <p>
          <label for="start_time"><?php _e( 'Start Date:' ) ?></label>
          <input type="text" id="start_time" />
        </p>
        <p>
          <label for="end_time"><?php _e( 'End Date:' ) ?></label>
          <input type="text" id="end_time" />
        </p>
        <p>
          <input type="button" class="button button-primary" id="submit" value="Create Session" />
          <img alt="loader" src="/wp-content/plugins/auth_session/img/ajax-loader.gif" />
        </p>
      </div>
  </div>

  <script type="text/javascript">
      jQuery( function() {
          jQuery("#start_time, #end_time").datepicker();
      } );

      jQuery("#generate").on("click", function() {
          var auth_str_len = jQuery("#auth_str_len").val();
          var auth_code = jQuery("#auth_code");

          auth_str_len = parseInt( auth_str_len );

          if ( auth_str_len <= 5 ) {
              alert( "Auth Code Length is too short." );
          } else {
              var text = "";
              var random = "abcdefghijklmnopqrstuvwxyz0123456789";

              for ( var i = 0; i < auth_str_len; i++ ) {
                  text += random.charAt(Math.floor(Math.random() *  random.length));
              }

              auth_code.attr( "value", text );
          }
      });

      jQuery("#submit").on("click", function() {
          var auth_name = jQuery("#auth_name").val();
          var auth_code = jQuery("#auth_code").val();
          var start_time = jQuery("#start_time").val();
          var end_time = jQuery("#end_time").val();

          if ( auth_name == "" || auth_name.length <= 2 ) {
              alert( "Authentication Name is too short." );
          } else if ( auth_code == "" || auth_code.length <= 5 ) {
              alert( "Authentication Code is too short." );
          } else if ( start_time == "" ) {
              alert( "Please set a session start time." );
          } else if ( end_time == '' ) {
              alert( "Please set a session end time." );
          } else if ( start_time == end_time ) {
            alert( "Plase select different dates." );
          } else {
              var data = {
                  "action": "AS_auth_session",
                  "operation": "add_auth_session",
                  "session_name": auth_name,
                  "session_auth": auth_code,
                  "start_time": start_time,
                  "end_time": end_time
              };

              jQuery(".create_auth_container img").show();

              jQuery.post( ajaxurl, data, function(r) {
                  if ( r == "ok" ) {
                    location = "/wp-admin/admin.php?page=as_main_page";
                  }
              });
          }
      });
  </script>
<?php else: ?>
  <?php $id = (int)$_GET['edit']; ?>
  <?php if ( $id ): ?>
    <?php
      $action = new Actions();
      $sessions = $action->get_session( $id );
      $session_name = '';
      $session_auth = '';
      $start_date = '';
      $end_date = '';

      foreach ( $sessions as $session ) {
        $session_name .= $session->session_name;
        $session_auth .= $session->session_auth;
        $start_date .= $session->start_date;
        $end_date .= $session->end_date;
      }
    ?>

    <div class="create_auth_container">
        <h1><?php _e( 'Edit Authentication Session' ) ?></h1>
        <div class="form">
            <p>
                <label for="auth_name"><?php _e( 'Authentication Name:' ) ?></label>
                <input type="text" id="auth_name" value="<?= $session_name ?>" />
            </p>
            <p>
                <label for="generate_auth_code"><?php _e( 'Generate Authication Code:' ) ?></label>
                <input type="number" id="auth_str_len" value="6" /><br />
                <input type="button" id="generate" value="Generate Auth Code" />
            </p>
            <p>
                <label for="auth_code"><?php _e( 'Authication Code:' ) ?></label>
                <input type="text" id="auth_code" value="<?= $session_auth ?>" />
            </p>
            <p>
                <label for="start_time"><?php _e( 'Start Date:' ) ?></label>
                <input type="text" id="start_time" value="<?= $action->datetimeToStr( $start_date ) ?>" />
            </p>
            <p>
                <label for="end_time"><?php _e( 'End Date:' ) ?></label>
                <input type="text" id="end_time" value="<?= $action->datetimeToStr( $end_date ) ?>" />
            </p>
            <p>
                <input type="button" class="button button-primary" id="submit" value="Save Session" />
                <img alt="loader" src="/wp-content/plugins/auth_session/img/ajax-loader.gif" />
            </p>
        </div>
    </div>

    <script type="text/javascript">
    jQuery( function() {
        jQuery("#start_time, #end_time").datepicker();
    } );

    jQuery("#generate").on("click", function() {
        var auth_str_len = jQuery("#auth_str_len").val();
        var auth_code = jQuery("#auth_code");

        auth_str_len = parseInt( auth_str_len );

        if ( auth_str_len <= 5 ) {
            alert( "Auth Code Length is too short." );
        } else {
            var text = "";
            var random = "abcdefghijklmnopqrstuvwxyz0123456789";

            for ( var i = 0; i < auth_str_len; i++ ) {
                text += random.charAt(Math.floor(Math.random() *  random.length));
            }

            auth_code.attr( "value", text );
        }
    });

      jQuery("#submit").on("click", function() {
          var auth_name = jQuery("#auth_name").val();
          var auth_code = jQuery("#auth_code").val();
          var start_time = jQuery("#start_time").val();
          var end_time = jQuery("#end_time").val();

          if ( auth_name == "" || auth_name.length <= 2 ) {
              alert( "Authentication Name is too short." );
          } else if ( auth_code == "" || auth_code.length <= 5 ) {
              alert( "Authentication Code is too short." );
          } else if ( start_time == "" ) {
              alert( "Please set a session start time." );
          } else if ( end_time == '' ) {
              alert( "Please set a session end time." );
          } else if ( start_time == end_time ) {
            alert( "Plase select different dates." );
          } else {
              var data = {
                  "action": "AS_auth_session",
                  "operation": "edit_auth_session",
                  "id": <?= $id ?>,
                  "session_name": auth_name,
                  "session_auth": auth_code,
                  "start_time": start_time,
                  "end_time": end_time
              };

              jQuery(".create_auth_container img").show();

              jQuery.post( ajaxurl, data, function(r) {
                  if ( r == "ok" ) {
                    location = "/wp-admin/admin.php?page=as_main_page";
                  }
              });
          }
      });
    </script>

  <?php endif; ?>
<?php endif; ?>
