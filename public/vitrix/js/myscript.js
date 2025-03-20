const basePath = window.location.origin + '/vitrix/img/tetris/';

const tetrisImages = [
    basePath + 'a.png',
    basePath + 'a.png',
    basePath + 'b.png',
    basePath + 'c.png',
    basePath + 'd.png',
    basePath + 'e.png',
    basePath + 'f.png',
    basePath + 'f.png'
];

const button = document.getElementById('tetrisButton');


// Función para cambiar la imagen del botón según el desplazamiento
window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY;
    const scrollPercent = scrollTop / (document.body.scrollHeight - window.innerHeight);
    let imageIndex = Math.floor(scrollPercent * tetrisImages.length);

    // Asegurar que imageIndex no exceda el tamaño del array
    imageIndex = Math.min(imageIndex, tetrisImages.length - 1);

    button.style.backgroundImage = `url(${tetrisImages[imageIndex]})`;
});

button.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Desplazamiento suave al inicio
    });
});