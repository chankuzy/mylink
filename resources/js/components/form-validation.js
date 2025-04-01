export function initializeFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input[data-validate]');
        
        inputs.forEach(input => {
            input.addEventListener('input', () => validateInput(input));
            input.addEventListener('blur', () => validateInput(input));
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            let isValid = true;
            
            inputs.forEach(input => {
                if (!validateInput(input)) {
                    isValid = false;
                }
            });

            if (isValid) {
                console.log('Form is valid, ready to submit');
                // Form submission logic here
            }
        });
    });
}

function validateInput(input) {
    const rules = input.dataset.validate.split('|');
    const errors = input.dataset.error.split('|');
    const errorElement = input.nextElementSibling;
    let isValid = true;
    let errorMessage = '';

    rules.forEach((rule, index) => {
        if (isValid) {
            const [ruleName, ruleValue] = rule.split(':');
            
            switch(ruleName) {
                case 'required':
                    if (!input.value.trim()) {
                        isValid = false;
                        errorMessage = errors[index];
                    }
                    break;

                case 'min':
                    if (input.value.length < parseInt(ruleValue)) {
                        isValid = false;
                        errorMessage = errors[index];
                    }
                    break;

                case 'email':
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(input.value)) {
                        isValid = false;
                        errorMessage = errors[index];
                    }
                    break;

                case 'alphanumeric':
                    const alphanumericRegex = /^[a-zA-Z0-9]+$/;
                    if (!alphanumericRegex.test(input.value)) {
                        isValid = false;
                        errorMessage = errors[index];
                    }
                    break;

                case 'password':
                    const passwordRegex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])/;
                    if (!passwordRegex.test(input.value)) {
                        isValid = false;
                        errorMessage = errors[index];
                    }
                    break;

                case 'match':
                    const targetInput = document.getElementById(ruleValue);
                    if (input.value !== targetInput.value) {
                        isValid = false;
                        errorMessage = errors[index];
                    }
                    break;
            }
        }
    });

    // Update input styling
    if (isValid) {
        input.classList.remove('ring-red-500');
        input.classList.add('ring-green-500');
        errorElement.classList.add('hidden');
    } else {
        input.classList.remove('ring-green-500');
        input.classList.add('ring-red-500');
        errorElement.classList.remove('hidden');
        errorElement.textContent = errorMessage;
    }

    return isValid;
}

