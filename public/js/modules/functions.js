 function startQuiz(quiz) {
		nextButton.style.display = 'block';

		let minutes = localStorage.getItem('minutes') ?? window.duration
		let secs = localStorage.getItem('secs') ?? 60;
		
		timer(minutes,secs);

		let start = document.querySelector("#start");
		start.style.display = 'none';

		displayQuestion(window.quiz[window.current]);
	}

	function displayQuestion(quiz) {
		console.log(quiz);
		$("#question-sec").text("")

		if(window.current == 0) {
			prevButton.style.display = 'none';
			nextButton.style.display = 'block';
			finishButton.style.display = 'none';
		} else {
			prevButton.style.display = 'block';
		}

		let quesDiv = createEle('div');
		let form = createEle('form','', {
			id: 'question',
			method: 'POST'
		});
		let quesPara = createEle('p', quiz.question);
		quesDiv.appendChild(quesPara);

		let options = randomiseOption([quiz.answer, ...quiz.options]);

		
		options.forEach( (option,index) => {

			let div = createEle('div','',{
				id: 'option-' + index
			});
			let label = createEle('label',option,{
			'for': 'option-' + index 
			});

			let input = createEle('input','', {
				type: 'radio',
				id: 'option-' + index,
				name: "answer",
				value: option
			});

			if(option == quiz.userAnswer) {
				input.checked = true;
			}
			label.prepend(input);
			div.appendChild(label);
			form.appendChild(div);

		});

		let qInput = createEle('input','', {
				type: 'hidden',
				name: "question",
				value: quiz.id
			});
		let aInput = createEle('input','', {
				type: 'hidden',
				name: "quiz-answer",
				value: quiz.answer
			});
		form.appendChild(qInput);
		form.appendChild(aInput);

		quesDiv.appendChild(form);
		$("#question-sec").append(quesDiv);
	}

	function createEle(tag, content = '', attributes = {}) {
	    let el = document.createElement(tag);
	    el.textContent = content;
	    for (const [key, value] of Object.entries(attributes)) {
	        el.setAttribute(key, value);
	    }
	    return el
 	};

 	function randomiseOption(options) {
 		let sortedOption = [];
 		let str = ''
 			while( sortedOption.length < options.length ) {
 				let index = Math.floor((Math.random() * options.length));
 				if(str.includes(index)) {
 					continue;
 				} else {
 					sortedOption.push(options[index]);
 					str += index
 				}
 			}
 		return sortedOption;
 	}

 	function processResult() {

		let secQuiz = document.getElementById('question-sec');

		let div = secQuiz.childNodes[0];
		let form = div.querySelector('#question');

		let formData = new FormData();

		formData.append('question', form.querySelector("input[name=question]").value);
		formData.append('user_answer', Array.from(form.querySelectorAll("input[name=answer]")).find( answer => answer.checked).value);
		formData.append('answer', form.querySelector("input[name=quiz-answer]").value);

		window.quiz.forEach(q => {
			if(q.id == parseInt(formData.get('question'))) {
				q.userAnswer = formData.get('user_answer')
			}
		});

	}

	function submit() {
		$.ajax({
			url: '../questions/process_result.php',
			method: "POST",
			data: {
				quiz: window.quiz
			},
			success: (resp) => {
				let response = JSON.parse(resp);
				if(response.complete) {
					window.location.replace("../pages/result.php");
				}
			},
			error: (error) => {
				console.log("Error",error.responseText);
			}
		})
	}

 function displayPrev() {
		if(window.current == 0) {
			prevButton.style.display = 'none';
		} else {
			prevButton.style.display = 'block';
		}
	}