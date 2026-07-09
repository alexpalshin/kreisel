<?php
if (isset($args)):

$contacts = $args['section'];
?>

<div class="component-container component-container-bg bg-gray">
	<!-- default -->
	<div class="container content-container">
		<header>
			<h2 class=""><?php echo $contacts['title']; ?></h2>
		</header>
		<section class="columns-3-col-wrap columns-grid-3">
			<div class="grid">
				<div class="row">
					<?php
					$contact_blocks = $contacts['column'];
					$i = 1;
					if (is_array($contact_blocks)) foreach ($contact_blocks as $block):
					?>
					<div class="col-md-4">
						<div class="ce-textpic ce-center ce-above">
							<?php
							$contact_details = $block['contact_details'];
							if (is_array($contact_details)) foreach ($contact_details as $contact_detail):
								?>
								<div class="ce-bodytext">
									<div class="p">
										<?php if (!empty($contact_detail['dept_name'])): ?>
											<strong><?php echo $contact_detail['dept_name'] ?></strong><br>
										<?php endif; ?>
										<?php if (!empty($contact_detail['name'])): ?>
											<?php echo $contact_detail['name'] ?><br>
										<?php endif; ?>
										<?php if (!empty($contact_detail['phone_number'])): ?>
											<a href="tel:<?php echo $contact_detail['phone_number'] ?>"><?php echo $contact_detail['phone'] ?></a><br>
										<?php endif; ?>
										<?php if (!empty($contact_detail['phone_2_number'])): ?>
											<a href="tel:<?php echo $contact_detail['phone_2_number'] ?>"><?php echo $contact_detail['phone_2'] ?></a><br>
										<?php endif; ?>
										<a href="mailto:<?php echo $contact_detail['email'] ?>"><?php echo $contact_detail['email'] ?></a>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	</div>
</div>

<?php  if (!empty($contacts['office_hours']['text'])): ?>
<div class="component-container">
	<div class="container content-container">
		<?php if (!empty($contacts['office_hours']['title'])): ?>
			<header>
				<h2 class=""><?php echo $contacts['office_hours']['title']; ?></h2>
			</header>
		<?php endif; ?>
		<div>
			<?php echo $contacts['office_hours']['text']; ?>
		</div>
	</div>
</div>
<?php endif; ?>


<?php  if (!empty($contacts['map_code']['code'])): ?>
	<div class="component-container">
		<div class="container content-container">
		<?php if (!empty($contacts['map_code']['title'])): ?>
			<header>
				<h2 class=""><?php echo $contacts['map_code']['title']; ?></h2>
			</header>
		<?php endif; ?>
			<div>
				<?php echo $contacts['map_code']['code']; ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php endif; ?>
