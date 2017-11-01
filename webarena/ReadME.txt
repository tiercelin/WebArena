This project has developped 4 functionalities : D and F were the selected functionalities and we decided to implement B and D as well.
It have been developped by CHAMPALIER Mariane, IMBERT Pierre-Louis, OLIVE Thomas and TIERCELIN Julie.

This text file will mention all important files in this project.

There are 4 working controllers : Arenas, Communication, HoF and Players.

Arenas is the main controller, with links to pages such as index, fighter, create_fighter, diary and sight.
- index is the page containing the rules of the game and a carrousel with avatars of the players in the database
- fighter is the page where the fighter's characteristics are diplayed and where upgrade buttons are displayed if he gaigned level. In this page, we can also select an avatar picture for the fighter
- creat_fighter is a page where we are redirected if our fighter died or when we create an account
- diary displays the events that occured in the last 24 hours (events being moves, attacks, kills, account connection and deconnection, as well as Sreams Events
- sight is the arena page where you can see the map and moving/attacking buttons. Also, you can reset the map and see your and your ennemis's fighters lifebar

Communication is the controller that deals with the messages between fighters, the Scream events feature and the guild. There is two pages only in this controller: 
- messages (that include messages and sream forms),
and 
- guilds (where you can create a new guild or join an existing one

The HoF Controller manages the hall of fame, accessible when you are connected and not connected.
There is two pages
- draw charts, which displays charts regarding level of all fighters as well as skills repartition
- draw charts2 that concerns succesfull atacks and connection times

Finally, Players is controller that manages the autentification system. It is composed of two pages :
- login_controller that manages the sign in form to connect as well as reset and changing passwords functionalities. 
- new_player that proposes a form for the user to create a new account

Also, an avatar folder has been created in the webroot/img folder to gather all avatars.
Moreover css and javascript files have been added to the project for the libraries options (Bootstrap and Datatables)