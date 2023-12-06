<?php
	require_once('../src/functions.php');
	view('dashboard-header');
	try {
		$pdo = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
		$stmt->bindValue(':id', $_SESSION['user']['id']);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

	} catch(PDOException $e) {
		$error = $e->getMessage();
	}
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
						<form class="form-section" id="updateForm" action="../api/update_user.php" method="POST">
							<div class="form-group">
								<label>First Name</label>
								<input type="text" name="first_name" value="<?=$user['first_name']?>">
							</div>
							<div class="form-group">
								<label>Last Name</label>
									<input type="text" name="last_name" value="<?=$user['last_name'] ?>">
							</div>
							<div class="form-group">
								<label>Email</label>
									<input type="email" name="email" value="<?=$user['email'] ?>" disabled />
							</div>
							<div class="form-group">
								<label>Password</label>
								<input class="password" type="password" name="password" value="<?=$user['password'] ?>">
								<?php if(isset($_SESSION['update']['error']['password'])): ?>
									<p> <?php echo $_SESSION['update']['error']['password'] ?? "" ?> </p>
								<?php endif; ?>
							</div>
							<div class="form-group">
								<label>Confirm Password</label>
								<input class="password" type="password" name="confirm_password" value="<?=$user['password'] ?>">
							</div>
							<div class="form-submit">
								<button>Save Changes</button>
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
