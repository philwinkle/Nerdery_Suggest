/******************************************************/
 _   _                               _
| |_| |__   ___   _ __   ___ _ __ __| | ___ _ __ _   _
| __| '_ \ / _ \ | '_ \ / _ \ '__/ _` |/ _ \ '__| | | |
| |_| | | |  __/ | | | |  __/ | | (_| |  __/ |  | |_| |
 \__|_| |_|\___| |_| |_|\___|_|  \__,_|\___|_|   \__, |
                                                 |___/
/******************************************************/

Product Recommendation Module
Version 0.1.1

@author: Phillip Jackson <phillip.w.jackson@gmail.com>


============
What's New??
============

0.1.1 Security Update

Added additional security measures to the product suggestion module.
Other fixes include code reorganization, some cleanup and translation
enhancements.

==========================
General Usage Instructions
==========================

Use of the Product Recommendation Module from The Nerdery is fast and easy.
Once installed, your customers may begin recommending products at the
following url. For example:

	http://[yoursite.com]/suggest/

Where [yoursite.com] is your site url.


As a customer, suggesting a product requires being logged in. You will receive
a message to this effect when you first visit the /suggest/ url as stated above.
Once logged in, users can perform one action per day - Voting, and Recommending.
If a customer suggests a product, they will not be able to vote or to suggest
again that same day. This resets at midnight, and is contingent upon the local
server time (will be localized in future releases).


==========================
Admin Usage Instructions
==========================

To administrate the store, log in to your admin panel. You will see a new 
menu item - "The Nerdery" - under the main menu bar.  There are two options
from this main menu - "Product Suggestions" and "Action Log".

	-	Product Suggestions is where you can edit, delete, and convert
		any recommendations to an inventory item

	-	Action Log is where you can view all actions taking place in the
		current store as well as remove actions to allow voting or
		recommending for a customer who may have taken an action errantly

** NOTE **

To enable or disable Weekend Voting, you may do so in:

System	> Configuration
		> The Nerdery 
		> Product Suggestion
		> "Allow Suggestions and Voting on Weekends"

=========================
Installation Instructions
=========================

Copy the enclosed files to your repsective folders:

1) The Application files:

├───app
│   ├───code
│   │   └───local
│   │       └───Nerdery
│   │           └───Suggest/*


2) The Design Files:

	a)	Copy nerdery.xml in app/design/adminhtml/default/default
		to the same folder in your local install:

		├───app/design
		│   ├───adminhtml
		│   │   └───default
		│   │       └───default/nerdery.xml


	b)	Copy nerdery.xml in app/design/frontend/base/default/layout
		to the same folder in your local install:

		│   └───frontend
		│       └───base
		│           └───default
		│               └───layout/nerdery.xml



	c)	Copy the entire template folder in app/design/frontend/base/default/template
		to the same folder in your local install:

		│   └───frontend
		│       └───base
		│           └───default
		│               └───template
		│                   └───nerdery/*


3) Copy Nerdery_Suggest.xml to app/etc/modules :


	├───etc
	│   └───modules/Nerdery_Suggest.xml


4) Copy the theme translation documents named Nerdery_Suggest.csv to your app/locale folders:

	└───locale
	    ├───de_DE
	    ├───en_US
	    ├───es_ES
	    └───fr_FR


/******************************************************/
                 _             _
  ___ ___  _ __ | |_ __ _  ___| |_   _   _ ___
 / __/ _ \| '_ \| __/ _` |/ __| __| | | | / __|
| (_| (_) | | | | || (_| | (__| |_  | |_| \__ \
 \___\___/|_| |_|\__\__,_|\___|\__|  \__,_|___/

/******************************************************/


For installation support please do not hesitate to contact us:

Phillip Jackson
The Nerdery
tw: @philwinkle
c: 813.785.1400