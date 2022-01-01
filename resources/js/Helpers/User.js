import Token from './Token';
import AppStorage from './AppStorage';


class User{
    async login(paylod){
        return await axios.post('/api/auth/login', paylod).then(
            response => this.LoginResponse(response)
        )
    }

    async register(paylod){
        return await axios.post('/api/auth/register', paylod).then(
            response => response.data
        )
    }

    LoginResponse(response){
        const access_token = response.data.access_token;
        const username = response.data.user;
        if(Token.checkIfValid(access_token)){
            AppStorage.store(access_token, username);
            return true;
        }
    }

    // check if user has token
    hasToken(){
        const storedToken = AppStorage.getToken();

        if(storedToken){
            return Token.checkIfValid(storedToken) ? true : false;
        }
        return false;
    }

    checkIfLoggedIn(){
        if(this.hasToken()){
            return true;
        }
        return false;
    }

    logout(){
        AppStorage.clear();
    }

    getUsersName(){
        if(this.checkIfLoggedIn()){
            return AppStorage.getUser();
        }
    }

    getUsersId(){
        if(this.checkIfLoggedIn()){
            const payload = Token.payload(AppStorage.getToken());
            return payload.sub;
        }
    }
}


export default User = new User();