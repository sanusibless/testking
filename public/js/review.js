
var current = 0;
var quiz = [];
document.addEventListener("DOMContentLoaded",(event) => {
	console.log(window.location)
	let url = new URL(window.location);
	let queryParams = url.searchParams;
	$.ajax({
		url: `../api/review.php?batch=${queryParams.get('batch')}`,
		success: (resp) => {
			console.log(resp)
			window.quiz = JSON.parse(resp).quiz;
			let info = JSON.parse(resp).info;
			reviewQuiz(window.quiz[window.current]);
			$("#score").text(`${info.score}/${info.total}`)
		},
		error: (error) => {
			console.log(error);
		}
	})

 	var api = {
 		'WN' : "https://questions.aloc.com.ng/api/v2/q-by-id/",
 		'UJ' : "https://questions.aloc.com.ng/api/v2/q-by-id/",
 	}

	let nextButton = document.querySelector("#next");
	let prevButton = document.querySelector("#prev");
	let finishButton = document.querySelector("#finish");

	nextButton.addEventListener("click", (event) => {
		event.preventDefault();


		if( window.current + 1 <= window.quiz.length - 1 ) {

			reviewQuiz(window.quiz[++window.current]);
			if(window.current == window.quiz.length - 1) {
				nextButton.style.display = 'none';
			}
		} 
	}, false );

	prevButton.addEventListener('click',(event) => {
		event.preventDefault();
		reviewQuiz(window.quiz[--window.current]);
		if(window.current < window.quiz.length - 1) {
			nextButton.style.display = 'block';
		}
	}, false);

	function reviewQuiz(question) {
		$.ajax({
			url: `https://questions.aloc.com.ng/api/v2/q-by-id/${question.question_id}?subject=${question.subject.toLowerCase()}`,
			headers: {
		         'Accept': 'application/json',
		         'Content-Type': 'application/json',
		         'AccessToken': 'ALOC-e5b1ec126e60f54669cf'
		    },
		    success: (resp) => {
		    	let { data } = resp;
		    	console.log(data);
		    	data.userAnswer = question.userAnswer;
		    	displayQuestion(data)
		    },
		    error: (error) => {
		    	setTimeout(()=> {
					$("#overlay").fadeOut(100);　
				}, 200)
		    	alert(error)
		    }
		}).done(function() {
			      setTimeout(function(){
			      $("#overlay").fadeOut(300);
		          },500);
	           });
	}

	function displayQuestion(quiz) {

		$("#question-sec").text("")

		if(window.current == 0) {
			prevButton.style.display = 'none';
			nextButton.style.display = 'block';
		} else {
			prevButton.style.display = 'block';
		}

		let quesDiv = createEle('div');
		let form = createEle('form','', {
			id: 'question',
			method: 'POST'
		});
		let quesPara = createEle('p', `${1 + window.current}. ${quiz.question}`);
		quesDiv.appendChild(quesPara);

		let options = quiz.option;

		
		for( const [option] in options) {
			if(options[option] == null) {
				continue;
			}
			let div = createEle('div','',{
				id: 'option-div' + option,
				class: 'options'
			});
			let label = createEle('label',`(${option}) ${options[option]}`,{
			'for': 'option-' + option 
			});

			let input = createEle('input','', {
				type: 'radio',
				id: 'option-' + option,
				name: "answer",
				value: option
			});

			if(option == quiz.userAnswer) {
				input.checked = true;
				quiz.answer == quiz.userAnswer ? div.classList.add('correct') : div.classList.add('wrong');
			}
			if(option == quiz.answer) {
				div.classList.add("correct")
			}
			div.appendChild(input)
			div.appendChild(label);

			form.appendChild(div);
		};

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

		let remarkP = createEle('p','',{
				class: quiz.answer !== quiz.userAnswer ? 'wrong-remark' : 'correct-remark',
			})
		let content = quiz.answer !== quiz.userAnswer ? `You are wrong. The correct answer is ${quiz.option[quiz.answer]}` : `You are correct, the answer is ${quiz.option[quiz.answer]}`;
		remarkP.textContent = content;

		form.appendChild(remarkP);

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

 	function displayPrev() {
		if(window.current == 0) {
			prevButton.style.display = 'none';
		} else {
			prevButton.style.display = 'block';
		}
	}

});