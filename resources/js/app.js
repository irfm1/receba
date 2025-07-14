import './pwa.js';

// Mobile-first enhancements
document.addEventListener('DOMContentLoaded', function() {
    // Prevent iOS bounce effect
    document.addEventListener('touchmove', function(e) {
        if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
        }
    }, { passive: false });
    
    // Handle keyboard on mobile
    if (window.innerWidth <= 768) {
        const inputs = document.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                document.body.classList.add('keyboard-open');
            });
            
            input.addEventListener('blur', function() {
                document.body.classList.remove('keyboard-open');
            });
        });
    }
    
    // Handle form validation feedback
    document.addEventListener('livewire:init', function() {
        if (window.Livewire) {
            window.Livewire.on('form-submitted', function() {
                if (window.RecebaPWA) {
                    window.RecebaPWA.showNotification('Salvo', 'Dados salvos com sucesso!', 'success');
                }
            });
            
            window.Livewire.on('form-error', function(message) {
                if (window.RecebaPWA) {
                    window.RecebaPWA.showNotification('Erro', message, 'error');
                }
            });
            
            // Handle system notifications
            window.Livewire.on('notification', function(data) {
                if (window.RecebaPWA) {
                    window.RecebaPWA.showNotification(
                        data.type === 'success' ? 'Sucesso' : 
                        data.type === 'error' ? 'Erro' : 
                        data.type === 'warning' ? 'Aviso' : 'Informação',
                        data.message,
                        data.type
                    );
                }
            });
        }
    });
});