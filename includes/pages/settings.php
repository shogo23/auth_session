<div class="AS_admin_settings_container">
  <h1><?php _e( 'Restrict Pages' ) ?></h1>

  <div class="AS_admin_restrict_page_container">
      <div class="AS_admin_page_list">
          &nbsp;
      </div>
      <div class="AS_admin_restrict_page_btn_container">
          <ul>
              <li><input type="button" id="add" value="Add >>" /></li>
              <li><input type="button" id="remove" value="<< Remove" /></li>
          </ul>
      </div>
      <div class="AS_admin_restrict_page_r_page_container">
          &nbsp;
      </div>
      <div class="clear"></div>
  </div>

  <h1><?php _e( 'Login Redirect' ); ?></h1>
  <div class="AS_admin_login_redirect_container">
      <div class="AS_admin_login_redirect_page_list">
          &nbsp;
      </div>
      <div class="AS_admin_login_redirect_btn_container">
          <ul>
              <li><input type="button" id="login_set" value="Set >>" /></li>
              <li><input type="button" id="login_remove" value="<< Remove" /></li>
          </ul>
      </div>
      <div class="AS_admin_login_redirect_set_page">
          &nbsp;
      </div>
      <div class="clear"></div>
  </div>

  <h1><?php _e( 'Logout Redirect' ) ?></h1>
  <div class="AS_admin_logout_redirect_container">
      <div class="AS_admin_logout_redirect_page_list">
          &nbsp;
      </div>
      <div class="AS_admin_logout_redirect_btn_container">
          <ul>
              <li><input type="button" id="logout_set" value="Set >>" /></li>
              <li><input type="button" id="logout_remove" value="<< Remove" /></li>
          </ul>
      </div>
      <div class="AS_admin_logout_redirect_set_page">
          &nbsp;
      </div>
  </div>

  <div class="clear"></div>
</div>

<div class="AS_admin_settings_mobile_container">
  <h1><?php _e( 'Restricted Pages' ) ?></h1>
  <div class="AS_admin_page_list_mobile_select">
    <select class="AS_admin_page_list_mobile"></select>
    <div class="AS_admin_restrict_page_container_mobile"></div>
    <button class="mobile_add_restrict_page">+</button><button class="mobile_remove_restrict_page">-</button>
  </div>

  <h1><?php _e( 'Login Redirect' ) ?></h1>
  <div class="AS_admin_login_redirect_mobile_container">
    <div class="AS_admin_login_redirect_page_list_mobile_select">
      <select class="AS_admin_login_redirect_page_list_mobile"></select>
      <div class="AS_admin_login_page_current_mobile"></div>
      <button class="mobile_add_login_page">+</button><button class="mobile_remove_login_page">-</button>
    </div>
  </div>

  <h1><?php _e( 'Logout Redirect' ); ?></h1>
  <div class="AS_admin_logout_redirect_mobile_container">
    <div class="AS_admin_logout_redirect_page_list_mobile_select">
      <select class="AS_admin_logout_redirect_page_list_mobile"></select>
      <div class="AS_admin_logout_page_current_mobile"></div>
      <button class="mobile_add_logout_page">+</button><button class="mobile_remove_logout_page">-</button>
    </div>
  </div>
</div>

<div class="AS_admin_recaptcha_container">
  <h1><?php _e( 'Recaptcha' ); ?></h1>
  <div class="AS_admin_recaptcha_contents">
    <p><input type="checkbox" class="AS_recaptcha_enable" /> Enable recaptcha</p>
    <field>
      <label for="AS_recaptcha_site_key"><?php _e( 'Site Key:' ) ?></label>
      <input type="text" class="AS_recaptcha_site_key" />
      <label for="AS_recaptcha_secret_key"><?php _e( 'Secret Key:' ) ?></label>
      <input type="text" class="AS_recaptcha_secret_key" />
      <label for="AS_recaptcha_validation"><?php _e( 'Validation Message:' ); ?></label>
      <input type="text" class="AS_recaptcha_validation" />
    </field>
    <div><button class="button button-primary AS_recaptcha_save">Save</button><span class="AS_admin_recaptcha_saved">Saved!</span></div>
    <div class="AS_admin_recaptcha_link"><a target="_blank" href="https://www.google.com/recaptcha/">Learn more about Recaptcha</a></div>
  </div>
</div>


