
class Auth {

    doLogin(vueObject, token, name, email) {
        vueObject.$localStorage.set('token', token);
        vueObject.$localStorage.set('name', name);
        vueObject.$localStorage.set('email', email);

        vueObject.$emit('updateuserdetails');
        vueObject.$router.push('/user');
    }

    isTokenValid(vueObject, error) {
        let response = error.response;
        if (response.status !== 401) {
            return true;
        }

        vueObject.$localStorage.remove('token');
        vueObject.$emit('updateuserdetails');
        vueObject.$router.push('/login');

        return false;
    }
}

export default Auth;