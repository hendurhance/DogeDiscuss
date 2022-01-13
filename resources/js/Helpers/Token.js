import AppStorage from "./AppStorage";

class Token {

    /**
     * Check if token is valid 
     * @param {String} token - token to check
     * uses checkIfExpired() function
     * @returns {Boolean} - true if token is valid
     * 
     */
    checkIfValid(token) {
        const checkExp = this.checkIfExpired(token);
        if (checkExp === true) {
            if (payload) {
                // create an array of iss
                const iss = [
                    "http://127.0.0.1:8000/api/auth/login",
                    "http://dogediscuss.herokuapp.com/api/auth/login",
                ]

                return iss.includes(payload.iss) ? true : false;
            }
        } else {
            AppStorage.clear();
            return false;
        }
    }




    payload(token) {
        const payload = token.split('.')[1];
        return this.decode(payload);
    }

    decode(payload) {
        return JSON.parse(atob(payload));
    }

    /**
     * Check if token is expired
     * @param {String} token - token to check
     * @returns {Boolean} - true if token is expired
     * 
     */
    checkIfExpired(token) {
        const payload = this.payload(token);
        if (payload) {
            const exp = payload.exp;
            if (exp) {
                return exp < Date.now() / 1000;
            }
        }
        return false;
    }

}

export default Token = new Token();