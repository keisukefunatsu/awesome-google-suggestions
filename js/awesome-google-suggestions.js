var awesomeGoogleSuggestions
(function($) {

	awesomeGoogleSuggestions = {
		init: function() {
			$(document).on('keyup', '.awesome-google-suggestion-input', function(e) {
        e.preventDefault()

				var text = $(this).val()
        console.log(text)
        awesomeGoogleSuggestions.getGoogleData(text)
			})
      // cancel default input behaivor
      $(".awesome-google-suggestion-input").keydown(function(e) {
          if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
              return false;
          } else {
              return true;
          }
      });
		},

    getGoogleData: function(text) {
      var args = $.extend({}, awesome_google_suggestions_args)
      console.log(awesome_google_suggestions_uri)
      $.ajax({
        url: awesome_google_suggestions_uri,
        async: true,
        type: 'POST',
        dataType: 'json',
        data: args,
        beforeSend: function(){
        },
        success: function(res) {
          console.log('success')
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log('error')
        },
        complete: function(xhr,event){
        }
        })
      }
	},

	$(document).ready(awesomeGoogleSuggestions.init)

})(jQuery)
