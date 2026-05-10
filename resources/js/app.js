import { init as initHeroSlotMachine } from './marketing/hero-slot-machine.js';
import { init as initThreeJourneys } from './marketing/three-journeys.js';

function bootMarketing() {
    initHeroSlotMachine();
    initThreeJourneys();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootMarketing);
} else {
    bootMarketing();
}