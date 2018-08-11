import { Validator } from 'vee-validate';
import PhoneNumber from 'awesome-phonenumber'

const phoneNumber = {
    getMessage: field => `${field} is not a valid phone number`,
    validate (value) {
        return new Promise(resolve => {
            let phone = new PhoneNumber(value);
            resolve({ valid: phone.isValid() })
        })
    }
}
Validator.extend('phoneNumber', phoneNumber)