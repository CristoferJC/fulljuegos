document.addEventListener('DOMContentLoaded', function() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        question.addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            
            // Cerrar todas las respuestas abiertas
            faqItems.forEach(otherItem => {
                otherItem.classList.remove('active');
            });
            
            // Abrir/cerrar la respuesta actual
            if (!isActive) {
                item.classList.add('active');
            }
        });
    });
});