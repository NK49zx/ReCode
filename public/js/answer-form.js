
// Initialize select2 with options and event handler
$('.select2').select2({
    theme: 'bootstrap-5',
    tags: true,
    placeholder: 'Add tags',
    allowClear: true,
    width: '100%'
}).on('change', function(e) {
    const selectedOption = $(this).find('option:selected');
    const tagId = selectedOption.val();
    const tagName = selectedOption.text();

    if (tagId) {
        addCodeBlock(tagId, tagName);
        $(this).val(null).trigger('change');
    }
});

function addCodeBlock(tagId, tagName) {
    const blockId = `code-block-${tagId}`;
    if (!document.getElementById(blockId)) {
        const blockHtml = `
            <div id="${blockId}" class="code-block border rounded-lg p-4 mb-4" data-tag-id="${tagId}">
                <div class="flex justify-between items-center mb-2">
                    <span class="badge badge-primary">${tagName}</span>
                    <button type="button" class="remove-block text-red-500 hover:text-red-700">Remove</button>
                </div>
                <textarea name="code_blocks[${tagId}]" rows="6" class="code-content w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7AE2CF] font-mono" placeholder="Add your code here..."></textarea>
            </div>
        `;
        document.getElementById('code-blocks-container').insertAdjacentHTML('beforeend', blockHtml);
    }
}

// Handle remove buttons using event delegation
document.getElementById('code-blocks-container').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-block')) {
        e.target.closest('.code-block').remove();
    }
});

// Handle form submission
document.querySelector('.answer-form').addEventListener('submit', function(e) {
    const tagCodes = {};
    document.querySelectorAll('.code-block').forEach(block => {
        const tagId = block.dataset.tagId;
        const code = block.querySelector('.code-content').value.trim();
        if (code) {
            tagCodes[tagId] = code;
        }
    });
    document.getElementById('tagCodesInput').value = JSON.stringify(tagCodes);
});
