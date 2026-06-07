(function () {
    'use strict';

    function hasLetter(value) {
        return /[a-zA-Z]/.test(value);
    }

    function hasNumber(value) {
        return /[0-9]/.test(value);
    }

    function hasSymbol(value) {
        return /[^a-zA-Z0-9]/.test(value);
    }

    var PASSWORD_RULE_MSG = 'Min. 8 characters with letters, numbers, and a symbol (e.g. !@#$).';

    function isStrongPassword(value) {
        if (!value || value.length < 8 || value.length > 128) return false;
        return hasLetter(value) && hasNumber(value) && hasSymbol(value);
    }

    function validateStrongPassword(value) {
        return isStrongPassword(value) ? '' : PASSWORD_RULE_MSG;
    }

    function isPasswordRuleField(input) {
        return input.name === 'password' || input.name === 'new_password';
    }

    function updatePasswordRuleState(input, message) {
        var wrap = getFieldWrap(input);
        if (!wrap) return;

        var ruleEl = wrap.querySelector('.field-password-rule');
        if (!ruleEl) return;

        ruleEl.textContent = PASSWORD_RULE_MSG;
        ruleEl.classList.remove('is-neutral', 'is-error', 'is-valid');

        if (input.dataset.touched !== '1') {
            ruleEl.classList.add('is-neutral');
        } else if (message) {
            ruleEl.classList.add('is-error');
        } else {
            ruleEl.classList.add('is-valid');
        }
    }

    var ruleSets = {
        profile: {
            name: function (value) {
                var v = value.trim();
                if (!v) return 'Full name is required.';
                if (v.length < 2) return 'Name must be at least 2 characters.';
                if (v.length > 80) return 'Name cannot exceed 80 characters.';
                if (!/^[\p{L}\s\-'.]+$/u.test(v)) {
                    return 'Name may only contain letters, spaces, hyphens, and apostrophes.';
                }
                return '';
            },
            email: function (value) {
                var v = value.trim().toLowerCase();
                if (!v) return 'Email is required.';
                if (v.length > 255) return 'Email cannot exceed 255 characters.';
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) {
                    return 'Please enter a valid email address.';
                }
                return '';
            },
            contact_number: function (value) {
                var v = value.trim();
                if (!v) return '';
                if (v.length > 20) return 'Contact number cannot exceed 20 characters.';
                if (!/^[0-9+\-\s()]+$/.test(v)) return 'Please enter a valid contact number.';
                return '';
            },
            postal_code: function (value) {
                var v = value.trim();
                if (!v) return '';
                if (v.length > 10) return 'Postal code cannot exceed 10 characters.';
                if (!/^[A-Za-z0-9\s\-]+$/.test(v)) return 'Please enter a valid postal code.';
                return '';
            },
            address: function (value) {
                var v = value.trim();
                if (!v) return '';
                if (v.length > 255) return 'Address cannot exceed 255 characters.';
                return '';
            }
        },
        register: {
            name: function (value) {
                var v = value.trim();
                if (!v) return 'Name is required.';
                if (v.length < 2) return 'Name must be at least 2 characters.';
                if (v.length > 80) return 'Name cannot exceed 80 characters.';
                if (!/^[\p{L}\s\-'.]+$/u.test(v)) {
                    return 'Name may only contain letters, spaces, hyphens, and apostrophes.';
                }
                return '';
            },
            email: function (value) {
                var v = value.trim().toLowerCase();
                if (!v) return 'Email is required.';
                if (v.length > 255) return 'Email cannot exceed 255 characters.';
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) {
                    return 'Please enter a valid email address.';
                }
                return '';
            },
            password: function (value) {
                return validateStrongPassword(value);
            },
            password_confirmation: function (value, form) {
                if (!value) return 'Please confirm your password.';
                var pwd = form.querySelector('[name="password"]');
                if (pwd && value !== pwd.value) return 'Passwords do not match.';
                return '';
            }
        },
        passwordChange: {
            current_password: function (value) {
                if (!value) return 'Current password is required.';
                if (value.length > 128) return 'Password cannot exceed 128 characters.';
                return '';
            },
            new_password: function (value) {
                return validateStrongPassword(value);
            },
            new_confirm_password: function (value, form) {
                if (!value) return 'Please confirm your new password.';
                var pwd = form.querySelector('[name="new_password"]');
                if (pwd && value !== pwd.value) return 'Passwords do not match.';
                return '';
            }
        },
        login: {
            email: function (value) {
                var v = value.trim().toLowerCase();
                if (!v) return 'Email is required.';
                if (v.length > 255) return 'Email cannot exceed 255 characters.';
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) {
                    return 'Please enter a valid email address.';
                }
                return '';
            },
            password: function (value) {
                if (!value) return 'Password is required.';
                if (value.length > 128) return 'Password cannot exceed 128 characters.';
                return '';
            }
        }
    };

    function getFieldWrap(input) {
        return input.closest('.form-field');
    }

    function setFieldState(input, message, showValid) {
        var wrap = getFieldWrap(input);
        if (!wrap) return;

        var liveError = wrap.querySelector('.field-error-live');
        var serverError = wrap.querySelector('.field-error-server');
        var usesPasswordRule = isPasswordRuleField(input) && wrap.querySelector('.field-password-rule');

        if (usesPasswordRule) {
            updatePasswordRuleState(input, message);
            if (liveError) {
                liveError.textContent = '';
                liveError.style.display = 'none';
            }
        }

        if (message) {
            wrap.classList.add('has-error');
            wrap.classList.remove('is-valid');
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            if (!usesPasswordRule && liveError) {
                liveError.textContent = message;
                liveError.style.display = 'block';
            }
            if (serverError) serverError.style.display = 'none';
        } else {
            wrap.classList.remove('has-error');
            input.classList.remove('is-invalid');
            if (!usesPasswordRule && liveError) {
                liveError.textContent = '';
                liveError.style.display = 'none';
            }
            if (serverError) serverError.style.display = 'none';
            if (showValid) {
                wrap.classList.add('is-valid');
                input.classList.add('is-valid');
            } else {
                wrap.classList.remove('is-valid');
                input.classList.remove('is-valid');
            }
        }
    }

    function validateField(input, form, rules, showError) {
        var validator = rules[input.name];
        if (!validator) return true;

        var message = validator(input.value, form);
        if (showError) {
            setFieldState(input, message, input.dataset.touched === '1');
        }
        return !message;
    }

    function bindField(input, form, rules) {
        if (input.dataset.serverError === '1') {
            input.dataset.touched = '1';
            var wrap = getFieldWrap(input);
            if (wrap) wrap.classList.add('has-error');
            input.classList.add('is-invalid');
            if (isPasswordRuleField(input) && wrap) {
                var ruleEl = wrap.querySelector('.field-password-rule');
                if (ruleEl) {
                    ruleEl.classList.remove('is-neutral', 'is-valid');
                    ruleEl.classList.add('is-error');
                }
            }
        } else if (isPasswordRuleField(input)) {
            updatePasswordRuleState(input, '');
        }

        input.addEventListener('input', function () {
            input.dataset.touched = '1';
            validateField(input, form, rules, true);
            if (input.name === 'password' || input.name === 'new_password') {
                var confirmName = input.name === 'new_password' ? 'new_confirm_password' : 'password_confirmation';
                var confirm = form.querySelector('[name="' + confirmName + '"]');
                if (confirm && confirm.dataset.touched === '1') {
                    validateField(confirm, form, rules, true);
                }
            }
        });

        input.addEventListener('blur', function () {
            input.dataset.touched = '1';
            validateField(input, form, rules, true);
        });
    }

    function initForm(form) {
        var setName = form.getAttribute('data-tc-validate');
        var rules = ruleSets[setName];
        if (!rules) return;

        form.querySelectorAll('input[name], textarea[name], select[name]').forEach(function (input) {
            bindField(input, form, rules);
        });

        form.addEventListener('submit', function (e) {
            var valid = true;

            form.querySelectorAll('input[name], textarea[name], select[name]').forEach(function (input) {
                input.dataset.touched = '1';
                if (!validateField(input, form, rules, true)) valid = false;
            });

            if (!valid) {
                e.preventDefault();
                var firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid) firstInvalid.focus();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form[data-tc-validate]').forEach(initForm);
    });
})();
