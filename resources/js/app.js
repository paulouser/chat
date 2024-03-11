require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;
console.log("hello");
alert("hello");
Alpine.start();


function showAlert(message) {
    alert(message);
    consoele.log(message);
}
