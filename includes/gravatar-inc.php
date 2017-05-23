<?php

	//gravatar

	//Perform tasks database query
	$UsersQuery = "SELECT email FROM users WHERE id = '$UserID'";
	$UsersResult = mysql_query($UsersQuery, $DBConnect);
	//Test if there was a query error
	if(!$UsersResult){
		die("Database failed to query.");
	}
	while($erow = mysql_fetch_assoc($UsersResult)) {
		$UserEmail = $erow['email'];
	}


	print_r( $UserEmailRow );


	// The users email, passed to Gravatar
	//$usersEmail = "";

	// A default avatar to load if Gravatar
	// doesn't find one.
	$defaultImage = "http://todolisto.net/images/icon-user.png";

	// The size of the image
	$avatarSize = "40";

	// Minimum rating for your site
	// Possible values (G, PG, R, X)
	$avatarRating = "PG";

	// Border around the image
	$avatarBorder = "000000";

	// URL for Gravatar
	$gravatarURL = "http://www.gravatar.com/avatar.php?gravatar_id=%s
	&default=%s&size=%s&border=%s&rating=%s";

	$avatarURL = sprintf
	(
		$gravatarURL,
		md5($UserEmail),
		$defaultImage,
		$avatarSize,
		$avatarBorder,
		$avatarRating
	);


/*
	print "<img src=\"" .
		$avatarURL . "\" width=\"" .
		$avatarSize . "\" height=\"" .
		$avatarSize . "\" />";
*/



	//gravatar----------------





?>
