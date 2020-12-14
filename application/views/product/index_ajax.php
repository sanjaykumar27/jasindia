
<div class="box-body">
	<div class="table-responsive">
		<table class="table no-margin">
			<thead>
				<tr>
					<th>ID#</th>
					<th>First Name</th>
					<th>Last Name</th>
					
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php if( ! empty($products)) { ?>
			<?php foreach($products as $product){ ?>
				<tr>
					<td width="40px"><?php echo $product->id ?></a></td>
					<td><?php echo $product->first_name ?></td>
					<td><?php echo $product->last_name  ?></td>
					
					
				</tr>
			<?php } ?>
			<?php } else { ?>
			<tr><td colspan="8" class="no-records">No records</td></tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<div class="box-footer">
	<ul class="pagination">
		<?php echo $pagelinks ?>
	</ul>
</div>