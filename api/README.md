# Tree Learning API Platform App

## Config

Create .env.local file to override the default .env file.

Make sure you install openssl and sodium php extensions.  
Generate SSL keys with `php bin/console lexik:jwt:generate-keypair` commande.  

> [!NOTE]
> You can install OpenSSL on Windows with Scoop : `scoop install openssl`

[More info on API Platform JWT integration](https://api-platform.com/docs/core/jwt/)