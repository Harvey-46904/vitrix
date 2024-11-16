const tetrisImages = [
    '../vitrix/img/tetris/a.png',
    '../vitrix/img/tetris/a.png', // Cambia estos nombres a las rutas de tus imágenes
    '../vitrix/img/tetris/b.png',
    '../vitrix/img/tetris/c.png',
    '../vitrix/img/tetris/d.png',
    '../vitrix/img/tetris/e.png',
    '../vitrix/img/tetris/f.png',
    '../vitrix/img/tetris/f.png'
];

const button = document.getElementById('tetrisButton');


// Función para cambiar la imagen del botón según el desplazamiento
window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY;
    const scrollPercent = scrollTop / (document.body.scrollHeight - window.innerHeight);
    const imageIndex = Math.floor(scrollPercent * tetrisImages.length);
console.log(`url(${tetrisImages[imageIndex]})`);

    button.style.backgroundImage = `url(${tetrisImages[imageIndex]})`;
});

button.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Desplazamiento suave al inicio
    });
});