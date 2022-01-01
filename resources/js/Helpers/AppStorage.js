class AppStorage{
    // Language: javascript
    
    /**
     * Store the access token in local storage
     * @param {*} token
     */
    storeToken(token){
        localStorage.setItem('access_token', token);
    }

    /**
     * Retrieve the access token from local storage
     * @param {*} token
     */
    storeUser(user){
        localStorage.setItem('user', JSON.stringify(user));
    }


    /**
     * Store the access token in local storage using storeToken() and storeUser()
     * @param {*} token
     * @param {*} user
     */
    store(token, user){
        this.storeToken(token);
        this.storeUser(user);
    }
    
    /**
     * Clear the access token from local storage
     * localStorage
     */
    clear(){
        localStorage.removeItem('access_token');
        localStorage.removeItem('user');
    }

    /**
     * Retrieve the access token from local storage
     * @returns {*} token
     */
    getToken(){
        return localStorage.getItem('access_token');
    }

    /**
     * Retrieve the user from local storage
     * @returns {*} user
     */
    getUser(){
        return JSON.parse(localStorage.getItem('user'));
    }
}

export default AppStorage = new AppStorage();