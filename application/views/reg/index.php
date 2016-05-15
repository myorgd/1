<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<?PHP echo $this->msg->show(); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<?PHP
							echo form_open('reg', 'role="form" id="myform"').'<fieldset>';
							echo form_input_new('email', 'E-mail', 'email', false, false, '', 'autofocus');
							echo form_input_new('phone', 'Номер телефона', 'text', false, false);
							echo form_dropdown_new('rules', $this->users->get_rules_id_select(), 'Клиент');
							echo form_input_new('captcha', 'Код', 'text', false, $image);
							echo form_close();
							echo form_submit('myform', 'Регистрация', 'class="btn btn-lg btn-success btn-block"');
							?>
						</fieldset>
						</form>
						</div>
					</div>
				</div>
