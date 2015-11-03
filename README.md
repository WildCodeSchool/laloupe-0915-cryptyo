#CRYPT YOUR OCTECT


##Objectifs / Goals

Création d'une application permetttant l'échange de messages cryptés entre personnes inscrites sur cette application.
Create an application to exchange crypted messages to people registrated on this application.

###Contraintes / Constraints

Pour décrypter le message, nous avons prévu d'envoyer un mail avec un sel (mot de passe). La contrainte majeure était de faire passer ce sel uniquement par email, sans l'enregistrer dans la base de données pour des raisons de sécurité.


##Installation

Dans la console / In the terminal :

> git clone https://github.com/WildCodeSchool/projet-cryptyo
> cd projet-cryptyo
> composer install
> php app/console doctrine:schema:update --force


##Configuration

Swiftmailer (envoi de mails / mails sending) : 

Ajoutez la configuration suivante dans app/config/config.yml
Add the following configuration to app/config/config.yml

>swiftmailer:
>    transport: "%mailer_transport%"
>    host:      "%mailer_host%"
>    username:  "%mailer_user%"
>    password:  "%mailer_password%"
>    spool:     { type: memory }



##Contributions au projet

Pour contribuer au projet, il vous suffit simplement de le "forker".

Une fois vos modifications effectuées, faites un commit sur votre branche et "pushez" votre commit sur cette branche.

Faites ensuite une "pull request".
