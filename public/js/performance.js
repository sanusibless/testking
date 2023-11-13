document.addEventListener("DOMContentLoaded", (event) => {
	$.ajax({
		url: '../api/records.php',
		success: (resp) => {
			let data = JSON.parse(resp);
			console.log(data)
			let dataHTML = data.map( (datum,index) => {
				return `<tr>
							<td>
							${++index}
							</td>
							<td>
							${datum.subject}
							</td>
							<td>
							${datum.batch}
							</td>
							<td>
							${datum.mode}
							</td>
							<td>
							${datum.categoryName}
							</td>
							<td>
							<a href="review.php?subject=${datum.subject.toLowerCase()}&batch=${datum.batch}&mode=${datum.mode}&categoryName=${datum.categoryName}&categoryCode=${datum.categoryCode}">
								review
							</a>
							<form action="../api/delete.php">
								<input type="hidden" name="batch" value="${datum.batch}" />
								<button>
									delete
								</button
							</form>
							</td>
						</tr>`
			})

			$('#result').html(dataHTML);
		},
		error : () => {
			console.log(error);
		}
	})
})