<?php
    $options = get_option( 'AS_Auth_Session' );
    $options = json_decode( $options, true );
    $pages = $options['as_options']['restrict_pages'];
?>

<div class="AS_admin_restrict_page_list">
    <ul>
        <?php foreach ( $pages as $val => $page ): ?>
            <li class="p_<?= $val ?> l_page" id="<?= $page ?>"><?= $page ?></li>
        <?php endforeach; ?>
    </ul>
</div>

<script type="text/javascript">
    var page_delete = "";
    
    jQuery(".AS_admin_restrict_page_list ul li").each(function( i ) {
        i = i + 1;
        jQuery(".AS_admin_restrict_page_list ul li:nth-child(" + i + ")").on("click", function() {
            jQuery(".AS_admin_restrict_page_list ul li").css("background-color", "transparent").css("color", "#000");
            jQuery(".AS_admin_restrict_page_list ul li:nth-child(" + i + ")").css("background-color", "blue").css("color", "#fff");
            
            page_delete = jQuery(".AS_admin_restrict_page_list ul li:nth-child(" + i + ")").attr("id");
        });
    });
</script>