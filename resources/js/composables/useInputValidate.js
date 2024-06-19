import { ref } from "vue";

const runRequired = (input) => input.trim() !== "";

const runEmail = (input) => {
    return String(input)
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
        );
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
                if (!runEmail(input)) {
                    errorMessage.value =
                        customErrorMessages["email"] ||
                        "Enter a valid email address";
                    return false;
                }
                return true;
            }
        }

        const [prefix, affix] = validator.split(":");

        if (prefix && affix) {
            if (prefix.toLowerCase() === "max" && input.length > +affix) {
                errorMessage.value =
                    customErrorMessages["max"] ||
                    `must be less than or equal to ${affix}`;
                return false;
            } else if (
                prefix.toLowerCase() === "min" &&
                input.length < +affix
            ) {
                errorMessage.value =
                    customErrorMessages["max"] ||
                    `must be greater than or equal to ${affix}`;
                return false;
            }
        }
        return true;
    };

    const validateInput = (input) => {
        isInputValid.value = validatorTypes.every((validator) => {
            return runValidator(input, validator);
        });
    };

    return { isInputValid, validateInput, errorMessage };
};
