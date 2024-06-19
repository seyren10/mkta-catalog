import { ref } from "vue";

const runRequired = (input) => input.trim() !== "";

const runEmail = (input) => {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailRegex.test(input);
};

export const useInputValidate = (validatorTypes, customErrorMessages) => {
    const isInputValid = ref(true);
    const errorMessage = ref("");

    const runValidator = (input, validator) => {
        switch (validator.toLowerCase()) {
            case "required": {
                if (!runRequired(input)) {
                    errorMessage.value =
                        customErrorMessages["required"] ||
                        "Input must not be empty.";
                    return false;
                }

                return true;
            }
            case "email": {
                if (runEmail(input)) {
                    errorMessage.value =
                        customErrorMessages["email"] ||
                        "Enter a valid email address";
                    return false;
                }
                return true;
            }
        }
    };

    const validateInput = (input) => {
        isInputValid.value = validatorTypes.every((validator) => {
            return runValidator(input, validator);
        });
    };

    return { isInputValid, validateInput, errorMessage };
};
