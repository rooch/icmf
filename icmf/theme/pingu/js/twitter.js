$(document).ready(function () {
	// When the document is loaded (jQuery function)
		$(document).ready(function() {
			// Call the Twitter API to retrieve the last 10 tweets in JSON format for the pcpro Twitter account
			$.getJSON("http://twitter.com/statuses/user_timeline.json?screen_name=jonhickley&count=1&callback=?", function(tweetdata) {		
				// Grab a reference to the ul element which will display the tweets
				var tl = $("#tweet");
				// For each item returned in tweetdata
				$.each(tweetdata, function(i,tweet) {
					// Append the info in li tags to the ul, converting any links to HTML <a href=.. code and convert the tweeted date
					// to a more readable Twitter format
					tl.append("<span>&ldquo;" + urlToLink(tweet.text) + "&rdquo;</span> <b><a href='http://twitter.com/jonhickley'>(follow me)</a></b>");
				});
			});
		});

		// Converts any links in text to their HTML <a href=""> equivalent
		function urlToLink(text) {
		  var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
		  return text.replace(exp,"<a href='$1'>$1</a>"); 
		}

		
	
});