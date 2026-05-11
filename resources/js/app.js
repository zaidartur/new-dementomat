// import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Metronic Imports
import '../metronic/core/index.ts';
import '../metronic/app/layouts/demo1.js';

import Swal from 'sweetalert2';
// Optional: Make it global so you can use it in inline <script> tags
window.Swal = Swal;