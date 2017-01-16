<form action="<?php echo esc_url( $this->self_url() ); ?>&action=update-sidebar" method="post" id="add-edit-sidebar">
	<?php wp_nonce_field( 'update-sidebar' ); ?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row" valign="top">
					<?php _e( 'Title', 'runway' ); ?>
					<p class="description required"><?php _e( 'Required', 'runway' ); ?></p>
				</th>
				<td>
					<input class="input-text " type="text" name="sidebar-title" id="sidebar-title"
					       value="<?php echo isset( $sidebar ) ? $sidebar['title'] : ''; ?>">
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top">
					Alias
					<p class="description required"><?php _e( 'Required', 'runway' ); ?></p>
				</th>
				<td>
					<input class="input-text " type="text" name="sidebar-alias"
					       id="sidebar-alias" <?php echo isset( $sidebar ) ? 'readonly="readonly"' : ''; ?>
					       value="<?php echo isset( $sidebar ) ? $sidebar['alias'] : ''; ?>">
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top">
					<?php _e( 'Description', 'runway' ); ?>
				</th>
				<td>
					<textarea class="input-textarea "
					          name="sidebar-description"><?php echo isset( $sidebar ) ? $sidebar['description'] : ''; ?>
					</textarea>
				</td>
			</tr>
		</tbody>
	</table>

	<input class="button-primary" id="submit-button" type="button" value="<?php _e( 'Save Settings', 'runway' ); ?>">

</form>
