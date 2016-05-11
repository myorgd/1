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
								echo form_open('wifi/access', 'role="form" id="myform"').'<fieldset>';
								echo form_input_new('email', 'E-mail', 'email', false, false, '', 'autofocus');
								echo form_input_new('password', 'Password', 'password', false, false);
								echo form_checkbox('remember', 'Remember Me');
								echo form_close();
								echo form_submit('myform', 'Вход', 'class="btn btn-lg btn-success btn-block"');
							?>
						</fieldset>
						</form>
						</div>
					</div>
				</div>
