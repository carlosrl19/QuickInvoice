function carouselLoanPaymentsViewer(event, loanId) {
    const files = event.target.files;
    const previewContainer = document.getElementById('image-preview-container');
    previewContainer.innerHTML = '';

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = function (e) {
            const imgContainer = document.createElement('div');
            imgContainer.classList.add('image-preview');

            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Vista previa';
            img.style.width = '100px';
            img.style.height = '100px';
            img.style.objectFit = 'cover';
            img.style.borderRadius = '4px';

            const deleteButton = document.createElement('span');
            deleteButton.textContent = '×';
            deleteButton.classList.add('delete-button');
            deleteButton.style.display = 'none';

            deleteButton.onclick = function () {
                // Eliminar la imagen de la vista previa
                imgContainer.remove();

                // Eliminar la imagen del input file
                const fileInput = document.getElementById('loan_payment_img');
                const dt = new DataTransfer();
                const filesArray = Array.from(fileInput.files);

                // Buscar el índice de la imagen a eliminar
                const index = filesArray.findIndex(f => f.name === file.name);

                if (index !== -1) {
                    filesArray.splice(index, 1);
                    filesArray.forEach(file => dt.items.add(file));
                    fileInput.files = dt.files;
                }
            };

            imgContainer.appendChild(img);
            imgContainer.appendChild(deleteButton);

            imgContainer.onmouseover = function () {
                deleteButton.style.display = 'block';
            };

            imgContainer.onmouseout = function () {
                deleteButton.style.display = 'none';
            };

            previewContainer.appendChild(imgContainer);
        };

        reader.readAsDataURL(file);
    }
}