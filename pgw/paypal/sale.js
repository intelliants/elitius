function getCookie(cookieName)
{
   var cookieValue = document.cookie;
   var cookieStartsAt = cookieValue.indexOf(" " + cookieName + "=");
   if (cookieStartsAt == -1)
   {
      cookieStartsAt = cookieValue.indexOf(cookieName + "=");
   }
   if (cookieStartsAt == -1)
   {
      cookieValue = null;
   }
   else
   {
      cookieStartsAt = cookieValue.indexOf("=", cookieStartsAt) + 1;
      var cookieEndsAt = cookieValue.indexOf(";", cookieStartsAt);
      if (cookieEndsAt == -1)
      {
         cookieEndsAt = cookieValue.length;
      }
      cookieValue = unescape(cookieValue.substring(cookieStartsAt,
         cookieEndsAt));
   }
   return cookieValue;
}

function sale()
{
	// Get product id
	var pid = document.getElementById('xp_pp_custom').value;

	// Firefox retains <input /> values between page refreshes.
	// So, in case the value was retained -- just ignore it,
	// otherwise, generate new combined value.
	var re = /^[0-9]+_[a-z0-9]{32}$/i;
	if (!re.test(pid))
	{
		// Get visitor id
		var vid = getCookie('xp');
		// Update custom value
		document.getElementById('xp_pp_custom').value = pid + '_' + vid;
	}
}
