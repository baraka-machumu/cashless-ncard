$(function() {
    "use strict";

    // typehead

    $.typeahead({
        input: '.js-typeahead-country_v2',
        minLength: 1,
        maxItem: 2,
        order: "asc",
        source: {
            country: {
                ajax: {
                    url: 'http://localhost/cashless/api/merchant-search',
    path: "data.country"
}
},
    capital: {
        ajax: {
            type: "POST",
                url: 'http://localhost/cashless/api/merchant-search',
            path: "data.capital",
                data: {myKey: "myValue"}
        }
    }
},

});















});