import "./bootstrap";
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

// 引用我們新的日曆模組
import "./calendar";