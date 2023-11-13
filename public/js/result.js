document.addEventListener("DOMContentLoaded", () => {
	let url = new URL(window.location);
	const { searchParams } = url;

	let subject = searchParams.get('subject');
	let category = searchParams.get('category');
	let batch = searchParams.get('batch');

	console.log(subject, category, batch);

	getResult(`../api/result.php?subject=${subject}&category=${category}&batch=${batch}`);

	function getResult($url) {
		fetch($url)
		.then(resp => resp.json())
		.then( data => displayResult(data))
		.catch(error => console.log(error))
	}

	function displayResult(result) {
		console.log(result)
		let score = Math.floor(((result.correct/result.total)*100));
		let scoreDOM = document.querySelector("#score");
		scoreDOM.textContent = score + '%';	

		let mode = document.getElementById('mode');
		let modeArr = result.mode.split("");
		modeArr[0] = modeArr[0].toUpperCase();

		let modeText = modeArr.join("");

		mode.innerHTML = modeText;

		let passingDom = document.querySelector("#passmark");
		passingDom.textContent = result.passmark + "%";

		let remark = document.querySelector("#remark");
		remark.textContent = score < result.passmark ? "Opps! You Failed" : "Congratulations you passed!" 
		remark.style.color = score < result.passmark ? "red" : "green"
	}	
})
