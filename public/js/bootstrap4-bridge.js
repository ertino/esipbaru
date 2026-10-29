/*
 |--------------------------------------------------------------------------
 | Bootstrap 4 -> Bootstrap 5 bridge (jQuery)
 |--------------------------------------------------------------------------
 |
 | The application was written against the jQuery plugin API that shipped with
 | Bootstrap 4 ($.fn.modal, $.fn.tooltip) and against the data-toggle /
 | data-target attribute names. Bootstrap 5 removed both, so this file
 | restores the two calls the Blade views and the shared footer still use:
 |
 |     $('#myModal').modal('show' | 'hide' | 'toggle')
 |     $('[data-bs-toggle="tooltip"]').tooltip()
 |     $('.hasilscaning').tooltip('hide')
 |
 | The markup itself is migrated to the data-bs-* attributes, so no other
 | Bootstrap 4 shim is needed. This file has to be loaded after jQuery and
 | after bootstrap.bundle (see layouts/adminlte4/back_corejs).
 |
 */
(function (window, document) {
    'use strict';

    var $ = window.jQuery;
    var bootstrap = window.bootstrap;

    if (!$ || !bootstrap) {
        return;
    }

    function getInstance(widgetName, element) {
        var Widget = bootstrap[widgetName];

        if (!Widget || !element) {
            return null;
        }

        return Widget.getOrCreateInstance
            ? Widget.getOrCreateInstance(element)
            : new Widget(element);
    }

    /**
     * $.fn.modal('show') / $.fn.modal('hide') / $.fn.modal('toggle')
     * $.fn.modal({ backdrop: 'static' }) creates the instance with options.
     */
    if (bootstrap.Modal && !$.fn.modal) {
        $.fn.modal = function (option) {
            var command = typeof option === 'string' ? option : 'toggle';

            return this.each(function () {
                var modal = getInstance('Modal', this);

                if (!modal) {
                    return;
                }

                if (command === 'dispose') {
                    modal.dispose();

                    return;
                }

                if (typeof modal[command] === 'function') {
                    modal[command]();
                }
            });
        };
    }

    /**
     * $.fn.tooltip() / $.fn.tooltip('show' | 'hide' | 'dispose')
     */
    if (bootstrap.Tooltip && !$.fn.tooltip) {
        $.fn.tooltip = function (option) {
            var command = typeof option === 'string' ? option : null;

            return this.each(function () {
                var tooltip = getInstance('Tooltip', this);

                if (!tooltip) {
                    return;
                }

                if (command === 'dispose') {
                    tooltip.dispose();

                    return;
                }

                if (command && typeof tooltip[command] === 'function') {
                    tooltip[command]();
                }
            });
        };
    }

    /**
     * Bootstrap 5 dispatches native events whose type literally contains a dot
     * ("shown.bs.tooltip"). jQuery reads everything after the first dot as a
     * namespace, so a handler bound with .on('shown.bs.tooltip') listens for
     * the type "shown" and would never fire. Re-emit the native event through
     * jQuery's own dispatcher, keeping the base type and the namespace apart.
     */
    var EVENTS = ['show', 'shown', 'hide', 'hidden', 'inserted', 'close', 'closed', 'slide', 'slid'];
    var WIDGETS = ['modal', 'tooltip', 'popover', 'dropdown', 'tab', 'collapse', 'alert', 'carousel', 'offcanvas', 'toast'];

    EVENTS.forEach(function (event) {
        WIDGETS.forEach(function (widget) {
            document.addEventListener(event + '.bs.' + widget, function (nativeEvent) {
                var element = nativeEvent.target;

                if (!element || element.nodeType !== 1) {
                    return;
                }

                var synthetic = $.Event(event);
                synthetic.namespace = 'bs.' + widget;
                synthetic.nativeEvent = nativeEvent;

                $(element).trigger(synthetic);
            });
        });
    });

    /**
     * Bootstrap 5 does not initialise tooltips and popovers on its own.
     */
    $(function () {
        $('[data-bs-toggle="tooltip"]').each(function () {
            getInstance('Tooltip', this);
        });

        $('[data-bs-toggle="popover"]').each(function () {
            getInstance('Popover', this);
        });
    });
})(window, document);
