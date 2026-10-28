/**
 * Application JavaScript (Vite entry).
 *
 * Replaces the Laravel Mix/CommonJS bundle from ijinnakes
 * (`require('./bootstrap'); require('alpinejs');`). Bootstrap 5 and AdminLTE 4
 * are imported here instead of being pulled from a CDN, and Alpine is started
 * the same way the old `require('alpinejs')` call did.
 */

import './bootstrap';

import * as bootstrap from 'bootstrap';
import 'admin-lte';
import Alpine from 'alpinejs';

window.bootstrap = bootstrap;
window.Alpine = Alpine;

Alpine.start();