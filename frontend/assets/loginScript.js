const username_text = document.getElementById("username");
const password_text = document.getElementById("password");

function login(){

    const obj = {
        username: username_text.value,
        password: password_text.value
    }
    axios.post('http://localhost:8000/auth/login', JSON.stringify(obj)).then( (response) => {
        if (response.status == 200){
            if (response.data.token){
                localStorage.setItem('token', response.data.token);
                axios.get('http://localhost:8000/index',{
                    headers: { 'Authorization': 'Bearer ' + response.data.token }
                }).then((response) => {
                    document.open();
                    document.write(response.data);
                    document.close();
                });
            }//else{
                //alert("Error: No token received");
        //    }
        }
    }).catch(error => {
        console.log(error);
        error.response.status == 401 ? alert("Invalid username or password") : alert("Server error");
    });
}