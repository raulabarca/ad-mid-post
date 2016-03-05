<div class="wrap">
<h2>Ad Shortcode</h2>

<form method="post" action="wordpress/wp-content/plugins/adshortcode/options.php">
<?php wp_nonce_field('update-options'); ?>
<?php settings_fields('adshortcode'); ?>

<table class="form-table">

<tr valign="top">
<th scope="row">Insert your ad code:</th>
<td><textarea rows="4" cols="50" form="web_ad_code"><?php echo get_option('adcode'); ?> </textarea></td>
</tr>

</tr>

</table>

<input type="hidden" name="action" value="update" />

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>
