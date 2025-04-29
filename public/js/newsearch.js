const searchInput = document.getElementById('search-input');
const searchDropdown = document.getElementById('search-dropdown');
const searchResultsContainer = document.getElementById('search-results');
let searchDebounceTimeout = null;

// Render the search results dropdown
function renderSearchResults(results) {
    searchResultsContainer.innerHTML = '';
    if (!results.length) {
        searchDropdown.style.display = 'none';
        return;
    }
    searchDropdown.style.display = 'block';
    results.forEach(result => {
        const a = document.createElement('a');
        a.href = `/question/${result.id}`;
        a.className = 'block p-3 hover:bg-gray-50 border-b border-gray-100';
        a.innerHTML = `
            <div class="font-medium text-gray-800">${result.title}</div>
            <div class="flex items-center gap-4 mt-1 text-sm text-gray-600">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>${result.views || 0}</span>
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <span>${result.answers || 0}</span>
                </span>
                <span class="flex flex-wrap gap-1">
                    ${(result.tags || []).map(tag => `<span class='px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs'>${tag}</span>`).join('')}
                </span>
            </div>`;
        a.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = `/question/${result.id}`;
        });
        searchResultsContainer.appendChild(a);
    });
}

// Fetch search results and call renderSearchResults
function searchQuestions(query) {
    if (query.length < 2) {
        renderSearchResults([]);
        return;
    }
    fetch(`/search?q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => renderSearchResults(data.data || []))
        .catch(() => renderSearchResults([]));
}

// Debounced input handler for search box
searchInput.addEventListener('input', function(e) {
    clearTimeout(searchDebounceTimeout);
    const value = e.target.value;
    searchDebounceTimeout = setTimeout(() => searchQuestions(value), 300);
});

// Hide dropdown when clicking outside
window.addEventListener('click', function(e) {
    if (!searchDropdown.contains(e.target) && e.target !== searchInput) {
        searchDropdown.style.display = 'none';
    }
});

// Hide dropdown on Escape key
searchInput.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        searchDropdown.style.display = 'none';
    }
});
