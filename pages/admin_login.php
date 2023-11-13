<?php require_once '../src/functions.php' ?>
<?php view('header',[
	'title' => "Student - Login"
]); ?>
	<section>
		<form method="POST" action="/auth/login.php">
			<input type="hidden" name="is_admin" value="true"> 
			<div>
				<label>Email
					<input type="email" name="email">
				</label>
			</div>
			<div>
				<label>Password
					<input type="password" name="email">
				</label>
			</div>
			<button>Sign in</button>
		</form>
	</section>
<?php view('footer'); ?>