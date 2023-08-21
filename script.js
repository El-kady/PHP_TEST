const imageInput = document.getElementById('userImage');
const thumbnailContainer = document.getElementById('thumbnail');

imageInput.addEventListener('change', handleImageUpload);

function handleImageUpload(event) {
    const file = event.target.files[0];

    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();

        reader.onload = function () {
            const image = new Image();
            image.src = reader.result;
            image.onload = function () {
                const thumbnail = document.createElement('img');
                thumbnail.src = image.src;
                thumbnail.classList.add('thumbnail');
                thumbnailContainer.innerHTML = '';
                thumbnailContainer.appendChild(thumbnail);
            };
        };

        reader.readAsDataURL(file);
    } else {
        alert('Please select a valid image file.');
    }
}
