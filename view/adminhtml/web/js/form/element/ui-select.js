define([
    'Magento_Ui/js/form/element/ui-select'
], function (Select) {
    'use strict';

    return Select.extend({
        defaults: {
            searchTimeout: 0,
        },

        initialize: function () {
            this._super();
            return this;
        },

        /**
         * Filtered options list by value from filter options list
         */
        filterOptionsList: function () {
            if (this.searchTimeout !== 0) {
                clearTimeout(this.searchTimeout);
            }
            var self = this;
            this.searchTimeout = setTimeout(function () {
                self.searchTimeout = 0;
                var value = self.filterInputValue().trim().toLowerCase(),
                    array = [];

                if (self.searchOptions) {
                    return self.loadOptions(value);
                }

                self.cleanHoveredElement();

                if (!value) {
                    self.renderPath = false;
                    self.options(self.cacheOptions.tree);
                    self._setItemsQuantity(false);

                    return false;
                }

                self.showPath ? self.renderPath = true : false;

                if (self.filterInputValue()) {

                    array = self.selectType === 'optgroup' ?
                        self._getFilteredArray(self.cacheOptions.lastOptions, value) :
                        self._getFilteredArray(self.cacheOptions.plain, value);

                    if (!value.length) {
                        self.options(self.cacheOptions.plain);
                        self._setItemsQuantity(self.cacheOptions.plain.length);
                    } else {
                        self.options(array);
                        self._setItemsQuantity(array.length);
                    }

                    return false;
                }

                self.options(self.cacheOptions.plain);
            }, 1000);
        }
    });
});
