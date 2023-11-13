<?php 
	require_once('../src/functions.php');
	view('dashboard-header');
?>
	<div class="content">
		<div class="details">
			<div class="head">
				<h2>Performance Review</h2>
			</div>
			<div>
				<p>
					This is your test performance score board. You can see entire summary of all your previous practice sessions. Score sheets, questions review and more.
				</p>
				<div class="table-div">
					<table class="table">
						<thead>
							<tr>
								<th> S/N</th>
							<th>Test</th>
							<th>Batch ID</th>
							<td>Mode</td>
							<td>Category</td>
							<th>Action</th>
							</tr>
						</thead>
						<tbody id="result">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
	view('dashboard-footer'); 
?>
