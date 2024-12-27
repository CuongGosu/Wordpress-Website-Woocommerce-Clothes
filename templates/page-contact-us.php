<?php
//Template name: Contact us
get_header(); ?>

<?php theBreadcrumb() ?>

	<div class="container">
		<div class="row">
			<div class="col-md-9">
                <?php theGoogleMap('contact_map', 'ban_do_cong_ty', 500) ?>
				<div class="row mt-3">
					<div class="col-md-6">
                        <?php echo apply_filters('the_content', getOption('noi_dung_lien_he')) ?>
					</div>
					<div class="col-md-6">
						<form action="/wp-admin/admin-ajax.php" id="contact_form" class="form-contact">
							<input type="hidden" id="contact_danger" name="contact_danger" value="<?php _e('Thành công', 'nrglobal') ?>">
		                    <input type="hidden" id="contact_waring" name="contact_waring" value="<?php _e('Thất bại', 'nrglobal') ?>">
		                    <input type="hidden" id="contact_success" name="contact_success" value="<?php _e('Bạn đã gửi liên hệ thành công. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất. Xin cảm ơn !', 'nrglobal') ?>">
		                	<input type="hidden" id="contact_error" name="contact_error" value="<?php _e('Gửi tin nhắn không thành công, xin vui lòng thử lại !', 'nrglobal') ?>">
							<div class="form-group">
								<label for=""><?php echo __('Tên', 'nrglobal') ?> <span>*</span></label>
								<input type="text" placeholder="" class="form-control" name="name" required>
							</div>
							<div class="form-group">
								<label for=""><?php echo __('Email', 'nrglobal') ?> <span>*</span></label>
								<input type="text" placeholder="" class="form-control" name="email" required>
							</div>
							<div class="form-group">
								<label for=""><?php echo __('Điện thoại', 'nrglobal') ?> <span>*</span></label>
								<input type="text" placeholder="" class="form-control" name="phone_number" required>
							</div>
							<div class="form-group">
								<label for=""><?php echo __('Chủ đề', 'nrglobal') ?> <span>*</span></label>
								<input type="text" placeholder="" class="form-control" name="subject" required>
							</div>
							<div class="form-group">
								<label for=""><?php echo __('Nội dung', 'nrglobal') ?> <span>*</span></label>
								<textarea name="message" class="form-control" rows="3" required style="resize: none;"></textarea>
							</div>
							<div class="verify">
								<div class="read-more ">
                                    <?php wp_nonce_field('send_contact_form', '_token') ?>
									<button type="submit" class="btn btn-primary form-control">Gửi <i class="fa fa-send"></i></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-3">
                <?php get_sidebar() ?>
			</div>
		</div>
	</div>

<?php get_footer() ?>