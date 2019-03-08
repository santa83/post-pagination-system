<?php


if (array_key_exists('pps_button_color_submit',$_POST)) {
    update_option('background_color', $_POST['background_color'] );
    update_option('text_color', $_POST['text_color'] );

    ?>
    <div id="setting-error_settings-updated" class="updated settings-error notice is-dismissible">
    <strong>Colori aggiornati</strong>
    </div>
    <?php
}

$backgroundColor = get_option('background_color', 'none');
$textColor = get_option('text_color', 'none');

    

?>
 
  <div class="pps_admin_area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Post Pagination System</h1>
                <form action="" method="post">
                <h3>Colore dello sfondo</h3>
                <input class="color-field" type="text" name="background_color" style="background: <?php esc_attr_e($backgroundColor); ?>" value="<?php esc_attr_e($backgroundColor); ?>"/>
                <h3>Colore del testo</h3>
                <input class="color-field" type="text" name="text_color" style="color: <?php esc_attr_e($textColor); ?>" value="<?php esc_attr_e($textColor); ?>"/>
                <input type="submit" name="pps_button_color_submit" value="Aggiorna i colori" class="button button-primary">
                </form>
            </div>
        </div>
    </div>
