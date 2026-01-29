import './bootstrap';

function clamp(value, min, max) {
    return Math.min(max, Math.max(min, value));
}

function getRingColor(score) {
    if (score >= 75) return '#16a34a'; // green-600
    if (score >= 50) return '#eab308'; // yellow-500
    return '#ef4444'; // red-500
}

function initScoreRings(root = document) {
    const rings = root.querySelectorAll('[data-score-ring]');

    rings.forEach((ring) => {
        const ratingAttr = ring.getAttribute('data-rating');
        const rating = Number.parseFloat(ratingAttr ?? '0');
        const score = Number.isFinite(rating) ? clamp(rating, 0, 100) : 0;
        const progress = clamp(score / 100, 0, 1);

        const progressCircle = ring.querySelector('[data-score-ring-progress]');
        const textEl = ring.querySelector('[data-score-ring-text]');

        if (!progressCircle || !textEl) return;

        const r = Number.parseFloat(progressCircle.getAttribute('r') ?? '0');
        if (!Number.isFinite(r) || r <= 0) return;

        const circumference = 2 * Math.PI * r;

        progressCircle.style.stroke = getRingColor(score);
        progressCircle.style.strokeDasharray = `${circumference}`;
        progressCircle.style.strokeDashoffset = `${circumference}`;
        progressCircle.style.transition = 'stroke-dashoffset 1400ms ease-in-out';

        // Ensure a clean restart if Livewire navigates back to this page.
        // eslint-disable-next-line no-unused-expressions
        progressCircle.getBoundingClientRect();

        progressCircle.style.strokeDashoffset = `${circumference * (1 - progress)}`;

        const durationMs = 1400;
        const start = performance.now();
        const endValue = Math.round(score);

        const tick = (now) => {
            const t = clamp((now - start) / durationMs, 0, 1);
            const value = Math.round(endValue * t);
            textEl.textContent = value === 0 ? '' : String(value);

            if (t < 1) requestAnimationFrame(tick);
        };

        requestAnimationFrame(tick);
    });
}

document.addEventListener('DOMContentLoaded', () => initScoreRings());
document.addEventListener('livewire:navigated', () => initScoreRings());


