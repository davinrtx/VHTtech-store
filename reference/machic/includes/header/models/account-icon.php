<?php $headeraccounticon  = get_theme_mod('machic_header_account','0'); ?>
<?php if($headeraccounticon){ ?>
<div class="header-addons login-button">
	<a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>">
		<div class="header-addons-icon"><i class="klbth-icon-user-1"></i></div>
		<div class="header-addons-text">
			<?php if(is_user_logged_in()){ ?>
				<?php $current_user = wp_get_current_user(); ?>
				<div class="sub-text"><?php esc_html_e('Welcome','machic'); ?></div>
				<div class="primary-text"><?php echo esc_html($current_user->user_login); ?></div>
			<?php } else { ?>
				<div class="sub-text"><?php esc_html_e('Sign In','machic'); ?></div>
				<div class="primary-text"><?php esc_html_e('Account','machic'); ?></div>
			<?php } ?>
		</div><!-- header-addons-text -->
	</a>
</div><!-- header-addons -->
<?php } ?>