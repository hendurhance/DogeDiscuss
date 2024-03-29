class Token{
    
    // check if token is valid
    checkIfValid(token){
        const payload = this.payload(token); 
        // check if payload exists and if it is not expired
        if(payload){
            const iss = [
                "http://127.0.0.1:8000/api/auth/login",
                "http://dogediscuss.herokuapp.com/api/auth/login",
            ]
            const now = Date.now() / 1000;
            if(iss.includes(payload.iss) && payload.exp > now){
                return true;
            }
        }
        return false;
    }

    
    payload(token){
        const payload = token.split('.')[1];
        return this.decode(payload);
    }

    decode(payload){
        if(this.isBase64(payload)){
            return JSON.parse(atob(payload));
        }
        return false;
    }

    isBase64(string){
        try{
            // replace = with ""
            return btoa(atob(string)).replace(/=/g, "") === string;
        }catch(err){
            console.warn("Nice try, but you can't do that", err);
            return false;
        }
    }
    
}

export default Token = new Token();