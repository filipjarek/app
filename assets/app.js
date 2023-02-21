/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';
import 'tw-elements';

// dark Mode
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const checkbox = document.querySelector("#toggle");
const html = document.querySelector("html");

const toggleDarkMode = function() {
    checkbox.checked
    ? html.classList.add("dark")
    : html.classList.remove("dark");
    
}

toggleDarkMode();
checkbox.addEventListener("click", toggleDarkMode);