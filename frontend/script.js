const main_container = document.getElementById("main_container");
const button_container = document.getElementById("button-container");
const token = localStorage.getItem('token');
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
const personGames = [];
axios.interceptors.response.use(
    response => response, 
    error => {
        if (error.response.status === 401) {
            alert("Session expirada");
            window.location.href = "http://localhost:8000/login";
        }
        return Promise.reject(error);
    }
);
//utilities
function createTable(){
    const tabla = document.createElement("table");
    main_container.appendChild(tabla);
    tabla.id = "tabla";
    return tabla;
}

function deleteDivs(){
    main_container.innerHTML="";

}

function deleteButtons(){
    button_container.innerHTML="";
}

function generateMainButtons(){
    deleteDivs();
    deleteButtons();
    button_container.innerHTML = `<button onclick="LoadUsersData()">Resumen de juego</button>
        <button onclick="loadPersonButton()">Personas</button>
        <button onclick="loadGamesButton()">Partidas</button>
        <button onclick="loadPersonGamesButton()">Personas y partidas</button>`;
}

function stringToNumber(cellString){
    numero = Number(cellString);
    if (isNaN(numero)){
        return 0;
    }else
        return numero;
}


//Person functions
function loadPersonButton(){
    deleteButtons();
    generatePersonList();
    button_container.innerHTML = `<button onclick="generateMainButtons()">←</button>`;
}

function generatePersonList(){
    deleteDivs();
    const table = createTable();
    table.innerHTML = `<thead><tr><th>ID</th><th>Nick</th><th>Modificar</th><th>Eliminar</th></tr></thead><tbody></tbody>`
    axios.get('http://localhost:8000/persons')
        .then(response => {
            const data = response.data;
            createTable();
            const tabla = document.getElementById("tabla").getElementsByTagName("tbody")[0];
            tabla.innerHTML = "";
            data.forEach(jugador => {
                let fila = tabla.insertRow();
                fila.insertCell(0).textContent = jugador.id;
                fila.insertCell(1).textContent = jugador.nick;

                let btnModificar = document.createElement("button");
                btnModificar.className = "full-cell-button"
                btnModificar.textContent = "Modificar";
                btnModificar.onclick = function() {
                    modPerson(this.closest("tr"));
                };
                fila.insertCell(2).appendChild(btnModificar);
            
                let btnEliminar = document.createElement("button");
                btnEliminar.textContent = "Eliminar";
                btnEliminar.className = "full-cell-button"
                btnEliminar.onclick = function() {
                    delPerson(this.closest("tr")); 
                };
                fila.insertCell(3).appendChild(btnEliminar);

                fila.cells[3].className = "cell"
                fila.cells[2].className = "cell"
            });
            fila = tabla.insertRow();
            fila.insertCell(0).contentEditable="false";
            fila.insertCell(1).contentEditable="true";
            fila.insertCell(2).contentEditable="false";
            let btnEliminar = document.createElement("button");
                btnEliminar.textContent = "Aniadir persona";
                btnEliminar.className = "full-cell-button"
                btnEliminar.onclick = function() {
                    if (fila.cells[1].textContent !=""){
                        createPerson(fila.cells[1].textContent);
                    }
                };
            fila.insertCell(3).appendChild(btnEliminar);
            fila.cells[3].className = "cell"
            fila.cells[0].style.backgroundColor = 'rgb(255, 150, 150)';;
            fila.cells[2].style.backgroundColor = 'rgb(255, 150, 150)';;
            fila.cells[1].focus();

        })
        .catch(error => console.error("Error al cargar datos:", error));
}

function modPerson(fila){
    const celda = fila.cells[1];
    if (celda.contentEditable=="true"){
        celda.contentEditable="false";
        const id = fila.cells[0].innerText;
        const nick = celda.innerText;
        axios.patch(`http://localhost:8000/persons?id=${id}&nick=${nick}`)
        .then(response => {
        })
        .catch(error => {
            console.error("Error al cargar datos:", error)
        });
        generatePersonList();
    }else{
        celda.contentEditable="true";
        celda.focus();
    }
}

