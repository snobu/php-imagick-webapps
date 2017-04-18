How to get `php_imagick` up and running on Azure App Service with Windows web workers
-------------------------------------------------------------------------------------

**DISCLAIMER:<br>
If this totally and permanently bricks your site, don't blame me.**


## UPDATE for PHP 7.0, VC14, x86, Non Thread Safe (NTS)

* Get the latest *stable* php_imagick.dll from here - https://pecl.php.net/package/imagick (3.4.3-stable used in this guide).

* Copy all `CORE_RL_*` files to `d:\home\site\ImageMagick\`

* Copy `php_imagick.dll` to `d:\home\site\ext\`

* Copy `applicationHost.xdt` (it's in this repo under `/site`) to `d:\home\site`. That's the XML transform responsible for adding `d:\home\site\ImageMagick` to **PATH**. Edit if you're using your own custom paths.

* Add `MAGICK_CODER_MODULE_PATH` Application Setting:
```
     Name: MAGICK_CODER_MODULE_PATH
    Value: d:\home\site\ImageMagick
```

* Add `MAGICK_HOME` Application Setting:
```
     Name: MAGICK_HOME
    Value: d:\home\site\ImageMagick
```

* Add `PHP_EXTENSIONS` Application Setting (apparently PHP 7.0 ignores PHP_INI_SCAN_DIR for some reason):
```    
     Name: PHP_EXTENSIONS
    Value: d:\home\site\ext\php_imagick.dll
```

This is what you should have now:

![image](https://cloud.githubusercontent.com/assets/6472374/25129762/20026b0e-2448-11e7-862a-441c47c7a558.png)

* Restart the Web App

* At this point `phpinfo()` should return a `imagick` module section. Get the ImageMagick version that `php_imagick.dll` was built against:

## ![image](https://cloud.githubusercontent.com/assets/6472374/25127940/802a8956-2440-11e7-9b68-60e7e678a49b.png)

We take a dependency here on **ImageMagick-6.9.3-7-Q16-x86-dll.exe**.
Download and extract (always get the one ending in **-x86-dll.exe**) - http://ftp.icm.edu.pl/packages/ImageMagick/binaries/ImageMagick-6.9.3-7-Q16-x86-dll.exe

* Copy the `IM_MOD*` and `FILTER*` DLLs from `modules\` to `d:\home\site\ImageMagick` (don't copy the folder structure, just the DLLs, you should have a flat structure in `d:\home\site\ImageMagick\` with just a bunch of DLLs).

* It should now work, test with this snippet:

```php
<?php
  /* Create a new imagick object */
  $im = new Imagick();
  /* Create new image. This will be used as fill pattern */
  $im->newPseudoImage(200, 200, "plasma:fractal");
  /* Create imagickdraw object */
  $draw = new ImagickDraw();
  /* Start a new pattern called "gradient" */
  $draw->pushPattern('gradient', 0, 0, 200, 200);
  /* Composite the gradient on the pattern */
  $draw->composite(Imagick::COMPOSITE_OVER, 0, 0, 200, 200, $im);
  /* Close the pattern */
  $draw->popPattern();
  /* Use the pattern called "gradient" as the fill */
  $draw->setFillPatternURL('#gradient');
  /* Set font size */
  $draw->setFontSize(36);
  /* Annotate some text */
  $draw->annotation(20, 50, "What do you mean this works and we still have daylight left???!!?");
  /* Create a new canvas object and a white image */
  $canvas = new Imagick();
  $canvas->newImage(1200, 70, "black");
  /* Draw the ImagickDraw on to the canvas */
  $canvas->drawImage($draw);
  /* 1px black border around the image */
  $canvas->borderImage('black', 1, 1);
  /* Set the format to PNG */
  $canvas->setImageFormat('png');

  /* Output the image */
  header("Content-Type: image/png");
  echo $canvas;
?>
```

### Result:

![image](https://cloud.githubusercontent.com/assets/6472374/25129674/ae189d10-2447-11e7-9a5b-d75ee20653db.png)

**NOTE:** `phpinfo()` should now report a bunch of formats being supported:

![image](https://cloud.githubusercontent.com/assets/6472374/25130247/2de1f102-244a-11e7-8e87-800f950ab5a5.png)


## For PHP 5.6, VC11, x86, Non Thread Safe

Follow the PHP 7.0 guide, just match the right binaries.

Tested working:

- PECL module: `php_imagick-3.3.0rc2-5.6-nts-vc11-x86.zip` - http://windows.php.net/downloads/pecl/releases/imagick/3.3.0rc2/

- ImageMagick Binaries: `ImageMagick-6.8.8-1-Q16-x86-dll.exe` - http://ftp.icm.edu.pl/packages/ImageMagick/binaries/
