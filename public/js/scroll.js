let div = document.querySelector('#loket')

let divHeight = div.offsetHeight
let contentScroll = div.scrollHeight
let endScroll = 0

window.setInterval(() => {
    if(endScroll == 0 || endScroll <= contentScroll){
        endScroll = endScroll + divHeight + 10
    }else{
        endScroll = 0
    }
    div.scroll(0, endScroll)
}, 10000);