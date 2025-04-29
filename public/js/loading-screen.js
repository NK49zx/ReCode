document.addEventListener('DOMContentLoaded', function() {
    const loadingOverlay = document.getElementById('loading-overlay');
    
    // Function to show loading overlay
    function showLoading() {
        loadingOverlay.classList.remove('hidden');
    }
    
    // Function to hide loading overlay
    function hideLoading() {
        loadingOverlay.classList.add('hidden');
    }
    
    // Handle link clicks
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        
        if (link) {
            // No loading for external links, forms and data-no-loading att.
            if (link.target === '_blank' || 
                link.href.includes('#') || 
                link.closest('form') || 
                link.hasAttribute('data-no-loading')) {
                return;
            }
            
            showLoading();
        }
    });
    
    // Handle form submissions
    document.addEventListener('submit', function(e) {
        if (!e.target.hasAttribute('data-no-loading')) {
            showLoading();
        }
    });
    
    // Handle page load
    window.addEventListener('load', function() {
        hideLoading();
    });
    
    // Handle page unload
    window.addEventListener('beforeunload', function() {
        showLoading();
    });
    
    
    // Handle browser back/forward navigation
    window.addEventListener('pageshow', function(event) {
        // If the page was loaded from the cache
        if (event.persisted) {
            hideLoading();
        }
    });
}); 