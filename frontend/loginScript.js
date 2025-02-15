const username_text = document.getElementById("username");
const password_text = document.getElementById("password");

function login(){

    const obj = {
        username: username_text.value,
        password: password_text.value
    }
    axios.post('http://localhost:8000/auth/login', JSON.stringify(obj)).then((response) => {
        if (response.status == 200){
            localStorage.setItem('token', response.data.token);
            window.location.href = '/frontend/index.html';
        }
    }).catch(error => console.error("Error al cargar datos:", error));
}