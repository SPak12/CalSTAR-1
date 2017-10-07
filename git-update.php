<?php

/*
 * This key is a SHA hash of the "secret key" set up in the
 * Github webhook. This must be edited after changing the secret!
 * To get the string to put here, do any push (so that Github sends
 * a webhook request) and then open up the details in the settings
 * page to see the payload: copy the X-Hub-Signature value here.
 */
$SHA_SECRET_KEY = "sha1=bf45f600746414aba51131d64e170e8b2f504b95";

function getRequestHeaders() {
	$headers = array();
	foreach($_SERVER as $key => $value) {
		if (substr($key, 0, 5) <> 'HTTP_') {
			continue;
		}
		$header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
		$headers[$header] = $value;
	}
	return $headers;
}
$headers = getRequestHeaders();

if (array_key_exists('X-Hub-Signature', $headers)) {
	if ($headers['X-Hub-Signature'] === $SHA_SECRET_KEY) {
		exec("touch ../trying-update");
		exec('../update.sh > update-output 2>&1');
	} else {
		exec("touch ../bad-signature");
		echo "go away hacker >(";
	}
} else {
	exec("touch ../no-key");
	echo "NOOOPE";
}

?>
