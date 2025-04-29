import './bootstrap';
import Alpine from 'alpinejs';

// Initialize Select2
$(document).ready(function() {
    $('.select2').select2();
});

window.Alpine = Alpine;
Alpine.start();
