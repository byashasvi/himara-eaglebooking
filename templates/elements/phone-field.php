<script>

jQuery(document).ready(function ($) {

    jQuery(function($) {

    // Phone
    var eb_countries = []
    eb_countries = {
        "af": "<?php echo  normalize_whitespace( __('Afghanistan', 'eagle-booking') ) ?>",
        "al": "<?php echo  normalize_whitespace( __('Albania', 'eagle-booking') ) ?>",
        "dz": "<?php echo  normalize_whitespace( __('Algeria‬', 'eagle-booking') ) ?>",
        "as": "<?php echo  normalize_whitespace( __('American Samoa', 'eagle-booking') ) ?>",
        "ad": "<?php echo  normalize_whitespace( __('Andorra', 'eagle-booking') ) ?>",
        "ao": "<?php echo  normalize_whitespace( __('Angola', 'eagle-booking') ) ?>",
        "ai": "<?php echo  normalize_whitespace( __('Anguilla', 'eagle-booking') ) ?>",
        "ag": "<?php echo  normalize_whitespace( __('Antigua and Barbuda', 'eagle-booking') ) ?>",
        "ar": "<?php echo  normalize_whitespace( __('Argentina', 'eagle-booking') ) ?>",
        "am": "<?php echo  normalize_whitespace( __('Armenia', 'eagle-booking') ) ?>",
        "aw": "<?php echo  normalize_whitespace( __('Aruba', 'eagle-booking') ) ?>",
        "au": "<?php echo  normalize_whitespace( __('Australia', 'eagle-booking') ) ?>",
        "at": "<?php echo  normalize_whitespace( __('Austria', 'eagle-booking') ) ?>",
        "az": "<?php echo  normalize_whitespace( __('Azerbaijan', 'eagle-booking') ) ?>",
        "bs": "<?php echo  normalize_whitespace( __('Bahamas', 'eagle-booking') ) ?>",
        "bh": "<?php echo  normalize_whitespace( __('Bahrain', 'eagle-booking') ) ?>",
        "bd": "<?php echo  normalize_whitespace( __('Bangladesh', 'eagle-booking') ) ?>",
        "bb": "<?php echo  normalize_whitespace( __('Barbados', 'eagle-booking') ) ?>",
        "by": "<?php echo  normalize_whitespace( __('Belarus', 'eagle-booking') ) ?>",
        "be": "<?php echo  normalize_whitespace( __('Belgium', 'eagle-booking') ) ?>",
        "bz": "<?php echo  normalize_whitespace( __('Belize', 'eagle-booking') ) ?>",
        "bj": "<?php echo  normalize_whitespace( __('Benin', 'eagle-booking') ) ?>",
        "bm": "<?php echo  normalize_whitespace( __('Bermuda', 'eagle-booking') ) ?>",
        "bt": "<?php echo  normalize_whitespace( __('Bhutan', 'eagle-booking') ) ?>",
        "bo": "<?php echo  normalize_whitespace( __('Bolivia', 'eagle-booking') ) ?>",
        "ba": "<?php echo  normalize_whitespace( __('Bosnia and Herzegovina', 'eagle-booking') ) ?>",
        "bw": "<?php echo  normalize_whitespace( __('Botswana', 'eagle-booking') ) ?>",
        "br": "<?php echo  normalize_whitespace( __('Brazil', 'eagle-booking') ) ?>",
        "io": "<?php echo  normalize_whitespace( __('British Indian Ocean Territory', 'eagle-booking') ) ?>",
        "vg": "<?php echo  normalize_whitespace( __('Virgin Islands, British', 'eagle-booking') ) ?>",
        "bn": "<?php echo  normalize_whitespace( __('Brunei Darussalam', 'eagle-booking') ) ?>",
        "bg": "<?php echo  normalize_whitespace( __('Bulgaria', 'eagle-booking') ) ?>",
        "bf": "<?php echo  normalize_whitespace( __('Burkina Faso', 'eagle-booking') ) ?>",
        "bi": "<?php echo  normalize_whitespace( __('Burundi', 'eagle-booking') ) ?>",
        "kh": "<?php echo  normalize_whitespace( __('Cambodia', 'eagle-booking') ) ?>",
        "cm": "<?php echo  normalize_whitespace( __('Cameroon', 'eagle-booking') ) ?>",
        "ca": "<?php echo  normalize_whitespace( __('Canada', 'eagle-booking') ) ?>",
        "cv": "<?php echo  normalize_whitespace( __('Cape Verde', 'eagle-booking') ) ?>",
        "bq": "<?php echo  normalize_whitespace( __('Caribbean Netherlands', 'eagle-booking') ) ?>",
        "ky": "<?php echo  normalize_whitespace( __('Cayman Islands', 'eagle-booking') ) ?>",
        "cf": "<?php echo  normalize_whitespace( __('Central African Republic', 'eagle-booking') ) ?>",
        "td": "<?php echo  normalize_whitespace( __('Chad', 'eagle-booking') ) ?>",
        "cl": "<?php echo  normalize_whitespace( __('Chile', 'eagle-booking') ) ?>",
        "cn": "<?php echo  normalize_whitespace( __('China', 'eagle-booking') ) ?>",
        "co": "<?php echo  normalize_whitespace( __('Colombia', 'eagle-booking') ) ?>",
        "km": "<?php echo  normalize_whitespace( __('Comoros', 'eagle-booking') ) ?>",
        "cd": "<?php echo  normalize_whitespace( __('Congo', 'eagle-booking') ) ?>",
        "cg": "<?php echo  normalize_whitespace( __('Congo, The Democratic Republic of The', 'eagle-booking') ) ?>",
        "ck": "<?php echo  normalize_whitespace( __('Cook Islands', 'eagle-booking') ) ?>",
        "cr": "<?php echo  normalize_whitespace( __('Costa Rica', 'eagle-booking') ) ?>",
        "ci": "<?php echo  normalize_whitespace( __("Cote D'ivoire", 'eagle-booking') ) ?>",
        "hr": "<?php echo  normalize_whitespace( __('Croatia', 'eagle-booking') ) ?>",
        "cu": "<?php echo  normalize_whitespace( __('Cuba', 'eagle-booking') ) ?>",
        "cw": "<?php echo  normalize_whitespace( __('Curaçao', 'eagle-booking') ) ?>",
        "cy": "<?php echo  normalize_whitespace( __('Cyprus', 'eagle-booking') ) ?>",
        "cz": "<?php echo  normalize_whitespace( __('Czech Republic', 'eagle-booking') ) ?>",
        "dk": "<?php echo  normalize_whitespace( __('Denmark', 'eagle-booking') ) ?>",
        "dj": "<?php echo  normalize_whitespace( __('Djibouti', 'eagle-booking') ) ?>",
        "dm": "<?php echo  normalize_whitespace( __('Dominica', 'eagle-booking') ) ?>",
        "do": "<?php echo  normalize_whitespace( __('Dominican Republic', 'eagle-booking') ) ?>",
        "ec": "<?php echo  normalize_whitespace( __('Ecuador', 'eagle-booking') ) ?>",
        "eg": "<?php echo  normalize_whitespace( __('Egypt', 'eagle-booking') ) ?>",
        "sv": "<?php echo  normalize_whitespace( __('El Salvador', 'eagle-booking') ) ?>",
        "gq": "<?php echo  normalize_whitespace( __('Equatorial Guinea', 'eagle-booking') ) ?>",
        "er": "<?php echo  normalize_whitespace( __('Eritrea', 'eagle-booking') ) ?>",
        "ee": "<?php echo  normalize_whitespace( __('Estonia', 'eagle-booking') ) ?>",
        "et": "<?php echo  normalize_whitespace( __('Ethiopia', 'eagle-booking') ) ?>",
        "fk": "<?php echo  normalize_whitespace( __('Falkland Islands (Malvinas)', 'eagle-booking') ) ?>",
        "fo": "<?php echo  normalize_whitespace( __('Faroe Islands', 'eagle-booking') ) ?>",
        "fj": "<?php echo  normalize_whitespace( __('Fiji', 'eagle-booking') ) ?>",
        "fi": "<?php echo  normalize_whitespace( __('Finland', 'eagle-booking') ) ?>",
        "fr": "<?php echo  normalize_whitespace( __('France', 'eagle-booking') ) ?>",
        "gf": "<?php echo  normalize_whitespace( __('French Guiana', 'eagle-booking') ) ?>",
        "pf": "<?php echo  normalize_whitespace( __('French Polynesia', 'eagle-booking') ) ?>",
        "ga": "<?php echo  normalize_whitespace( __('Gabon', 'eagle-booking') ) ?>",
        "gm": "<?php echo  normalize_whitespace( __('Gambia', 'eagle-booking') ) ?>",
        "ge": "<?php echo  normalize_whitespace( __('Georgia', 'eagle-booking') ) ?>",
        "de": "<?php echo  normalize_whitespace( __('Germany', 'eagle-booking') ) ?>",
        "gh": "<?php echo  normalize_whitespace( __('Ghana', 'eagle-booking') ) ?>",
        "gi": "<?php echo  normalize_whitespace( __('Gibraltar', 'eagle-booking') ) ?>",
        "gr": "<?php echo  normalize_whitespace( __('Greece', 'eagle-booking') ) ?> ",
        "gl": "<?php echo  normalize_whitespace( __('Greenland', 'eagle-booking') ) ?>",
        "gd": "<?php echo  normalize_whitespace( __('Grenada', 'eagle-booking') ) ?>",
        "gp": "<?php echo  normalize_whitespace( __('Guadeloupe', 'eagle-booking') ) ?>",
        "gu": "<?php echo  normalize_whitespace( __('Guam', 'eagle-booking') ) ?>",
        "gt": "<?php echo  normalize_whitespace( __('Guatemala', 'eagle-booking') ) ?>",
        "gn": "<?php echo  normalize_whitespace( __('Guinea', 'eagle-booking') ) ?>",
        "gw": "<?php echo  normalize_whitespace( __('Guinea-bissau', 'eagle-booking') ) ?>",
        "gy": "<?php echo  normalize_whitespace( __('Guyana', 'eagle-booking') ) ?>",
        "ht": "<?php echo  normalize_whitespace( __('Haiti', 'eagle-booking') ) ?>",
        "hn": "<?php echo  normalize_whitespace( __('Honduras', 'eagle-booking') ) ?>",
        "hk": "<?php echo  normalize_whitespace( __('Hong Kong', 'eagle-booking') ) ?>",
        "hu": "<?php echo  normalize_whitespace( __('Hungary', 'eagle-booking') ) ?>",
        "is": "<?php echo  normalize_whitespace( __('Iceland', 'eagle-booking') ) ?>",
        "in": "<?php echo  normalize_whitespace( __('India', 'eagle-booking') ) ?>",
        "id": "<?php echo  normalize_whitespace( __('Indonesia', 'eagle-booking') ) ?>",
        "ir": "<?php echo  normalize_whitespace( __('Iran, Islamic Republic of', 'eagle-booking') ) ?>",
        "iq": "<?php echo  normalize_whitespace( __('Iraq', 'eagle-booking') ) ?>",
        "ie": "<?php echo  normalize_whitespace( __('Ireland', 'eagle-booking') ) ?>",
        "il": "<?php echo  normalize_whitespace( __('Israel', 'eagle-booking') ) ?>",
        "it": "<?php echo  normalize_whitespace( __('Italy', 'eagle-booking') ) ?>",
        "jm": "<?php echo  normalize_whitespace( __('Jamaica', 'eagle-booking') ) ?>",
        "jp": "<?php echo  normalize_whitespace( __('Japan', 'eagle-booking') ) ?>",
        "jo": "<?php echo  normalize_whitespace( __('Jordan', 'eagle-booking') ) ?>",
        "kz": "<?php echo  normalize_whitespace( __('Kazakhstan', 'eagle-booking') ) ?>",
        "ke": "<?php echo  normalize_whitespace( __('Kenya', 'eagle-booking') ) ?>",
        "ki": "<?php echo  normalize_whitespace( __('Kiribati', 'eagle-booking') ) ?>",
        "kw": "<?php echo  normalize_whitespace( __('Kuwait', 'eagle-booking') ) ?>",
        "kg": "<?php echo  normalize_whitespace( __('Kyrgyzstan', 'eagle-booking') ) ?>",
        "la": "<?php echo  normalize_whitespace( __('Kyrgyzstan', 'eagle-booking') ) ?>",
        "lv": "<?php echo  normalize_whitespace( __('Latvia', 'eagle-booking') ) ?>",
        "lb": "<?php echo  normalize_whitespace( __('Lebanon', 'eagle-booking') ) ?>",
        "ls": "<?php echo  normalize_whitespace( __('Lesotho', 'eagle-booking') ) ?>",
        "lr": "<?php echo  normalize_whitespace( __('Liberia', 'eagle-booking') ) ?>",
        "ly": "<?php echo  normalize_whitespace( __('Libyan Arab Jamahiriya', 'eagle-booking') ) ?>",
        "li": "<?php echo  normalize_whitespace( __('Liechtenstein', 'eagle-booking') ) ?>",
        "lt": "<?php echo  normalize_whitespace( __('Lithuania', 'eagle-booking') ) ?>",
        "lu": "<?php echo  normalize_whitespace( __('Luxembourg', 'eagle-booking') ) ?>",
        "mo": "<?php echo  normalize_whitespace( __('Macao', 'eagle-booking') ) ?>",
        "mk": "<?php echo  normalize_whitespace( __('North Macedonia', 'eagle-booking') ) ?>",
        "mg": "<?php echo  normalize_whitespace( __('Madagascar', 'eagle-booking') ) ?>",
        "mw": "<?php echo  normalize_whitespace( __('Malawi', 'eagle-booking') ) ?>",
        "my": "<?php echo  normalize_whitespace( __('Malaysia', 'eagle-booking') ) ?>",
        "mv": "<?php echo  normalize_whitespace( __('Maldives', 'eagle-booking') ) ?>",
        "ml": "<?php echo  normalize_whitespace( __('Mali', 'eagle-booking') ) ?>",
        "mt": "<?php echo  normalize_whitespace( __('Malta', 'eagle-booking') ) ?>",
        "mh": "<?php echo  normalize_whitespace( __('Marshall Islands', 'eagle-booking') ) ?>",
        "mq": "<?php echo  normalize_whitespace( __('Martinique', 'eagle-booking') ) ?>",
        "mr": "<?php echo  normalize_whitespace( __('Mauritania', 'eagle-booking') ) ?>",
        "mu": "<?php echo  normalize_whitespace( __('Mauritius', 'eagle-booking') ) ?>>",
        "mx": "<?php echo  normalize_whitespace( __('Mexico', 'eagle-booking') ) ?>",
        "fm": "<?php echo  normalize_whitespace( __('Micronesia, Federated States of', 'eagle-booking') ) ?>",
        "md": "<?php echo  normalize_whitespace( __('Moldova, Republic of', 'eagle-booking') ) ?>",
        "mc": "<?php echo  normalize_whitespace( __('Monaco', 'eagle-booking') ) ?>",
        "mn": "<?php echo  normalize_whitespace( __('Mongolia', 'eagle-booking') ) ?>",
        "me": "<?php echo  normalize_whitespace( __('Montenegro', 'eagle-booking') ) ?>",
        "ms": "<?php echo  normalize_whitespace( __('Montserrat', 'eagle-booking') ) ?>",
        "ma": "<?php echo  normalize_whitespace( __('Morocco', 'eagle-booking') ) ?>",
        "mz": "<?php echo  normalize_whitespace( __('Mozambique', 'eagle-booking') ) ?>",
        "mm": "<?php echo  normalize_whitespace( __('Myanmar', 'eagle-booking') ) ?>",
        "na": "<?php echo  normalize_whitespace( __('Namibia', 'eagle-booking') ) ?>",
        "nr": "<?php echo  normalize_whitespace( __('Nauru', 'eagle-booking') ) ?>",
        "np": "<?php echo  normalize_whitespace( __('Nepal', 'eagle-booking') ) ?>",
        "nl": "<?php echo  normalize_whitespace( __('Netherlands', 'eagle-booking') ) ?>",
        "nc": "<?php echo  normalize_whitespace( __('New Caledonia', 'eagle-booking') ) ?>",
        "nz": "<?php echo  normalize_whitespace( __('New Zealand', 'eagle-booking') ) ?>",
        "ni": "<?php echo  normalize_whitespace( __('Nicaragua', 'eagle-booking') ) ?>",
        "ne": "<?php echo  normalize_whitespace( __('Niger', 'eagle-booking') ) ?>",
        "ng": "<?php echo  normalize_whitespace( __('Nigeria', 'eagle-booking') ) ?>",
        "nu": "<?php echo  normalize_whitespace( __('Niue', 'eagle-booking') ) ?>",
        "nf": "<?php echo  normalize_whitespace( __('Norfolk Island', 'eagle-booking') ) ?>",
        "kp": "<?php echo  normalize_whitespace( __('North Korea', 'eagle-booking') ) ?>",
        "mp": "<?php echo  normalize_whitespace( __('Northern Mariana Islands', 'eagle-booking') ) ?>",
        "no": "<?php echo  normalize_whitespace( __('Norway', 'eagle-booking') ) ?>",
        "om": "<?php echo  normalize_whitespace( __('Oman', 'eagle-booking') ) ?>",
        "pk": "<?php echo  normalize_whitespace( __('Pakistan', 'eagle-booking') ) ?>",
        "pw": "<?php echo  normalize_whitespace( __('Palau', 'eagle-booking') ) ?>",
        "ps": "<?php echo  normalize_whitespace( __('Palestinian Territory, Occupied', 'eagle-booking') ) ?>",
        "pa": "<?php echo  normalize_whitespace( __('Panama', 'eagle-booking') ) ?>",
        "pg": "<?php echo  normalize_whitespace( __('Papua New Guinea', 'eagle-booking') ) ?>",
        "py": "<?php echo  normalize_whitespace( __('Paraguay', 'eagle-booking') ) ?>",
        "pe": "<?php echo  normalize_whitespace( __('Peru', 'eagle-booking') ) ?>",
        "ph": "<?php echo  normalize_whitespace( __('Philippines', 'eagle-booking') ) ?>",
        "pl": "<?php echo  normalize_whitespace( __('Poland', 'eagle-booking') ) ?>",
        "pt": "<?php echo  normalize_whitespace( __('Portugal', 'eagle-booking') ) ?>",
        "pr": "<?php echo  normalize_whitespace( __('Puerto Rico', 'eagle-booking') ) ?>",
        "qa": "<?php echo  normalize_whitespace( __('Qatar', 'eagle-booking') ) ?>",
        "re": "<?php echo  normalize_whitespace( __('Reunion', 'eagle-booking') ) ?>",
        "ro": "<?php echo  normalize_whitespace( __('Romania', 'eagle-booking') ) ?>",
        "ru": "<?php echo  normalize_whitespace( __('Russian Federation', 'eagle-booking') ) ?>",
        "rw": "<?php echo  normalize_whitespace( __('Rwanda', 'eagle-booking') ) ?>",
        "bl": "<?php echo  normalize_whitespace( __('Saint Barthélemy', 'eagle-booking') ) ?>",
        "sh": "<?php echo  normalize_whitespace( __('Saint Helena', 'eagle-booking') ) ?>",
        "kn": "<?php echo  normalize_whitespace( __('Saint Kitts and Nevis', 'eagle-booking') ) ?>",
        "lc": "<?php echo  normalize_whitespace( __('Saint Lucia', 'eagle-booking') ) ?>",
        "mf": "<?php echo  normalize_whitespace( __('Saint Martin', 'eagle-booking') ) ?>",
        "pm": "<?php echo  normalize_whitespace( __('Saint Pierre and Miquelon', 'eagle-booking') ) ?>",
        "vc": "<?php echo  normalize_whitespace( __('Saint Vincent and the Grenadines', 'eagle-booking') ) ?>",
        "ws": "<?php echo  normalize_whitespace( __('Samoa', 'eagle-booking') ) ?>",
        "sm": "<?php echo  normalize_whitespace( __('San Marino', 'eagle-booking') ) ?>",
        "st": "<?php echo  normalize_whitespace( __('Sao Tome and Principe', 'eagle-booking') ) ?>",
        "sa": "<?php echo  normalize_whitespace( __('Saudi Arabia', 'eagle-booking') ) ?>",
        "sn": "<?php echo  normalize_whitespace( __('Senegal', 'eagle-booking') ) ?>",
        "rs": "<?php echo  normalize_whitespace( __('Serbia', 'eagle-booking') ) ?>",
        "sc": "<?php echo  normalize_whitespace( __('Seychelles', 'eagle-booking') ) ?>",
        "sl": "<?php echo  normalize_whitespace( __('Sierra Leone', 'eagle-booking') ) ?>",
        "sg": "<?php echo  normalize_whitespace( __('Singapore', 'eagle-booking') ) ?>",
        "sx": "<?php echo  normalize_whitespace( __('Sint Maarten', 'eagle-booking') ) ?>",
        "sk": "<?php echo  normalize_whitespace( __('Slovakia', 'eagle-booking') ) ?>",
        "si": "<?php echo  normalize_whitespace( __('Slovenia', 'eagle-booking') ) ?>",
        "sb": "<?php echo  normalize_whitespace( __('Solomon Islands', 'eagle-booking') ) ?>",
        "so": "<?php echo  normalize_whitespace( __('Somalia', 'eagle-booking') ) ?>",
        "za": "<?php echo  normalize_whitespace( __('South Africa', 'eagle-booking') ) ?>",
        "kr": "<?php echo  normalize_whitespace( __('South Korea', 'eagle-booking') ) ?>",
        "ss": "<?php echo  normalize_whitespace( __('Sudan', 'eagle-booking') ) ?>",
        "es": "<?php echo  normalize_whitespace( __('Spain', 'eagle-booking') ) ?>",
        "lk": "<?php echo  normalize_whitespace( __('Sri Lanka', 'eagle-booking') ) ?>",
        "sd": "<?php echo  normalize_whitespace( __('Sudan', 'eagle-booking') ) ?>",
        "sr": "<?php echo  normalize_whitespace( __('Suriname', 'eagle-booking') ) ?>",
        "sz": "<?php echo  normalize_whitespace( __('Swaziland', 'eagle-booking') ) ?>",
        "se": "<?php echo  normalize_whitespace( __('Sweden', 'eagle-booking') ) ?>",
        "ch": "<?php echo  normalize_whitespace( __('Switzerland', 'eagle-booking') ) ?>",
        "sy": "<?php echo  normalize_whitespace( __('Syrian Arab Republic', 'eagle-booking') ) ?>",
        "tw": "<?php echo  normalize_whitespace( __('Taiwan, Province of China','eagle-booking') ) ?>",
        "tj": "<?php echo  normalize_whitespace( __('Tajikistan', 'eagle-booking') ) ?>",
        "tz": "<?php echo  normalize_whitespace( __('Tanzania, United Republic of', 'eagle-booking') ) ?>",
        "th": "<?php echo  normalize_whitespace( __('Thailand', 'eagle-booking') ) ?>",
        "tl": "<?php echo  normalize_whitespace( __('Timor-leste', 'eagle-booking') ) ?>",
        "tg": "<?php echo  normalize_whitespace( __('Togo', 'eagle-booking') ) ?>",
        "tk": "<?php echo  normalize_whitespace( __('Tokelau', 'eagle-booking') ) ?>",
        "to": "<?php echo  normalize_whitespace( __('Tonga', 'eagle-booking') ) ?>",
        "tt": "<?php echo  normalize_whitespace( __('Trinidad and Tobago', 'eagle-booking') ) ?>",
        "tn": "<?php echo  normalize_whitespace( __('Tunisia', 'eagle-booking') ) ?>",
        "tr": "<?php echo  normalize_whitespace( __('Turkey', 'eagle-booking') ) ?>",
        "tm": "<?php echo  normalize_whitespace( __('Turkmenistan', 'eagle-booking') ) ?>",
        "tc": "<?php echo  normalize_whitespace( __('Turks and Caicos Islands', 'eagle-booking') ) ?>",
        "tv": "<?php echo  normalize_whitespace( __('Tuvalu', 'eagle-booking') ) ?>",
        "vi": "<?php echo  normalize_whitespace( __('U.S. Virgin Islands', 'eagle-booking') ) ?>",
        "ug": "<?php echo  normalize_whitespace( __('Uganda', 'eagle-booking') ) ?>",
        "ua": "<?php echo  normalize_whitespace( __('Ukraine', 'eagle-booking') ) ?>",
        "ae": "<?php echo  normalize_whitespace( __('United Arab Emirates', 'eagle-booking') ) ?>",
        "gb": "<?php echo  normalize_whitespace( __('United Kingdom', 'eagle-booking') ) ?>",
        "us": "<?php echo  normalize_whitespace( __('United States', 'eagle-booking') ) ?>",
        "uy": "<?php echo  normalize_whitespace( __('Uruguay', 'eagle-booking') ) ?>",
        "uz": "<?php echo  normalize_whitespace( __('Uzbekistan', 'eagle-booking') ) ?>",
        "vu": "<?php echo  normalize_whitespace( __('Vanuatu', 'eagle-booking') ) ?>",
        "va": "<?php echo  normalize_whitespace( __('Vatican City', 'eagle-booking') ) ?>",
        "ve": "<?php echo  normalize_whitespace( __('Venezuela', 'eagle-booking') ) ?>",
        "vn": "<?php echo  normalize_whitespace( __('Viet Nam', 'eagle-booking') ) ?>",
        "wf": "<?php echo  normalize_whitespace( __('Wallis and Futuna', 'eagle-booking') ) ?>",
        "ye": "<?php echo  normalize_whitespace( __('Yemen', 'eagle-booking') ) ?>",
        "zm": "<?php echo  normalize_whitespace( __('Zambia', 'eagle-booking') ) ?>",
        "zw": "<?php echo  normalize_whitespace( __('Zimbabwe', 'eagle-booking') ) ?>"
    }

    var input = document.querySelectorAll(".eb_user_phone_field");
    var i;

    function eb_phone_ip_lookup(callback) {

        // Check if IP Lookup is enabled
        <?php if ( eb_get_option( 'geo_ip_lookup' ) == true ) : ?>

            $.get("//ipinfo.io?callback=?", function() {}, "jsonp").always(function(resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
             if(callback) callback(countryCode);
            });

        <?php else: ?>

            return false

        <?php endif ?>

    }

    for (i = 0; i < input.length; i++) {

        window.intlTelInput(input[i], {

            autoHideDialCode: false,
            autoPlaceholder: "off",
            formatOnDisplay: false,
            geoIpLookup: eb_phone_ip_lookup,
            hiddenInput: "user_phone",
            initialCountry: "auto",
            localizedCountries: eb_countries,
            nationalMode: true,
            preferredCountries: [],
            separateDialCode: true,
            utilsScript: "<?php echo EB_URL ?>/assets/js/utils.js",

        });

    }

});

});
</script>