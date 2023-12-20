$(function () {
    const titleInput = document.getElementById('title');
    const charCountTitle = document.getElementById('charCountTitle');

    const descriptionInput = document.getElementById('description');
    const charCountDescription = document.getElementById('charCountDescription');

    titleInput.addEventListener('input', updateCharacterCount.bind(null, titleInput, charCountTitle, 200));
    descriptionInput.addEventListener('input', updateCharacterCount.bind(null, descriptionInput,
        charCountDescription, 200));

    function updateCharacterCount(input, charCountElement, maxCount) {
        input.value = input.value.slice(0, maxCount);
        const currentCount = input.value.length;
        charCountElement.textContent = `${currentCount}/${maxCount}`;
    }
});
