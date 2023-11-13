let form = document.querySelector(".form-section form");
let inputs = Array.from(form.querySelectorAll("input"));
let error = form.querySelector('.error');

inputs.forEach(input => {
	input.addEventListener("focus", (event) => {
		error.style.display = 'none';
	})
})
console.log('in');