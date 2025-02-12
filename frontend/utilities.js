export const main_container = document.getElementById("main_container");
export const button_container = document.getElementById("button-container");

export function deleteDivs(){
    main_container.innerHTML="";

}

export function deleteButtons(){
    button_container.innerHTML="";
}

export function generateMainButtons(){
    deleteDivs();
    deleteButtons();
    button_container.innerHTML = `<button onclick="LoadUsersData()">Resumen de juego</button>
        <button onclick="loadPersonButton()">Personas</button>
        <button onclick="loadGamesButton()">Partidas</button>
        <button onclick="loadPersonGamesButton()">Personas y partidas</button>`;
}

export function stringToNumber(cellString){
    if (cellString==""){
        return 0;
    }else{
        numero = Number(cellString);
        if (isNaN(numero)){
            return 0;
        }else
            return numero;
    }
}