// -> Hobbies-Collage: Polaroids mit der Maus verschieben, per Klick umdrehen (am Handy nur umdrehen)
function initCollage () {
    const canDrag = () => window.matchMedia('(hover: hover) and (pointer: fine) and (min-width: 769px)').matches;

    document.querySelectorAll('[data-module="hobbies"] .collage').forEach((board) => {
        let z = 10;

        board.querySelectorAll('.polaroid').forEach((card) => {
            let startX, startY, startLeft, startTop;
            let down = false;
            let moved = false;

            card.addEventListener('pointerdown', (e) => {
                if (!canDrag() || e.button !== 0) return;
                down = true;
                moved = false;
                startX = e.clientX;
                startY = e.clientY;
                startLeft = card.offsetLeft;
                startTop = card.offsetTop;
                card.setPointerCapture(e.pointerId);
                card.style.zIndex = ++z;
            });

            card.addEventListener('pointermove', (e) => {
                if (!down) return;
                const dx = e.clientX - startX;
                const dy = e.clientY - startY;
                if (!moved && Math.abs(dx) + Math.abs(dy) < 5) return;
                moved = true;
                card.classList.add('is-dragging');
                const maxLeft = board.clientWidth - card.offsetWidth;
                const maxTop = board.clientHeight - card.offsetHeight;
                card.style.left = Math.max(0, Math.min(maxLeft, startLeft + dx)) + 'px';
                card.style.top = Math.max(0, Math.min(maxTop, startTop + dy)) + 'px';
            });

            const stop = () => {
                down = false;
                card.classList.remove('is-dragging');
            };
            card.addEventListener('pointerup', stop);
            card.addEventListener('pointercancel', stop);

            // Klick (auch Enter/Leertaste) dreht um, aber nicht direkt nach dem Verschieben
            card.addEventListener('click', () => {
                if (moved) {
                    moved = false;
                    return;
                }
                const flipped = card.classList.toggle('is-flipped');
                card.setAttribute('aria-pressed', flipped ? 'true' : 'false');
            });
        });
    });
}

// -> Bildungsweg: gekritzelte Linie, die sich beim Scrollen zeichnet, mit Kringel bei jeder Station
function initSketchPath () {
    const NS = 'http://www.w3.org/2000/svg';
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isMobile = () => window.matchMedia('(max-width: 768px)').matches;

    document.querySelectorAll('[data-module="education"] .sketch-path').forEach((wrap) => {
        const svg = wrap.querySelector('.sketch-svg');
        const items = [...wrap.querySelectorAll('.sketch-item')];
        if (!svg || !items.length) return;

        let line = null;
        let rings = [];
        let stops = [];

        const addPath = (d, className) => {
            const p = document.createElementNS(NS, 'path');
            p.setAttribute('d', d);
            p.setAttribute('class', className);
            p.setAttribute('pathLength', '1');
            svg.appendChild(p);
            return p;
        };

        // leicht schiefer, nicht ganz geschlossener Kringel wie von Hand
        const ring = (x, y) =>
            `M ${x - 10} ${y - 4} C ${x - 11} ${y - 15}, ${x + 12} ${y - 15}, ${x + 12} ${y + 1} ` +
            `C ${x + 12} ${y + 16}, ${x - 12} ${y + 16}, ${x - 11} ${y + 1} ` +
            `C ${x - 10} ${y - 8}, ${x + 4} ${y - 11}, ${x + 10} ${y - 5}`;

        const build = () => {
            const w = wrap.clientWidth;
            const h = wrap.clientHeight;
            const mobile = isMobile();
            const x = mobile ? 12 : w / 2;       // Linie links am Handy, sonst in der Mitte
            const amp = mobile ? 8 : 40;          // wie stark die Linie wackelt

            svg.setAttribute('viewBox', `0 0 ${w} ${h}`);
            svg.innerHTML = '';

            // Punkt jeder Station auf Höhe der Jahreszahl
            const points = items.map((item) => {
                const years = item.querySelector('.sketch-years');
                return item.offsetTop + (years ? years.offsetHeight / 2 : 12);
            });
            const end = Math.min(h, points[points.length - 1] + 60);

            // Linie startet beim ersten Kringel
            let d = `M ${x} ${points[0]}`;
            let prevY = points[0];
            [...points.slice(1), end].forEach((y, i) => {
                const dy = y - prevY;
                const s = i % 2 ? 1 : -1;
                d += ` C ${x + amp * s} ${prevY + dy * 0.33}, ${x - amp * s} ${prevY + dy * 0.66}, ${x} ${y}`;
                prevY = y;
            });

            line = addPath(d, 'sketch-line');
            rings = points.map((y) => addPath(ring(x, y), 'sketch-ring'));
            stops = points.map((y) => (y - points[0]) / (end - points[0]));
            update();
        };

        const update = () => {
            if (!line) return;
            const rect = wrap.getBoundingClientRect();
            const start = window.innerHeight * 0.8;   // Linie startet, wenn der Block 80 % der Bildschirmhöhe erreicht
            const raw = reduceMotion ? 1 : (start - rect.top) / (rect.height * 0.9);
            const progress = Math.max(0, Math.min(1, raw));

            line.style.strokeDashoffset = 1 - progress;
            items.forEach((item, i) => {
                const reached = raw >= stops[i];
                item.classList.toggle('is-reached', reached);
                rings[i].classList.toggle('is-reached', reached);
            });
        };

        wrap.classList.add('is-animated');
        build();

        let ticking = false;
        window.addEventListener('scroll', () => {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(() => {
                update();
                ticking = false;
            });
        }, { passive: true });
        window.addEventListener('resize', build);
        if (document.fonts) document.fonts.ready.then(build);   // Höhen ändern sich, sobald Lora geladen ist
    });
}

// -> beide starten, sobald die Seite geladen ist
function initAboutPage () {
    initCollage();
    initSketchPath();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAboutPage);
} else {
    initAboutPage();
}

// -> Arbeiten: nach Kategorie filtern, Auswahl steht in der Adresse (z. B. /arbeiten/#film)
function initProjectFilter () {
    document.querySelectorAll('[data-module="all_projects"]').forEach((module) => {
        const pills = [...module.querySelectorAll('.filter-pill')];
        const groups = [...module.querySelectorAll('.category')];
        if (!pills.length) return;

        const show = (filter, updateHash) => {
            // unbekannte Kategorie in der Adresse -> alle zeigen
            if (!pills.some((pill) => pill.dataset.filter === filter)) filter = 'alle';

            pills.forEach((pill) => pill.setAttribute('aria-pressed', pill.dataset.filter === filter ? 'true' : 'false'));
            groups.forEach((group) => {
                group.hidden = filter !== 'alle' && group.dataset.category !== filter;
            });

            if (updateHash) {
                const url = filter === 'alle' ? location.pathname + location.search : '#' + filter;
                history.replaceState(null, '', url);   // ohne Springen und ohne neuen Verlaufseintrag
            }
        };

        pills.forEach((pill) => pill.addEventListener('click', () => show(pill.dataset.filter, true)));

        show(decodeURIComponent(location.hash.slice(1)) || 'alle', false);
        window.addEventListener('hashchange', () => show(decodeURIComponent(location.hash.slice(1)) || 'alle', false));
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initProjectFilter);
} else {
    initProjectFilter();
}