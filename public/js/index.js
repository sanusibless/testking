  $(document).ajaxSend(function() {
    let sample = document.querySelector('.samples');
    console.log(sample)
    $("#overlay-index").fadeIn(1000);
  });

const categoryLinks = Array.from(document.querySelectorAll(".category-link"));
console.log('im');
console.log(categoryLinks);

categoryLinks.forEach( categoryLink => {
	categoryLink.addEventListener('click', (event) => {

		event.preventDefault();
		let url = event.target.href;
		let search = new URL(url);

		$.ajax({
			url: `../src/subcategories.php?category=${search.searchParams.get('category')}`,
			success: (resp) => {
		       	let data = JSON.parse(resp);
		       	data = data.map( datum => {
		   			return `<div class="samples-card">
 								<div class="samples-card-body">
									<span class="samples-card-head">Free</span>
									<p class="samples-card-text">Free ${datum.subject} Practice Test</p>
									<a class="samples-card-link" href="./quiz-details.php?category=${search.searchParams.get('category')}&subject=${datum.subject}">Take Quiz</a>
								</div>
								<div class="samples-card-footer">
									<p>Free Test</p>
								</div>
							</div>`
		       	})
		       	$(".samples").html(data.join(''))
		       },
		    error: (error) => {
			      $("#overlay-index").fadeOut(300);
		       	  alert("There was an error when trying to load.\nEnsure you are connected to the internet");
		        }
   		    }).done(function() {
			      setTimeout(function(){
			      $("#overlay-index").fadeOut(2000);
		          },200);
	           });
		})
	})

function createEle(tag, content = '', attributes = {}) {
	    let el = document.createElement(tag);
	    el.textContent = content;
	    for (const [key, value] of Object.entries(attributes)) {
	        el.setAttribute(key, value);
	    }
	    return el
 	};

// '<div class="samples-card">
// 				<div class="samples-card-body">
// 					<span class="samples-card-head">Free</span>
// 					<p class="samples-card-text">Free NESTLE FLOWER GATE Practice Aptitude Test</p>
// 					<a class="samples-card-link" href="./quiz-details.php">Take Quiz</a>
// 				</div>
// 				<div class="samples-card-footer">
// 					<p>Free Test</p>
// 				</div>
// 			</div>'