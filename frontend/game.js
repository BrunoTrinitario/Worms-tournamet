import {main_container, button_container} from '/frontend/script.js';

export function loadGamesButton(){
    deleteButtons();
    button_container.innerHTML = `<button onclick=generateGameList()>Listar partidas</button><button onclick="generateMainButtons()"><-</button>`;
}

export function generateGameList(){
    deleteDivs();
    const table = createTable();
    table.innerHTML = `<thead><tr><th>ID</th><th>Fecha</th><th>Descripcion</th><th>Eliminar</th></tr></thead><tbody></tbody>`
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
            
                let btnEliminar = document.createElement("button");
                btnEliminar.textContent = "Eliminar";
                btnEliminar.className = "full-cell-button"
                btnEliminar.onclick = function() {
                     delGame(this.closest("tr"));
                };
                fila.insertCell(3).appendChild(btnEliminar);

                fila.cells[3].className = "cell"
            });
            fila = tabla.insertRow();
            fila.insertCell(0).contentEditable="false";
            fila.insertCell(1).contentEditable="true";
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
            fila.insertCell(3).appendChild(btnAniadir);
            fila.cells[3].className = "cell";
        })
        .catch(error => console.error("Error al cargar datos:", error));
}

export function delGame(fila){
    const id = fila.cells[0].innerText;
    axios.delete('http://localhost:8000/games?id='+id)
        .then(response => {
            generateGameList();
        })
        .catch(error => console.error("Error al cargar datos:", error));
}