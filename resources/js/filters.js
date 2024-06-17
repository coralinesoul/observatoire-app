document.addEventListener('DOMContentLoaded', function () {
    const fromSlider = document.getElementById('fromSlider');
    const toSlider = document.getElementById('toSlider');
    const fromInput = document.getElementById('fromInput');
    const toInput = document.getElementById('toInput');
    const minGap = 1;

    function updateSlider() {
        const fromValue = parseInt(fromSlider.value);
        const toValue = parseInt(toSlider.value);

        fromInput.value = fromValue;
        toInput.value = toValue;

        const rangeDistance = toSlider.max - toSlider.min;
        const fromPosition = ((fromValue - toSlider.min) / rangeDistance) * 100;
        const toPosition = ((toValue - toSlider.min) / rangeDistance) * 100;

        toSlider.style.background = `linear-gradient(
            to right,
            #C6C6C6 0%,
            #C6C6C6 ${fromPosition}%,
            #25daa5 ${fromPosition}%,
            #25daa5 ${toPosition}%, 
            #C6C6C6 ${toPosition}%,
            #C6C6C6 100%
        )`;

        if (toValue - fromValue <= minGap) {
            if (fromSlider.value > toSlider.value) {
                toSlider.value = fromValue + minGap;
                toInput.value = fromValue + minGap;
            } else {
                fromSlider.value = toValue - minGap;
                fromInput.value = toValue - minGap;
            }
        }
    }

    function syncFromSlider() {
        updateSlider();
    }

    function syncToSlider() {
        updateSlider();
    }

    function syncFromInput() {
        fromSlider.value = fromInput.value;
        updateSlider();
    }

    function syncToInput() {
        toSlider.value = toInput.value;
        updateSlider();
    }

    fromSlider.addEventListener('input', syncFromSlider);
    toSlider.addEventListener('input', syncToSlider);
    fromInput.addEventListener('input', syncFromInput);
    toInput.addEventListener('input', syncToInput);

    updateSlider();
});
