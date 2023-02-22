var allH1s = document.querySelectorAll('h1')
var allH2s = document.querySelectorAll('h2')
var allH3s = document.querySelectorAll('h3')

console.log(allH1s)

for (let index = 0; index < allH1s.length; index++) {
    allH1s[index].classList.add('bg-info', 'p-2', 'text-center')
}

for (let index = 0; index < allH2s.length; index++) {
    allH2s[index].classList.add('bg-danger', 'p-2')
}

for (let index = 0; index < allH3s.length; index++) {
    allH3s[index].classList.add('bg-warning', 'p-2')
}