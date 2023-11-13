<?php 
	require_once('../src/functions.php');
	view('dashboard-header');
?>
	<div class="content">
		<div class="details">
			<div class="head">
				<h2>Manage Account</h2>
			</div>
			<div>
				<p>
					From here, you can manage your account details including login details
				</p>
				<div>
						<form class="form-section">
						<div class="form-group">
							<label>First Name</label>
							<input type="text" name="first_name">
						</div>
						<div class="form-group">
							<label>Last Name</label>
								<input type="text" name="last_name">
						</div>
						<div class="form-group">
							<label>Email</label>
								<input type="email" name="email">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password">
							<?php if(isset($_SESSION['error']['register']) && gettype($_SESSION['error']['register']) === 'array') {
								foreach ($_SESSION['error']['register'] as $value) { ?>
									<p> <?php echo "$value" ?> </p>
							<?php } } else { ?>
								<p> <?php echo $_SESSION['error']['register'] ?? "" ?> </p>
							<?php } ?>
						</div>
						<div class="form-group">
							<label>Confirm Password</label>
							<input type="password" name="confirm_password">
						</div>
						<div class="form-submit">
							<button>Create</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
	view('dashboard-footer'); 
?>
