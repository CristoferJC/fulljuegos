// Para la búsqueda en tiempo real
document.getElementById('searchInput').addEventListener('keyup', function() {
    let searchText = this.value.toLowerCase();
    let gameRows = document.getElementsByClassName('game-row');
    
    for (let row of gameRows) {
        let gameName = row.getElementsByClassName('game-name')[0].textContent.toLowerCase();
        // Comprueba si el nombre del juego contiene el texto de búsqueda
        if (gameName.includes(searchText)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
});