document.addEventListener('DOMContentLoaded', function() {
    const keyframesContainer = document.getElementById('keyframesContainer');
    const addKeyframeBtn = document.getElementById('addKeyframeBtn');
    const generateBtn = document.getElementById('generateBtn');
    const cssOutput = document.getElementById('cssOutput');

    // Add keyframe block
    addKeyframeBtn.addEventListener('click', function() {
        const keyframeBlock = document.createElement('div');
        keyframeBlock.classList.add('keyframeBlock', 'flex', 'space-x-4', 'mb-2');

        keyframeBlock.innerHTML = `
            <input type="number" class="keyframe w-1/4 p-2 border border-gray-300 rounded" placeholder="Keyframe (%)">
            <input type="text" class="propertyName w-1/4 p-2 border border-gray-300 rounded" placeholder="Property Name (e.g., transform)">
            <input type="text" class="propertyValue w-1/2 p-2 border border-gray-300 rounded" placeholder="Property Value (e.g., translateX(100px))">
            <button type="button" class="removeKeyframeBtn text-red-500">-</button>
        `;

        // Add remove event
        keyframeBlock.querySelector('.removeKeyframeBtn').addEventListener('click', function() {
            keyframeBlock.remove();
        });

        keyframesContainer.appendChild(keyframeBlock);
    });

    // Generate CSS
    generateBtn.addEventListener('click', function() {
        const animationName = document.getElementById('animationName').value.trim();
        const duration = document.getElementById('duration').value.trim();
        const keyframeBlocks = document.querySelectorAll('.keyframeBlock');

        if (!animationName || !duration || keyframeBlocks.length === 0) {
            alert("Please fill out all fields.");
            return;
        }

        let cssKeyframes = `@keyframes ${animationName} {\n`;

        keyframeBlocks.forEach(block => {
            const keyframe = block.querySelector('.keyframe').value.trim();
            const propertyName = block.querySelector('.propertyName').value.trim();
            const propertyValue = block.querySelector('.propertyValue').value.trim();

            if (keyframe && propertyName && propertyValue) {
                cssKeyframes += `  ${keyframe}% {\n    ${propertyName}: ${propertyValue};\n  }\n`;
            }
        });

        cssKeyframes += `}\n\n`;

        const cssClass = `
.ani-${animationName} {
  animation: ${animationName} ${duration}s ease-in-out infinite;
}`;

        cssOutput.textContent = cssKeyframes + cssClass;
    });
});