<script>
    // Inicializar tooltips de Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // Envío por WhatsApp (solo para los PDFs reales)
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('enviarWhatsapp')) {
            const url = e.target.value;
            if (url) {
                window.open(url, '_blank');
                e.target.selectedIndex = 0;
            }
        }
    });
</script>