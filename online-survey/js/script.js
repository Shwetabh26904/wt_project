document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");

    if (form) {
        form.addEventListener("submit", function(e) {
            let checked = document.querySelectorAll("input[type=radio]:checked");

            if (checked.length === 0) {
                alert("Please select at least one option!");
                e.preventDefault();
            }
        });
    }
});