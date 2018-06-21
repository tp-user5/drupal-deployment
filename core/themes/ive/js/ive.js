(function($, Drupal, drupalSettings) {
    $(document).ready(function(){
        var uid = drupalSettings.user.uid;
        var language = drupalSettings.path.currentLanguage;
        var url = drupalSettings.path.baseUrl + drupalSettings.path.pathPrefix + drupalSettings.path.currentPath;

        alert(
            'Hello user "' + uid + '".' + "\n"  +
            'your language is ' + language + '.' + "\n" +
            'Your URL is ' + url);
    });
})(jQuery, Drupal, drupalSettings);