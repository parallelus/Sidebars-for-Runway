<form action="<?php echo esc_url($this->self_url()); ?>&action=update-sidebar" method="post" id="add-edit-sidebar">
	<table class="form-table">
		<tbody>
			<tr class="">
				<th scope="row" valign="top">
					<?php _e('Title', 'runway') ?>
					<p class="description required"><?php _e('Required', 'runway') ?></p>
				</th>
				<td>
					<input class="input-text " type="text" name="sidebar-title" id="sidebar-title" value="<?php echo isset($sidebar) ? $sidebar['title'] : ''; ?>">
				</td>
			</tr>
			<tr class="">
				<th scope="row" valign="top">
					Alias
					<p class="description required"><?php _e('Required', 'runway') ?></p>
				</th>
				<td>
					<input class="input-text " type="text" name="sidebar-alias" id="sidebar-alias" <?php echo isset($sidebar) ? 'readonly="readonly"' : ''; ?> value="<?php echo isset($sidebar) ? $sidebar['alias'] : ''; ?>">
				</td>
			</tr>
			<tr class="">
				<th scope="row" valign="top">
					<?php _e('Description', 'runway') ?>
				</th>
				<td>
					<textarea class="input-textarea " name="sidebar-description"><?php echo isset($sidebar) ? $sidebar['description'] : ''; ?></textarea>
				</td>
			</tr>
		</tbody>
	</table>
	<input class="button-primary" id="submit-button" type="button" value="<?php echo __('Save Settings', 'runway'); ?>">
</form>
<!-- Form validation -->
<script type="text/javascript">
	(function($){

		$('#submit-button').click(function(e){
			var sidebarTitle = $('#sidebar-title').val().trim();
			var sidebarAlias = $('#sidebar-alias').val().trim();
			if(sidebarTitle == ''){
				$('#sidebar-title').css('border-color', 'Red');
			}

			if(sidebarAlias == ''){
				$('#sidebar-alias').css('border-color', 'Red');
			}

			if(sidebarTitle != '' && sidebarAlias != ''){
				$('#add-edit-sidebar').submit();
			}
		});

	})(jQuery);
</script>