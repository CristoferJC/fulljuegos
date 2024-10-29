// Para la búsqueda en tiempo real
document.getElementById('searchInput').addEventListener('input', function() {
    const searchInput = this.value.toLowerCase();
    const gameCards = document.querySelectorAll('.game-card');
    const resultadosContainer = document.getElementById('resultados-busqueda');
    
    resultadosContainer.innerHTML = '';
    
    // Si el campo de búsqueda está vacío  oculta los resultados
    if (searchInput === '') {
        resultadosContainer.style.display = 'none';
        return;
    }
    
    let encontrado = false;
    gameCards.forEach(card => {
        const titulo = card.querySelector('h3').textContent.toLowerCase();
        // Si encuentra coincidencia, crea y muestra un resultado compacto
        if (titulo.includes(searchInput)) {
            encontrado = true;
            const resultado = crearResultadoCompacto(card);
            resultadosContainer.appendChild(resultado);
        }
    });
    
    // Muestra mensaje si no hay resultados
    if (!encontrado) {
        resultadosContainer.innerHTML = '<p class="no-resultados">No se encontraron juegos que coincidan con tu búsqueda.</p>';
    }
    
    resultadosContainer.style.display = 'block';
});

// Función que crea una versión compacta de la tarjeta de juego para mostrar en resultados
function crearResultadoCompacto(gameCard) {
    const resultado = document.createElement('div');
    resultado.className = 'resultado-juego';
    
    const imagen = gameCard.querySelector('img').cloneNode(true);
    const titulo = gameCard.querySelector('h3').textContent;
    const precio = gameCard.querySelector('.game-price').textContent;
    resultado.innerHTML = `
        <img src="${imagen.src}" alt="${titulo}">
        <div class="resultado-info">
            <h4>${titulo}</h4>
            <p class="resultado-precio">${precio}</p>
            <a href="comprar.html" class="resultado-comprar">Comprar</a>
        </div>
    `;
    
    return resultado;
}