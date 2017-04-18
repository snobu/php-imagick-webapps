php_imagick.dll and binaries
----------------------------

..for PHP 5.6 (x86, Non Thread Safe) under Azure App Services Web Apps platform.

PECL module: `php_imagick-3.3.0rc2-5.6-nts-vc11-x86.zip`, API version: `20131226` - from http://windows.php.net/downloads/pecl/releases/imagick/3.3.0rc2/
>![api_ver](https://raw.githubusercontent.com/snobu/php-imagick-webapps/master/screenshots-from-portal/imagick_api_ver.png "api_ver")


>Imagick is a native php extension to create and modify images using the ImageMagick API.
>This extension requires ImageMagick version 6.2.4+ and PHP 5.1.3+.
>IMPORTANT: Version 2.x API is not compatible with earlier versions.

Binaries: `ImageMagick-6.8.8-1-Q16-x86-dll.exe` from http://ftp.icm.edu.pl/packages/ImageMagick/binaries/

`applicationHost.xdt` - XML transform responsible for adding `d:\home\site\ImageMagick` to PATH.
