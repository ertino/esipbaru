/*
 |--------------------------------------------------------------------------
 | Light / dark theme toggle
 |--------------------------------------------------------------------------
 |
 | Bootstrap 5.3 (bundled inside AdminLTE 4) switches the whole palette with
 | the data-bs-theme attribute on <html>, so no extra theme stylesheet is
 | needed. This file only wires up the button that lives in the navbar
 | (layouts/adminlte4/back_header).
 |
 | The first paint is handled by the inline snippet in
 | layouts/adminlte4/back_core, which reads the stored value before the
 | stylesheets are applied. That way a user who picked dark mode never sees a
 | white flash while this deferred script loads.
 |
 | The choice is stored in localStorage under "sipbaru-theme". When nothing
 | has been stored yet the operating system preference is used, and every
 | open tab is kept in sync through the storage event.
 |
 */
(function (window, document) {
    'use strict';

    var STORAGE_KEY = 'sipbaru-theme';
    var DARK = 'dark';
    var LIGHT = 'light';

    function readStored() {
        try {
            return window.localStorage.getItem(STORAGE_KEY);
        } catch (error) {
            /* Private mode / blocked storage: fall back to the OS preference. */
            return null;
        }
    }

    function writeStored(theme) {
        try {
            window.localStorage.setItem(STORAGE_KEY, theme);
        } catch (error) {
            /* Nothing to persist; the attribute on <html> still changes. */
        }
    }

    function prefersDark() {
        return !!(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
    }

    /**
     * The theme currently applied to the document. The inline snippet in the
     * layout already resolved it, so the attribute is the single source of
     * truth here.
     */
    function currentTheme() {
        return document.documentElement.getAttribute('data-bs-theme') === DARK ? DARK : LIGHT;
    }

    /**
     * Keep every toggle button in step with the applied theme. The label is
     * the action the button performs ("Aktifkan mode gelap" / "Aktifkan mode
     * terang") and comes from the Blade markup, so it stays translatable.
     */
    function syncButtons(theme) {
        var isDark = theme === DARK;
        var buttons = document.querySelectorAll('[data-theme-toggle]');

        Array.prototype.forEach.call(buttons, function (button) {
            var label = button.getAttribute(isDark ? 'data-label-light' : 'data-label-dark');

            button.setAttribute('aria-pressed', isDark ? 'true' : 'false');

            if (label) {
                button.setAttribute('title', label);
                button.setAttribute('aria-label', label);
            }
        });
    }

    function applyTheme(theme, persist) {
        document.documentElement.setAttribute('data-bs-theme', theme);

        if (persist) {
            writeStored(theme);
        }

        syncButtons(theme);

        /**
         * Charts and DataTables redraw their own colours, so they can listen
         * for this event instead of polling the attribute.
         */
        document.dispatchEvent(new window.CustomEvent('themechange', { detail: { theme: theme } }));
    }

    document.addEventListener('click', function (event) {
        var target = event.target;

        if (!target || typeof target.closest !== 'function') {
            return;
        }

        var button = target.closest('[data-theme-toggle]');

        if (!button) {
            return;
        }

        event.preventDefault();
        applyTheme(currentTheme() === DARK ? LIGHT : DARK, true);
    });

    /**
     * Another tab changed the theme: follow it without writing the value back.
     */
    window.addEventListener('storage', function (event) {
        if (event.key !== STORAGE_KEY) {
            return;
        }

        applyTheme(event.newValue === DARK ? DARK : LIGHT, false);
    });

    /**
     * Follow the OS while the user has not picked a theme explicitly.
     */
    if (window.matchMedia) {
        var query = window.matchMedia('(prefers-color-scheme: dark)');
        var onSystemChange = function (event) {
            if (readStored() === null) {
                applyTheme(event.matches ? DARK : LIGHT, false);
            }
        };

        if (typeof query.addEventListener === 'function') {
            query.addEventListener('change', onSystemChange);
        } else if (typeof query.addListener === 'function') {
            query.addListener(onSystemChange);
        }
    }

    function init() {
        applyTheme(currentTheme(), false);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})(window, document);
