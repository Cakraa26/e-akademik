btn = document.querySelector(".load-btn");
        const originalWidth = btn.offsetWidth;

        btn.style.width = `${originalWidth}px`;
        
        btn.onclick = function() {
            this.innerHTML = "<div class='loader'></div>";
        }

        document.addEventListener("DOMContentLoaded", function() {
            const btn = document.querySelector("#submit-btn");
            const originalWidth = btn.offsetWidth;

            btn.style.width = `${originalWidth}px`;

            const form = document.getElementById("form");

            form.onsubmit = function(event) {
                event.preventDefault();

                if ($(this).parsley().isValid()) {
                    btn.innerHTML = "<div class='loader'></div>";

                    this.submit();
                }
            };
        });