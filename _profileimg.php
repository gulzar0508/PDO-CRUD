<div class="col-xl-4">
	<!-- Profile picture card-->
	<div class="card mb-4 mb-xl-0">
		<div class="card-header">Profile Picture</div>
		<div class="card-body text-center">
			<!-- Profile picture image-->
			<img class="img-account-profile rounded-circle mb-2" src="<?php echo $profile_pic; ?>" alt="user profile">
			<!-- Profile picture help block-->
			<!-- <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 2 MB</div> -->
			<!-- Profile picture upload button-->
			<?php
			if($_file_name=='editprofile.php')
			{
				?>
				<input type="file" name="file_pic" id="file_pic" value="" />
				<br/>
				<br/>
				<button class="btn btn-primary" type="submit">Save Changes</button>
				<button class="btn btn-danger" type="button" onclick="confirm_delete()">Remove Photo</button>
				<?php
			}
			?>
		</div>
	</div>
</div>