document.addEventListener('DOMContentLoaded', function() {
    // Get references to key elements
    const tagSelect = document.getElementById('tagSelect');
    const codeBlocksContainer = document.getElementById('code-blocks-container');
    const tagCodesInput = document.getElementById('tagCodesInput');
    const form = document.querySelector('.answer-form');
    
    // Track which tags have code blocks
    const tagBlocks = new Set(Array.from(codeBlocksContainer.querySelectorAll('.code-block')).map(b => b.dataset.tagId));

    // Add code block when a tag is selected
    tagSelect && tagSelect.addEventListener('change', function() {
        const selected = tagSelect.options[tagSelect.selectedIndex];
        const tagId = selected.value;
        if (tagId && !tagBlocks.has(tagId)) {
            // Add new code block for selected tag
            codeBlocksContainer.insertAdjacentHTML('beforeend',
                `<div class="code-block border rounded-lg p-4 mb-4" data-tag-id="${tagId}">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium text-gray-700">Code for ${selected.text}</label>
                        <button type="button" class="remove-block text-red-500 hover:text-red-700">Remove</button>
                    </div>
                    <textarea name="code_blocks[${tagId}]" rows="6" class="code-content w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7AE2CF] font-mono" placeholder="Add your code here..."></textarea>
                </div>`
            );
            tagBlocks.add(tagId);
            tagSelect.selectedIndex = 0;
        }
    });

    // Remove code block on button click
    codeBlocksContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-block')) {
            const block = e.target.closest('.code-block');
            tagBlocks.delete(block.dataset.tagId);
            block.remove();
        }
    });

    // Serial code blocks on form submit
    form && form.addEventListener('submit', function() {
        const tagCodes = {};
        codeBlocksContainer.querySelectorAll('.code-block').forEach(block => {
            tagCodes[block.dataset.tagId] = block.querySelector('.code-content').value;
        });
        tagCodesInput.value = JSON.stringify(tagCodes);
    });
});
