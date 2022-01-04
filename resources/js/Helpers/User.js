import Token from './Token';
import AppStorage from './AppStorage';

/**
 * User class
 * @class
 */
class User{


    /**
     * Login user
     * @param {*} paylod 
     * @returns response from server
     */
    // async login(paylod){
    //     return await axios.post('/api/auth/login', paylod).then(
    //         response => this.LoginResponse(response)
    //     )
    // }
    async login(paylod){
        return await axios.post('/api/auth/login', paylod).then(
            response => {
                const access_token = response.data.access_token;
                const user = response.data.user;
                console.log(response.data, 'response.data');
                if(Token.checkIfValid(access_token)){
                    AppStorage.store(access_token, user);
                    console.log('token stored on login()');
                    return response;
                }
            }
        )
    }

    /**
     * Register user
     * @param {*} paylod
     * @returns response from server
     */
    async register(paylod){
        return await axios.post('/api/auth/register', paylod).then(
            response => response.data
        )
    }

    /**
     * Login Response
     * @param {*} response
     * Get token and user from Local Storage
     * @returns boolean
     */
    // LoginResponse(response){
    //     const access_token = response.data.access_token;
    //     const username = response.data.user;
    //     if(Token.checkIfValid(access_token)){
    //         AppStorage.store(access_token, username);
    //         console.log('token stored on LoginResponse');
    //         return true;
    //     }
    // }

    /**
     * Check if user has token
     * @returns boolean
     */
    hasToken(){
        const storedToken = AppStorage.getToken();

        if(storedToken){
            return Token.checkIfValid(storedToken) ? true : false;
        }
        return false;
    }

    /**
     * Check if user is logged in
     * @returns boolean
     */
    checkIfLoggedIn(){
        if(this.hasToken()){
            return true;
        }
        return false;
    }

    /**
     * Logout Request
     * @returns response from server
     * @throws error if user is not logged in
     */
    async logoutRequest(){
        if(this.checkIfLoggedIn()){
            // return post request with token as header
            return await axios.post('/api/auth/logout'
            ).then(
                // return response and console log
                response => {
                    console.log(response);
                    return response.data;
                }
            )
        }
        console.log('User is not logged in');
    }

    /**
     * Logout user
     * Clear token and user from Local Storage
     */
    logout(){
        AppStorage.clear();
        this.logoutRequest();
    }
    

    /**
     * Get user
     * @returns user
     * @throws error if user is not logged in
     */
    getUsersName(){
        if(this.checkIfLoggedIn()){
            return AppStorage.getUser();
        }
        throw new Error('User is not logged in');
    }

    /**
     * Get User ID
     * @returns user id
     * @throws error if user is not logged in
     */
    getUsersId(){
        if(this.checkIfLoggedIn()){
            const payload = Token.payload(AppStorage.getToken());
            return payload.sub;
        }
        throw new Error('User is not logged in');
    }
}


export default User = new User();