function delPerson(fila){
    const id = fila.cells[0].innerText;
    axios.delete('http://localhost:8000/persons?id='+id)
        .then(response => {
            generatePersonList();
        })
        .catch(error => console.error("Error al cargar datos:", error));
}

function createPerson(nick){
    const obj={
        nick:nick
    }
    axios.post('http://localhost:8000/persons',JSON.stringify(obj))
    .then(response => {
        generatePersonList();
    })
    .catch(error => console.error("Error al cargar datos:", error));
}

//Games function
function loadGamesButton(){
    deleteButtons();
    generateGameList();
    button_container.innerHTML = `<button onclick="generateMainButtons()">←</button>`;
}

function generateGameList(){
    deleteDivs();
    const table = createTable();
    table.innerHTML = `<thead><tr><th>ID</th><th>Fecha</th><th>Descripcion</th><th>Detalles</th><th>Eliminar</th></tr></thead><tbody></tbody>`
    axios.get('http://localhost:8000/games')
        .then(response => {
            const data = response.data;
            const tabla = document.getElementById("tabla").getElementsByTagName("tbody")[0];
            tabla.innerHTML = ""; // Limpiar la tabla antes de agregar nuevos datos
            data.forEach(partida => {
                let fila = tabla.insertRow();
                fila.insertCell(0).textContent = partida.id;
                fila.insertCell(1).textContent = partida.date;
                fila.insertCell(2).textContent = partida.description;
            
                let btnDetails = document.createElement("button");
                btnDetails.textContent = "Detalles";
                btnDetails.className = "full-cell-button"
                btnDetails.onclick = function() {
                    showGameDetails(this.closest("tr"));
                };
                fila.insertCell(3).appendChild(btnDetails);
                fila.cells[3].className = "cell"

                let btnEliminar = document.createElement("button");
                btnEliminar.textContent = "Eliminar";
                btnEliminar.className = "full-cell-button"
                btnEliminar.onclick = function() {
                     delGame(this.closest("tr"));
                };
                fila.insertCell(4).appendChild(btnEliminar);

                fila.cells[4].className = "cell"
            });
            fila = tabla.insertRow();
            fila.insertCell(0).contentEditable="false";
            fila.insertCell(1).contentEditable="true";
            fila.insertCell(2).contentEditable="false";
            const dateInput = document.createElement('input');
            dateInput.type = 'date';
            dateInput.name = 'calendar';
            fila.cells[1].appendChild(dateInput);
            fila.cells[1].className = "cell";
            fila.insertCell(2).contentEditable="true";
            let btnAniadir = document.createElement("button");
                btnAniadir.textContent = "Aniadir partida";
                btnAniadir.className = "full-cell-button"
                btnAniadir.onclick = function() {
                    createGame(this.closest("tr"));
                };
            fila.insertCell(4).appendChild(btnAniadir);
            fila.cells[4].className = "cell";
        })
        .catch(error => console.error("Error al cargar datos:", error));
}

function showGameDetails(row){
    deleteDivs();
    button_container.innerHTML = `<button onclick="loadGamesButton()">←</button>`;
    const game_id = row.cells[0].innerText;
    axios.get(`http://localhost:8000/games?game_details=${game_id}`).then((response)=>{
        generateGameDetailsTable(response.data,row);
    }).catch(error => console.error("Error al cargar datos:", error));
}

