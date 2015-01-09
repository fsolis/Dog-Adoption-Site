Dog-Adoption-Site
=================
# README #

### What is this repositor for? ###

*This application is a mock website for a Dog adoption center. 

* This can be used as a template for anyone. 

* This website runs on a LAMP Server on an Ubuntu Linux Machine. 

*Version: 1.0

*Once released it will be seen on [HERE](http://www.fsolis.net)

### How do I get set up? ###

####Summary of set up####

* Initial Commands to get your machine up and running. (This assumes you have sudo privilages).

##### Update machine repository list:#####
*   sudo apt-get update 

##### Install any update to any programs#####
*   sudo apt-get upgrade
*(If asked to install new software hit 'Y')

##### Install Apache Server #####
*  sudo apt-get install apache2
*(If asked to install new software hit 'Y')

##### Install MySQL #####
* sudo apt-get install mysql-server
*(If asked to install new software hit 'Y')
*(You will have to enter an admin password, don't forget this password!)

##### Install PHP #####
* sudo apt-get install php5 libapache2-mod-php5
*(If asked to install new software hit 'Y')

###### Restart Server (If needed!) ######
* (Read terminal window if it says it restarted the server then this is not needed)
* sudo /etc/init.d/apache2 restart

##### Check Apache Server #####
* Go to [http://localhost/](http://localhost/)
* (You should see a message saying it works!)

##### Test PHP #####
*(Type this into the terminal to see if your PHP server is working).
* php -r 'echo "\n\nYour PHP installation is working fine. \n\n\n";'
*( You should see a message that says 'Your PHP installation is working fine.')
*( If this is not shown there have been errors in the PHP installation)


#### Configuration ####
##### Apache server #####
* Apache server sets all public files in the /var/www/html/ directory
* to change it to another directory edit /etc/apache2/apache2.conf
* for this project we will use /var/www/html/

#### Dependencies
* N/A

#### Database configuration 
* N/A

#### How to run tests ####
* N/A

#### Initial Repository Clone ####
* THIS STEP ASSUMES YOU HAVE YOUR COMPUTER PRIVATE KEY ASSOCIATED WITH YOUR ACCOUNT
* 1. Create a directory where you want hold all your files 
*  mkdir DogAdoption
* 2. Change into this directory
*  cd DogAdoption
* 3. Pull from the repository
*  git clone https://github.com/fsolis/Dog-Adoption-Site.git
* 5. All files should now be in current directory (DogAdoption)

#### Deployment instructions ####
* 1. Make a symbolic link between current working directory 
*  sudo ln -s ~/Desktop/DogAdoption /var/www/html
* 2. Make sure the link worked by going to [http://localhost/DogAdoption](http://localhost/DogAdoption)



### Who do I talk to? ###

* For questions or more information contact creator Freddy Solis at fsolis@csumb.edu
