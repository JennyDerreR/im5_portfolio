console.log('hoi js')

// Fotogalerie mit Grossansicht
document.addEventListener('DOMContentLoaded', () => {
    const gallery  = document.querySelector('[data-gallery]');
    const lightbox = document.querySelector('.lightbox');

    if (!gallery || !lightbox) return;   // Seite ohne Galerie: nichts tun

    const photos = [...gallery.querySelectorAll('img')];
    const image  = lightbox.querySelector('.lightbox-img');
    const count  = lightbox.querySelector('.lightbox-count');
    let current  = 0;

    const show = (index) => {
        current = (index + photos.length) % photos.length;   // nach dem letzten Foto kommt wieder das erste
        image.src = photos[current].src;
        image.alt = photos[current].alt;
        count.textContent = `${current + 1} / ${photos.length}`;
    };

    gallery.addEventListener('click', (event) => {
        const item = event.target.closest('.gallery-item');
        if (!item) return;
        show(Number(item.dataset.index));
        lightbox.showModal();
    });

    lightbox.querySelector('.lightbox-prev').addEventListener('click', () => show(current - 1));
    lightbox.querySelector('.lightbox-next').addEventListener('click', () => show(current + 1));
    lightbox.querySelector('.lightbox-close').addEventListener('click', () => lightbox.close());

    // Klick auf den dunklen Hintergrund schliesst die Ansicht
    lightbox.addEventListener('click', (event) => {
        if (event.target === lightbox) lightbox.close();
    });

    // Pfeiltasten blättern, Esc schliesst von selbst
    lightbox.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft')  show(current - 1);
        if (event.key === 'ArrowRight') show(current + 1);
    });
});