function generateGameDetailsTable(data,row){
    main_container.innerHTML = `<table id="table-details"><thead><th>Atributos</th><th>Valores</th></thead><tbody><tbody></table>`
    main_container.innerHTML += `<table id="table-players-details"><thead><th>Nick</th><th>Puntos de partida</th><th>puntos mvp</th><th>puntos dano</th><th>puntos cantidad</th></thead><tbody><tbody></table>`

    let flag = false;
    const table = document.getElementById("table-details").getElementsByTagName("tbody")[0];

    let fila = table.insertRow();
    fila.insertCell(0).innerText = "Partida";
    fila.insertCell(1).innerText = data.game.id;
    
    fila = table.insertRow();
    fila.insertCell(0).innerText = "Cantidad de worms";
    const q_worm_cell = fila.insertCell(1);
    q_worm_cell.innerText = data.worms_quantity;
    
    fila = table.insertRow();
    fila.insertCell(0).innerText = "Vida de los worms";
    const hp_worm_cell = fila.insertCell(1);
    hp_worm_cell.innerText = data.worms_hp;
    
    fila = table.insertRow();
    let celda = fila.insertCell(0);
    celda.innerText = "descripcion:"
    celda.colSpan= 2;
    celda.className = "full-row";
    
    fila = table.insertRow();
    desc_cell = fila.insertCell(0);
    desc_cell.innerText = data.description;
    desc_cell.colSpan= 2;
    desc_cell.className = "full-row";

    fila = table.insertRow();
    celda = fila.insertCell(0);
    celda.colSpan= 2;
    celda.className = "full-row";

    let btnMod = document.createElement("button");
    btnMod.textContent = "modificar datos";
    btnMod.className = "full-cell-button"
    btnMod.onclick = function() {
        if (flag){
            flag=false;
            q_worm_cell.contentEditable="false";
            hp_worm_cell.contentEditable="false";
            desc_cell.contentEditable="false";

            const obj = {
                worms_quantity:stringToNumber(q_worm_cell.innerText),
                worms_hp:stringToNumber(hp_worm_cell.innerText),
                description:desc_cell.innerText
            }

            axios.patch(`http://localhost:8000/games?game_id=${data.game.id}`,obj).then((response)=>{
                showGameDetails(row);
            }).catch(error => console.error("Error al cargar datos:", error));
        }else{
            flag=true;
            q_worm_cell.contentEditable="true";
            hp_worm_cell.contentEditable="true";
            desc_cell.contentEditable="true";
        }
       
    };
    celda.appendChild(btnMod);

    fila = table.insertRow();
    celda = fila.insertCell(0);
    celda.innerText = "jugadores";
    celda.colSpan= 2;
    celda.className = "full-row";

    const table1 = document.getElementById("table-players-details").getElementsByTagName("tbody")[1];
    axios.get(`http://localhost:8000/points?game-id=${data.game.id}`).then((response)=>{
        const data = response.data;
        data.forEach(partida => {
            let fila = table1.insertRow();
            fila.insertCell(0).textContent = partida.person_nick;
            fila.insertCell(1).textContent = partida.total_games_point;
            fila.insertCell(2).textContent = partida.total_mvp_points;
            fila.insertCell(3).textContent = partida.total_damage_points;
            fila.insertCell(4).textContent = partida.total_quantity_points;
        });
    }).catch(error => console.error("Error al cargar datos:", error));
}

function delGame(fila){
    const id = fila.cells[0].innerText;
    axios.delete(`http://localhost:8000/games?id=${id}`)
        .then(response => {
            generateGameList();
        })
        .catch(error => console.error("Error al cargar datos:", error));
}

function createGame(fila){
    const celda = fila.cells[1];
    const dateInput = celda.querySelector('input[type="date"]');
    const date = dateInput.value;
    const description = fila.cells[2].innerText;

    const obj ={
        date:date,
        description:description
    }
    axios.post(`http://localhost:8000/games`,JSON.stringify(obj)).then(response=>{
        generateGameList();
    }).catch(error => console.error("Error al cargar datos:", error));
}

