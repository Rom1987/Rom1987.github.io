<?
while( $object = mysqli_fetch_object($result_select) ){ ?>
<div class="post-item">
	<div class="post-item-wrap">
		<a href="PC.php?page=<?= $object->ID ?>">
			<img class='block_pc_img' src="<?= $object->IMG ?>">
			<div class="post-info">
				<div class="post-meta">
					<div class="post-date"> <?= $object->Price ?> руб</div>
					<div class="post-cat"> <?= $object->Category ?> </div>
				</div> <!-- end post-meta -->
				<h4 class="post-title"> <?= $object->PC_name ?> </h4>
			</div> <!-- end post-info -->
		</a>
	</div> <!-- end post-item-wrap -->
</div> <!-- end post-item -->

<? } ?>