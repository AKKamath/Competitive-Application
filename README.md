# Competitive-Application

Application to grab details of upcoming competitive coding competitions from their respective websites.

### Execution Instructions

* Clone repository, navigate to the directory and run the following commands:
	```
	cd public
	php -S localhost:8080
	```
* Now go here: http://localhost:8080
* Wait a few minutes for data to be gathered.

### Adding More Site

__The following steps can be undertaken to scrape data from a custom site:__
* Create a file in controllers folder in the format `c_YourSiteName.php`
```php
<?php
// Include the class that we create objects of
require("../models/m_contest.php");

scrape_site();

function scrape_site()
{
	// YOUR CODE HERE
}
```
* Copy the above template into this file
* In scrape_site(), scrape the site into an array of type contest [defined here](models/m_contest.php).
* Each object of the array represents a single competition.
* For error checking, echo "INV"; and exit;
* After gathering details, echo the json_encode($arr);
* Edit websites.json in the root directory, by adding the site name and folder location of the scraper.
* Optionally add a picture of the site logo to the images folder in public.

### Explanation of File Structure ###
* [controllers](controllers) folder contains all the scraping logic.
* [models](models) folder currently only contains [m_contest.php](models/m_contest.php) which contains a class contest describing the details required for a class.
* [public](public) contains the index.php and logos of competitive coding sites.

### TODOs ###
* Change to JavaScript and Ajax, instead of PHP output.
* Implement a way so that all files relating to a single competitive site are gathered together.
* Improve formatting of data
* Implement raw data storage so that user isn't forced to wait while data is gathered.
* Port to Python as a standalone application.

###### Other #####
Credits to:   
Jack Rugile (https://codepen.io/jackrugile/full/EyABe) for the table structure.
