	new TypingText(document.getElementById("type"), 50, function(i){ var ar 

	= new Array("|", "|", "|", "|"); return " " + ar[i.length % ar.length]; });

	TypingText.runAll();