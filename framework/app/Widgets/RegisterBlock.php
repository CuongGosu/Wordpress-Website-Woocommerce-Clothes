<?php

namespace Gaumap\Widgets;

use Carbon_Fields\Widget;
use Carbon_Fields\Field;

class RegisterBlock extends Widget
{
    // Register widget function. Must have the same name as the class
    function __construct()
    {
        $this->setup('register_block', __('Register Email', 'gaumap'), __('Đăng ký email', 'nrglobal'), [
            Field::make('text', 'title_block', __('Tiêu đề', 'nrglobal')),
            Field::make('text', 'txt_btn_email', __('Text button email', 'nrglobal')),
        ]);
    }
    
    // Called when rendering the widget in the front-end
    function front_end($args, $instance)
    {
        
?>
    <div class="top-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8">
                    <div class="area_newsletter">
                        <div class="title_newsletter">
                            <h4><?php echo $instance['title_block'] ?></h4>
                        </div>
                        <div class="form_newsletter form_newsletter_customer">
                            <form accept-charset='UTF-8' action='/wp-admin/admin-ajax.php' class='contact-form'>
                                <div class="input-group">
                                    <input required="" type="email"  value="" placeholder="<?php _e('Enter your email', 'nrglobal') ?>" name="register_email">
                                    <?php wp_nonce_field('send_register_form', '_token') ?>
                                    <button type="submit" class="button dark"><?php echo ($instance['txt_btn_email'] != '') ? $instance['txt_btn_email'] : __('Subscribe', 'nrglobal') ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php

    }
}