<?php
if (isset($args)):

$facts = $args['section'];

$columns = $facts['column'];
?>
<div class="component-container bg-darkgray facts-component-container">
	<div id="facts" class="scroll-anchor"></div>
	<div class="container">
		<div class="facts" >
			<div class="row">
				<?php if (is_array($columns)) foreach ($columns as $column): ?>
				<div class="col fact-section">
					<div class="fact-title"><?php echo $column['number'] ?></div>
					<div class="fact-text"><?php echo $column['description'] ?></div>
					<hr>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>