<script type="text/javascript">
    AS_load_page_list();
    AS_load_restrict_page_list();
    AS_load_login_redirect_page_list();
    AS_load_current_login_redirect_page();
    AS_load_logout_page_list();
    AS_load_current_logout_page_list();
    AS_recaptcha_enable();
    AS_load_recaptcha_vals();

    jQuery("#add").on("click", function() {
        var data = {
            "action": "AS_auth_session",
            "operation": "add_page_restrict",
            "page": page_selected
        };

        jQuery.post(ajaxurl, data, function(r) {
            if ( r == "ok" ) {
                AS_load_page_list();
                AS_load_restrict_page_list();
                AS_load_login_redirect_page_list();
                AS_load_current_login_redirect_page();
                AS_load_logout_page_list();
                AS_load_current_logout_page_list();
            }
        });
    });

    jQuery("#remove").on("click", function() {
        var data = {
          "action": "AS_auth_session",
          "operation": "remove_restrict_page",
          "page": page_delete
        };

        jQuery.post(ajaxurl, data, function( r ) {
            if ( r == "ok" ) {
              AS_load_page_list();
              AS_load_restrict_page_list();
              AS_load_login_redirect_page_list();
              AS_load_current_login_redirect_page();
              AS_load_logout_page_list();
              AS_load_current_logout_page_list();
            }
        });
    });

    jQuery(".AS_admin_page_list_mobile").on("change", function() {
      page_selected = jQuery(this).val();
    });

    jQuery(".mobile_add_restrict_page").on("click", function() {
      var data = {
        "action": "AS_auth_session",
        "operation": "add_page_restrict",
        "page": page_selected
      };

      jQuery.post(ajaxurl, data, function(r) {
        if ( r == "ok" ) {
          AS_load_page_list();
          AS_load_restrict_page_list();
          AS_load_login_redirect_page_list();
          AS_load_current_login_redirect_page();
          AS_load_logout_page_list();
          AS_load_current_logout_page_list();
        }
      });
    });

    jQuery(".mobile_remove_restrict_page").on("click", function() {
      var data = {
        "action": "AS_auth_session",
        "operation": "remove_restrict_page",
        "page": page_delete
      };

      jQuery.post(ajaxurl, data, function( r ) {
          if ( r == "ok" ) {
          AS_load_page_list();
          AS_load_restrict_page_list();
          AS_load_login_redirect_page_list();
          AS_load_current_login_redirect_page();
          AS_load_logout_page_list();
          AS_load_current_logout_page_list();
          }
      });
    });

    jQuery("#login_set").on("click", function() {
        var data = {
          "action": "AS_auth_session",
          "operation": "set_login_redirect",
          "page": page_login_selected
        }

        jQuery.post(ajaxurl, data, function( r ) {
            if ( r == "ok" ) {
              AS_load_page_list();
              AS_load_restrict_page_list();
              AS_load_login_redirect_page_list();
              AS_load_current_login_redirect_page();
              AS_load_logout_page_list();
              AS_load_current_logout_page_list();
            }
        });
    });

    jQuery("#login_remove, .mobile_remove_login_page").on("click", function() {
        var data = {
          "action": "AS_auth_session",
          "operation": "remove_login_page"
        };

        jQuery.post(ajaxurl, data, function( r ) {
            if ( r == "ok" ) {
              AS_load_page_list();
              AS_load_restrict_page_list();
              AS_load_login_redirect_page_list();
              AS_load_current_login_redirect_page();
              AS_load_logout_page_list();
              AS_load_current_logout_page_list();
            }
        });
    });

    jQuery(".AS_admin_login_redirect_page_list_mobile").on("change", function() {
      page_login_selected = jQuery(this).val();
    });

    jQuery(".mobile_add_login_page").on("click", function() {
      var data = {
        "action": "AS_auth_session",
        "operation": "set_login_redirect",
        "page": page_login_selected
      }

      jQuery.post(ajaxurl, data, function( r ) {
          if ( r == "ok" ) {
            AS_load_page_list();
            AS_load_restrict_page_list();
            AS_load_login_redirect_page_list();
            AS_load_current_login_redirect_page();
            AS_load_logout_page_list();
            AS_load_current_logout_page_list();
          }
      });
    });

    jQuery("#logout_set").on("click", function() {
      var data = {
        "action": "AS_auth_session",
        "operation": "set_logout_page",
        "page": page_logout
      };

      jQuery.post(ajaxurl, data, function( r ) {
        if ( r == "ok") {
          AS_load_page_list();
          AS_load_restrict_page_list();
          AS_load_login_redirect_page_list();
          AS_load_current_login_redirect_page();
          AS_load_logout_page_list();
          AS_load_current_logout_page_list();
        }
      })
    });

    jQuery(".AS_admin_logout_redirect_page_list_mobile").on("change", function() {
      page_logout = jQuery(this).val();
    });

    jQuery(".mobile_add_logout_page").on("click", function() {
      var data = {
        "action": "AS_auth_session",
        "operation": "set_logout_page",
        "page": page_logout
      };

      jQuery.post(ajaxurl, data, function( r ) {
        if ( r == "ok") {
          AS_load_page_list();
          AS_load_restrict_page_list();
          AS_load_login_redirect_page_list();
          AS_load_current_login_redirect_page();
          AS_load_logout_page_list();
          AS_load_current_logout_page_list();
        }
      })
    });

    jQuery("#logout_remove, .mobile_remove_logout_page").on("click", function() {
        var data = {
          "action": "AS_auth_session",
          "operation": "remove_logout_page"
        };

        jQuery.post(ajaxurl, data, function( r ) {
            if ( r == "ok" ) {
              AS_load_page_list();
              AS_load_restrict_page_list();
              AS_load_login_redirect_page_list();
              AS_load_current_login_redirect_page();
              AS_load_logout_page_list();
              AS_load_current_logout_page_list();
            }
        });
    });

    jQuery(".AS_recaptcha_enable").on("change", function() {
      if ( jQuery(this).is(":checked") ) {
        var enabled = 1;
      } else {
        var enabled = 0;
      }

      var data = {
        "action": "AS_auth_session",
        "operation": "recaptcha_switch",
        "enabled": enabled
      };

      jQuery.post(ajaxurl, data, function(r) {
        AS_recaptcha_enable();
      });
    });

    jQuery(".AS_recaptcha_save").on("click", function() {
      var site_key = jQuery(".AS_recaptcha_site_key").val();
      var secret_key = jQuery(".AS_recaptcha_secret_key").val();
      var validation = jQuery(".AS_recaptcha_validation").val();

      var data = {
        "action": "AS_auth_session",
        "operation": "recaptcha_save",
        "site_key": site_key,
        "secret_key": secret_key,
        "validation": validation
      };

      jQuery.post(ajaxurl, data, function(r) {
        jQuery(".AS_admin_recaptcha_saved").fadeIn(500, function() {
          setTimeout(function() {
            jQuery(".AS_admin_recaptcha_saved").fadeOut(500);
          }, 3000);

          console.log(r);
        });
      });
    });

    function AS_load_page_list() {
        var d1 = {
            "action": "AS_auth_session",
            "operation": "page_list"
        };

        var d1_m = {
          "action": "AS_auth_session",
          "operation": "page_list_mobile"
        }

        jQuery.post(ajaxurl, d1 ,function(r) { jQuery(".AS_admin_page_list").html( r ); });
        jQuery.post(ajaxurl, d1_m ,function(r1) { jQuery(".AS_admin_page_list_mobile").html( r1 ); });
    }

    function AS_load_restrict_page_list() {
        var d2 = {
          "action": "AS_auth_session",
          "operation": "restricted_page_list"
        };

      jQuery.post(ajaxurl, d2 ,function(r) { jQuery(".AS_admin_restrict_page_r_page_container, .AS_admin_restrict_page_container_mobile").html( r ); });
    }

    function AS_load_login_redirect_page_list() {
        var d1 = {
          "action": "AS_auth_session",
          "operation": "page_list_for_login_redirect"
        };

        var d1_1 = {
          "action": "AS_auth_session",
          "operation": "page_list_for_login_redirect_mobile"
        };

        jQuery.post(ajaxurl, d1, function(r) {
          jQuery(".AS_admin_login_redirect_page_list").html(r);
        });

        jQuery.post(ajaxurl, d1_1, function(r1) {
          jQuery(".AS_admin_login_redirect_page_list_mobile").html(r1);
        });
    }

    function AS_load_current_login_redirect_page() {
        var d2 = {
          "action": "AS_auth_session",
          "operation": "current_page_redirect"
        };

        jQuery.post(ajaxurl, d2, function(r) {
          jQuery(".AS_admin_login_redirect_set_page, .AS_admin_login_page_current_mobile").html( r );
        });
    }

    function AS_load_logout_page_list() {
        var d1 = {
          "action": "AS_auth_session",
          "operation": "page_list_for_logout_redirect"
        };

        var d1_1 = {
          "action": "AS_auth_session",
          "operation": "page_list_for_logout_redirect_mobile"
        };

        jQuery.post(ajaxurl, d1, function(r) {
          jQuery(".AS_admin_logout_redirect_page_list").html( r );
        });

        jQuery.post(ajaxurl, d1_1, function(r1) {
          jQuery(".AS_admin_logout_redirect_page_list_mobile").html( r1 );
        });
    }

    function AS_load_current_logout_page_list() {
        var d2 = {
          "action": "AS_auth_session",
          "operation": "current_logout_page"
        };

        jQuery.post(ajaxurl, d2, function(r) {
          jQuery(".AS_admin_logout_redirect_set_page, .AS_admin_logout_page_current_mobile").html( r );
        });
    }

    function AS_recaptcha_enable() {
      var data = {
        "action": "AS_auth_session",
        "operation": "recaptch_check_enable"
      };

      jQuery.post(ajaxurl, data, function(r) {
        if ( r == 1 ) {
          jQuery(".AS_recaptcha_enable").attr("checked", "checked");
          jQuery(".AS_recaptcha_site_key, .AS_recaptcha_secret_key, .AS_recaptcha_validation, .AS_recaptcha_save").removeAttr("disabled");
        } else {
          jQuery(".AS_recaptcha_enable").removeAttr("checked");
          jQuery(".AS_recaptcha_site_key, .AS_recaptcha_secret_key, .AS_recaptcha_validation, .AS_recaptcha_save").attr("disabled", "disabled");
        }
      });
    }

    function AS_load_recaptcha_vals() {
      var data = {
        "action": "AS_auth_session",
        "operation": "recaptcha_vals"
      };

      jQuery.post(ajaxurl, data, function(r) {
        var vals = r.split("||");

        jQuery(".AS_recaptcha_site_key").attr("value", vals[0]);
        jQuery(".AS_recaptcha_secret_key").attr("value", vals[1]);
        jQuery(".AS_recaptcha_validation").attr("value", vals[2]);
      });
    }
</script>
