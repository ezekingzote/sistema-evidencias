<script>
    // Manejo seguro del click para abrir SweetAlert2 sin romper comillas HTML
    document.querySelectorAll('.btn-preview-pdf').forEach(btn => {
        btn.addEventListener('click', function() {
            const pdfUrl = this.getAttribute('data-url');
            const pdfName = this.getAttribute('data-name');

            Swal.fire({
                title: `<span class="fs-5 text-dark fw-bold text-truncate d-block px-3">${pdfName}</span>`,
                html: `
                    <div style="width: 100%; height: 72vh; overflow: hidden; border-radius: 8px; border: 1px solid #dee2e6;">
                        <iframe src="${pdfUrl}#toolbar=1" width="100%" height="100%" style="border: none;"></iframe>
                    </div>
                `,
                width: '85%',
                showCloseButton: true,
                showConfirmButton: false,
                focusConfirm: false,
                customClass: {
                    popup: 'rounded-4 shadow-lg'
                }
            });
        });
    });
    document.querySelectorAll('.folder-link').forEach(folder => {
        folder.addEventListener('click', function() {
            window.location.href = this.getAttribute('data-url');
        });
    });
</script>