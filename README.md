#CRYPT YOUR OCTECT


##Objectifs / Goals

Création d'une application permetttant l'échange de messages cryptés entre personnes inscrites sur cette application.

Create an application to exchange crypted messages to people registrated on this application.

###Contraintes / Constraints

Pour décrypter le message, nous avons prévu d'envoyer un mail avec un sel (mot de passe). La contrainte majeure était de faire passer ce sel uniquement par email, sans l'enregistrer dans la base de données pour des raisons de sécurité.

##Installation

Requis / Require : 

* [Installer composer](https://getcomposer.org/download/)


Fork le projet sur Github / Fork the project on Github.

Puis depuis la console :
``` shell
$ git clone https://github.com/TON_COMPTE_GITHUB/projet-cryptyo.git 
$ cd projet-cryptyo 
$ composer install 
$ bash bash/chmod.sh 
$ php app/console doctrine:schema:update --force 
```

Le projet est bien installé bravo ᕕ( ͡° ͜ʖ ͡° )ᕗ



##Configuration

#####1. Configurer Swiftmailer (envoi de mails / mails sending) : 

Ajoute la configuration suivante dans app/config/config.yml / Add the following configuration to app/config/config.yml

---
    swiftmailer:
        transport: "%mailer_transport%" 
        host:      "%mailer_host%"
        username:  "%mailer_user%"
        password:  "%mailer_password%"
        spool:     { type: memory }
---

######En environnement de developpement, tu peux utiliser une adresse gmail :

---
    swiftmailer:
        transport: gmail
        username:  your_gmail_username
        password:  your_gmail_password
---

##Contributions au projet

Pour contribuer au projet, il te suffis de le forker sur [Github](https://github.com/WildCodeSchool/projet-cryptyo)

Merci de commenter clairement tes commits.

N'hésite pas à PR tes avancées régulierement.