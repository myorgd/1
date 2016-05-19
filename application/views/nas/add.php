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
								echo form_open('nas/add', 'role="form" id="myform"').'<fieldset>';
								echo form_dropdown_new('tst', $this->tst->get_tst_id_select(), set_value('tst'));
								echo form_input_new('nasname', 'имя оборудования', 'text', false, false, set_value('nasname'));
								echo form_close();
								echo form_submit('myform', 'Вход', 'class="btn btn-lg btn-success btn-block"');
							?>
						</fieldset>
						</form>
						</div>
					</div>
				</div>
