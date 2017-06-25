(function($) {
	var awesomeGoogleSuggestions
		awesomeGoogleSuggestions = {
			init: function() {
				$(document).on('keydown', '.awesome-google-suggestion-input', function(e) {
					if (e.keyCode == 13) {
						var text = $(this).val()
						var target = $(this)
						awesomeGoogleSuggestions.displayGoogleData(text, target)
					}
				})
				// cancel default input behaivor
				$(".awesome-google-suggestion-input").keydown(function(e) {
					if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
						e.preventDefault()
					}
				});

				$('.awesome-google-suggestion-input').on('hover', function(e) {
					$('.awesome-google-suggestion-results').show()
				}).on('click', function(e) {
					$('.awesome-google-suggestion-results').hide()
				})

				$(document).on('mouseleave', '.awesome-google-suggestion-results', function(e) {
					$('.awesome-google-suggestion-results').hide()
				})
			},

			displayGoogleData: function(text, target) {
				var text = {
					text: text
				}
				var args = $.extend({}, text, awesome_google_suggestions_args)
				// console.log(args)
				$.ajax({
					url: awesome_google_suggestions_uri,
					async: true,
					type: 'GET',
					dataType: 'json',
					data: args,
					beforeSend: function() {},
					success: function(res) {
						// console.log(res)
						if (Object.keys(res).length && res.CompleteSuggestion !== 'undefined') {
							$('.awesome-google-suggestion-results').remove()
							target.after('<p class="awesome-google-suggestion-results"></p>')
							if (res.CompleteSuggestion.length > 1) {
								for (var i = 0; i < res.CompleteSuggestion.length; i++) {
									var output = res.CompleteSuggestion[i].suggestion['@attributes'].data
									$('.awesome-google-suggestion-results').append('<a href="https://www.google.co.jp/search?q=' + output + '">' + output + '<a><br/>')
								}
                $('.awesome-google-suggestion-results').show()
							} else {
								var output = res.CompleteSuggestion.suggestion['@attributes'].data
								target.after('<p class="awesome-google-suggestion-results"><a href="https://www.google.co.jp/search?q=' + output + '">' + output + '<a></p>')
                $('.awesome-google-suggestion-results').show()
							}

						} else {
							$('.awesome-google-suggestion-results').remove()
							target.after('<p class="awesome-google-suggestion-results">検索結果がありません</p>')
              $('.awesome-google-suggestion-results').show()
						}

					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						console.log('error')
					},
					complete: function(xhr, event) {}
				})
			}
		},

		$(document).ready(awesomeGoogleSuggestions.init)

	})(jQuery)
