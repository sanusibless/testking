   // import { v4 as uuidv4 } from 'https://jspm.dev/uuid';

   $(document).ajaxSend(function() {
    $("#overlay").fadeIn(300);　
  });
	const timer = (minutes,secs) => {
 		let time = setInterval(() => {

 			--secs;
 			if(secs == 0 & minutes > 0) {
 				secs = 59;
 				localStorage.setItem('minutes', --minutes);
 			}

 			localStorage.setItem('secs', secs);

 			let minSpan = document.querySelector('#min');
 			let secsSpan = document.querySelector('#secs');

 			let mins = localStorage.getItem('minutes') ?? minutes;
 			let sec = localStorage.getItem('secs') ?? secs;

 			minSpan.textContent = mins < 10 ? '0'+ mins : mins;
 			secsSpan.textContent = sec < 10 ? '0' + secs : secs;

 			if(minutes < 2) {
 				minSpan.style.color = 'red';
 				secsSpan.style.color = 'red'
 			}
 			if(minutes == 0 & secs == 0) {
 				clearInterval(time);
 				localStorage.clear();
 				console.log('y');
 				processResult();
				submit();
 			}
 		},1000)
 	};


 	var current = 0;
 	var quiz = [];

 	var api = {
 		'WN' : "https://questions.aloc.com.ng/api/v2/m?examtype=wassce&subject=",
 		'UJ' : "https://questions.aloc.com.ng/api/v2/m?examtype=jamb&subject=",
 	}

	let start = document.querySelector("#start");

	var duration = 0;

	let nextButton = document.querySelector("#next");
	let prevButton = document.querySelector("#prev");
	let finishButton = document.querySelector("#finish");


	start.onclick = (event) => {

		event.preventDefault();

		let startBtn = start.querySelector("#link");

		startBtn.onclick = (event) => {
			event.preventDefault();

			let url = new URL(window.location);

			const { searchParams } = url;

			let subject = searchParams.get('subject');
			let category = searchParams.get('category');
			let mode = searchParams.get('mode');
			let uniqueId = Math.floor(Math.random() * 10000) + new Date().getTime();

			console.log(uniqueId);

			$.ajax({
				url: api[category]+subject,
		       	headers: {
		         'Accept': 'application/json',
		         'Content-Type': 'application/json',
		         'AccessToken': 'ALOC-e5b1ec126e60f54669cf'
		       },
		       beforeSend: () => console.log("Going"),
		       success: (resp) => {

		       		window.quiz = resp.data;
		       		window.quiz.forEach( q => {
			       		q.userAnswer = null;
			       		q.subject = subject;
			       		q.category = category;
			       		q.batch = uniqueId;
			       		q.mode = mode;
		       		});
		       		startQuiz(window.quiz);
		       },
		       error: (error) => {
			      $("#overlay").fadeOut(300);
		       	  alert("There was an error when trying to load question.\nEnsure you are connected to the internet");
		        }
   		      }).done(function() {
			      setTimeout(function(){
			      $("#overlay").fadeOut(300);
		          },500);
	           });
		}

	  }

	nextButton.addEventListener("click", (event) => {
		event.preventDefault();

		processResult();

		if( window.current + 1 <= window.quiz.length - 1 ) {

			displayQuestion(window.quiz[++window.current]);
			if(window.current == window.quiz.length - 1) {
				nextButton.style.display = 'none';
				finish.style.display = "block";
			}
		} 
	}, false );

	finishButton.addEventListener('click',(event) => {
		event.preventDefault();
		setTimeout(function(){
	      $("#overlay").fadeOut(300);
          },500);
		processResult();
		submit();
	}, false);

	prevButton.addEventListener('click',(event) => {
		event.preventDefault();
		displayQuestion(window.quiz[--window.current]);
	}, false);





 function startQuiz(quiz) {
		nextButton.style.display = 'block';

		let url = new URL(window.location);


		if(url.searchParams.get('mode') == 'exam') {

		let minutes = localStorage.getItem('minutes') ?? 1
		let secs = localStorage.getItem('secs') ?? 59;
		
		timer(minutes,secs);
		}
		let start = document.querySelector("#start");
		start.style.display = 'none';

		displayQuestion(window.quiz[window.current]);
	}

	function displayQuestion(quiz) {
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
		let quesPara = createEle('p', `${1 + window.current}. ${quiz.question}`);
		quesDiv.appendChild(quesPara);

		let options = quiz.option;

		
		for( const [option] in options) {

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
		let answer = Array.from(form.querySelectorAll("input[name=answer]")).find( answer => answer.checked);
		console.log(answer)
		formData.append('question', form.querySelector("input[name=question]").value);
		formData.append('user_answer', answer == undefined ? "f" : answer.value);
		formData.append('answer', form.querySelector("input[name=quiz-answer]").value);

		window.quiz.forEach(q => {
			if(q.id == parseInt(formData.get('question'))) {
				q.userAnswer = formData.get('user_answer')
			}
		});

	}

	function submit() {
		$.ajax({
			url: '../api/process_result.php',
			method: "POST",
			data: {
				quiz: window.quiz
			},
			success: (resp) => {
				let response = JSON.parse(resp);
				if(response.complete) {
					window.location.replace(`../pages/result.php?subject=${window.quiz[0].subject}&category=${window.quiz[0].category}&batch=${window.quiz[0].batch}`);
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