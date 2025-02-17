const username_text = document.getElementById("username");
const password_text = document.getElementById("password");

function login(){

    const obj = {
        username: username_text.value,
        password: password_text.value
    }
    axios.post('http://localhost:8000/auth/login', JSON.stringify(obj)).then((response) => {
        if (response.status == 200){
            if (response.data.token){
                localStorage.setItem('token', response.data.token);
                window.location.href = './frontend/index.html';
            }else{
                alert("Server error");
            }
            
        }
    }).catch(error => {
        error.response.status == 401 ? alert("Invalid username or password") : alert("Server error");
    });
}