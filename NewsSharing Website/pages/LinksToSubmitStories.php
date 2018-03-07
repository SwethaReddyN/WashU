<?php
   //User can either post a text or URL.
   echo sprintf('<body onload = "parent.window.contentFrame.location.reload();" onunload = "parent.window.contentFrame.location.reload();">');
   //Logout
   echo sprintf('<form method = "POST" action = "../core/UserActions.php" name = "newlinkform" target = "loginFrame">');
   echo sprintf('%s<input type = "submit" id = "logout" value = "Logout" name = "logout" class = "logout">',
                "\n\t\n");
   echo sprintf('</form>');
   
   //Submit a Text post(both text and url)
   echo sprintf('<form method = "POST" action = "../pages/NewTextPost.php" name = "newlinkform" target = "contentFrame">');
   echo sprintf('%s<input type = "submit" id = "newstory" value = "Submit a new Text Post" name = "newlink" class = "submitstories">',
                "\n\t\n");
   echo sprintf('</form>');
   //Submit a url post(only a url)
   echo sprintf('<form method = "POST" action = "../pages/NewURLPost.php" name = "newlinkform" target = "contentFrame">');
   echo sprintf('%s<input type = "submit" id = "newstory" value = "Submit a new link" name = "newlink" class = "submitstories">',
                "\n\t\n");
   echo sprintf('</form>');
   echo sprintf('</body>');
?>
