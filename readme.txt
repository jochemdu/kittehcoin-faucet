Hello,

This is a simple faucet script for KittehCoin. It is rather easy to set up and requires 
minimal technical/programming knowledge. This script is free for you to use/modify in
any way. Credit is not required. 

Now, onto the installation: Please direct your attention to the config.php file, it 
contains all the settings for the faucet. Edit them to suit your needs. Several 
settings have comments behind them to explain what they mean.

Installation in short:

- Create the database and add the table. (see end of this document)
- Edit config.php to suit your needs.
- Upload all files to your web host.


Features:

- Templates. Easily create your own designs with basic HTML and CSS knowledge.
- Placeholder values. Add different kinds of statistics to the page.
- CAPTCHA. Can be enabled and disabled instantly.
- Quickly change payout values like minimum/maximum payout, and the payout threshold.
- The payout interval can be set in minutes, hours, or days.
- Check for users based on the IP address, Kitteh address, or both.
- Support for encrypted wallets.


Requirements:

- PHP enabled webhost
- PHP GD library (if you are using CAPTCHA, most PHP hosts have this by default)
- MySQL server



If you have any questions or wish to send me a 'thank you', feel free to contact me.

Donations are much appreciated, too: KHi1Lf6Hi81yc61r5SKQMvkCMSF5s9JbSY




MySQL table SQL query:
---

CREATE TABLE `sf_payouts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL DEFAULT '',
  `payout_amount` float NOT NULL,
  `payout_address` varchar(34) NOT NULL DEFAULT '',
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

---