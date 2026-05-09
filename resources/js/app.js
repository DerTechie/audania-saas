import { init as initHeroSlotMachine } from './marketing/hero-slot-machine.js';

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeroSlotMachine);
} else {
    initHeroSlotMachine();
}