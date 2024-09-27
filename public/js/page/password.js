function setupPasswordToggle(inputId, toggleId) {
    const input = document.getElementById(inputId);
    const toggle = document.getElementById(toggleId);

    function togglePasswordVisibility() {
        if (input.type === 'password') {
            input.type = 'text';
            toggle.querySelector('i').classList.remove('fa-eye-slash');
            toggle.querySelector('i').classList.add('fa-eye');
        } else {
            input.type = 'password';
            toggle.querySelector('i').classList.remove('fa-eye');
            toggle.querySelector('i').classList.add('fa-eye-slash');
        }
    }

    function checkPasswordField() {
        if (input.value.length > 0) {
            toggle.style.display = 'block';
        } else {
            toggle.style.display = 'none';
            input.type = 'password';
            toggle.querySelector('i').classList.remove('fa-eye');
            toggle.querySelector('i').classList.add('fa-eye-slash');
        }
    }

    input.addEventListener('input', checkPasswordField);
    toggle.addEventListener('click', togglePasswordVisibility);

    checkPasswordField();
}

setupPasswordToggle('password', 'togglePassword');
setupPasswordToggle('konfirpass', 'toggleKonfirpass');