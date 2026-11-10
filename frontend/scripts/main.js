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

    // Audio-Player
    document.addEventListener('DOMContentLoaded', () => {
        const player = document.querySelector('[data-audio]');
        if (!player) return;   // Seite ohne Audio: nichts tun

        const audio    = player.querySelector('audio');
        const seek     = player.querySelector('.audio-seek');
        const current  = player.querySelector('.audio-current');
        const duration = player.querySelector('.audio-duration');
        const toggle   = player.querySelector('.audio-toggle');
        const speedVal = player.querySelector('.audio-speed-value');
        const speeds   = [0.5, 0.75, 1, 1.25, 1.5, 2];
        let speedIdx   = 2;   // 1.0x

        const format = (s) => {
            if (!isFinite(s)) return '00:00';
            const m = Math.floor(s / 60);
            const r = Math.floor(s % 60);
            return String(m).padStart(2, '0') + ':' + String(r).padStart(2, '0');
        };

        const paint = () => {
            const pct = audio.duration ? (audio.currentTime / audio.duration) * 100 : 0;
            seek.value = pct;
            seek.style.setProperty('--progress', pct + '%');
            current.textContent = format(audio.currentTime);
        };

        audio.addEventListener('loadedmetadata', () => {
            duration.textContent = format(audio.duration);
            paint();
        });
        audio.addEventListener('timeupdate', paint);
        audio.addEventListener('play', () => {
            player.classList.add('is-playing');
            toggle.setAttribute('aria-label', 'Pausieren');
        });
        audio.addEventListener('pause', () => {
            player.classList.remove('is-playing');
            toggle.setAttribute('aria-label', 'Abspielen');
        });

        toggle.addEventListener('click', () => (audio.paused ? audio.play() : audio.pause()));

        player.querySelector('.audio-back').addEventListener('click', () => {
            audio.currentTime = Math.max(0, audio.currentTime - 10);
        });
        player.querySelector('.audio-forward').addEventListener('click', () => {
            if (!audio.duration) return;
            audio.currentTime = Math.min(audio.duration, audio.currentTime + 10);
        });

        seek.addEventListener('input', () => {
            if (audio.duration) audio.currentTime = (seek.value / 100) * audio.duration;
            seek.style.setProperty('--progress', seek.value + '%');
        });

        const setSpeed = (index) => {
            speedIdx = Math.min(speeds.length - 1, Math.max(0, index));
            const value = speeds[speedIdx];
            audio.playbackRate = value;
            speedVal.textContent = (Number.isInteger(value) ? value.toFixed(1) : value) + 'x';
        };

        player.querySelector('.audio-speed-down').addEventListener('click', () => setSpeed(speedIdx - 1));
        player.querySelector('.audio-speed-up').addEventListener('click', () => setSpeed(speedIdx + 1));
    });
});