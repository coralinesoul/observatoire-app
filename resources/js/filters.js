document.addEventListener('DOMContentLoaded', () => {
    const fromSlider = document.getElementById('fromSlider');
    const toSlider = document.getElementById('toSlider');
    const fromInput = document.getElementById('fromInput');
    const toInput = document.getElementById('toInput');

    const updateFromInput = (val) => {
        fromInput.value = val;
    };

    const updateToInput = (val) => {
        toInput.value = val;
    };

    const updateFromSlider = (val) => {
        fromSlider.value = val;
    };

    const updateToSlider = (val) => {
        toSlider.value = val;
    };

    fromSlider.oninput = function() {
        const val = this.value;
        updateFromInput(val);
        if (parseInt(val) > parseInt(toSlider.value)) {
            const adjustedValue = toSlider.value;
            updateToSlider(val);
            updateToInput(adjustedValue);
        }
    };

    toSlider.oninput = function() {
        const val = this.value;
        updateToInput(val);
        if (parseInt(val) < parseInt(fromSlider.value)) {
            const adjustedValue = fromSlider.value;
            updateFromSlider(val);
            updateFromInput(adjustedValue);
        }
    };

    fromInput.onchange = function() {
        const val = this.value;
        updateFromSlider(val);
        if (parseInt(val) > parseInt(toInput.value)) {
            const adjustedValue = toInput.value;
            updateToSlider(val);
            updateToInput(adjustedValue);
        }
    };

    toInput.onchange = function() {
        const val = this.value;
        updateToSlider(val);
        if (parseInt(val) < parseInt(fromInput.value)) {
            const adjustedValue = fromInput.value;
            updateFromSlider(val);
            updateFromInput(adjustedValue);
        }
    };
});
