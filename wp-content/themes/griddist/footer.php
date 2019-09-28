			<footer id="site-footer">

				<?php if ( is_active_sidebar( 'footer-one' ) || is_active_sidebar( 'footer-two' ) || is_active_sidebar( 'footer-three' ) ) : ?>

				<div class="footer-widgets-outer-wrapper section-inner">

					<div class="footer-widgets-wrapper">

						<div class="footer-widgets">
							<?php dynamic_sidebar( 'footer-one' ); ?>
						</div>

						<div class="footer-widgets">
							<?php dynamic_sidebar( 'footer-two' ); ?>
						</div>

						<div class="footer-widgets">
							<?php dynamic_sidebar( 'footer-three' ); ?>
						</div>

					</div><!-- .footer-widgets-wrapper -->

				</div><!-- .footer-widgets-outer-wrapper.section-inner -->

			<?php endif; ?>
			<div class="site-info">
			&copy;<?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>
			<!-- Delete below lines to remove copyright from footer -->
			<span class="footer-info-right">
				<?php echo __(' | Theme: Griddist by', 'griddist') ?> <a href="<?php echo esc_url('https://superbthemes.com/', 'griddist'); ?>"><?php echo __(' Superb', 'griddist') ?></a>
			</span>
			<!-- Delete above lines to remove copyright from footer -->

	</div>
</footer><!-- #site-footer -->

<?php wp_footer(); ?>

</div><!-- #site-wrapper -->

</body>
</html>
