document.addEventListener('DOMContentLoaded', function() {
    // Get references to toggle button, panel, and icon
    var filterBtn = document.getElementById('toggle-tags-btn');
    var tagsPanel = document.getElementById('tags-panel');
    var icon = document.getElementById('toggle-tags-icon');
    var show = false;

    // Add click event to toggle tag panel
    if (filterBtn && tagsPanel && icon) {
        filterBtn.addEventListener('click', function() {
            show = !show; // Toggle state
            tagsPanel.style.display = show ? 'flex' : 'none'; // Show/hide panel
            icon.className = 'fas fa-chevron-' + (show ? 'down' : 'right'); // Update icon
        });
    }
});
