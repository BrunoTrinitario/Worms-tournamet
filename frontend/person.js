import { deleteButtons,deleteDivs, generateMainButtons } from "./utilities.js";

function loadPersonButton(){
    deleteButtons();
    button_container.innerHTML = `<button onclick=generatePersonList()>Listar personas</button><button onclick="generateMainButtons()"><-</button>`;
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