//PersonGame functions
function LoadUsersData() {
    deleteDivs();
    const table = createTable();
    table.innerHTML = `<thead><tr><th>Nombre</th><th>Puntos Totales</th><th>Puntos MVP</th><th>Puntos Damage</th><th>Puntos Cantidad</th><th>Puntos totales</th><th>Juegos Jugados</th></tr></thead><tbody></tbody>`
    axios.get('http://localhost:8000/points?user')
        .then(response => {
            const data = response.data;
            const tabla = document.getElementById("tabla").getElementsByTagName("tbody")[0];
            tabla.innerHTML = ""; // Limpiar la tabla antes de agregar nuevos datos
            data.forEach(jugador => {
                let fila = tabla.insertRow();
                fila.insertCell(0).textContent = jugador.person_nick;
                fila.insertCell(1).textContent = jugador.total_games_point;
                fila.insertCell(2).textContent = jugador.total_mvp_points;
                fila.insertCell(3).textContent = jugador.total_damage_points;
                fila.insertCell(4).textContent = jugador.total_quantity_points;
                fila.insertCell(5).textContent = jugador.total_games_point+jugador.total_mvp_points+jugador.total_damage_points+jugador.total_quantity_points;
                fila.insertCell(6).textContent = jugador.total_games;
            });
        })
        .catch(error => console.error("Error al cargar datos:", error));
}

function loadPersonGamesButton(){
    deleteButtons();
    generatePersonGameList();
    button_container.innerHTML = `<input type="text" id="game-text" maxlength="4" placeholder="ingrese ID de partida"><button onclick="generateMainButtons()">←</button>`;
    generateInputText();
}

function generateInputText(){
    const textbox = document.getElementById("game-text");
    textbox.addEventListener("keyup", function (event) {
        const len = textbox.value.length;
        if (len<=3){
            console.log()
            if (textbox.value==""){
                generatePersonGameList();
            }else{
                filterPersonGameList(textbox.value);
            }
        }
    });
}

function generatePersonGameList(){
    deleteDivs();
    if (!document.getElementById("tabla")){
        const table = createTable();
        table.innerHTML = `<thead><tr><th>Partida</th><th>Nick</th><th>Puntos de partida</th><th>puntos mvp</th><th>puntos dano</th><th>puntos cantidad</th><th>Eliminar</th></tr></thead><tbody></tbody>`
    }
    axios.get('http://localhost:8000/points')
        .then(response => {
            const data = response.data;
            const tabla = document.getElementById("tabla").getElementsByTagName("tbody")[0];
            tabla.innerHTML = ""; // Limpiar la tabla antes de agregar nuevos datos
            personGames.length=0;
            data.forEach(partida => {
                personGames.push(partida);
                let fila = tabla.insertRow();
                fila.insertCell(0).textContent = partida.game_id;
                fila.insertCell(1).textContent = partida.person_nick;
                fila.insertCell(2).textContent = partida.total_games_point;
                fila.insertCell(3).textContent = partida.total_mvp_points;
                fila.insertCell(4).textContent = partida.total_damage_points;
                fila.insertCell(5).textContent = partida.total_quantity_points;

                let btnEliminar = document.createElement("button");
                btnEliminar.textContent = "Eliminar";
                btnEliminar.className = "full-cell-button"
                btnEliminar.onclick = function() {
                    delPersonGame(this.closest("tr"));
                };
                fila.insertCell(6).appendChild(btnEliminar);

                fila.cells[6].className = "cell"
            });
            fila = tabla.insertRow();
            fila.insertCell(0).contentEditable="false";
            fila.insertCell(1).contentEditable="false";
            setPersonAndGamesSelector(fila.cells[0],fila.cells[1]);
            fila.insertCell(2).contentEditable="true";
            fila.insertCell(3).contentEditable="true";
            fila.insertCell(4).contentEditable="true";
            fila.insertCell(5).contentEditable="true";
            let btnAniadir = document.createElement("button");
                btnAniadir.textContent = "Aniadir persona";
                btnAniadir.className = "full-cell-button"
                btnAniadir.onclick = function() {
                    createPersonGame(this.closest("tr"));
                };
            fila.insertCell(6).appendChild(btnAniadir);
            fila.cells[6].className = "cell";
        })
        .catch(error => console.error("Error al cargar datos:", error));
}

