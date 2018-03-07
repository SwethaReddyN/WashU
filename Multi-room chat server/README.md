# Multi-room Chat Server 

Run the file "ChatServer.js" and then open the client in a browser by visiting one of the links given below :

[http://ec2-54-186-171-207.us-west-2.compute.amazonaws.com:3456](Link URL)

[http://ec2-54-174-181-94.compute-1.amazonaws.com:3456/](Link URL)


When you visit the webpage, a prompt box would appear asking you to enter
the nickname. If you click "Ok" without entering a name, or enter a name
that doesn't meet the validations (length more than 5, less than 16, and 
only alpha numerics, _ and - are allowed), an alert box would appear 
until the nickname entered meets the validations. 

If you click "Cancel", the prompt box would close
and nothing would be displayed on the webpage.


### Administration of user created chat rooms  
* Users can create chat rooms with an arbitrary room name 

      * A private room can be created that is password protected 

  When you clicks on create private room or create public room button, a prompt box would appear asking you to 
enter the roomname. If you click "Ok" without entering a name, an alert box would appear until the room name is entered.
If create password room button is clicked, then after entering room name, another prompt box would appear asking you to enter password.
If you click "Ok" without entering a password, an alert box would appear until the password is entered.

If you click "Cancel" anytime during the process, create new room operation will be cancelled and there is no change in the user session

* Users can join an arbitrary chat room

  You can join a room by clicking on the room name listed in "Room Names" section. If it is a private room, prompt box would appear asking you to enter password.
  If you click "cancel", then entering private room action is cancelled there is no change in the user session.
  
  If user is temporarily or permanently banned from that room, an alert message will be displayed to the user that he is temporarily or permanently banned from the room.
  And the user is still in the previous room
  
* The chat room displays all users currently in the room 

When user enters a room, a list of users who are in the room is displayed to the user. If the user is the creator of the room, then temporarily banned users list is also displayed.
Different buttons will be displayed for each user depending on following conditions :

      * No buttons for current user in the list.

![img1.png](https://bitbucket.org/repo/x8AzEpg/images/2632192570-img1.png)

      * If current user is the creator, 

           *  For users in unbanned list, "Temp ban", "Perm ban" and "Private Msg" buttons are displayed.

           *  For temporarily banned users, "Unban" button is displayed.
![img1.png](https://bitbucket.org/repo/x8AzEpg/images/2630613677-img1.png)
![img2.png](https://bitbucket.org/repo/x8AzEpg/images/3947965326-img2.png)

      * If current user is not the creator, 

           *  Only unbanned uers will be displayed with "Report" and "Private Msg" for other users.

           *  For the creator of the room in the list, only "Private Msg" button is displayed.

![img3.png](https://bitbucket.org/repo/x8AzEpg/images/1709378700-img3.png)

  
* Creators of chat rooms can temporarily kick others out of the room 

  When creator of the room clicks on "Temp ban" button against a user in the room, a message is sent to banned the user.
  The user being banned will get an alert message and evicted from the room. Now, if banned user tries to enter the room again,
  an alert message is displayed and user cannot enter the room.
  Banned user name is removed from users list in other users screen.
  For creator, user name will be displayed in temporarily banned users sections. 
  
* Creators of chat rooms can permanently ban users from joining that particular room 

When creator of the room clicks on "Perm ban" button against a user in the room, a message is sent to banned the user.
The user being banned will get an alert message and evicted from the room. 
User name is removed from users list in other users screen.

Now, if banned user tries to enter the room again,
 An alert message is displayed and user cannot enter the room.

### Messaging 
* A user's message shows their username and is sent to everyone in the room 
* Users can send private messages to another user in the same room 

### Creative Portion ###

1. Public rooms displayed in Green color and private rooms in Red
2. Private messages displayed in Red with additional line saying 
         "Private message sent to ....." or "Private message received from ....."
3. We can change color of our messages and make them Bold, Italic, or both.
4. A user can be reported by other users in a room. If 3 different users report one user in a room, then that user is     
   permanently banned from the room. 
   For ex, 
    * If user1 is reported by user2 and user3 in room1 and user4 in room2, then user1 is not banned even though 3 
      users have reported in different rooms.
    * If user2 reportes user1 3 times in a single room, user1 is not banned because 3 different users have to report 
      user1 to get banned.