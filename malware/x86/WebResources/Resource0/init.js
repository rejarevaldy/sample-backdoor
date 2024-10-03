// __Consolidated JS loaded before app.__

/*************************************************************************
* ADOBE CONFIDENTIAL
* ___________________
*
*  Copyright 2014 Adobe Systems Incorporated
*  All Rights Reserved.
*
* NOTICE:  All information contained herein is, and remains
* the property of Adobe Systems Incorporated and its suppliers,
* if any.  The intellectual and technical concepts contained
* herein are proprietary to Adobe Systems Incorporated and its
* suppliers and are protected by all applicable intellectual property laws,
* including trade secret and or copyright laws.
* Dissemination of this information or reproduction of this material
* is strictly forbidden unless prior written permission is obtained
* from Adobe Systems Incorporated.
**************************************************************************/

// `JSLint` directives.
/*global window */
/*jslint devel: true, browser: true */

(function () {
    "use strict";
    var Ac = window.Ac, Locale, localeMap, queryParams, _locale;

    // Global namespace for framework.
    if (!Ac) {
        Ac = window.Ac = {};
    }

    // Ad-hoc performance metrics.
    Ac.START_TIME = new Date().getTime();

    // Feature flippers
    // Feature flippers
    Ac.Features = {
        features: {"share_ui_2": true, "my_plan_ui": true, "throttle_ajax_requests": true, "throttle_count_threshold": 10, "throttle_interval_threshold": 10000, "faf_autocomplete": true}
    };

    // Statically loaded versions of framework.
    Ac.config = {
        frameworkVersions: []
    };

    // ----------------
    // Locale
    //
    Ac.Locale = {
        language: "en-US,en-GB;q=0.8,en;q=0.6"
    };
    Locale = Ac.Locale;

    // Maps normalized locale code to its variants.
    localeMap = {
        "ar-ae" : ["ar", "ar-ae", "ar_ae"],
        "bg-bg" : ["bg", "bg-bg", "bg_bg"],
        "ca-es" : ["ca", "ca-es", "ca_es"],
        "cs-cz" : ["cs", "cs-cz", "cs_cz"],
        "da-dk" : ["da", "da-dk", "da_dk"],
        "de-de" : ["de", "de-de", "de_de"],
        "en-ae" : ["en", "en-ae", "en_ae"],
        "en-gb" : ["uk", "en-gb", "en_gb"],
        "en-us" : ["en", "en-us", "en_us"],
        "en-il" : ["en", "en-il", "en_il"],
        "es-es" : ["es", "es-es", "es_es"],
        "eu-es" : ["eu", "eu-es", "eu_es"],
        "fi-fi" : ["fi", "fi-fi", "fi_fi"],
        "fr-fr" : ["fr", "fr-fr", "fr_fr"],
        "fr-ma" : ["fr", "fr-ma", "fr_ma"],
        "he-il" : ["he", "he-il", "he_il"],
        "hr-hr" : ["hr", "hr-hr", "hr_hr"],
        "hu-hu" : ["hu", "hu-hu", "hu_hu"],
        "it-it" : ["it", "it-it", "it_it"],
        "ja-jp" : ["ja", "jp", "ja-jp", "ja_jp"],
        "ko-kr" : ["ko", "ko-kr", "ko_kr"],
        "nb-no" : ["nb", "nb-no", "nb_no"],
        "nl-nl" : ["nl", "nl-nl", "nl_nl"],
        "pl-pl" : ["pl", "pl-pl", "pl_pl"],
        "pt-br" : ["pt", "pt-br", "pt_br"],
        "ro-ro" : ["ro", "ro-ro", "ro_ro"],
        "root"  : ["en", "en-us", "en_us"],
        "ru-ru" : ["ru", "ru-ru", "ru_ru"],
        "sk-sk" : ["sk", "sk-sk", "sk_sk"],
        "sl-si" : ["sl", "sl-si", "sl_si"],
        "sl-sl" : ["sl", "sl-sl", "sl_sl"],
        "sv-se" : ["sv", "sv-se", "sv_se"],
        "tr-tr" : ["tr", "tr-tr", "tr_tr"],
        "uk-ua" : ["uk", "uk-ua", "uk_ua"],
        "xx-xx" : ["xx", "xx-xx"],
        "zh-cn" : ["zh", "zh-cn", "zh_cn"],
        "zh-tw" : ["zh", "zh-tw", "zh_tw"]
    };
    Locale.localeMap = localeMap;

    // Dict of query parameter values indexed by name.
    queryParams = (function (params) {
        var dict = {}, i, param;

        if (params !== "") {
            for (i = 0; i < params.length; i += 1) {
                param = params[i].split('=');
                if (param.length === 2) {
                    dict[param[0]] =
                        decodeURIComponent(param[1].replace(/\+/g, " "));
                }
            }
        }
        return dict;
    }(document.location.search.substr(1).split('&')));

    // Gets query parameter from URL, if there is one.
    Locale.getQueryParamLocale = function () {
        return queryParams.locale;
    };
    
    // 4216559 - Background color and other Theme details are queried from Reader 
    // and applied later with applyUIThemeStyles. Till then it falls back to white background 
    // in the absence of any color specified in WebContent. Hence causing a white flicker.
    // If the URL request contains backgroundcolor, we set the body backgroundcolor here till 
    // Theme is queried and applied
    if (queryParams.backgroundcolor) {
        var backgroundcolor = parseInt(queryParams.backgroundcolor);
        if (backgroundcolor) {
            document.body.style.backgroundColor = "#" + backgroundcolor.toString(16);
        }
    }
    

    // Gets cookie by name.
    function getCookie(name) {
        var nameEq = name + "=", i, c, ca = document.cookie.split(';');

        for (i = 0; i < ca.length; i += 1) {
            c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1, c.length);
            }
            if (c.indexOf(nameEq) === 0) {
                return c.substring(nameEq.length, c.length);
            }
        }
        return null;
    }

    // Returns normalized locale name to match available translations,
    // e.g. maps `fr` to `fr-fr`.
    Locale.getNormalizedLocale = function (locale) {
        var normalizedLocale, localeKey, localeVariants, len, i;

        if (!locale) {
            locale = this.getLocale();
        }
        locale = locale.toLowerCase();

        for (localeKey in localeMap) {
            if (localeMap.hasOwnProperty(localeKey)) {
                localeVariants = localeMap[localeKey];
                len = localeVariants.length;

                // Avoid indexOf() because of IE8.
                for (i = 0; i < len; i += 1) {
                    if (locale === localeVariants[i]) {
                        normalizedLocale = localeKey;
                        break;
                    }
                }
                if (normalizedLocale) {
                    break;
                }
            }
        }

        // If we couldn't find a match, use default locale.
        if (!normalizedLocale) {
            normalizedLocale = "root";
        }

        return normalizedLocale;
    };

    // Translates raw language value into locale value for `RequireJS`
    // `i18n` module.
    Locale.getLocale = function () {
        var locale = _locale, lang, comma;

        // If we've already computed it, return that value.
        if (locale) {
            return locale;
        }

        // If there's a **locale** query parameter, it takes precedence.
        locale = this.getQueryParamLocale();

        // If not provided as query parameter, use `adotcomLang` cookie if available.
        /*if (!locale) {
            locale = getCookie("adotcomLang");
        }*/

        // If not provided by query parameter or cookie, get locale that's been set
        // via **setLanguage**.
        if (!locale && this.language) {
            lang = this.language;
            comma = lang.indexOf(",");
            if (comma >= 0) {
                lang = lang.substr(0, comma);
            }
            locale = lang;
        }

        // Record result so we don't recompute. It's reading the cookie
        // that takes time.
        // Normalize to match available translations.
        _locale = this.getNormalizedLocale(locale);

        return _locale;
    };

}());

// Global configuration for RequireJS.
var require = {
    // No timeout for main.js.
    waitSeconds: 0
};
