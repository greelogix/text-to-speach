function fetchLanguages() {
    let ttsLanguages = {
        "af-ZA": "Afrikaans", "bg-BG": "Bulgarian", 
        "ca-ES": "Catalan", "cs-CZ": "Czech", "da-DK": "Danish", "de-DE": "German", "el-GR": "Greek",
        "en-AU": "English (Australia)", "en-GB": "English (UK)", "en-IN": "English (India)", "en-US": "English (US)",
        "es-ES": "Spanish (Spain)", "es-MX": "Spanish (Mexico)", "et-EE": "Estonian", "eu-ES": "Basque", 
        "fa-IR": "Persian", "fi-FI": "Finnish", "fr-CA": "French (Canada)", "fr-FR": "French (France)",
        "gl-ES": "Galician", "gu-IN": "Gujarati", "he-IL": "Hebrew", "hi-IN": "Hindi", "hr-HR": "Croatian",
        "hu-HU": "Hungarian", "hy-AM": "Armenian", "id-ID": "Indonesian", "is-IS": "Icelandic", "it-IT": "Italian",
        "ja-JP": "Japanese", "jv-ID": "Javanese", "ka-GE": "Georgian", "kk-KZ": "Kazakh", "km-KH": "Khmer",
        "kn-IN": "Kannada", "ko-KR": "Korean", "lt-LT": "Lithuanian", "lv-LV": "Latvian",
        "mk-MK": "Macedonian", "ml-IN": "Malayalam", "mn-MN": "Marathi", "ms-MY": "Malay",
        "my-MM": "Burmese", "ne-NP": "Nepali", "nl-NL": "Dutch", "no-NO": "Norwegian", "or-IN": "Odia",
        "pa-IN": "Punjabi", "pl-PL": "Polish", "pt-BR": "Portuguese (Brazil)", "pt-PT": "Portuguese (Portugal)",
        "ro-RO": "Romanian", "ru-RU": "Russian", "si-LK": "Sinhala", "sk-SK": "Slovak", "sl-SI": "Slovenian",
        "sq-AL": "Albanian", "sr-RS": "Serbian", "su-ID": "Sundanese", "sv-SE": "Swedish", "sw-KE": "Swahili",
        "ta-IN": "Tamil", "te-IN": "Telugu", "th-TH": "Thai", "tr-TR": "Turkish", "uk-UA": "Ukrainian",
        "ur-PK": "Urdu", "uz-UZ": "Uzbek", "vi-VN": "Vietnamese", "xh-ZA": "Xhosa", "zh-CN": "Chinese (Simplified)",
        "zh-HK": "Chinese (Hong Kong)", "zh-TW": "Chinese (Taiwan)",
    };


    $("#lang").empty().append('<option value="en-US" selected>English (US)</option>');
    
    Object.entries(ttsLanguages).forEach(([code, name]) => {
        $("#lang").append(new Option(name, code));
    });

    $("#lang").trigger("change");
}