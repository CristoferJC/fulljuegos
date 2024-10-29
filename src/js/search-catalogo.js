// Para la búsqueda en tiempo real
document.getElementById('searchInput').addEventListener('input', function() {
    const searchInput = this.value.toLowerCase();
    const juegoCards = document.querySelectorAll('.juego-card');
    const resultadosContainer = document.getElementById('resultados-busqueda');
    
    resultadosContainer.innerHTML = '';
    
    if (searchInput === '') {
        resultadosContainer.style.display = 'none';
        return;
    }
    
    let encontrado = false;
    
    juegoCards.forEach(card => {
        const titulo = card.querySelector('h3').textContent.toLowerCase();
        if (titulo.includes(searchInput)) {
            encontrado = true;
            const resultado = crearResultadoCompacto(card);
            resultadosContainer.appendChild(resultado);
        }
    });
    
    if (!encontrado) {
        resultadosContainer.innerHTML = '<p class="no-resultados">No se encontraron juegos que coincidan con tu búsqueda.</p>';
    }
    
    resultadosContainer.style.display = 'block';
});

// Crea una versión compacta de la tarjeta del juego para mostrar en resultados
function crearResultadoCompacto(juegoCard) {
    const resultado = document.createElement('div');
    resultado.className = 'resultado-juego';
    
    const imagen = juegoCard.querySelector('img').cloneNode(true);
    const titulo = juegoCard.querySelector('h3').textContent;
    const precio = juegoCard.querySelector('.precio').textContent;
    
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