let menu = document.querySelector('#menu-btn');
let header = document.querySelector('.header');

menu.onclick = () => {
    menu.classList.toggle('fa-times');
    header.classList.toggle('active');
};

window.onscroll = () => {
    menu.classList.remove('fa-times');
    header.classList.remove('active');
};

let themeToggler = document.querySelector('#theme-toggler');

themeToggler.onclick = () => {
    themeToggler.classList.toggle('fa-sun');
    document.body.classList.toggle('active');
};

// Display contact form submission response
let responseMessage = document.querySelector('.response-message');
if (responseMessage) {
    setTimeout(() => {
        responseMessage.style.display = 'none';
    }, 3000);
}
