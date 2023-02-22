var allTagsH1 = document.querySelectorAll('h1')
var allTagsH2 = document.querySelectorAll('h2')
var menu = document.getElementById('menu')

/*
for (let i = 0; i < allTagsH1.length; i++) {
    menu.innerHTML += `<li class="list-group-item mb-2">${[i+1]} . ${allTagsH1[i].innerHTML}</li>`;
}
*/

for (let i = 0; i < allTagsH1.length; i++) {
    menu.innerHTML += `<li class="list-group-item mb-2">${[i+1]} . ${allTagsH1[i].innerHTML}</li>`;
	
	for (var j = i; j < allTagsH2.length + i; j++) {
		
		menu.innerHTML += `
		<ul>
			<li class="list-group-item bg-info">${[j-i]} .${allTagsH2[j-i].innerHTML}</li>
		</ul>`;
		
	}
}