async function delPersonGame(list){
    let nick = list.cells[1].innerText;;
    let game_id= list.cells[0].innerText;

    const response = await axios.get(`http://localhost:8000/persons?nick=${nick}`);
    const user_id = response.data.id;
    
    axios.delete(`http://localhost:8000/points?person_id=${user_id}&game_id=${game_id}`).then((response)=>{
        generatePersonGameList();
    }).catch(error => console.error("Error al cargar datos:", error));

}

function filterPersonGameList(game_id){
    const aux = personGames.filter( person => person.game_id == game_id);
    const tabla = document.getElementById("tabla").getElementsByTagName("tbody")[0];
    tabla.innerHTML = ""; // Limpiar la tabla antes de agregar nuevos datos
    aux.forEach(partida => {
        let fila = tabla.insertRow();
        fila.insertCell(0).textContent = partida.game_id;
        fila.insertCell(1).textContent = partida.person_nick;
        fila.insertCell(2).textContent = partida.total_games_point;
        fila.insertCell(3).textContent = partida.total_mvp_points;
        fila.insertCell(4).textContent = partida.total_damage_points;
        fila.insertCell(5).textContent = partida.total_quantity_points;

        let btnEliminar = document.createElement("button");
        btnEliminar.textContent = "Eliminar";
        btnEliminar.className = "full-cell-button"
        btnEliminar.onclick = function() {
             delGame(this.closest("tr"));
        };
        fila.insertCell(6).appendChild(btnEliminar);

        fila.cells[6].className = "cell"
    });
}

function setPersonAndGamesSelector(celda1, celda2){
    const select1 = document.createElement("select");
    const select2 = document.createElement("select");
    axios.get('http://localhost:8000/games')
        .then(response => {
            const data = response.data;
            data.forEach((partida,index) => {
                const opcion = document.createElement("option");
                opcion.value = index + 1; // Asigna un valor numérico a cada opción
                opcion.textContent = partida.id; // Asigna el texto visible
                select1.appendChild(opcion);
            });
            select1.value = "-2";
            celda1.appendChild(select1);
        })
        .catch(error => console.error("Error al cargar datos:", error));

    axios.get('http://localhost:8000/persons')
    .then(response => {
        const data = response.data;
        data.forEach((jugador,index) => {
            const opcion = document.createElement("option");
            opcion.value = index + 1;
            opcion.textContent = jugador.nick; 
            select2.appendChild(opcion);
        });
        select2.value = "-2";
        celda2.appendChild(select2);
    })
    .catch(error => console.error("Error al cargar datos:", error));
    
    
}

async function createPersonGame(list){
    let select = list.cells[1].querySelector("select"); // Encuentra el <select> dentro de la celda
    let nick;
    let game_id;
    if (select && select.selectedIndex>=0) {
        nick = select.options[select.selectedIndex].text;  // Obtiene el valor seleccionado
    }
    select = list.cells[0].querySelector("select");
    if (select && select.selectedIndex>=0) {
        game_id = select.options[select.selectedIndex].text;  // Obtiene el valor seleccionado
    }

    const response = await axios.get(`http://localhost:8000/persons?nick=${nick}`);
    const user_id = response.data.id;

    const obj = {
        person_id:user_id,
        game_id:game_id,
        game_points:stringToNumber(list.cells[2].innerText),
        mvp_points:stringToNumber(list.cells[3].innerText),
        damage_points:stringToNumber(list.cells[4].innerText),
        quantity_points:stringToNumber(list.cells[5].innerText),
    }

    axios.post('http://localhost:8000/points',JSON.stringify(obj)).then((response)=>{
        generatePersonGameList();
    }).catch(error => console.error("Error al cargar datos:", error));


}