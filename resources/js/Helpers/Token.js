class Token{
    
    // check if token is valid
    checkIfValid(token){
        const payload = this.payload(token); 
        if(payload){
            // create an array of iss
            const iss = [
                "http://127.0.0.1:8000/api/auth/login",
                "https://dogediscuss.herokuapp.com/api/auth/login"
            ]

            return iss.includes(payload.iss) ? true : false;
        }
        return false;
    }

    
    payload(token){
        const payload = token.split('.')[1];
        return this.decode(payload);
    }

    decode(payload){
        return JSON.parse(atob(payload));
    }
}

export default Token = new Token();